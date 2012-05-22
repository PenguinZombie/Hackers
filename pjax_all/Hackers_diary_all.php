<?php
	// jsやcss読み込めてるか確認に使用,これと最後のコメントを解除すれば使える
	// include 'PHPBugLost/phpBugLost.0.3.php';
?>
<!DOCTYPE html>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/3.4.1/build/cssreset/cssreset-min.css">
<link rel="stylesheet" type="text/css" href="css/main.css">
<link rel="stylesheet" type="text/css" href="css/Hackers_settei.css">
<link rel="stylesheet" type="text/css" href="css/jquery-ui-1.8.18.custom.css">
<link rel="stylesheet" type="text/css" href="css/styles.css">
<script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.8.18.custom.min.js"></script>
<script type="text/javascript" src="js/jquery.pjax.js"></script>
<script type="text/javascript" src="js/Hackers_main.js"></script>
<title>Hackers 設定</title>
</head>
<body>
<!-- header(ヘッダー部分) -->
<div class="header">
	<div class="header_str">Hackers <a href="Hackers_logout.php">ログアウト</a></div>
</div> <!-- /header -->
<!-- 3カラムレイアウト -->
<div class="wrap">
	<div class="left">
		<div class="left_con">
			<div class="profile">
				<ul>
					<li><a href="Hackers_main.php" class="js-pjax current">プロフィール</a></li>
					<li><a href="Hackers_friend.php" class="js-pjax">フレンド</a></li>
					<li><a href="Hackers_com.php" class="js-pjax">コミュニティ</a></li>
					<li><a href="Hackers_diary.php" class="js-pjax">日記</a></li>
					<li><a href="Hackers_settei.php" class="js-pjax">設定</a></li>
				</ul>
			</div>
		</div>
	</div>
	<div class="center">
		<div class="center_con">
			<?php
				include("pjax_parts/Hackers_diary_parts.php");
			?>
		</div>
	</div>
	<div class="right">
		<div class="right_con">
			ここはリキッドレイアウト<br>日記やプロフィールを参照に広告や求人情報を表示する<br>
			左のサイドメニューからが基本操作でpjaxを使用してコンテンツのみをロードしている<br>
			アカウントの設定等はpjaxを使用せず、ページに飛ぶ予定<br>
			はやくクリックしているとたまに表示されずcssの設定が変わる前になっていて表示されないことがある
		</div>
	</div>
</div>
</body>
</html>
<?php
	// echo bl_debug();
?>