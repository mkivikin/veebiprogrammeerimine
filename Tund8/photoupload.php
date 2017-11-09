<?php
	require("functions.php");
	require("edituserideafunctions.php");
	require("../../../config.php");
	
	if(!isset ($_SESSION["userID"])){
		header("Location: login.php");
		exit();
	}
	//et pääseks ligi sessioonile ja funktsioonidele
	$target_dir = "";
	$target_file = "";
	$imageFileType = "";
	$error = "";
	$target_dir = "../../fotod/";
	$maxWidth = 600;
	$maxHeight = 400;
	$marginHor = 10;
	$marginVer = 10;
	//Kui pole sisse loginud, liigume login lehele
	if(isset($_POST["submit"])) {
		if(!empty($_FILES["fileToUpload"]["name"])) {
			$imageFileType = strtolower(pathinfo(basename($_FILES["fileToUpload"]["name"]),PATHINFO_EXTENSION));
			$target_file = $target_dir . pathinfo(basename($_FILES["fileToUpload"]["name"]))["filename"] ."_" .(microtime(1) *10000) ."." .$imageFileType;
			//$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
			$uploadOk = 1;
			$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
			// Check if image file is a actual image or fake image
			if($check !== false) {
				$uploadOk = 1;
			} else {
				$error = "File is not an image.";
				$uploadOk = 0;
			}
			
			// Check if file already exists
			if (file_exists($target_file)) {
				 $error = "Sorry, file already exists.";
				$uploadOk = 0;
			}
			// Check file size
			if ($_FILES["fileToUpload"]["size"] > 500000) {
				$error = "Sorry, your file is too large.";
				$uploadOk = 0;
			}
			// Allow certain file formats
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
			&& $imageFileType != "gif" ) {
				$error = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
				$uploadOk = 0;
			}
			// Check if $uploadOk is set to 0 by an error
			if ($uploadOk == 0) {
				$error .=" Upload läks lappe";
			// if everything is ok, try to upload file
			} else {
				/*if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
					$error =  "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
				} */
				
				//sõltuvalt failitüübist loon pildiobjekti
				if($imageFileType == "jpg" or $imageFileType == "jpeg") {
					$myTempImage = imagecreatefromjpeg($_FILES["fileToUpload"]["tmp_name"]);
				}
				if($imageFileType == "png") {
					$myTempImage = imagecreatefrompng($_FILES["fileToUpload"]["tmp_name"]);
				}
				if($imageFileType == "gif") {
					$myTempImage = imagecreatefromgif($_FILES["fileToUpload"]["tmp_name"]);
				}
				$imageWidth = imagesx($myTempImage);
				$imageHeight = imagesy($myTempImage);
				//arvutan suuruse suhte
				if($imageWidth>$imageHeight) {
					$sizeRatio= $imageWidth/$maxWidth;
				} else {
					$sizeRatio= $imageHeight/$maxHeight;
				}
				//tekitame uue sobiva suurusega pikslikogumi
				$myImage = resizeImage($myTempImage, $imageWidth, $imageHeight, round($imageWidth/$sizeRatio), round($imageHeight/$sizeRatio));
				//lisan vesimärgi
				$stamp = imagecreatefrompng("../../graphics/hmv_logo.png");
				$stampWidth = imagesx($stamp);
				$stampHeight = imagesy($stamp);
				$stampx = imagesx($myImage) - $stampWidth - $marginHor;
				$stampy = imagesy($myImage) - $stampHeight - $marginVer;
				imagecopy($myImage, $stamp, $stampx, $stampy, 0, 0, $stampWidth, $stampHeight);
				//lisame teksti 
				$textToImage = "Heade mõtete veeb";
				//määrame teksti värvi
				$textColor = imagecolorallocatealpha($myImage, 255, 255, 255, 65);
				imagettftext($myImage, 24, -45, 10, 25, $textColor, "../../graphics/arial.ttf", $textToImage);
				//salvestame
				if($imageFileType == "jpg" or $imageFileType == "jpeg") {
					if(imagejpeg($myImage, $target_file, 90)) {
						$error =  "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
					} else {
						$error = "Failed";
					}
				}
				
				if($imageFileType == "png") {
					if(imagepng($myImage, $target_file, 5)) {
						$error =  "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
					} else {
						$error = "Failed";
					}
				}
				
				if($imageFileType == "gif") {
					if(imagegif($myImage, $target_file)) {
						$error =  "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
					} else {
						$error = "Failed";
					}
				}
				imagedestroy($myImage);
				imagedestroy($myTempImage);
				imagedestroy($stamp);
				
			}
		} else {
			$error = "Please choose a file to upload";
				}
	}
function resizeImage($image, $origW, $origH, $W, $H) {
	$newImage = imagecreatetruecolor($W, $H);
	//kuhu, kust, kuhu koordinaatidele, x ja y kust koordinaatidelt x ja y, kui laialt/kõrgelt uude kohta, ja kui laialt võtta, kui kõrgelt võtta
	imagecopyresampled($newImage, $image, 0, 0, 0, 0, $W, $H, $origW, $origH);
	return $newImage;
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
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
		Select image to upload:
		<input type="file" name="fileToUpload" id="fileToUpload">
		<input type="submit" value="Upload" name="submit">
		<span style="color:red"><?php echo $error; ?> </span>
		</form>
	</p>

</body>
</html>