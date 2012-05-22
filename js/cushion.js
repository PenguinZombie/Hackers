/************************************
　　パスワードのマスク表示/非表示の切り替え
*************************************/
$(function() {
	// ページ読み込み時にチェックボックスのチェックを外す(つけてから更新されると一回目のチェックで何もおきなくなるので)
	$(".show-pass").attr("checked",false);
	// チェックボックスが切り替わったとき
	$(".show-pass").change(function() {
		// チェックがついていればテキストに、そうでなければパスワードにreplaceWithで置き換える
		if ($(this).attr('checked')) {
			// html側と同じもの,valueに現在の値を入れているだけ,下のも同じ
			$(".text-pass").replaceWith('<input type="text" name="pass" class="text-input text-pass" value="' + $('.text-pass').val() + '" />');
		} else {
			$(".text-pass").replaceWith('<input type="password" name="pass" class="text-input text-pass" value="' + $('.text-pass').val() + '" />');
		}
	});
});
/************************************
  プレースホルダーの設定
*************************************/
$(function() {
	// 消されてから更新されたときにプレースホルダーがない状態になるので最初に全てチェックし
	// 値が格納されていないテキストボックスにはプレースホルダーを表示する
	$.each($(".text-input"),function() {
		var text = $(this).val();
		if(text.length == 0) {
			$(this).next().show();
		}
	});
	// プレースホルダーがクリックでもテキストボックスにフォーカスを移す
	$(".placeholder").click(function() {
		// this(現在)のprev(ひとつ前の要素)にfocus(フォーカスを移す)
		$(this).prev().focus();
	});
	// keydown キーを押した直後(テキストに値が入る前)
	// 未入力時に全角/半角でも消えてしまう
	// keyCode229が全角/半角だが,全角時はどのアルファベット入力でも
	// 229になるので判断が難しいので諦める(ツイッターは出来ているけど･･･)
	$(".text-input").keydown(function(e) {
		// 押されたキーがバックスペース以外なら消す
		if(e.keyCode != 8) {
			$(this).next().hide();
		}
	});
	// keyup キーから指を話した瞬間(テキストに値が入ったあと)
	// その時に空ならテキストボックスに値がないということなのでプレースホルダーを表示
	$(".text-input").keyup(function() {
		var text = $(this).val();
		if(text.length == 0) {
			$(this).next().show();
		}
	});
	// テキストボックス(.text-input)からフォーカスが外れたとき
	$(".text-input").blur(function() {
		// テキストの中身を格納
		var text = $(this).val();
		// 文字数が0ならプレースホルダ表示(数値の比較なので速いらしい?)
		if(text.length == 0) {
			$(this).next().show();
		}
	});
});
/************************************
　　submit時の処理
*************************************/
$(function() {
	// formのクラス名
	$(".register").click(function(e) {
		e.preventDefault();
		// GIFを表示
		$(".load-gif").show();
		var sei = $(".text-sei").val();
		var mei = $(".text-mei").val();
		var mail = $(".text-mail").val();
		var pass = $(".text-pass").val();
		$.post("Ajax/check.php",{
			sei:sei,
			mei:mei,
			mail:mail,
			pass:pass
		},function(ret) {
			// retがOK_NEXTの場合はエラーがないということなので飛ばす
			if(ret != "OK_NEXT") {
				// エラーメッセージを一旦非表示(内容だけかわると変更がわかりにくい)
				$(".result").hide();
				// GIFを非表示に(あえてのフェードアウト)
				$(".load-gif").fadeOut();
				// エラーメッセージのHTMLにPHPからの戻り値をセットする
				$(".result").html(ret);
				// エラーメッセージを表示
				$(".result").fadeIn("normal");
			}else{
				// OKなのでsubmitを発生させる
				$(".register_form").trigger("submit");
			}
		});
	});
});
