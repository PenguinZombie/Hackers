<?php
	session_start();
	// インクルードパスを設定
	ini_set('include_path','PEAR');
	require_once("MDB2.php");
	// idを格納
	$id = $_SESSION["id"];
	// 種類受け取り
	$zokusei = $_POST["zokusei"];
	// 送られてくる値はi2等(idea:2)なので、こちらで区別し格納する
	// 全てのチェックボックスの値を配列で受け取る
	if(isset($_POST["rating"])) {
		$loop1 = true;
	}else{
		// ひとつも選択されてない場合は0で作る,値がないのにforeachすると警告がでるのでこういう形にしている
		$rating = array(
				"idea"		=> 0,
				"algorithm"	=> 0,
				"design"	=> 0,
				"server"	=> 0,
				"client"	=> 0,
				"db"		=> 0,
				"linux"		=> 0
		);
		$loop1 = false;
	}
	// 各ラジオボタンの対応、値がはいっていれば+する。
	if(isset($_POST["client"])) {
		$rati = preg_split("/,/",$_POST["client"]);
		foreach($rati as $val) {
			// 後半のふたつは必要ないけど...
			selectArray($rating,$val,$lang,$laCn);
		}
	}
	if(isset($_POST["client2"])) {
		$rati = preg_split("/,/",$_POST["client2"]);
		foreach($rati as $val) {
			// 後半のふたつは必要ないけど...
			selectArray($rating,$val,$lang,$laCn);
		}
	}
	if(isset($_POST["algorithm"])) {
		$rati = preg_split("/,/",$_POST["algorithm"]);
		foreach($rati as $val) {
			// 後半のふたつは必要ないけど...
			selectArray($rating,$val,$lang,$laCn);
		}
	}
	if(isset($_POST["linux"])) {
		$rati = preg_split("/,/",$_POST["linux"]);
		foreach($rati as $val) {
			// 後半のふたつは必要ないけど...
			selectArray($rating,$val,$lang,$laCn);
		}
	}
	$checkbox = $_POST["rating"];
	$laCn = 0;
	if($loop1) {
		foreach($checkbox as $value) {
			// カンマで区切る
			$rati = preg_split("/,/",$value);
			foreach($rati as $val) {
				// レーティング配列,区切った値,言語配列,そのカウント
				selectArray($rating,$val,$lang,$laCn);
			}
		}
	}
	/************************************
	　　DBに追加し,メインページに飛ばす
	*************************************/
	// データベース接続 mysql://ユーザ名:パスワード@ホスト名/DB名?charset=文字コード指定
	$mdb2 = MDB2::connect("mysql://LAA0170018:kouyansaiko@mysql561.phy.lolipop.jp/LAA0170018-seisaku?charset=utf8");
	// $mdb2 = MDB2::connect("mysql://root:kouyansaiko@localhost/hackers?charset=utf8");
	// フェッチモード指定(列名指定)
	$mdb2->setFetchMode(MDB2_FETCHMODE_ASSOC);
	$sql = "INSERT INTO user_rating(user_id,user_idea,user_algorithm,user_design,user_serverside,user_clientside,user_db,user_linux,user_syurui) ";
	$sql.= "VALUES(?,?,?,?,?,?,?,?,?)";
	$sth = $mdb2->prepare($sql,array("integer","integer","integer","integer","integer","integer","integer","integer"));
	$sth->execute(array($id,$rating["idea"],$rating["algorithm"],$rating["design"],$rating["server"],$rating["client"],$rating["db"],$rating["linux"],$zokusei));
	// 追加が終われば会員のfast_settingを1にする(次からはアンケートページに飛ばないようにする)
	$sql = "UPDATE kaiin SET user_setting = 1 WHERE user_id = ?";
	$sth = $mdb2->prepare($sql,array("integer"));
	$sth->execute(array($id));
	// 言語を格納する処理　まずは値が入っているかをチェックする
	if(isset($lang)) {
		$sql = "INSERT INTO user_lang(user_id,user_lang,user_comment,user_color) ";
		$sql.= "VALUES(?,?,?,?)";
		$sth = $mdb2->prepare($sql,array("integer","text","text","text"));
		// 複数ある可能性があるので要素数分ループ
		foreach($lang as $value) {
			$sth->execute(array($id,$value,"no","green"));
		}
	}
	/* いまだけ,日記のページンクテストのため */
	for($i=0; $i<35; $i++) {
		$text = "test " . $i;
		$today = time();
		$sql = "INSERT INTO user_diary(user_id,user_text,user_time) ";
		$sql.= "VALUES(?,?,?)";
		$sth = $mdb2->prepare($sql,array("integer","text","integer"));
		$sth->execute(array($id,$text,$today));
	}
	
	$text = 
'<code js>
/************************************
  閉じるor更新発生時
*************************************/
$(function() {
    $(window).bind("beforeunload",function() {
		// ここに処理を記述
	});  
});</code>';
	$today = time();
	$sql = "INSERT INTO user_diary(user_id,user_text,user_time) ";
	$sql.= "VALUES(?,?,?)";
	$sth = $mdb2->prepare($sql,array("integer","text","integer"));
	$sth->execute(array($id,$text,$today));

	$text = 
'Notepad++ 公式サイトから
<code c>
#include <stdio.h>

int main(int argc, char **argv)
{
	printf("Good bye Dennis Ritchie");
	return 0;
}</code>';
	$today = time();
	$sql = "INSERT INTO user_diary(user_id,user_text,user_time) ";
	$sql.= "VALUES(?,?,?)";
	$sth = $mdb2->prepare($sql,array("integer","text","integer"));
	$sth->execute(array($id,$text,$today));
	$text = 
'Java
<code java>
// 変数に値を格納
int a = 50;
// 出力
System.out.println("Hello, world! " + a);</code>
PHP
<code php>
// 変数に値を格納
$a = 50;
// 出力(ブラウザ)
echo "Hello, world! " . $a . "<br>";</code>';
	$today = time();
	$sql = "INSERT INTO user_diary(user_id,user_text,user_time) ";
	$sql.= "VALUES(?,?,?)";
	$sth = $mdb2->prepare($sql,array("integer","text","integer"));
	$sth->execute(array($id,$text,$today));
	/* ここまで */
	header("Location:Hackers_main.php");
	/************************************
	  要素を判定して各配列にプラスしていく関数
	*************************************/
	function selectArray(&$rating,$val,&$lang,&$laCn) {
		// 長くなるがif文で7項目を区別し数値部分を取り出す
		if(preg_match("/^i([0-9]+)$/",$val,$match)) {
			// idea
			$rating["idea"] += $match[1];
		}else if(preg_match("/^a([0-9]+)$/",$val,$match)) {
			// algorithm 
			$rating["algorithm"] += $match[1];
		}else if(preg_match("/^d([0-9]+)$/",$val,$match)) {
			// design
			$rating["design"] += $match[1];
		}else if(preg_match("/^s([0-9]+)$/",$val,$match)) {
			// serverside
			$rating["server"] += $match[1];
		}else if(preg_match("/^c([0-9]+)$/",$val,$match)) {
			// clientside
			$rating["client"] += $match[1];
		}else if(preg_match("/^m([0-9]+)$/",$val,$match)) {
			// db
			$rating["db"] += $match[1];
		}else if(preg_match("/^l([0-9]+)$/",$val,$match)) {
			// linux
			$rating["linux"] += $match[1];
		}else{
			$lang[$laCn] = $val;
			$laCn++;
		}
	}
?>