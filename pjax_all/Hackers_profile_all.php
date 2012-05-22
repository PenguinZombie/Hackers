<!DOCTYPE html>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/3.4.1/build/cssreset/cssreset-min.css">
<link rel="stylesheet" type="text/css" href="css/main.css">
<script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="js/jquery.pjax.js"></script>
<script type="text/javascript" src="js/Hackers_main.js"></script>
<title>Hackers 設定</title>
</head>
<body>
<!-- header(ヘッダー部分) -->
<div class="header">
	<div class="header_str">Hackers</div>
</div> <!-- /header -->
<!-- 3カラムレイアウト -->
<div class="wrap">
	<div class="left">
		<div class="left_con">
			<div class="profile">
				<ul>
					<li>プロフィール</li>
					<li>フレンド</li>
					<li>グループ</li>
					<li>日記</li>
				</ul>
			</div>
		</div>
	</div>
	<div id="main" class="center">
		<div class="center_con">
			<?php 
				include("pjax_parts/Hackers_profile_parts.php");
			?>
		</div>
	</div>
	<div class="right">
		<div class="right_con">
			right
		</div>
	</div>
</div>
</body>
</html>