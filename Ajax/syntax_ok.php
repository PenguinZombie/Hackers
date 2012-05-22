<?php
	session_start();
	if(isset($_SESSION["NoPjax"])) {
		$NoPjax = $_SESSION["NoPjax"];
		unset($_SESSION["NoPjax"]);
	}
	echo $NoPjax;
?>