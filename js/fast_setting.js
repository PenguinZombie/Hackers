$(function() {
	// ラジオボタンで表示するものを変更する
	$(".system").click(function() {
		$(".we").hide();
		$(".en").fadeIn("normal");
	});
	$(".web").click(function() {
		$(".en").hide();
		$(".we").fadeIn("normal");
	});
});
$(function() {
	$("button").button();
	$("button").click(function(e) {
		// formの動作を停止
		e.preventDefault();
		// ダイアログ表示
		$(".dialog").dialog({
			title:"確認",
			// ダイアログ表示時他の操作をできなくする true
			modal:true,
			// ここでボタンを作れる,functionはクリック時の動作を記述
			buttons: {
				"OK":function() {
					// formの内容を送信するのでsubmit
					$(".anke_form").trigger("submit");
				},
				"CANCEL":function() {
					$(this).dialog("close");
				}
			}
		});
	});
});
