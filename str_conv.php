<?php
	function str_conv($text) {
		// 受け取ったらまず何の言語をハイライトするのかを正規表現で取得する
		preg_match_all("/<code ([a-z]+)>/s",$text,$matches);
		// 2次元配列だが()の中身をとるので[1]をforeachで回す
		foreach($matches[1] as $value) {
			// <code php>みたいな形なのでそれを<codeStart><code php>にする
			// スプリットで分割したときに<code php>の部分もいれたいのでこうする
			$text = str_replace("<code ". $value .">","<codeStart><code ". $value .">",$text);
		}
		// 終了はどの言語も同じなのでループ後に実行
		$text = str_replace("</code>","</code></codeStart>",$text);
		// 分割
		$diary = preg_split("/<codeStart>|<\/codeStart>/",$text);
		$i = 0;
		$j = 0;
		foreach($diary as $value) {
			// プログラムか、そうでないか判断
			if(preg_match("/^<code [a-z]+>/",$value)) {
				// プラグインの仕様で特殊文字にして記述しないといけないのでプログラム部分に一旦htmlspecialcharsをする
				$diary[$i] = htmlspecialchars($diary[$i],ENT_QUOTES);
				// そのあとに特殊文字だとマークアップ？が機能しないので<code>(&lt;code&gt;)を<pre~に置き換える
				// 言語指定の部分は最初に取得した言語を順番にいれていく
				$diary[$i] = str_replace("&lt;code ". $matches[1][$j] ."&gt;","<pre class='brush: ". $matches[1][$j] ."'>",$diary[$i]);
				$diary[$i] = str_replace("&lt;/code&gt;","</pre>",$diary[$i]);
				$j++;
			}else{
				// 通常の文字部分は特殊文字にして改行を反映させる
				$diary[$i] = htmlspecialchars($value,ENT_QUOTES);
				$diary[$i] = nl2br($diary[$i]);
			}
			$i++;
		}
		return $diary;
	}
?>