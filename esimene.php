<?php
	//muutujad
	$myName = "Marek";
	$mySurname = "Kivikirbe";
	$monthNamesET = ["Jaanuar", "Veebruar", "Märts", "Aprill", "Mai", "Juuni",
	"Juuli", "August", "September", "Oktoober", "November", "Detsember"];
	
	//var_dump ($monthNamesET);
	//var_dump($_POST);
	//echo $_POST["birthYear"];
	//echo $monthNamesET[1];
	$myBirthYear;
	$ageNotice = "";
	if  (isset($_POST["birthYear"]) and $_POST["birthYear"] != 0) {
		$myBirthYear = $_POST["birthYear"];
		$myAge = date("Y") - $_POST["birthYear"];
		$ageNotice = "<p>Te olete umbkaudu " .$myAge ." Aastat vana.</p>";
		
		$ageNotice .= "<p>Te olete elanud järgnevatel aastatel: </p> <ul>";
		for ($i = $myBirthYear; $i <= date("Y"); $i ++) {
			$ageNotice .="<li>" .$i ."</li>";
		}			
		$ageNotice .="</ul>";
	}
	
	$monthNow = $monthNamesET[date ("n") -1];
	
	//Hindan päevaosa
	$hourNow = date("H");
	$partOfDay ="";
	
	if ($hourNow < 8) {
		$partOfDay = "Varajane Hommik";
	}
	if ($hourNow >= 8 and $hourNow < 16) {
		$partOfDay = "Koolipäev";
	}
	
	else {
		$partOfDay = "Vabaaeg";
	}
	
	//echo $partOfDay;
	
	/* 
	for ($i = 0; $i <5; $i ++) {
		echo "Ha";
	}
	*/
	
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
	<h1><?php  echo $myName . " " . $mySurname;?></h1>
	<p>See veebileht on loodud õppetöö raames ning ei 
	sisalda mingisugust tõsiseltvõetavat sisu!</p>
	<p>Kirjutasin siia veits midagi kodus ka veel.
	<br>Tegelt sa oled normaalne vend
	<br>
	<img src="http://greeny.cs.tlu.ee/~kivimare/zoolander.jpg" alt="malemodels">
	<br>
	<?php
		echo "<p>Algas PHP õppimine</p>";
		echo "<p>Täna on: ";
		echo date("d. ") . $monthNow. date(" Y") .", Kell oli lehe avamise hetkel " .date("H:i:s");
		echo " Hetkel on: " .$partOfDay . ".<p>";
		
	?>
	<h2>Natuke vanusest</h2>
	<form method="POST">
		<label>Teie sünniaasta: </label>
		<input name="birthYear" id="birthYear" type="number" value="<?php echo $myBirthYear?>" min="1900" max="2017">
		<input name="submitBirthYear" type ="submit" value="Sisesta" >
	</form>

	<?php
		if ($ageNotice != "") {
			echo $ageNotice;
		}
	?>
	
</body>
</html>