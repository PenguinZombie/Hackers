<script type="text/javascript" src="js/Hackers_settei.js"></script>
<form class="rating_settei" method="post" action="rating_settei.php">
<table class="settei_table">
	<tr>
		<th>アイデア</th>
		<!-- idはスライド発生のときに数値をかえるのに必要になる -->
		<td class="slider_view"><div class="slider_idea" id="slider_idea"><!-- ここにjQuery UIでスライダーを表示 --></div></td>
		<td class="slider_value"><input type="text" class="slider_val slider_idea_value" name="slider_idea_value"></td>
		<td><div class="idea_button">ヘルプ</div></td>
	</tr>
	<tr>
		<td colspan="4">
			<div class="idea_button_help">
				自分を10段階で評価してください,下記にあるチェックボックスであなたの推奨値を表示します<br>
				<input type="checkbox"> 何かを企画し、実現したことがある
			</div>
		</td>
	</tr>
	<tr>
		<th>アルゴリズム</th>
		<td class="slider_view"><div class="slider_algorithm" id="slider_algorithm"><!-- ここにjQuery UIでスライダーを表示 --></div></td>
		<td class="slider_value"><input type="text" class="slider_val slider_algorithm_value" name="slider_algorithm_value"></td>
		<td><div class="idea">ヘルプ</div></td>
	</tr>
	<tr>
		<th>デザイン</th>
		<td class="slider_view"><div class="slider_design" id="slider_design"><!-- ここにjQuery UIでスライダーを表示 --></div></td>
		<td class="slider_value"><input type="text" class="slider_val slider_design_value" name="slider_design_value"></td>
		<td><div class="idea">ヘルプ</div></td>
	</tr>
	<tr>
		<th>サーバーサイド</th>
		<td class="slider_view"><div class="slider_serverside" id="slider_serverside"><!-- ここにjQuery UIでスライダーを表示 --></div></td>
		<td class="slider_value"><input type="text" class="slider_val slider_serverside_value" name="slider_serverside_value"></td>
		<td><div class="idea">ヘルプ</div></td>
	</tr>
	<tr>
		<th>クライアントサイド</th>
		<td class="slider_view"><div class="slider_clientside" id="slider_clientside"><!-- ここにjQuery UIでスライダーを表示 --></div></td>
		<td class="slider_value"><input type="text" class="slider_val slider_clientside_value" name="slider_clientside_value"></td>
		<td><div class="idea">ヘルプ</div></td>
	</tr>
	<tr>
		<th>データベース</th>
		<td class="slider_view"><div class="slider_db" id="slider_db"><!-- ここにjQuery UIでスライダーを表示 --></div></td>
		<td class="slider_value"><input type="text" class="slider_val slider_db_value" name="slider_db_value"></td>
		<td><div class="idea">ヘルプ</div></td>
	</tr>
	<tr>
		<th>Linux</th>
		<td class="slider_view"><div class="slider_linux" id="slider_linux"><!-- ここにjQuery UIでスライダーを表示 --></div></td>
		<td class="slider_value"><input type="text" class="slider_val slider_linux_value" name="slider_linux_value"></td>
		<td><div class="idea">ヘルプ</div></td>
	</tr>
	<tr>
		<td colspan="4" class="hbutton"><button class="dialog_open">編集完了</button></td>
	</tr>
</table>
<!-- jQuery UI クラス名をつけるだけで色々なアイコンが簡単にだせる(span要素がアイコン) -->
<div class="ui-area ui-state-highlight" id="msg1">
	<span class="ui-icon ui-icon-check"></span>
	<div>変更を保存しました、プロフィール画面で確認してください。</div>
</div>
</form>
<?php
	require_once("MDB2.php");
	$mdb2 = MDB2::connect("mysql://LAA0170018:kouyansaiko@mysql561.phy.lolipop.jp/LAA0170018-seisaku?charset=utf8");
	// フェッチモード設定 カラム名をキーとする(元の列名に関係なく必ず小文字)
	$mdb2->setFetchMode(MDB2_FETCHMODE_ASSOC);
	$sql = "SELECT user_lang,user_color FROM user_lang WHERE user_id = ?";
	$sth = $mdb2->prepare($sql,array("integer"));
	$rs = $sth->execute(array($id));
	$i = 0;
	echo "<form method='post' action='lang_settei.php'><table class='lang_table'>";
	while($rows = $rs->fetchRow()) {
		if($rows["user_color"] == "red") {
			echo "<tr>";
			echo "<td>";
			echo "<a href='#' class='cta cta-red'>" . $rows["user_lang"] . "</a>";
			echo "</td>";
			echo "<td><input type='radio' name='tokui" . $i . "' value='" . $rows["user_lang"] . ",blue'>得意</td>";
			echo "<td><input type='radio' name='tokui" . $i . "' value='" . $rows["user_lang"] . ",green'>普通</td>";
			echo "<td><input type='radio' name='tokui" . $i . "' value='" . $rows["user_lang"] . ",red' checked>不得意</td>";
			echo "</tr>";
		}else if($rows["user_color"] == "green") {
			echo "<tr>";
			echo "<td>";
			echo "<a href='#' class='cta cta-green'>" . $rows["user_lang"] . "</a>";
			echo "</td>";
			echo "<td><input type='radio' name='tokui" . $i . "' value='" . $rows["user_lang"] . ",blue'>得意</td>";
			echo "<td><input type='radio' name='tokui" . $i . "' value='" . $rows["user_lang"] . ",green' checked>普通</td>";
			echo "<td><input type='radio' name='tokui" . $i . "' value='" . $rows["user_lang"] . ",red'>不得意</td>";
			echo "</tr>";
		}else if($rows["user_color"] == "blue") {
			echo "<tr>";
			echo "<td>";
			echo "<a href='#' class='cta cta-blue'>" . $rows["user_lang"] . "</a>";
			echo "</td>";
			echo "<td><input type='radio' name='tokui" . $i . "' value='" . $rows["user_lang"] . ",blue' checked>得意</td>";
			echo "<td><input type='radio' name='tokui" . $i . "' value='" . $rows["user_lang"] . ",green'>普通</td>";
			echo "<td><input type='radio' name='tokui" . $i . "' value='" . $rows["user_lang"] . ",red'>不得意</td>";
			echo "</tr>";
		}
		$i++;
	}
	echo "<input type='hidden' value='" . $i . "' name='kazu'>";
	echo "</table><input type='submit' value='変更'></form>";
?>
<!-- jQuery UI クラス名をつけるだけで色々なアイコンが簡単にだせる(span要素がアイコン) -->
<div class="ui-area ui-state-highlight" id="msg2">
	<span class="ui-icon ui-icon-check"></span>
	<div>変更を保存しました、プロフィール画面で確認してください。</div>
</div>
<!-- ダイアログ , 普段はdisplay:none で隠しておく span中に値をいれてるが,変更時はhtmlで変更されるので(上書き)問題はない -->
<div class="settei_dialog">
	<table class="dialog_table">
		<tr>
			<th>アイデア：</th>
			<td><span class="slider_val slider_idea_value"></span></td>
		</tr>
		<tr>
			<th>アルゴリズム：</th>
			<td><span class="slider_val slider_algorithm_value"></span></td>
		</tr>
		<tr>
			<th>デザイン：</th>
			<td><span class="slider_val slider_design_value"></span></td>
		</tr>
		<tr>
			<th>サーバーサイド：</th>
			<td><span class="slider_val slider_serverside_value"></td>
		</tr>
		<tr>
			<th>クライアントサイド：</th>
			<td><span class="slider_val slider_clientside_value"></td>
		</tr>
		<tr>
			<th>データベース：</th>
			<td><span class="slider_val slider_db_value"></td>
		</tr>
		<tr>
			<th>Linux：</th>
			<td><span class="slider_val slider_linux_value"></td>
		</tr>
	</table>
	<br>
	<div class="kakunin">上記の内容でよろしければOKボタンを押してください</div>
</div>