<?php
	session_start();
	require_once("MDB2.php");
	$id = $_SESSION["id"];
	$com_no = $_POST["com_no"];
	// データベース接続 mysql://ユーザ名:パスワード@ホスト名/DB名?charset=文字コード指定
	$mdb2 = MDB2::connect("mysql://LAA0170018:kouyansaiko@mysql561.phy.lolipop.jp/LAA0170018-seisaku?charset=utf8");
	// $mdb2 = MDB2::connect("mysql://root:kouyansaiko@localhost/hackers?charset=utf8");
	// フェッチモード設定 カラム名をキーとする(元の列名に関係なく必ず小文字)
	$mdb2->setFetchMode(MDB2_FETCHMODE_ASSOC);
	// IDとコミュニティNoが一致するものを削除
	$sql = "INSERT INTO user_com(user_id,com_no) ";
	$sql.= "VALUES(?,?)";
	$sth = $mdb2->prepare($sql,array("integer","integer"));
	$sth->execute(array($id,$com_no));
	// user_comから所属しているNoを引っ張ってきて一致するものを全て表示
	$sql = "SELECT * FROM community WHERE com_no IN (SELECT com_no FROM user_com WHERE user_id = ?)";
	$sth = $mdb2->prepare($sql,array("integer"));
	$rs = $sth->execute(array($id));
	echo "-----所属しているコミュニティ-----<br>";
	while($rows = $rs->fetchRow()) {
		echo "<div class='com_info_". $rows["com_no"] ."'>";
		echo "コミュニティタイトル    : ". $rows["com_name"] ."<br>";
		echo "コミュニティ説明     : ". $rows["com_message"] ."<br>";
		echo "<input type='button' id='". $rows["com_no"] ."' class='dattai' value='脱退する'><br><br>";
		echo "</div>";
	}
?>
<script type="text/javascript" src="js/Hackers_com.js"></script>