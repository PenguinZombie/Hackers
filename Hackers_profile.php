<?php
	session_start();
	// pjaxでのアクセス時 $_GET["_pjax"] が送られてくる
	$pjax = $_GET["_pjax"];
	// pjaxであればコンテンツ部分のみ,違う場合は全てのページを読み込む
	if($pjax) {
		include("pjax_parts/Hackers_profile_parts.php");
	}else{
		include("pjax_all/Hackers_profile_all.php");
	}
?>