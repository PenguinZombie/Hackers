<?php
	session_start();
	$id = $_SESSION["id"];
	$text = $_SESSION["diary_text"];
	// mysqlのデータのフォーマットに合わせる
	$today = time();
	// 日記の内容のセッションを破棄
	unset($_SESSION["diary_text"]);
	// インクルードパスを設定
	ini_set('include_path','PEAR');
	require_once("MDB2.php");
	// インサートしたあと設定画面に戻し,変更完了の文字を出す
	// データベース接続 mysql://ユーザ名:パスワード@ホスト名/DB名?charset=文字コード指定
	$mdb2 = MDB2::connect("mysql://LAA0170018:kouyansaiko@mysql561.phy.lolipop.jp/LAA0170018-seisaku?charset=utf8");
	// $mdb2 = MDB2::connect("mysql://root:kouyansaiko@localhost/hackers?charset=utf8");
	// フェッチモード設定 カラム名をキーとする(元の列名に関係なく必ず小文字)
	$mdb2->setFetchMode(MDB2_FETCHMODE_ASSOC);
	$sql = "INSERT INTO user_diary(user_id,user_text,user_time) ";
	$sql.= "VALUES(?,?,?)";
	$sth = $mdb2->prepare($sql,array("integer","text","integer"));
	$sth->execute(array($id,$text,$today));
	header("Location:Hackers_diary.php");
?>