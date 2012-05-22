/************************************
　　スライダーの設定
*************************************/
$(function() {
	// ページ読み込み時に現在の値でスライダーの位置がかわるので,その設定のために
	// $.postを使ってphpから値を受け取る(カンマ区切りで)
	$.post("Ajax/slider_out.php",function(ret) {
		// カンマ区切りなのでスプリットで配列にする
		var rating = ret.split(",");
		// 各スライダーに初期値を設定
		$(".slider_idea").slider("value",rating[0]);
		$(".slider_algorithm").slider("value",rating[1]);
		$(".slider_design").slider("value",rating[2]);
		$(".slider_serverside").slider("value",rating[3]);
		$(".slider_clientside").slider("value",rating[4]);
		$(".slider_db").slider("value",rating[5]);
		$(".slider_linux").slider("value",rating[6]);
		// 最初の数値はこのときにテキストボックスに格納しておく(次からはスライド発生時)
		$(".slider_idea_value").val(rating[0]);
		$(".slider_algorithm_value").val(rating[1]);
		$(".slider_design_value").val(rating[2]);
		$(".slider_serverside_value").val(rating[3]);
		$(".slider_clientside_value").val(rating[4]);
		$(".slider_db_value").val(rating[5]);
		$(".slider_linux_value").val(rating[6]);
		// ダイアログ側のhtml要素にも格納しておく
		$(".slider_idea_value").html(rating[0]);
		$(".slider_algorithm_value").html(rating[1]);
		$(".slider_design_value").html(rating[2]);
		$(".slider_serverside_value").html(rating[3]);
		$(".slider_clientside_value").html(rating[4]);
		$(".slider_db_value").html(rating[5]);
		$(".slider_linux_value").html(rating[6]);
		// ここで処理が終了しているかわからないけど,コールバックがないのでここに記述
		// AJAXでのpjax判定が何故かできなかったのでセッションを使う	
		$.post("Ajax/pjax_bool.php",function(ret) {
			if(ret) {
				$(".center_con").show("slide",{direction:"left"},200);
			}
		});
	});
	// jQuery UIのサイトに色々かいてある(設定できる項目) 全てのスライダーの設定(初期値以外は共通)
	$(".slider_idea,.slider_algorithm,.slider_design,.slider_serverside,.slider_clientside,.slider_db,.slider_linux").slider({
		animate:true,
		range:"min",
		step:0.1,			
		min:0,
		max:10,
		// スライドが発生したとき呼ばれる
		slide:function(event,ui) {
			// id + _valueで対象の数値のクラス名にしている
			var val = "." + $(this).attr("id") + "_value";
			// スライダーの数値と確認画面のhtmlの両方を変える
			$(val).val(ui.value);
			$(val).html(ui.value);
		}
	});
});
/************************************
　　ヘルプのクリック時
*************************************/
$(function() {
	// こちらもスライダーと同じでクラス名を統一して上手くする
	$(".idea_button").click(function() {
		var help = "." + $(this).attr("class") + "_help";
		$(help).slideDown("normal");
	});
});
/************************************
　　jQuery UIのボタン設定,ダイアログの設定
*************************************/
$(function() {
	$("button").button();
	$("button").click(function(e) {
		// formの動作を停止
		e.preventDefault();
		// ダイアログ表示
		$(".settei_dialog").dialog({
			title:"確認",
			// ダイアログ表示時他の操作をできなくする true
			modal:true,
			// ここでボタンを作れる,functionはクリック時の動作を記述
			buttons: {
				"OK":function() {
					// formの内容を送信するのでsubmit
					$(".rating_settei").trigger("submit");
				},
				"CANCEL":function() {
					$(this).dialog("close");
				}
			}
		});
	});
});
/************************************
　　設定変更時
*************************************/
$(function() {
	// searchはURLの?からをとってくれる
	var search = location.search;
	if(search == "?ok_rating") {
		$("#msg1").fadeIn("normal");
	}
	if(search == "?ok_lang") {
		$("#msg2").fadeIn("normal");
	}
});