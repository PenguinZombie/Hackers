<?php
	// インクルードパスを設定
	ini_set('include_path','PEAR');
	require_once("MDB2.php");
	require_once("make_token.php");
	// セッションスタート(自動ログインでない場合のid取得)
	session_start();
	// pjaxでのアクセス時 $_GET["_pjax"] が送られてくる
	$pjax = @$_GET["_pjax"];
	// ajaxのとき$_getで受け取れないのでセッションに保存しておく
	$_SESSION["pjax"] = $pjax;
	// idを取得
	$id = islogin();
	// idとpjaxの情報を送りコンテンツをロードする
	content_Load($id,$pjax);
	/************************************
	　　セッションでの通常ログインか,自動ログインかを判断し,idを返す
	*************************************/
	function islogin() {
		// セッションなら自動ログインの処理はしないので先にチェック
		if(isset($_SESSION["id"])) {
			// セットされている場合はidを返す
			return $_SESSION["id"];
		}
		// クッキーがあれば自動ログインの可能性がある,DBに同一のtokenがあり有効期限がどうかを問い合わせる
		if(isset($_COOKIE["token"])) {
			// データベース接続 mysql://ユーザ名:パスワード@ホスト名/DB名?charset=文字コード指定
			$mdb2 = MDB2::connect("mysql://LAA0170018:kouyansaiko@mysql561.phy.lolipop.jp/LAA0170018-seisaku?charset=utf8");
			// $mdb2 = MDB2::connect("mysql://root:kouyansaiko@localhost/hackers?charset=utf8");
			// フェッチモード指定(列名指定)
			$mdb2->setFetchMode(MDB2_FETCHMODE_ASSOC);
			// sql文を作成
			$sql = "SELECT user_id,expires FROM autologin WHERE token = ?";
			// データ型を指定
			$sth = $mdb2->prepare($sql,array("text"));
			// 実行
			$rs = $sth->execute(array($_COOKIE["token"]));
			// 結果から1行取得
			$rows = $rs->fetchRow();
			$mdb2->disconnect();
			if($rows > 0) {
				// 有効期限(ログインしてから1週間)が過ぎている場合はトークンを削除
				if($rows["expires"] < time()) {
					// 過去の時間を指定すればクッキーを削除出来る DBは自動ログインの場合も削除するので下でする
					setcookie("token","クッキーを削除",$rows["expires"]);
					return false;
				}
				// 自動ログインOKの場合はトークンを再発行する(DBのは削除する)
				// 複数してる場合もあるのでtokenではなくユーザーid
				$sql = "DELETE FROM autologin WHERE user_id = ?";
				$sth = $mdb2->prepare($sql,array("integer"));
				$sth->execute(array($rows["user_id"]));
				//　再発行処理,tokenと有効期限を取得
				list($token,$expires) = make_Token();
				// プリペアドステートメント
				$sql = "INSERT INTO autologin(token,user_id,expires) ";
				$sql.= "VALUES(?,?,?)";
				// データ型指定
				$sth = $mdb2->prepare($sql,array("text","integer","integer"));
				// セットして実行(インサート)
				$sth->execute(array($token,$rows["user_id"],$expires));
				// クッキー(名前,値,有効期限,パス(ルート指定で全てに適応))
				setcookie("token",$token,$expires,"/");
				// セッションにidを格納しておく
				$_SESSION["id"] = $rows["user_id"];
				return $_SESSION["id"];
			}
		}
		return false;
	}
	/************************************
	　　pjaxかどうかを判別しコンテンツをインクルードする
	*************************************/	
	function content_Load($id,$pjax) {
		// idがfalseではないとき読み込む
		if($id != false) {
			// pjaxであればコンテンツ部分のみ,違う場合は全てのページを読み込む
			if($pjax) {
				include("pjax_parts/Hackers_settei_parts.php");
			}else{
				include("pjax_all/Hackers_settei_all.php");
			}
		}else{
			// falseならトップページに飛ばす
			header("location:Hackers_top.php");
		}
	}
?>