$(function() {
	// ここで処理が終了しているかわからないけど,コールバックがないのでここに記述
	// スライド中(show)にサイドメニューをクリックされるとshowが2回重なることがあるので,cssのdiplayの状態と両方で判定
	$.post("Ajax/pjax_bool.php",function(ret) {
		if(ret) {
			$(".center_con").show("slide",{direction:"left"},200);
		}
	});
});