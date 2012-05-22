<?php
	// インクルードパスを設定
	ini_set('include_path','PEAR');
	// defineでソルトを定義する、ハッシュ化時に使用
	define("SALT","5C4EA7924127AD852EB9751FBC2DAB4A8387F219");
	require_once("MDB2.php");
	// 入力された値をを受け取る
	$sei = $_POST["sei"];
	$mei = $_POST["mei"];
	$mail = $_POST["mail"];
	$pass = $_POST["pass"];
	// チケット(hiddenとセッション)
	session_start();
	$post_ticket = $_POST["ticket"];
	$session_ticket = @$_SESSION["ticket"];
	$string = "";
	// 一つのブラウザで複数確認画面へいくと最後のセッションで全て上書きされてしまう(対策がよくわからなかったので放置)
	// submitでこのページにきているか、二つの値が同じかチェックする
	if(isset($post_ticket) && $session_ticket == $post_ticket) {
		// ここは一度しか実行しないのでセッションを破棄する
		unset($_SESSION["ticket"]);
		user_insert($sei,$mei,$mail,$pass);
		// 正常に実行できた場合の登録完了のメッセージを格納
		$string = "登録が完了しました。<a href='Hackers_top.php'>トップページ</a>からログインしてください。";
	}else{
		// 失敗時のメッセージを格納
		$string = "エラーが発生しました。お手数ですがもう一度<a href='Hackers_top.php'>トップページ</a>から入力してください。";
	}
	/************************************
	　　DBにデータをインサートする関数(ifにいれるとややこしいので)
	*************************************/	
	function user_insert($sei,$mei,$mail,$pass) {
		// データベース接続 mysql://ユーザ名:パスワード@ホスト名/DB名?charset=文字コード指定
		$mdb2 = MDB2::connect("mysql://LAA0170018:kouyansaiko@mysql561.phy.lolipop.jp/LAA0170018-seisaku?charset=utf8");
		// $mdb2 = MDB2::connect("mysql://root:kouyansaiko@localhost/hackers?charset=utf8");
		// フェッチモード設定 カラム名をキーとする(元の列名に関係なく必ず小文字)
		$mdb2->setFetchMode(MDB2_FETCHMODE_ASSOC);
		// SQL文生成(静的プレースホルダ) 方法はいくつかある(参考資料:PEAR MDB2~)
		$sql = "INSERT INTO kaiin(user_sei,user_mei,user_mail,user_pass) ";
		$sql.= "VALUES(?,?,?,?)";
		// データ型指定(すべてvarcharなのでtext) ?の順番で指定
		$sth = $mdb2->prepare($sql,array("text","text","text","text"));
		// パスワードを パスワード+ソルト(メールアドレス+固定文字列) にしてsha256でハッシュ化する
		$salt = $mail . SALT;
		$hash =  hash("sha256",$pass . $salt);
		// 値を渡して実行
		$sth->execute(array($sei,$mei,$mail,$hash));
	}
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
	<div class="logo"><a href="Hackers_top.php"><img src="images/Hackers.png" alt="Hackers"></a></div>
</div> <!-- /header -->

<!-- wrap(1カラムレイアウト,centerを包むクラス -->
<div class="wrap effect">
	<div class="center">
		<div class="moj"><?php echo $string; ?></div>
	</div> <!-- /center -->
</div> <!-- /wrap -->
<!-- footer(フッター部分) -->
<div class="footer">
	<div class="footer_content">フッター</div>
</div> <!-- /footer -->
</body>
</html>