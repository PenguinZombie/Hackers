<?php
	// インクルードパスを設定
	ini_set('include_path','PEAR');
	require_once("MDB2.php");
	require_once("str_conv.php");
	$diarytext = @$_SESSION["diary_text"];
	// js css phpが読み込めてるか確認に使用,これと最後のコメントを解除すれば使える
	// include 'PHPBugLost/phpBugLost.0.3.php';
?>
<link rel="stylesheet" type="text/css" href="css/styles.css">
<link rel="stylesheet" type="text/css" href="css/Hackers_diary.css">
<link rel="stylesheet" type="text/css" href="css/style/shCore.css">
<link rel="stylesheet" type="text/css" href="css/style/shCoreDefault.css">
<script type="text/javascript" src="js/scripts/shCore.js"></script>
<!-- ローカルでは使えないみたい <script type="text/javascript" src="js/scripts/shAutoloader.js"></script> -->
<script type="text/javascript" src="js/scripts/shBrushCpp.js"></script>
<script type="text/javascript" src="js/scripts/shBrushCSharp.js"></script>
<script type="text/javascript" src="js/scripts/shBrushCss.js"></script>
<script type="text/javascript" src="js/scripts/shBrushGroovy.js"></script>
<script type="text/javascript" src="js/scripts/shBrushJava.js"></script>
<script type="text/javascript" src="js/scripts/shBrushJavaFX.js"></script>
<script type="text/javascript" src="js/scripts/shBrushJScript.js"></script>
<script type="text/javascript" src="js/scripts/shBrushPhp.js"></script>
<script type="text/javascript" src="js/scripts/shBrushPerl.js"></script>
<script type="text/javascript" src="js/scripts/shBrushPython.js"></script>
<script type="text/javascript" src="js/scripts/shBrushRuby.js"></script>
<script type="text/javascript" src="js/scripts/shBrushScala.js"></script>
<script type="text/javascript" src="js/scripts/shBrushSql.js"></script>
<script type="text/javascript" src="js/scripts/shBrushVb.js"></script>
<script type="text/javascript" src="js/scripts/shBrushXml.js"></script>
<script type="text/javascript" src="js/Hackers_diary.js"></script>
<script type="text/javascript" src="js/Hackers_diary2.js"></script>
<input type="button" class="css3button" value="日記を追加">
<div class="diary_area">
	<input type="button" id="php" class="lang_code" value="PHP Code">
	<input type="button" id="perl" class="lang_code" value="Perl Code">
	<input type="button" id="python" class="lang_code" value="Python Code">
	<input type="button" id="ruby" class="lang_code" value="Ruby Code">
	<select class="code">
		<option id="cpp">C,C++</option>
		<option id="csharp">C#</option>
		<option id="css">CSS</option>
		<option id="groovy">Groovy</option>
		<option id="java">Java</option>
		<option id="javafx">JavaFX</option>
		<option id="js">Javascript</option>
		<option id="xhtml">HTML/XHTML</option>
		<option id="scala">Scala</option>
		<option id="vb">Visual Basic</option>
	</select>
	<input type="button" class="code_area" value="Other Code">
	<!-- top画面と同じ,プレースホルダのため -->
	<div class="placeholding-input">
		<form class="diary_form" method="post" action="diary_cushion.php">
		<textarea class="user_text" maxlength="8000" name="user_text"><?php echo $diarytext; ?></textarea>
		<div class="placeholder">printf("ここに入力してください");</div>
		</form>
	</div>
	<input type="submit" value="確認画面へ" class="diary_kakunin">
</div>
<div class="diary_out_area">
	<div class="diary_out">
	<?php
		// 1ページに表示する数、8000文字なので3つにしておく
		$diarys = 3;
		// diarysを引数にスタート行を取得する
		list($start,$page) = startIndex($diarys);
		// データベース接続 mysql://ユーザ名:パスワード@ホスト名/DB名?charset=文字コード指定
		$mdb2 = MDB2::connect("mysql://LAA0170018:kouyansaiko@mysql561.phy.lolipop.jp/LAA0170018-seisaku?charset=utf8");
		// $mdb2 = MDB2::connect("mysql://root:kouyansaiko@localhost/hackers?charset=utf8");
		// フェッチモード設定 カラム名をキーとする(元の列名に関係なく必ず小文字)
		$mdb2->setFetchMode(MDB2_FETCHMODE_ASSOC);
		// 日付の降順で取り出す(SQL_CALC_FOUND_ROWSがあればFOUND_ROWS()で全部で何件あるかを取得出来る(limitを外した結果での数値)
		$sql = "SELECT SQL_CALC_FOUND_ROWS user_text,user_time,diary_id FROM user_diary WHERE user_id = ? ORDER BY diary_id DESC";
		// setLimit(end,start) start行 からはじめ end行 読み込む
		$mdb2->setLimit(3,$start);
		$sth = $mdb2->prepare($sql,array("integer"));
		$rs = $sth->execute(array($id));
		while($rows = $rs->fetchRow()) {
			$text = $rows["user_text"];
			// 文字列をシンタックスハイライトの仕様に変換+タグ対策(配列で返ってくる)
			$diary = str_conv($text);
			echo "<div class='diary_out_one'>";
			// テキストによって要素数が変わるのでeachで回す
			echo "<div class='diary_day'>" . date("Y-m-d G時i分",$rows["user_time"]);
			echo "<hr class='suihei'></div>";
			foreach($diary as $value) {
				echo $value;
			}
			echo "</div>";
		}
		// 全部で何件かを取得する プレアドではなく普通の実行(query)
		$sql = "SELECT FOUND_ROWS() as count";
		$rs = $mdb2->query($sql);
		$rows = $rs->fetchRow();
		// センタリングのため
		echo "<div class='back_next'>";
		// 前のページ,次のページ,総件数を表示(現在のページ,1ページの表示数,総件数が引数)
		back_next($page,$diarys,$rows["count"]);
		echo "</div>";
		// 切断
		$mdb2->disconnect();
		/************************************
		  スタート位置を返す関数
		*************************************/
		function startIndex($diarys) {
			// pが送られていて（0が1ページ目)、数値ならばそれを格納,違うなら0に設定
			if(isset($_GET["p"]) && is_numeric($_GET["p"])) {
				$page = $_GET["p"];
				// セッションに保存するのはシンタックスハイライターの未解決バグのため
				$_SESSION["NoPjax"] = true;
			}else{
				$page = 1;
			}
			// 1ページ目なら0行目から出力なので0を格納
			if($page == 1) {
				$start = 0;
			}else{
				// そうじゃない場合は-1してそれをかける(3ページ目なら6行目から)
				$start = $diarys * ($page-1);
			}				
			return array($start,$page);
		}
		/************************************
		  前のページ,次のページ,総件数を表示する関数(前 1 ... 4 5 6 7 8 9 10 ... 25 次 のようにする)
		*************************************/
		// Ajaxを使用して画面繊維をしないように(もっと読む的なやつ,スクロールで下までくれば自動的に3件増やす)
		// をしたかったけど、シンタックスハイライターが読み込んだときに値が入っていないとダメみたいでこのタイプにした
		// 参考資料に詳しいコメントをメモしている(基本は現在±3を表示)
		function back_next($page,$diarys,$count) {
			// ２ページ目以上なら前のページへもどるをまず設置
			if($page > 1) {
				// 前のページ
				echo "<span class='pagination_one'><a href='Hackers_diary.php?p=" . ($page-1) ."'><img src='images/pagination/left.png' alt='前のページ'></a></span>";
			}else{
				// ないとき(１ページ目)
				echo "<span class='NoPages'><img src='images/pagination/NoLeft.png' alt='前のページはありません'></span>";
			}
			// 確定したものから出力していきたいので-3からスタートする
			for($i=3; $i>0; $i--) {
				// $iを引いた値を格納
				$page_copy = $page-$i;
				if($page_copy > 0) {
					// 一回目のループ時に$page_copyが3以上なら 1 ... を表示
					if($i == 3 && $page_copy > 2) {
						// 1 ... を表示
						echo "<span class='pagination_one'><a href='Hackers_diary.php?p=1'><img src='images/pagination/pages.png' alt='". $page_copy ."'><span class='pagination_pages_one'>1</span></a></span>";
						echo "<span class='pagination_one'><img src='images/pagination/keika.png' alt='省略'></span>";
					}else if($i == 3 && $page_copy == 2) {
						// 2なら 1を最初に追加
						echo "<span class='pagination_one'><a href='Hackers_diary.php?p=1'><img src='images/pagination/pages.png' alt='". $page_copy ."'><span class='pagination_pages_one'>1</span></a></span>";"<span class='pagination_one'><a href='Hackers_diary.php?p=1'><img src='images/pagination/pages.png' alt='>". $page_copy ."'><span class='pagination_pages_one'>1</span></a></span>";
					}
					// クラス名を取得
					$classname = numLength($page_copy);
					// ページ番号を表示
					echo "<span class='pagination_one'><a href='Hackers_diary.php?p=" . ($page-$i) ."'><img src='images/pagination/pages.png' alt='". $page_copy ."'><span class='". $classname ."'>". $page_copy ."</span></a></span>";
				}
			}
			// 現在のページ
			// クラス名を取得
			$classname = numLength($page);
			// ページ番号を表示
			echo "<span class='pagination_one pagination_current'><a href='Hackers_diary.php?p=" . $page ."'><img src='images/pagination/current.png' alt='". $page ."'><span class='". $classname ."'>". $page ."</span></a></span>";
			// 最終のページ番号を求める(切り上げ)
			$lastNum = ceil($count / $diarys);
			// 次のページがあるかどうかの判定変数
			$next = false;
			for($i=1; $i<=3; $i++) {
				// $iを足した値を格納
				$page_copy = $page+$i;
				// それが$lastNumより同じか小さければそのページを表示
				if($page_copy <= $lastNum) {
					// クラス名を取得
					$classname = numLength($page_copy);
					echo "<span class='pagination_one'><a href='Hackers_diary.php?p=" . ($page+$i) ."'><img src='images/pagination/pages.png' alt='". $page_copy ."'><span class='". $classname ."'>". $page_copy ."</span></a></span>";
					// ここに通るということは次のページが存在するのでtrueにする
					$next = true;
				}
			}
			// 3回ループ後+1の数値より$lastNumのほうが大きい場合は ... $lastNum を表示
			if($page_copy+1 < $lastNum) {				
				// ... $lastNum を表示
				echo "<span class='pagination_one'><img src='images/pagination/keika.png' alt='省略'></span>";
				// クラス名を取得
				$classname = numLength($lastNum);
				// ページ番号を表示
				echo "<span class='pagination_one'><a href='Hackers_diary.php?p=" . ($lastNum) ."'><img src='images/pagination/pages.png' alt='" . $lastNum ."'><span class='". $classname ."'>". $lastNum ."</span></a></span>";
			}else if($page_copy+1 == $lastNum) {
				// +1して同じなら 4 5 6 ... 7 となるのでおかしい
				// 4 5 6 7 と表示
				// クラス名を取得
				$classname = numLength($lastNum);
				// ページ番号を表示
				echo "<span class='pagination_one'><a href='Hackers_diary.php?p=" . ($lastNum) ."'><img src='images/pagination/pages.png' alt='" . $lastNum ."'><span class='". $classname ."'>". $lastNum ."</span></a></span>";
			}
			// nextがtrueなら表示
			if($next) {
				// 次のページを表示
				echo "<span class='pagination_one'><a href='Hackers_diary.php?p=" . ($page+1) ."'><img src='images/pagination/right.png' alt='次のページ'></a></span>";
			}else{
				echo "<span class='NoPages'><img src='images/pagination/NoRight.png' alt='次のページはありません'></span>";
			}

		}
		/************************************
		  桁数に応じてクラス名を返す関数
		*************************************/
		function numLength($num) {
			// 画像に文字を重ねているが相対指定なので桁が変わるとずれるので適したクラスを返す
			if(strlen($num) == 1) {
				// 1桁の場合
				return "pagination_pages_one";
			}else if(strlen($num) == 2) {
				// 2桁の場合
				return "pagination_pages_two";
			}else if(strlen($num) == 3) {
				return "pagination_pages_th";
			}
		}
	?>
	</div>
</div>
<?php
	// echo bl_debug();
?>