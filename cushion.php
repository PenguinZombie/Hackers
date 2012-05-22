<?php
	// ポストデータを受け取る
	$sei = $_POST["sei"];
	$mei = $_POST["mei"];
	$mail = $_POST["mail"];
	$pass = $_POST["pass"];
	session_start();
	// リロード対策,同じ値のチケットをセッションとhiddenで送りuser_insert側で確認する
	// uniqid(マイクロ秒単位の現在時刻に基づき 先頭辞（prefix）を付けたユニークなIDを返す)
	// mt_rand(randより高速でランダム性が優れている)
	// uniqidとmt_randをくっつけてそれをsha256でハッシュ化した値をチケットにする
	$unirand = uniqid() . mt_rand();
	$ticket = hash("sha256",$unirand);
	$_SESSION["ticket"] = $ticket;
?>
<!DOCTYPE html>
<html>
<head>
<meta charset=UTF-8>
<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/3.4.1/build/cssreset/cssreset-min.css">
<link rel="stylesheet" type="text/css" href="css/cushion.css">
<script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="js/cushion.js"></script>
<title>Hackers</title>
</head>
<body>
<!-- header(ヘッダー部分) -->
<div class="header">
	<div class="logo"><img src="images/Hackers.png" alt="Hackers"></div>
</div> <!-- /header -->
<!-- wrap(1カラムレイアウト,centerを包むクラス -->
<div class="wrap effect">
	<div class="center">
		<div class="moj">以下の内容でよろしければアカウント作成ボタンをクリックしてください。</div>
		<form class="register_form" method="post" action="user_insert.php">
		<input type="hidden" name="ticket" value="<?php echo $ticket; ?>">
			<table class="cushion_table">
				<tr>
					<td>
						<div class="placeholding-input">
							<input type="text" name="sei" maxlength="20" class="text-input text-sei" value="<?php echo $sei; ?>">
							<span class="placeholder">姓</span>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<div class="placeholding-input">
							<input type="text" name="mei" maxlength="20" class="text-input text-mei" value="<?php echo $mei; ?>">
							<span class="placeholder">名</span>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<div class="placeholding-input">
							<input type="text" name="mail" maxlength="50" class="text-input text-mail" value="<?php echo $mail; ?>">
							<span class="placeholder">メールアドレス</span>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<div class="placeholding-input">
							<input type="password" name="pass" maxlength="15" class="text-input text-pass" value="<?php echo $pass; ?>">
							<span class="placeholder">パスワード</span><!-- labelを使うと文字列クリックでもチェックボックスをクリックすることになる.囲むだけではダメなブラウザがあるみたいなのでforで指定(idじゃないとダメ) -->
						<label for="label1"><input type="checkbox" id="label1" class="show-pass">パスワードを表示する
						</div>
					</td>
				</tr>
				<tr>
					<td class="td_right">
						<!-- ロード中のGIF(必要なときに表示させる) -->
						<span class="load-gif"><img src="images/ajax-loader1.gif" alt="load"></span>
						<input type="submit" class="register" value="アカウント生成">
					</td>
				</tr>
				<td>
				<tr>
					<td>
						<div class="result"><!-- ここに動的にエラーメッセージを表示させる --></div>
					</td>
				</tr>
			</table>
		</form>
	</div> <!-- /center -->
</div> <!-- /wrap -->
<!-- footer(フッター部分) -->
<div class="footer">
	<div class="footer_content">フッター</div>
</div> <!-- /footer -->
</body>
</html>