<?php
	ini_set('include_path','PEAR');
	// もう一度しないとエラーがでる
	// mdb2.phpは読み込めているので影響がでると思われるので,名前が被らないようにcssで設定する(読み込みはallのほうでする)
	// データベース接続 mysql://ユーザ名:パスワード@ホスト名/DB名?charset=文字コード指定
	$mdb2 = MDB2::connect("mysql://LAA0170018:kouyansaiko@mysql561.phy.lolipop.jp/LAA0170018-seisaku?charset=utf8");
	// $mdb2 = MDB2::connect("mysql://root:kouyansaiko@localhost/hackers?charset=utf8");
	// フェッチモード指定(列名指定)
	$mdb2->setFetchMode(MDB2_FETCHMODE_ASSOC);
	/************************************
	  画像のパスを受け取る処理
	*************************************/
	$sql = "SELECT image_path FROM user_images WHERE user_id = ?";
	$sth = $mdb2->prepare($sql,array("text"));
	$rs = $sth->execute(array($id));
	// 結果から1行を取得(画像があればそのパスを,なければNo_Imageを表示
	$rows = $rs->fetchRow();
	if($rows > 0) {
		$image = $rows["image_path"];
	}else{
		$image = "images/No_Image.png";
	}
	/************************************
	  レーティングの値を受け取る処理
	*************************************/
	$sql = "SELECT * FROM user_rating WHERE user_id = ?";
	$sth = $mdb2->prepare($sql,array("integer"));
	$rs = $sth->execute(array($id));
	$rows = $rs->fetchRow();
	if($rows > 0) {
		// 種類を判別,0ならPG,SE 1ならweb系 わけるのは種類に応じて項目が違うから
		if($rows["user_syurui"] == 0) {
			// 未実装
		}else{
			// 全て値を変数に格納する(html側でわかりやすい) 値チェックをループでしたいので配列
			// 使ったことがないので連想配列でやってみる,レーティングの仕様があれなので-6した値を格納
			$rating = array(
				"idea"			=> $rows["user_idea"] - 6,
				"algorithm"		=> $rows["user_algorithm"] - 6,
				"design"		=> $rows["user_design"] - 6,
				"serverside" 	=> $rows["user_serverside"] - 6,
				"clientside" 	=> $rows["user_clientside"] - 6,
				"db"			=> $rows["user_db"] - 6,
				"linux"			=> $rows["user_linux"] - 6
			);
			// colorをあらかじめ作る必要がなく動作するけど、ややこしいと思うので残しておく
			// グラフの色を格納する,適当な値をいれて準備しておく
			$color = array(
				"idea"			=> "none",
				"algorithm"		=> "none",
				"design"		=> "none",
				"serverside"	=> "none",
				"clientside"	=> "none",
				"db"			=> "none",
				"linux"			=> "none"
			);
			// この時点で-6されているので+6した値が実際のパーセント(ややこしい)
			// 4(10%)未満なら一律4(10%)にする,同じキー($key)で色の種類を格納する
			foreach($rating as $key => $val) {
				// レーティングの値格納
				$rval = $rating[$key];
				if($rval < 4) {
					// 4未満なら4(10%)にする
					$rating[$key] = 4;
					$color[$key] = "red";
				}else if($rval < 34) {
					// 34(40%)未満なら赤色
					$color[$key] = "red";
				}else if($rval < 59) {
					// 59(65%)未満なら緑色
					$color[$key] = "green";
				}else{
					// 59(65%)以上なら青色
					$color[$key] = "blue";
				}	
			}	
		}
	}
	/************************************
	  数値計算の関数
	*************************************/
	function rating_suuti($suuti) {
		//$ratingの値を受け取り,1.0~10.0で表示するのでこういう計算
		$rating = ($suuti+6) * 0.1;
		// 一桁の場合は .0 を付け足す
		if(strlen($rating) == 1) {
			$rating = $rating . ".0";
		}
		return $rating;
	}
?>
<!-- パーツに記述すれば毎回読み込む(他に影響は与えないはず) -->
<script type="text/javascript" src="js/Hackers_main2.js"></script>
<!-- css3のboxがここに囲みも記述しないときかないのでここに記述する -->
<div class="center_con_con">
	<div class="center_left">
		<img src="<?php echo $image; ?>" width="179" height="195" alt="プロフィール画像">
		<div class="proglang">
			<?php
				/************************************
				  言語情報を取得し表示
				*************************************/
				$sql = "SELECT user_lang,user_color FROM user_lang WHERE user_id = ?";
				$sth = $mdb2->prepare($sql,array("integer"));
				$rs = $sth->execute(array($id));
				while($rows = $rs->fetchRow()) {
					if($rows["user_color"] == "red") {
						echo "<a href='#' class='cta cta-red'>" . $rows["user_lang"] . "</a>";
					}else if($rows["user_color"] == "green") {
						echo "<a href='#' class='cta cta-green'>" . $rows["user_lang"] . "</a>";
					}else if($rows["user_color"] == "blue") {
						echo "<a href='#' class='cta cta-blue'>" . $rows["user_lang"] . "</a>";
					}
				}
			?>
		</div>
	</div>
	<div class="center_right">
		<div class="rating_view">
			<table class="rating_talbe">
				<tr>
					<th class="mainth">アイデア</th>
				</tr>
				<tr>
					<td>
						<!--　レーティングの黒色の背景 -->
						<div class="rating_back">
							<!-- レーティング計算の関数を呼び出し戻り値を表示 -->
							<div class="suuti"><?php echo rating_suuti($rating["idea"]); ?></div>
							<!-- 左端の画像,レーティングのメインの画像,右端の画像の順番で並んでいる
				　				 間に隙間をあけたくないので詰めた記述になっている,拡大縮小だと多少おかしくなるのでサイドの部分を用意
								 センター94%でレーティングマックス(widht:284),全て合わせて100がわからないので-6した値を使う
								 ファイル名は rating_色_left みたいな感じに統一してあるので色の部分を変数でいれる -->
							<img src="images/rating_<?php echo $color["idea"]; ?>_left.png" width="8" height="22" alt="アイデア" class="rating_left"><img
							src="images/rating_<?php echo $color["idea"]; ?>_center.png" width="<?php echo $rating["idea"]; ?>%" height="24" alt="アイデア" class="rating_center"><img
							src="images/rating_<?php echo $color["idea"]; ?>_right.png" width="8" height="22" alt="アイデア" class="rating_right">
						</div>
					</td>
				</tr>
				<tr>
					<th class="mainth">アルゴリズム</th>
				</tr>
				<tr>
					<td>
						<div class="rating_back">
							<div class="suuti"><?php echo rating_suuti($rating["algorithm"]); ?></div>
							<img src="images/rating_<?php echo $color["algorithm"]; ?>_left.png" width="8" height="22" alt="アルゴリズム" class="rating_left"><img
							src="images/rating_<?php echo $color["algorithm"]; ?>_center.png" width="<?php echo $rating["algorithm"]; ?>%" height="24" alt="アルゴリズム" class="rating_center"><img
							src="images/rating_<?php echo $color["algorithm"]; ?>_right.png" width="8" height="22" alt="アルゴリズム" class="rating_right">
						</div>
					</td>
				</tr>
				<tr>
					<th class="mainth">デザイン</th>
				</tr>
				<tr>
					<td>
						<div class="rating_back">
							<div class="suuti"><?php echo rating_suuti($rating["design"]); ?></div>
							<img src="images/rating_<?php echo $color["design"]; ?>_left.png" width="8" height="22" alt="デザイン" class="rating_left"><img
							src="images/rating_<?php echo $color["design"]; ?>_center.png" width="<?php echo $rating["design"]; ?>%" height="24" alt="デザイン" class="rating_center"><img
							src="images/rating_<?php echo $color["design"]; ?>_right.png" width="8" height="22" alt="デザイン" class="rating_right">
						</div>
					</td>
				</tr>
				<tr>
					<th class="mainth">サーバーサイド</th>
				</tr>
				<tr>
					<td>
						<div class="rating_back">
							<div class="suuti"><?php echo rating_suuti($rating["serverside"]); ?></div>
							<img src="images/rating_<?php echo $color["serverside"]; ?>_left.png" width="8" height="22" alt="サーバーサイド" class="rating_left"><img
							src="images/rating_<?php echo $color["serverside"]; ?>_center.png" width="<?php echo $rating["serverside"]; ?>%"" height="24" alt="サーバーサイド" class="rating_center"><img
							src="images/rating_<?php echo $color["serverside"]; ?>_right.png" width="8" height="22" alt="サーバーサイド" class="rating_right">
						</div>
					</td>
				</tr>
				<tr>
					<th class="mainth">クライアントサイド</th>
				</tr>
				<tr>
					<td>
						<div class="rating_back">
							<div class="suuti"><?php echo rating_suuti($rating["clientside"]); ?></div>
							<img src="images/rating_<?php echo $color["clientside"]; ?>_left.png" width="8" height="22" alt="クライアントサイド" class="rating_left"><img
							src="images/rating_<?php echo $color["clientside"]; ?>_center.png" width="<?php echo $rating["clientside"]; ?>%" height="24" alt="クライアントサイド" class="rating_center"><img
							src="images/rating_<?php echo $color["clientside"]; ?>_right.png" width="8" height="22" alt="クライアントサイド" class="rating_right">
						</div>
					</td>
				</tr>
				<tr>
					<th class="mainth">データベース</th>
				</tr>
				<tr>
					<td>
						<div class="rating_back">
							<div class="suuti"><?php echo rating_suuti($rating["db"]); ?></div>
							<img src="images/rating_<?php echo $color["db"]; ?>_left.png" width="8" height="22" alt="データベース" class="rating_left"><img
							src="images/rating_<?php echo $color["db"]; ?>_center.png" width="<?php echo $rating["db"]; ?>%" height="24" alt="データベース" class="rating_center"><img
							src="images/rating_<?php echo $color["db"]; ?>_right.png" width="8" height="22" alt="データベース" class="rating_right">
						</div>
					</td>
				</tr>
				<tr>
					<th class="mainth">Linux</th>
				</tr>
				<tr>
					<td>
						<div class="rating_back">
							<div class="suuti"><?php echo rating_suuti($rating["linux"]); ?></div>
							<img src="images/rating_<?php echo $color["linux"]; ?>_left.png" width="8" height="22" alt="Linux" class="rating_left"><img
							src="images/rating_<?php echo $color["linux"]; ?>_center.png" width="<?php echo $rating["linux"]; ?>%" height="24" alt="Linux" class="rating_center"><img
							src="images/rating_<?php echo $color["linux"]; ?>_right.png" width="8" height="22" alt="Linux" class="rating_right">
						</div>
					</td>
				</tr>
			</table>
		</div>
	</div>
</div>