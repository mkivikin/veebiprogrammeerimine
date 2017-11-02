<?php
	//et pääseks ligi sessioonile ja funktsioonidele
	require("functions.php");
	require("edituserideafunctions.php");
	require("../../../config.php");
	$database = "if17_marek";
	$notice = "";
	
	//Kui pole sisse loginud, liigume login lehele
	if(!isset ($_SESSION["userID"])){
		header("Location: login.php");
		exit();
	}
	
	
	if(isset ($_POST["ideaButton"])) {
		updateIdea($_POST["id"], test_input($_POST["idea"]), $_POST["ideaColor"]);
		//jään siia lehele
		header("Location: ?id=".$_POST["id"]);
		exit();
		}
	if(isset($_GET["delete"])){
		deleteIdea($_GET["id"]);
		header("Location: usersIdeas.php");
		exit();
	}
	
	$idea = getSingleIdea($_GET["id"]);
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
	Toimeta mõtet
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
	<input name="id" type="hidden" value="<?php echo $_GET["id"];?>">
	<label> Hea mõte:</label>
	<textarea name = "idea"><?php echo $idea->text;?></textarea>
	<label> Mõttega seonduv värv: </label>
	<input name="ideaColor" type="color" value = "<?php echo $idea->color; ?>">
	<input name="ideaButton" type="submit" value="Salvesta muudatused">
	<span style="color:red"><?php echo $notice?></span>
	</form>
	<hr>
	</p>
	<p><a href="?id=<?=$_GET['id'];?>&delete=1">Kustuta</a> see mõte!</p>
	<p><a href="usersIdeas.php">Tagasi heade mõtete juurde</a></p>
</body>
</html>