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
	$(".text-input , .login-input").keydown(function(e) {
		// 押されたキーがバックスペース以外なら消す
		if(e.keyCode != 8) {
			$(this).next().hide();
		}
	});
	// keyup キーから指を話した瞬間(テキストに値が入ったあと)
	// その時に空ならテキストボックスに値がないということなのでプレースホルダーを表示
	$(".text-input , .login-input").keyup(function() {
		var text = $(this).val();
		if(text.length == 0) {
			$(this).next().show();
		}
	});
	// テキストボックス(.text-input)からフォーカスが外れたとき
	$(".text-input , .login-input").blur(function() {
		// テキストの中身を格納
		var text = $(this).val();
		// 文字数が0ならプレースホルダ表示(数値の比較なので速いらしい?)
		if(text.length == 0) {
			$(this).next().show();
		}
	});
	// ペースト発生時
	$(".user_text").bind("paste",function() {
		$(this).next().hide();
	});
});
/************************************
　　submit時の処理
*************************************/
// ログイン
$(function() {
	$(".login_button").click(function(e) {
		// デフォルトの動作を停止
		e.preventDefault();
		// GIFを表示
		$(".load-gif2").show();
		var mail = $(".login-mail").val();
		var pass = $(".login-pass").val();
		var chk = "";
		if($(".pass_on").attr("checked")) {
			chk  = $(".pass_on").val();
		}
		// Ajaxでphp側に値を渡す
		$.post("Ajax/login_check.php",{
			mail:mail,
			pass:pass,
			chk:chk
		},function(ret) {
			// 2連続間違ったときに画面に変化がないので、最初に消す
			$(".login_message").hide();
			// GIFを非表示に(あえてのフェードアウト)
			$(".load-gif2").fadeOut();
			// retがOK_LOGINの場合はエラーがないということなのでsubmit
			if(ret == "OK_LOGIN") {
				// ログイン成功なのでsubmit発生(ここはクリックなので無限ループにならない)
				$(".login_submit").trigger("submit");
			}else if(ret == "setting") { 
				location.href = "fast_setting.php";
			}else{
				// ログイン失敗はエラーメッセージを表示
				$(".login_message").fadeIn("normal");
			}
		});
	});
});
// 新規登録
$(function() {
	// formのクラス名 エンターでもクリックは呼ばれるので大丈夫(submitにすると色々難しい)
	// $.postのなかでreturn falseをしてもsubmitが止められないのでこの形にした
	$(".register").click(function(e) {
		// デフォルトの動作を停止
		e.preventDefault();
		// GIFを表示
		$(".load-gif1").show();
		var sei = $(".text-sei").val();
		var mei = $(".text-mei").val();
		var mail = $(".text-mail").val();
		var pass = $(".text-pass").val();
		// Ajaxでphp側に値を渡す
		$.post("Ajax/check.php",{
			sei:sei,
			mei:mei,
			mail:mail,
			pass:pass
		},function(ret) {
			// retがOK_NEXTの場合はエラーがないということなのでsubmit
			if(ret != "OK_NEXT") {
				// エラーメッセージを一旦非表示(内容だけかわると変更がわかりにくい)
				$(".result").hide();
				// GIFを非表示に(あえてのフェードアウト)
				$(".load-gif1").fadeOut();
				// エラーメッセージのHTMLにPHPからの戻り値をセットする
				$(".result").html(ret);
				// エラーメッセージを表示
				$(".result").fadeIn("normal");
			}else{
				// OKならばsubmitを発生させる(ここはクリックなので無限ループにならない)
				$(".register_form").trigger("submit");
			}
		});
	});
});