<?php
	// インクルートのパス設定
	ini_set('include_path','PEAR');
	require_once("MDB2.php");
	session_start();
	$id = $_SESSION["id"];
	// DBの準備
	// データベース接続 mysql://ユーザ名:パスワード@ホスト名/DB名?charset=文字コード指定
	$mdb2 = MDB2::connect("mysql://LAA0170018:kouyansaiko@mysql561.phy.lolipop.jp/LAA0170018-seisaku?charset=utf8");
	// $mdb2 = MDB2::connect("mysql://root:kouyansaiko@localhost/hackers?charset=utf8");
	// フェッチモード設定 カラム名をキーとする(元の列名に関係なく必ず小文字)
	$mdb2->setFetchMode(MDB2_FETCHMODE_ASSOC);
	// idが同じでかつ言語名が同じものを変更
	$sql = "UPDATE user_lang SET user_color = ? WHERE user_id = ? AND user_lang = ?";
	$sth = $mdb2->prepare($sql,array("text","integer","text"));
	$loop = $_POST["kazu"];
	for($i=0; $i<$loop; $i++) {
		// 言語,色で送られてくるので区切って格納(0に言語,1に色が入る)
		$langset = preg_split("/,/",$_POST["tokui" . $i]);
		$sth->execute(array($langset[1],$id,$langset[0]));
	}
	header("Location:Hackers_settei.php?ok_lang");
?>