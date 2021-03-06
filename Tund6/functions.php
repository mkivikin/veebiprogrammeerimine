<?php
	$database = "if17_marek";
	require("../../../config.php");
	//alustame sessiooni
	session_start();
	
	//sisselogimine
	function signIn($email, $password){
		$notice = "";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"],$GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT id, email, password, firstname, lastname FROM vp_users WHERE email = ?");
		$stmt->bind_param("s", $email);
		$stmt->bind_result($id, $emailFromDb, $passwordFromDb, $firstNameDb, $lastNameDb);
		$stmt->execute();
		
		//kontrollime kasutajat
		
		if($stmt->fetch()) { // kui fetch ja saab midagi kätte
			$hash = hash("sha512", $password);
			if($hash == $passwordFromDb) {
				$notice = "Kõik korras, logisimegi sisse";
				//salvestame sessiooni muutujaid
				$_SESSION["userID"] = $id;
				$_SESSION["userEmail"] = $emailFromDb; 
				$_SESSION["userFirstName"] = $firstNameDb;
				$_SESSION["userLastName"] = $lastNameDb;
				
				//liigume pealehele
				header("Location: main.php");
				exit();
			} else {
				$notice = "Sisestasite ebakorrektse salasõna";
			}
			
		} else {
			$notice = "Sellist kasutajat:." .$email ."ei ole";
		}
		return $notice;
		
	}
	
	//uue kasutaja lisamine andmebaasi
	function signUp($signupFirstName, $signupFamilyName, $signupBirthDate, $gender, $signupEmail, $signupPassword){
			//ühendus serveriga
			
			$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"],$GLOBALS["serverPassword"], $GLOBALS["database"]);
			//käsud serverile
			$stmt = $mysqli->prepare("INSERT INTO vp_users (firstname, lastname, birthdate, gender, email, password) VALUES (?, ?, ?, ?, ?, ?)");
			echo $mysqli->error;
			//s - string ehk tekst
			//i - integer ehk täisarv
			//d - decimal ehk ujukomaarv
			$stmt->bind_param("sssiss", $signupFirstName, $signupFamilyName, $signupBirthDate, $gender, $signupEmail, $signupPassword);
			//stmt->execute();
			if ($stmt->execute()) {
				echo "Kasutaja registreeritud";
				
			} else {
				echo "Tekkis viga: " .$stmt->error;
			}
			$stmt->close();
			$mysqli->close();
	}		
	function saveIdea($idea, $color) {
		$notice="";
		//ühendus serveriga
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"],$GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("INSERT INTO vp_userideas (userid, idea, ideacolor) VALUES (?, ?, ?)");
		$stmt->bind_param("iss", $_SESSION["userID"], $idea, $color);
		if ($stmt->execute()) {
			$notice = "Mõte on salvestatud";
		} else {
			$notice = "Tekkis viga: " .$stmt->error;
		}
		$stmt->close();
		$mysqli->close();
		return $notice;
	}
	//sisestuse kontrollimine
	function test_input($data) {
		$data = trim($data); //eemaldab lõpust tühiku
		$data = stripslashes($data); // eemaldab /'id
		$data = htmlspecialchars($data); //eemaldab keelatud märgid
		return $data;
	}
	
	function add_values() {
		echo "Teine summa on:" .(($GLOBALS["x"]) + ($GLOBALS["y"]));
	}
	
	function genderText($genderDb) {
		if ($genderDb == 1) {
				$gender = "Male";
				return $gender;
			} 	elseif ($genderDb == 2) {
				$gender = "Female";
				return $gender;
			}
	}
	
	function color_inverse($color){
    $color = str_replace('#', '', $color);
    if (strlen($color) != 6){ return '000000'; }
    $rgb = '';
    for ($x=0;$x<3;$x++){
        $c = 255 - hexdec(substr($color,(2*$x),2));
        $c = ($c < 0) ? 0 : dechex($c);
        $rgb .= (strlen($c) < 2) ? '0'.$c : $c;
    }
    return '#'.$rgb;
}

	function listIdeas() {
		$tableheads ="";
		$notice="";
		$table="";
		//ühendus serveriga
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"],$GLOBALS["serverPassword"], $GLOBALS["database"]);
		//$stmt = $mysqli->prepare("SELECT idea, ideacolor FROM vp_userideas");
		//$stmt = $mysqli->prepare("SELECT idea, ideacolor, userid FROM vp_userideas WHERE userid = ? ORDER BY id DESC");
		$stmt = $mysqli->prepare("SELECT vp_userideas.idea, vp_userideas.ideacolor, vp_userideas.userid, vp_users.firstname, vp_users.lastname FROM vp_userideas INNER JOIN vp_users on vp_userideas.userid = vp_users.id ORDER BY vp_userideas.id DESC;");
		//SELECT vp_userideas.idea, vp_userideas.ideacolor, vp_userideas.userid, vp_users.firstname, vp_users.lastname FROM vp_userideas INNER JOIN vp_users on vp_userideas.userid = vp_users.id;
		//$stmt->bind_param("i", $_SESSION["userID"]);
		$stmt->bind_result($ideaDb, $colorDb, $userID, $firstNameDb, $lastNameDb);
		$stmt->execute();
		while($stmt->fetch()){ 
			$colorinv = color_inverse($colorDb);
			//$notice .= '<p style="background-color:'.$colorDb .'">'. $ideaDb .'<i> -' .$firstNameDb .' ' .$lastNameDb. "</i></p> \n";
			$notice .= '<p style="color:'.$colorinv .';background-color:'.$colorDb .';">'.$ideaDb .'<i> -' .$firstNameDb .' ' .$lastNameDb. "</i></p> \n"; 
			//echo $colorDb;
			//echo $colorinv;
		}
		$stmt->close();
		$mysqli->close();
		return $notice;
	}
	
	function latestIdea() {
		//ühendus serveriga
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"],$GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT idea FROM vp_userideas WHERE id =(SELECT MAX(id) FROM vp_userideas)");
		$stmt->bind_result($ideaDb);
		$stmt->execute();
		$stmt->fetch();
		$stmt->close();
		$mysqli->close();
		return $ideaDb;
	}
	
?>