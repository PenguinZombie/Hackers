<?php
	// インクルードパスを設定
	ini_set('include_path','PEAR');
	require_once("MDB2.php");
	session_start();
	$id = $_SESSION["id"];
	// 変更後のレーティングの値を10倍して受け取る
	$idea = $_POST["slider_idea_value"] * 10;
	$algorithm = $_POST["slider_algorithm_value"] * 10;
	$design = $_POST["slider_design_value"] * 10;
	$serverside = $_POST["slider_serverside_value"] * 10;
	$clientside = $_POST["slider_clientside_value"] * 10;
	$db = $_POST["slider_db_value"] * 10;
	$linux = $_POST["slider_linux_value"] * 10;
	// インサートしたあと設定画面に戻し,変更完了の文字を出す
	// データベース接続 mysql://ユーザ名:パスワード@ホスト名/DB名?charset=文字コード指定
	$mdb2 = MDB2::connect("mysql://LAA0170018:kouyansaiko@mysql561.phy.lolipop.jp/LAA0170018-seisaku?charset=utf8");
	// $mdb2 = MDB2::connect("mysql://root:kouyansaiko@localhost/hackers?charset=utf8");
	// フェッチモード設定 カラム名をキーとする(元の列名に関係なく必ず小文字)
	$mdb2->setFetchMode(MDB2_FETCHMODE_ASSOC);
	$sql = "UPDATE user_rating SET user_idea = ?";
	$sql.= ",user_algorithm = ?";
	$sql.= ",user_design = ?";
	$sql.= ",user_serverside = ?";
	$sql.= ",user_clientside = ?";
	$sql.= ",user_db = ?";
	$sql.= ",user_linux = ?";
	$sql.= " WHERE user_id = ?";
	// データ型指定
	$sth = $mdb2->prepare($sql,array("integer","integer","integer","integer","integer","integer","integer","integer"));
	// 値を渡して実行(UPDATE)
	$sth->execute(array($idea,$algorithm,$design,$serverside,$clientside,$db,$linux,$id));
	// 登録しましたの画面を出さないタイプにする(新規登録とは違う)
	// 変更画面にメッセージを出して表示する形にする
	header("location:Hackers_settei.php?ok_rating");
?>