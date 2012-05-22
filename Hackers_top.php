<?php
	// インクルードパスを設定
	ini_set('include_path','PEAR');
	require_once("MDB2.php");
	require_once("make_token.php");
	// セッションスタート(自動ログインでない場合のid取得)
	session_start();
	// クッキーがあれば自動ログインの可能性がある,DBに同一のtokenがあり有効期限がどうかを問い合わせる
	if(isset($_COOKIE["token"])) {
		// データベース接続 mysql://ユーザ名:パスワード@ホスト名/DB名?charset=文字コード指定
		$mdb2 = MDB2::connect("mysql://LAA0170018:kouyansaiko@mysql561.phy.lolipop.jp/LAA0170018-seisaku?charset=utf8");
		// $mdb2 = MDB2::connect("mysql://root:kouyansaiko@localhost/hackers?charset=utf8");
		// フェッチモード指定(列名指定)
		$mdb2->setFetchMode(MDB2_FETCHMODE_ASSOC);
		// sql文を作成
		$sql = "SELECT user_id,expires FROM autologin WHERE token = ?";
		// データ型を指定
		$sth = $mdb2->prepare($sql,array("text"));
		// 実行
		$rs = $sth->execute(array($_COOKIE["token"]));
		// 結果から1行取得
		$rows = $rs->fetchRow();
		$mdb2->disconnect();
		if($rows > 0) {
			// 有効期限(ログインしてから1週間)が過ぎている場合はトークンを削除
			if($rows["expires"] < time()) {
				// 過去の時間を指定すればクッキーを削除出来る DBは自動ログインの場合も削除するので下でする
				setcookie("token","クッキーを削除",$rows["expires"]);
			}
			// 自動ログインOKの場合はトークンを再発行する(DBのは削除する)
			// 複数してる場合もあるのでtokenではなくユーザーid
			$sql = "DELETE FROM autologin WHERE user_id = ?";
			$sth = $mdb2->prepare($sql,array("integer"));
			$sth->execute(array($rows["user_id"]));
			//　再発行処理,tokenと有効期限を取得
			list($token,$expires) = make_Token();
			// プリペアドステートメント
			$sql = "INSERT INTO autologin(token,user_id,expires) ";
			$sql.= "VALUES(?,?,?)";
			// データ型指定
			$sth = $mdb2->prepare($sql,array("text","integer","integer"));
			// セットして実行(インサート)
			$sth->execute(array($token,$rows["user_id"],$expires));
			// クッキー(名前,値,有効期限,パス(ルート指定で全てに適応))
			setcookie("token",$token,$expires,"/");
			// セッションにidを格納しておく
			$_SESSION["id"] = $rows["user_id"];
			Header("Location:Hackers_main.php");
		}
	}
?>
<!DOCTYPE html>
<!-- HTML5のドキュメント宣言↑ -->
<head>
<!-- HTML5ならこれで文字コードを指定出来る -->
<meta charset=UTF-8>
<!-- CSSリセット(YUI3),外部ファイル読み込み -->
<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/3.4.1/build/cssreset/cssreset-min.css">
<link rel="stylesheet" type="text/css" href="css/top.css">
<script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="js/Hackers_top.js"></script>
<title>Hackers</title>
</head>
<body>
<!-- header(ヘッダー部分) -->
<div class="header">
	<div class="logo"><div class="image"><img src="images/Hackers.png" alt="Hackers"></div>
		<!-- ログインフォーム -->
		<div class="login_form">
			<form class="login_submit" method="post" action="Hackers_main.php">
				<table class="login_table">
					<tr>
						<td>
							<!-- プレースホルダーをspan要素で表示する -->
							<div class="placeholding-input">
								<!-- autocompleteをオフにする(プレースホルダと被る) -->
								<input type="text" maxlength="50" name="mail" class="login-input login-mail" autocomplete="off">
								<span class="placeholder">メールアドレス</span>
							</div>
						</td>
						<td>
							<div class="placeholding-input">
								<input type="password" maxlength="15" name="pass" class="login-input login-pass" autocomplete="off">
								<span class="placeholder">パスワード</span>
							</div>
						</td>
						<td>
							<input type="submit" class="login_button" value="ログイン">
						</td>
					</tr>
					<tr>
						<td>
							<label for="label1"><input type="checkbox" name="chk" value="on" id="label1" class="pass_on"><span class="moj1">1週間ログインし続ける</span>
						</td>
						<td>
							<span class="moj2"><a href="forgot_pass.php">パスワードを忘れた方はこちら</a></span>
						</td>
						<!-- 位置の調整が難しいので結構無理矢理 -->
						<td class="gif_center1">
							<div class="gif_center2">
								<span class="load-gif2"><img src="images/ajax-loader2.gif" alt="load2"></span>
							</div>
						</td>
					</tr>
					<tr>
						<td colspan="3">
							<div class="login_message">※メールアドレスまたはパスワードが間違っています。</div>
						</td>
					</tr>
				</table>
			</form>
		</div><!-- /login_form" -->
	</div><!-- /logo -->
</div> <!-- /header -->
<!-- wrap(2カラムレイアウト,両方を包むクラス) -->
<div class="wrap">
	<!-- left(左側のコンテンツ) -->
	<div class="left">
		<div class="left_view">ここに説明等<br>
		<img src="images/tux1.png" alt="tux" height="156" width="156">
		</div>
	</div> <!-- /left -->
	<!-- right(右側のコンテンツ) -->
	<div class="right effect">
		<!-- sign_up(新規登録フォーム) -->
		<div class="sign_up">
			<div class="sign_title">アカウント登録<HR></div>
			<form class="register_form" method="post" action="cushion.php">
				<table class="Register_table">
					<tr>
						<td>
							<!-- プレースホルダーをspan要素で表示する -->
							<div class="placeholding-input">
								<!-- autocompleteをオフにする(プレースホルダと被る) -->
								<input type="text" maxlength="20" name="sei" class="text-input text-sei" autocomplete="off">
								<span class="placeholder">姓</span>
							</div>
						</td>
					</tr>
					<tr>
						<td>
							<div class="placeholding-input">
								<input type="text" maxlength="20" name="mei" class="text-input text-mei" autocomplete="off">
								<span class="placeholder">名</span>
							</div>
						</td>
					</tr>
					<tr>
						<td>
							<div class="placeholding-input">
								<input type="text" maxlength="50" name="mail" class="text-input text-mail" autocomplete="off">
								<span class="placeholder">メールアドレス</span>
							</div>
						</td>
					</tr>
					<tr>
						<td>
							<div class="placeholding-input">
								<input type="password" maxlength="15" name="pass" class="text-input text-pass" autocomplete="off">
								<span class="placeholder">パスワード</span>
							</div>
						</td>
					</tr>
					<tr>
						<td>
							<!-- 2つの要素がこうしないと動いてくれないので,囲む -->
							<div class="move">
								<!-- ロード中のGIF(必要なときに表示させる) -->
								<span class="load-gif1"><img src="images/ajax-loader1.gif" alt="load"></span>
								<input type="submit" class="register" value="アカウント登録">
							</div>
						</td>
					</tr>
					<tr>
						<td>
							<div class="result"><!-- ここに動的にエラーメッセージを表示させる --></div>
						</td>
					</tr>
				</form>
			</table>
		</div> <!-- /sign_up -->
	</div> <!-- /right -->
</div> <!-- /wrap -->
<!-- footer(フッター部分) -->
<div class="footer">
	<div class="footer_content">フッター</div>
</div> <!-- /footer -->
</body>
</html>