<?php
	session_start();
	$text = $_POST["text"];
	$_SESSION["diary_text"] = $text;
?>