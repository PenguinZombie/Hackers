<?php
	function make_Token() {
		// 一週間分の時間
		$timeout = 7 * 24 * 60 * 60;
		// 現在の時間にプラスする
		$expires = time() + $timeout;
		// ユニークid+乱数+現在時刻でユニークな値を作成する
		$token = uniqid() . mt_rand() . time();
		// 戻り値が二つなので配列で返す,受け取り側はlist($a,$b) 変数ひとつだと自動で配列になる
		return array($token,$expires);
	}
?>