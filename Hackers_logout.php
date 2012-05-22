<?php
	ini_set('include_path','PEAR');
	require_once("MDB2.php");
	session_start();
	$id = $_SESSION["id"];
	// からの配列を格納することで全てのセッション変数を削除することができる
	$_SESSION = array();
	// セッションを破棄(ログアウト)
	session_destroy();
	// クッキーも削除
	setcookie("token","クッキーを削除",time() - 60);
	// データベース接続 mysql://ユーザ名:パスワード@ホスト名/DB名?charset=文字コード指定
	$mdb2 = MDB2::connect("mysql://LAA0170018:kouyansaiko@mysql561.phy.lolipop.jp/LAA0170018-seisaku?charset=utf8");
	// $mdb2 = MDB2::connect("mysql://root:kouyansaiko@localhost/hackers?charset=utf8");
	// フェッチモード指定(列名指定)
	$mdb2->setFetchMode(MDB2_FETCHMODE_ASSOC);
	$sql = "DELETE FROM autologin WHERE user_id = ?";
	$sth = $mdb2->prepare($sql,array("integer"));
	$sth->execute(array($id));
	header("Location:Hackers_top.php");
?>
