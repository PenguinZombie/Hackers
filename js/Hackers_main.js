$(function() {
	// pjax　を .js-pjaxに設定
	// .center_conの中身をpjaxで切り替える
	$(".js-pjax").pjax(".center_con");
	// 設定画面等処理が遅いので見栄えが悪い,クリックされたときにコンテンツ部分を非表示にし,処理が終われば表示にする
	// p=1等の画面のときに日記を押すと何故かエラーが発生する(プラグイン側というか読み込みの問題みたい)
	// p=0に戻って押すとエラーはでない、解決できないのでクリックされたURLが日記のhref + セッションがあればpjaxを使用しないで飛ばす
	$(".js-pjax").click(function() {
		// クリックされたURLを取得しておく,$.postの中では取得出来ない
		var url = $(this).attr("href");
		// スライド完了後に飛ばす
		$(".center_con").hide("slide",{direction:"right"},200,function() {
			// 日記ページならプラグインの関係で必ず更新
			if(url == "Hackers_diary.php") {
				$.post("Ajax/syntax_ok.php",function(ret) {
					location.href = "Hackers_diary.php";
				});
			}
		});
	});
});