<?php
	$database = "if17_marek";
	
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
	//sisestuse kontrollimine
	function test_input($data) {
		$data = trim($data); //eemaldab lõpust tühiku
		$data = stripslashes($data); // eemaldab /'id
		$data = htmlspecialchars($data); //eemaldab keelatud märgid
		return $data;
	}
	$x = 5;
	$y = 5;
	echo "Esimene summa on:" .($x + $y);
	
	function add_values() {
		echo "Teine summa on:" .(($GLOBALS["x"]) + ($GLOBALS["y"]));
	}
	
	
	
?>