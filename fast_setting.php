<?php
	// インクルードパスを設定
	ini_set('include_path','PEAR');
	require_once("MDB2.php");
	session_start();
	// idを格納
	$id = $_SESSION["id"];
	// データベース接続 mysql://ユーザ名:パスワード@ホスト名/DB名?charset=文字コード指定
	$mdb2 = MDB2::connect("mysql://LAA0170018:kouyansaiko@mysql561.phy.lolipop.jp/LAA0170018-seisaku?charset=utf8");
	// $mdb2 = MDB2::connect("mysql://root:kouyansaiko@localhost/hackers?charset=utf8");
	// フェッチモード指定(列名指定)
	$mdb2->setFetchMode(MDB2_FETCHMODE_ASSOC);
?>
<!DOCTYPE html>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="css/fast_setting.css">
<link rel="stylesheet" type="text/css" href="css/jquery-ui-1.8.18.custom.css">
<script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.8.18.custom.min.js"></script>
<script type="text/javascript" src="js/fast_setting.js"></script>
<title>Hackers 設定</title>
</head>
<body>
<div class="wrap effect">
	<div class="center">
		<form class="anke_form" method="post" action="rating_set.php">
		レーティングの初期設定のために簡単なアンケートに答えていただきます。<br>
		レーティングはログイン後の設定画面からいつでも変更することが出来ます<br>
		<fieldset>
			<legend>種類</legend>
			あなたのタイプを選択して下さい。<br>
			<input type="radio" name="zokusei" class="system" value="0">システムエンジニア/プログラマ<br>
			<input type="radio" name="zokusei" class="web" value="1">Web系<br>			
		</fieldset>
		<fieldset class="en" disabled>
			<legend>システムエンジニア/プログラマ</legend>
			未実装なのでwebを選択して下さい<br>
			<input type="checkbox" value="1">test<br>
			<input type="checkbox" value="2">test<br>
			<input type="checkbox" value="3">test<br>
			<input type="checkbox" value="4">test<br>
		</fieldset>
			<fieldset class="we">
			<legend>Web</legend>
			あなたについて選択してください。<br>
			<label><input type="checkbox" name="rating[]" value="i22">アイデアは出せる方だ。</label><br>
			<label><input type="checkbox" name="rating[]" value="i15">実現したいが、技術力不足で出来ないことがある。</label><br>
			<label><input type="checkbox" name="rating[]" value="i12,c10">ホームページを自分で考え、作ったことがある。</label><br>
			<label><input type="checkbox" name="rating[]" value="i11,s10,a16">webで動くシステム(なんでも良い)を自分で考え、実装したことがある。</label><br>
			<label><input type="checkbox" name="rating[]" value="a13">複雑なロジックが好き。</label><br>
			<label><input type="checkbox" name="rating[]" value="a13,i15">情報系の資格を持っている。</label><br>
			<label><input type="checkbox" name="rating[]" value="a21,i10">論理的思考はあるほうだと思う。</label><br>
			<br>
			プラグイン(js)や用意された関数(どの言語でも)について選択してください。<br>
			<label><input type="radio" name="algorithm" value="a8,i5">利用するが中身を理解しようとする。</label>&nbsp;
			<label><input type="radio" name="algorithm" value="a11,i12">場合によりけり、半分半分である。</label>&nbsp;
			<label><input type="radio" name="algorithm" value="a17,i15">あまり頼らない、自分で実装することが多い。</label><br>
			<br>
			HTML,CSS について選択してください<br>
			<label><input type="radio" name="client" value="c5">リファレンスがあれば基礎程度は使える。</label>&nbsp;
			<label><input type="radio" name="client" value="c14">リファレンスがあれば大体のレイアウト,やりたいことは実現出来る。</label>&nbsp;
			<label><input type="radio" name="client" value="c20">何もみなくても思っていることが実現出来る。</label><br>
			<label><input type="checkbox" name="rating[]" value="c5">フッターとヘッターのある3カラムのレイアウトを作れる</label><br>
			<label><input type="checkbox" name="rating[]" value="c7">リキッドレイアウトでホームページを作成したことがある。(css3:boxプロパティ含まない)</label><br>	
			<br>
			Javascript について選択してください<br>
			<label><input type="checkbox" name="rating[]" value="c8">javascriptで任意の処理(入力チェック等)が出来る。(ライブラリ可)</label><br>				
			<label><input type="checkbox" name="rating[]" value="c10,s4">Ajaxを理解し使える。</label><br>
			<label><input type="checkbox" name="rating[]" value="c4">画面遷移のしないプログラムを作ったことがある。(エラーメッセージを動的に表示等)</label><br>
			<br>
			Javascriptのプラグインについて選択してください<br>
			<label><input type="radio" name="client2" value="c12,a5">複数のコードをみて何をしているか部分部分理解できる。</label>&nbsp;
			<label><input type="radio" name="client2" value="c14,a10">複数のコードを理解できる。</label><br>
			<label><input type="checkbox" name="rating[]" value="c22,a10">実用的なJSのプラグインを作ったことがある。</label><br>
			<br>
			デザイン,フォトショップ,イラストレータについて選択してください<br>
			<label><input type="checkbox" name="rating[]" value="d10">デザインについての知識がある、色の相性等(少しでもあれば)</label><br>
			<label><input type="checkbox" name="rating[]" value="d15">用意されているpsdファイルを編集することができる(欲しい部分をとる、自分なりに少しアレンジ等)</label><br>
			<label><input type="checkbox" name="rating[]" value="d20">ボタン等を自作したことがある。</label><br>
			<label><input type="checkbox" name="rating[]" value="d20">アイコンやロゴを自作したことがある。</label><br>
			<label><input type="checkbox" name="rating[]" value="d12">CSSで影や立体感をのあるボタン等のデザインが出来る。</label><br>
			<label><input type="checkbox" name="rating[]" value="d12">CSSで透明度やグラデーションを使ったデザインが出来る。</label><br>
			<label><input type="checkbox" name="rating[]" value="d11">理想のユーザインタフェースはデザイン出来る。(実現出来る、出来ない関係なし)</label><br>
			<br>
			サーバーサイドの言語について,利用したことのある言語を選択してください。<br>
			<label><input type="checkbox" name="rating[]" value="Java">Java</label><br>
			<label><input type="checkbox" name="rating[]" value="PHP">PHP</label><br>
			<label><input type="checkbox" name="rating[]" value="Ruby">Ruby</label><br>
			<label><input type="checkbox" name="rating[]" value="Perl">Perl</label><br>
			<label><input type="checkbox" name="rating[]" value="Python">Python</label><br>
			<br>
			次からの項目はいずれの言語でも当てはまれば選択してください。<br>
			<label><input type="checkbox" name="rating[]" value="s2">フォームから送られてくる内容を受け取れる。</label><br>
			<label><input type="checkbox" name="rating[]" value="s4">各種ループ(for foreach while)を理解している。</label><br>
			<label><input type="checkbox" name="rating[]" value="s6">配列,2次元配列,連想配列を理解している。</label><br>
			<label><input type="checkbox" name="rating[]" value="s6">正規表現を理解していて、様々なパターンに対応出来る。</label><br>
			<label><input type="checkbox" name="rating[]" value="s10,m3">データベースから取り出したの値で出力を変更することが出来る。(aの場合aを表示,bの場合はbの表示)</label><br>
			<label><input type="checkbox" name="rating[]" value="s4">テキストファイル等をファイル処理でき,ダイアログでの保存やなんらかの形で出力することが出来る。</label><br>
			<label><input type="checkbox" name="rating[]" value="s15,m3">データベースを扱い、ログイン処理等が出来る。</label><br>
			<label><input type="checkbox" name="rating[]" value="s7">サニタイズやSQLインジェクション対策が出来る。</label><br>
			<label><input type="checkbox" name="rating[]" value="s10">クッキー/セッションを理解していて、それの管理方法(セキリュティ面)に自信がある。</label><br>
			<label><input type="checkbox" name="rating[]" value="s22">実用的な関数を複数自作したことがある</label><br>
			<br>
			データベース(oracle,mysql,PostgreSQL)について選択してください。<br>			
			<label><input type="checkbox" name="rating[]" value="m12">DDLを理解している。。(ALTER,CREATE,DROP)</label><br>
			<label><input type="checkbox" name="rating[]" value="m25">基本的なDMLの使い方を理解している。(SELECT,INSERT,UPDATE,DELETE)</label><br>
			<label><input type="checkbox" name="rating[]" value="m5">副問い合わせを理解している。</label><br>
			<label><input type="checkbox" name="rating[]" value="m4">シーケンスを使ったことがある。</label><br>
			<label><input type="checkbox" name="rating[]" value="m18">FOREIGN KEY等の制約をつけたDBを設計したことがある。</label><br>
			<label><input type="checkbox" name="rating[]" value="m30">データベースに関しての知識があり、設計には自信がある。</label><br>
			<br>
			Linuxについて選択してください。<br>
			<label><input type="checkbox" name="rating[]" value="l12">基本的なコマンドが使える。(ls,cd,pwd,cp,rm,mkdir,rmdir,mv)</label><br>
			<label><input type="checkbox" name="rating[]" value="l10">Linux上でプログラムを組んだことがある。</label><br>
			<label><input type="checkbox" name="rating[]" value="l12">LAMP環境を構築出来る。</label><br>
			<label><input type="checkbox" name="rating[]" value="l20">Linuxサーバを構築したことがある。</label><br>
			<label><input type="checkbox" name="rating[]" value="l6">Linuxが他のOSより優れている点をいえる。</label><br>
			<br>
			資格を取得している場合は一番レベルの高いものを選択してください<br>
			<label><input type="radio" name="linux" value="l20">LPIC1</label>&nbsp;
			<label><input type="radio" name="linux" value="l30">LPIC2</label>&nbsp;
			<label><input type="radio" name="linux" value="l40">LPIC3</label><br>
			<br>
			これでアンケートは終了です、ありがとうございました。<br>
			<button>送信</button>
		</fieldset>
		</form>
	</div>
</div>
<!-- 確認ダイアログ -->
<div class="dialog">
アンケートを送信してよろしいですか？<br>
送信後,自動的にメインページに移動します。
</div>
</body>
</html>