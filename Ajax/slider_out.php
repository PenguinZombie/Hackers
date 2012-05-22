<?php
	require_once("MDB2.php");
	session_start();
	$id = $_SESSION["id"];
	// データベース接続 mysql://ユーザ名:パスワード@ホスト名/DB名?charset=文字コード指定
	$mdb2 = MDB2::connect("mysql://LAA0170018:kouyansaiko@mysql561.phy.lolipop.jp/LAA0170018-seisaku?charset=utf8");
	// $mdb2 = MDB2::connect("mysql://root:kouyansaiko@localhost/hackers?charset=utf8");
	// フェッチモード設定 カラム名をキーとする(元の列名に関係なく必ず小文字)
	$mdb2->setFetchMode(MDB2_FETCHMODE_ASSOC);
	// sql文,idをキーに現在のレーティングの値を取ってくる
	$sql = "SELECT * FROM user_rating WHERE user_id = ?";
	$sth = $mdb2->prepare($sql,array("integer"));
	$rs = $sth->execute(array($id));
	$rows = $rs->fetchRow();
	// 1行でもあれば(必ずある)
	if($rows > 0) {
		// 種類を判別,0ならPG,SE 1ならweb系 わけるのは種類に応じて項目が違うから
		if($rows["user_syurui"] == 0) {
			// 未実装
		}else{
			// 全て値を変数に格納する(html側でわかりやすい) こちらはDBに格納する値なので-6はしない
			// js側でするとややこしいので÷10して格納する
			$rating = array(
				$rows["user_idea"] / 10,
				$rows["user_algorithm"] / 10,
				$rows["user_design"] / 10,
				$rows["user_serverside"] / 10,
				$rows["user_clientside"] / 10,
				$rows["user_db"] / 10,
				$rows["user_linux"] / 10
			);
		}
	}
	$rating_csv = join(",",$rating); 
	echo $rating_csv
?>