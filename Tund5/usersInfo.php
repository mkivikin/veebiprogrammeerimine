<?php
	//et pääseks ligi sessioonile ja funktsioonidele
	require("functions.php");
	require("../../../config.php");
	$database = "if17_marek";
	
	//Kui pole sisse loginud, liigume login lehele
	if(!isset ($_SESSION["userID"])){
		header("Location: login.php");
		exit();
	}
	
	if(isset ($_GET["Logout"])) {
		session_destroy();
		header("Location: login.php");
		exit();
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>
		Marek
	</title>
</head>
<body>
	<h1><?php  echo "Tervist, " .$_SESSION["userFirstName"] ." " .$_SESSION["userLastName"] .".";?></h1>
	<p>
	<a href="main.php">Pealeht</a>
	<?php
		$gender = "";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"],$GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT id, email, firstname, lastname, gender, birthdate FROM vp_users");
		//$stmt->bind_param("isssii", $idDb, $emailFromDb, $firstNameDb, $lastNameDb, $genderDb, $birthDateDb);
		$stmt->bind_result($idDb, $emailFromDb, $firstNameDb, $lastNameDb, $genderDb, $birthDateDb);
		$stmt->execute();	
		echo "<table border='1' cellpadding='5px' cellspacing='2px'>";
		echo "<tr><td>ID</td>";
		echo "<td>Email</td>";
		echo "<td>First name</td>";
		echo "<td>Last name</td>";
		echo "<td>Gender</td>";
		echo "<td>Birthdate</td></tr>";
		
		while($stmt->fetch()){
			//Katkine soo nimetaja
			foreach ($stmt as $value) { 
			if ($genderDb = 1) {
				$gender = "Male";
			} elseif ($genderDb = 2) {
				$gender = "Female";
			}
		}
			//Kuvame numbri asemel soo
			echo "<tr><td>" .$idDb ."</td>";
			echo "<td>" .$emailFromDb ."</td>";
			echo "<td>" .$firstNameDb ."</td>";
			echo "<td>" .$lastNameDb ."</td>";
			echo "<td>" .$gender ."</td>";
			echo "<td>" .$birthDateDb ."</td>";
			echo "</tr>";
          //siia read, mis loovad iga kasutaja kohta tabeli rea
		}
		echo "</table>";
		$mysqli->close();
	?>
	</p>
	<p><a href="?Logout=1">Logi välja</a></p>
</body>
</html>