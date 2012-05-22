<?php
	// defineでソルトを定義する、ハッシュ化時に使用
	define("SALT","5C4EA7924127AD852EB9751FBC2DAB4A8387F219");
	// PEARのMDB2ライブラリを読み込む
	require_once("MDB2.php");
	// tokenと有効期限を返す関数を呼ぶため
	require_once("../make_token.php");
	// 入力された値を受け取る
	$mail = $_POST["mail"];
	$pass = $_POST["pass"];
	$autologin = $_POST["chk"];
	// ソルトを準備
	$salt = $mail . SALT;
	// メールアドレスも一致しないとパスが合わないので,sqlではパスがあってるかを調べる
	$hash = hash("sha256",$pass . $salt);
	// データベース接続 mysql://ユーザ名:パスワード@ホスト名/DB名?charset=文字コード指定
	$mdb2 = MDB2::connect("mysql://LAA0170018:kouyansaiko@mysql561.phy.lolipop.jp/LAA0170018-seisaku?charset=utf8");
	// $mdb2 = MDB2::connect("mysql://root:kouyansaiko@localhost/hackers?charset=utf8");
	// フェッチモード設定 カラム名をキーとする(元の列名に関係なく必ず小文字)
	$mdb2->setFetchMode(MDB2_FETCHMODE_ASSOC);
	// SQL文生成(静的プレースホルダ)
	$sql = "SELECT user_ID,user_setting FROM kaiin WHERE user_pass = ?";
	// データ型指定
	$sth = $mdb2->prepare($sql,array("text"));
	// セットして実行
	$rs = $sth->execute(array($hash));
	// 結果から1行を取得
	$rows = $rs->fetchRow();
	$mdb2->disconnect();
	// 行があればログイン成功なのでセッションに値を保存しておく
	if($rows > 0) {
		// セッションスタート
		session_start();
		$id = $rows["user_id"];
		// autologinがonならログイン保持
		if($autologin == "on")  {
			// トークン,有効期限生成の関数を用意しているのでそれを使う,expiresは有効期限(7日)
			list($token,$expires) = make_Token();
			// プリペアドステートメント
			$sql = "INSERT INTO autologin(token,user_id,expires) ";
			$sql.= "VALUES(?,?,?)";
			// データ型指定
			$sth = $mdb2->prepare($sql,array("text","integer","integer"));
			// セットして実行(インサート)
			$sth->execute(array($token,$id,$expires));
			// クッキー(名前,値,有効期限,パス(ルート指定で全てに適応))
			setcookie("token",$token,$expires,"/");
		}
		$_SESSION["id"] = $id;
		// 初期のアンケートを行っているかチェック
		if($rows["user_setting"] == 0) {
			die("setting");
		}
		die("OK_LOGIN");
	}
	echo "NOT";
?>