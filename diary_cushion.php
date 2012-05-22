<?php
	session_start();
	// 文字列をシンタックスハイライターの仕様に変換する+タグ対策の関数を呼び出すため
	require_once("str_conv.php");
	$text = $_POST["user_text"];
	// 入力画面に戻った時用にsessionに保存しておく
	$_SESSION["diary_text"] = $text;
	// テキストを引数に関数から戻り値を受け取る
	$diary = str_conv($text);
?>
<!DOCTYPE html>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/3.4.1/build/cssreset/cssreset-min.css">
<link rel="stylesheet" type="text/css" href="css/Hackers_diary.css">
<link rel="stylesheet" type="text/css" href="css/style/shCore.css">
<link rel="stylesheet" type="text/css" href="css/style/shCoreDefault.css">
<link rel="stylesheet" type="text/css" href="css/styles.css">
<script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="js/scripts/shCore.js"></script>
<!-- ローカルでは使えないみたいなので全て記述 <script type="text/javascript" src="js/scripts/shAutoloader.js"></script> -->
<script type="text/javascript" src="js/scripts/shBrushCpp.js"></script>
<script type="text/javascript" src="js/scripts/shBrushCSharp.js"></script>
<script type="text/javascript" src="js/scripts/shBrushCss.js"></script>
<script type="text/javascript" src="js/scripts/shBrushGroovy.js"></script>
<script type="text/javascript" src="js/scripts/shBrushJava.js"></script>
<script type="text/javascript" src="js/scripts/shBrushJavaFX.js"></script>
<script type="text/javascript" src="js/scripts/shBrushJScript.js"></script>
<script type="text/javascript" src="js/scripts/shBrushPhp.js"></script>
<script type="text/javascript" src="js/scripts/shBrushPerl.js"></script>
<script type="text/javascript" src="js/scripts/shBrushPython.js"></script>
<script type="text/javascript" src="js/scripts/shBrushRuby.js"></script>
<script type="text/javascript" src="js/scripts/shBrushScala.js"></script>
<script type="text/javascript" src="js/scripts/shBrushSql.js"></script>
<script type="text/javascript" src="js/scripts/shBrushVb.js"></script>
<script type="text/javascript" src="js/scripts/shBrushXml.js"></script>
<script type="text/javascript" src="js/Hackers_diary2.js"></script>
<title>Hackers 設定</title>
</head>
<body>
<div class="diary_cushion_area">
	<div class="diary_cushion_area_in" name="test">
		<?php
			// 本文表示
			foreach($diary as $value) {
				echo $value;
			}
		?>
	</div>
	<div class="diary_cushion_submit_area">
			<hr color="#ccc">
			<a href="Hackers_diary.php?back" class="cta cta-green">戻る</a>
			<a href="Hackers_diary_insert.php" class="cta cta-blue">確定</a>
	</div>
</div>s
</body>
</html>