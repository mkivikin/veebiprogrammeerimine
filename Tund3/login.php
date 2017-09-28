<?php
	$myUsername;
	$myFirstName;
	$myFamilyName;
	$gender;
	$myEmail;
	
	if  (isset($_POST["loginEmail"])){
		$myUsername = $_POST["loginEmail"];
	}
	else {
		$myUsername = "";
	}
	
	if  (isset($_POST["signupFirstName"])) {
		$myFirstName = $_POST["signupFirstName"];
	}
	else {
		$myFirstName = "";
	}
	
	if  (isset($_POST["signupFamilyName"])) {
		$myFamilyName = $_POST["signupFamilyName"];
	}
	else {
		$myFamilyName = "";
	}
	
	if  (isset($_POST["gender"])) {
		$gender = $gender = intval($_POST["gender"]);
	}
	else {
		$gender = "";
	}
	
	if  (isset($_POST["signupEmail"])) {
		$myEmail = $_POST["signupEmail"];
	}
	else {
		$myEmail = "";
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
	 
	<form method="POST">
		<table border="1" cellpadding="2px" cellspacing="2px">  
			<tr>  
				<td><label>Kasutajanimi: </label></td>  
				<td><input name="loginEmail" id="loginEmail" type="email" value="<?php echo $myUsername?>"> </td>  
			</tr>  
			<tr>  
				<td><label>Parool: </label> </td>  
				<td><input name="password" id="loginPassword" type="password" value=""> </td> 
			</tr>
				<td></td>
				<td><input name="loginbutton" type ="submit" value="logi sisse"></td>    
			</tr>     
		</table> 
	</form> 
	
	<form method="POST">
	<label>Registreerimine </label>
		<table border="1" cellpadding="2px" cellspacing="2px">
			<tr>
				<td><label>Eesnimi:</label></td>
				<td><input name="signupFirstName" type="text" value="<?php echo $myFirstName?>"></td>
			</tr>
			<tr>
				<td><label>Perenimi:</label></td>
				<td><input name="signupFamilyName" type="text" value="<?php echo $myFamilyName?>"></td>
			</tr>
			<tr>
				<td><label>Sugu:</label></td>
				<td><input type="radio" name="gender" value="1" <?php if ($gender == '1') {echo 'checked';} ?>><label>Mees</label> <input type="radio" name="gender" value="2" <?php if ($gender == '2') {echo 'checked';}?>><label>Naine</label></td>
			</tr>
			<tr>
				<td><label>Email:</label></td>
				<td><input name="signupEmail" type="email" value="<?php echo $myEmail?>"></td>
			</tr>
			<tr>
				<td><label>Parool:</label></td>
				<td><input name="signupPassword" type="password"></td>
			</tr>
			</tr>
				<td></td>
				<td><input name="registerbutton" type ="submit" value="registreeri"></td>    
			</tr>     
		</table> 
	</form> 
</body>
</html>