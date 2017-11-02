<?php
	//et pääseks ligi sessioonile ja funktsioonidele
	require("functions.php");
	require("../../../config.php");
	$database = "if17_marek";
	$notice = "";
	
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
	
	if(isset ($_POST["ideaButton"])) {
		if(isset($_POST["idea"]) and !empty($_POST["idea"])) {
		//echo $_POST["ideaColor"];
		$notice = saveIdea(($_POST["idea"]), ($_POST["ideaColor"]));
		}
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
	</p>
	<p>
	Lisa oma hea mõte
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
	<label> Hea mõte:</label>
	<input name="idea" type="text">
	<br>
	<label> Mõttega seonduv värv: </label>
	<input name="ideaColor" type="color">
	<input name="ideaButton" type="submit" value="Sisesta mõte">
	<span style="color:red"><?php echo $notice?></span>
	</form>
	<hr>
	<div style="width: 40%">
		<?php
			echo listIdeas();
		?>
	<div>
	</p>
	<p><a href="?Logout=1">Logi välja</a></p>
</body>
</html>