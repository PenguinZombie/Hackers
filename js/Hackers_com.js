$(function() {
	$.post("Ajax/pjax_bool.php",function(ret) {
		if(ret) {
			$(".center_con").show("slide",{direction:"left"},200);
		}
	});
	// 脱退ボタンクリック時
	$(".dattai").click(function() {
		// idにcom_noを格納している
		var com_no = $(this).attr("id");
		// 戻り値に脱退後のコミュニティを受け取るので反映させる
		$.post("Ajax/com_dattai.php",{com_no:com_no},function(ret) {
			$(".sonota_com").html(ret);
		});
		$(".com_info_" + com_no).slideUp("fast");
	});
	// 参加ボタンクリック時
	$(".sanka").click(function() {
		var com_no = $(this).attr("id");
		// 戻り値に参加後のコミュニティを受け取るので反映させる
		$.post("Ajax/com_sanka.php",{com_no:com_no},function(ret) {
			$(".my_com_area").html(ret);
		});
		$(".com_info_" + com_no).slideUp("fast");
	});
});
/************************************
  プレースホルダーの設定
*************************************/
$(function() {
	// プレースホルダーがクリックでもテキストボックスにフォーカスを移す
	$(".placeholder").click(function() {
		// this(現在)のprev(ひとつ前の要素)にfocus(フォーカスを移す)
		$(this).prev().focus();
	});
	// keydown キーを押した直後(テキストに値が入る前)
	// 未入力時に全角/半角でも消えてしまう
	// keyCode229が全角/半角だが,全角時はどのアルファベット入力でも
	// 229になるので判断が難しいので諦める(ツイッターは出来ているけど･･･)
	$(".com_search").keydown(function(e) {
		// 押されたキーがバックスペース以外なら消す
		if(e.keyCode != 8) {
			$(this).next().hide();
		}
	});
	// keyup キーから指を話した瞬間(テキストに値が入ったあと)
	// その時に空ならテキストボックスに値がないということなのでプレースホルダーを表示
	$(".com_search").keyup(function() {
		var text = $(this).val();
		if(text.length == 0) {
			$(this).next().show();
		}
	});
	// テキストボックス(.text-input)からフォーカスが外れたとき
	$(".com_search").blur(function() {
		// テキストの中身を格納
		var text = $(this).val();
		// 文字数が0ならプレースホルダ表示(数値の比較なので速いらしい?)
		if(text.length == 0) {
			$(this).next().show();
		}
	});
	// ペースト発生時
	$(".com_search").bind("paste",function() {
		$(this).next().hide();
	});
});