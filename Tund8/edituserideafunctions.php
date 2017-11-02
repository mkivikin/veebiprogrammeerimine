<?php
$database = "if17_marek";
require("../../../config.php");

function getSingleIdea($editId) {
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"],$GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt = $mysqli->prepare("SELECT idea, ideacolor FROM vp_userideas WHERE id = ?");
	echo $mysqli->error;
	$stmt->bind_param("i", $editId);
	$stmt->bind_result($ideaText, $ideaColor);
	$stmt->execute();
	$ideaObject = new stdclass();
	if($stmt->fetch()) {
		$ideaObject->text = $ideaText;
		$ideaObject->color = $ideaColor;
	} else {
		$stmt->close();
		$mysqli->close();
		//sellist mõtet polnud
		Header("Location: usersIdeas.php");
		exit();
	}
	$stmt->close();
	$mysqli->close();
	return $ideaObject;
}
function updateIdea($id, $idea, $color) {
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"],$GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt = $mysqli->prepare("UPDATE vp_userideas SET idea = ?, ideacolor = ? WHERE id = ?");
	echo $mysqli->error;
	$stmt->bind_param("ssi", $idea, $color, $id);
	$stmt->execute();
	$stmt->close();
	$mysqli->close();
}

function deleteIdea($id) {
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"],$GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt = $mysqli->prepare("UPDATE vp_userideas SET deleted = NOW() WHERE id = ?");
	echo $mysqli->error;
	$stmt->bind_param("i", $id);
	$stmt->execute();
	$stmt->close();
	$mysqli->close();
}
?>