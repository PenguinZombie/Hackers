<link rel="stylesheet" type="text/css" href="css/Hackers_com.css">
<script type="text/javascript" src="js/Hackers_com.js"></script>
<?php
	ini_set('include_path','PEAR');
	require_once("MDB2.php");
	// データベース接続 mysql://ユーザ名:パスワード@ホスト名/DB名?charset=文字コード指定
	$mdb2 = MDB2::connect("mysql://LAA0170018:kouyansaiko@mysql561.phy.lolipop.jp/LAA0170018-seisaku?charset=utf8");
	// $mdb2 = MDB2::connect("mysql://root:kouyansaiko@localhost/hackers?charset=utf8");
	// フェッチモード設定 カラム名をキーとする(元の列名に関係なく必ず小文字)
	$mdb2->setFetchMode(MDB2_FETCHMODE_ASSOC);
?>
<div class="com_area">
	<!-- 所属しているコミュニティ表示エリア -->
	<div class="my_com_area">
		-----所属しているコミュニティ-----<br>
		<?php
			// user_comから所属しているNoを引っ張ってきて一致するものを全て表示
			$sql = "SELECT * FROM community WHERE com_no IN (SELECT com_no FROM user_com WHERE user_id = ?)";
			$sth = $mdb2->prepare($sql,array("integer"));
			$rs = $sth->execute(array($id));
			while($rows = $rs->fetchRow()) {
				echo "<div class='com_info_". $rows["com_no"] ."'>";
				echo "コミュニティタイトル    : ". $rows["com_name"] ."<br>";
				echo "コミュニティ説明     : ". $rows["com_message"] ."<br>";
				echo "<input type='button' id='". $rows["com_no"] ."' class='dattai' value='脱退する'><br><br>";
				echo "</div>";
			}
		?>
	</div>
	<!-- 未所属のコミュニティ表示エリア -->
	<div class="all_com_area">
		<!-- プレースホルダーをspan要素で表示する -->
		<div class="placeholding-input">
			<!-- autocompleteをオフにする(プレースホルダと被る) -->
			<input type="text" maxlength="50" name="search" class="com_search" autocomplete="off">
			<span class="placeholder">コミュニティを検索...</span>
		</div>
	-----その他のコミュニティ-----<br>
	<div class="sonota_com">
		<?php
			// user_comから所属しているNoを引っ張ってきて一致しないものを全て表示
			$sql = "SELECT * FROM community WHERE com_no NOT IN (SELECT com_no FROM user_com WHERE user_id = ?)";
			$sth = $mdb2->prepare($sql,array("integer"));
			$rs = $sth->execute(array($id));
			while($rows = $rs->fetchRow()) {
				echo "<div class='com_info_". $rows["com_no"] ."'>";
				echo "コミュニティタイトル    : ". $rows["com_name"] ."<br>";
				echo "コミュニティ説明     : ". $rows["com_message"] ."<br>";
				echo "<input type='button' id='". $rows["com_no"] ."' class='sanka' value='参加する'><br><br>";
				echo "</div>";
			}
		?>
		</div>
	</div>
</div>