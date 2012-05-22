<?php
	// PEARのMDB2ライブラリを読み込む
	require_once("MDB2.php");
	// 入力された値受け取り
	$sei = $_POST["sei"];
	$mei = $_POST["mei"];
	$mail = $_POST["mail"];
	$pass = $_POST["pass"];
	// データベース接続 mysql://ユーザ名:パスワード@ホスト名/DB名?charset=文字コード指定
	$mdb2 = MDB2::connect("mysql://LAA0170018:kouyansaiko@mysql561.phy.lolipop.jp/LAA0170018-seisaku?charset=utf8");
	//$mdb2 = MDB2::connect("mysql://root:kouyansaiko@localhost/hackers?charset=utf8");
	// 失敗することはないが失敗時のエラーメッセージ
	if(PEAR::isError($mdb2)) {
		die($mdb2->getMessage());
	}
	// フェッチモード設定 カラム名をキーとする(元の列名に関係なく必ず小文字)
	$mdb2->setFetchMode(MDB2_FETCHMODE_ASSOC);
	// SQL文生成(静的プレースホルダ)
	$sql = "SELECT user_mail FROM kaiin WHERE user_mail = ?";
	// データ型指定
	$sth = $mdb2->prepare($sql,array("text"));
	// mailをセットして実行
	$rs = $sth->execute(array($mail));
	// 結果から1行を取得
	$rows = $rs->fetchRow();
	// 文字コードがUTF-8以外の時はUTF-8に変換する
	/* 何故かローカルだとエラーが発生するので保留
	if(!mb_check_encoding($sei,"UTF-8")) {
		$sei = mb_convert_encoding($sei,"UTF-8",auto);
		$mei = mb_convert_encoding($mei,"UTF-8",auto);
		$mail = mb_convert_encoding($mail,"UTF-8",auto);
		$pass = mb_convert_encoding($pass,"UTF-8",auto);
	}
	*/
	// 値から半角,全角のスペースを削除する
	// 複数のワードを検索する場合は配列を使用
	$search = array(" ","　");
	// str_replace(検索文字列,置換文字列,対象)
	$sei = str_replace($search,"",$sei);
	$mei = str_replace($search,"",$mei);
	$mail = str_replace($search,"",$mail);
	$pass = str_replace($search,"",$pass);
	/************************************
	　　入力チェック(dieを使うのでif文を単発で作る)
	*************************************/
	// 始まり(^)と終わり($)を指定しないといけないことに注意
	// 指定しないと正規表現自体を否定でヒットするようにしないとダメ
	// 未入力の値チェック　
	if(empty($sei) || empty($mei) || empty($mail) || empty($pass)) {
		// スクリプト終了
		die("全ての項目に入力してください。");
	}
	// 名前に使用出来るのはひらがな,カタカナ.英語のみ
	// phpはunicodeブロックが使えないので自力で指定する,最後のuはマルチバイト（UTF-8）対応を意味する
	$name = $sei . $mei;
	if(!preg_match("/^[ぁ-ん一-龠]+$/u",$name)) {
		die("姓,名は漢字または平仮名で入力してください。");
	}
	// 同じメールアドレスがDBにあった場合
	if($rows > 0){
		die("入力されたメールアドレスは既に登録済みです。<br><a href=\"\">パスワードを忘れた方はこちら</a>");
	}
	// メールアドレスの形式チェック \w = _a-zA-Z0-9 \d = 0-9
	// 使える文字 + @ + 使える文字 + 最後の.の後がa-zで2~4文字ならOK
	if(!preg_match("/^[\w.-]+@[a-z\d.]+\.[a-z]{2,4}$/",$mail)) {
		die("正しい形式でメールアドレスを入力してください。");
	}
	// パスワードのチェック(6文字以上の半角英数字ならOK
	if(!preg_match("/^[a-zA-Z\d]+$/",$pass) || strlen($pass) < 6) {
		die("パスワードは6~15文字の半角英数字で入力してください。");
	}
	// ここまでくればOK,条件分岐のためにechoで文字列を返す
	echo "OK_NEXT";
?>