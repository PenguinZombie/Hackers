/************************************
  アクセス時,シンタックスハイライターの未解決バグのための無理矢理対策
*************************************/
$(function() {
	// ここで処理が終了しているかわからないけど,コールバックがないのでここに記述
	// AJAXでのpjax判定が何故かできなかったのでセッションを使う
	$.post("Ajax/pjax_bool.php",function(ret) {
		if(ret) {
			$(".center_con").show("slide",{direction:"left"},200);
		}
	});
});
/************************************
  追加ボタンクリック時,確認きたときから戻ってきたとき
*************************************/
$(function() {
	var URL = location.search;
	if(URL == "?back") {
		buttonHide();
	}
	$(".css3button").click(function() {
		buttonHide();
	});
	// ボタンを隠し日記エリアを表示する関数
	function buttonHide() {
		// ボタンを隠す
		$(".css3button").slideUp("fast",function() {
			// 日記エリアを表示させ,フォーカスを移す
			$(".diary_area").fadeIn("normal",function() {
				$(".user_text").focus();
			});
		});
	}
});
/************************************
  プレースホルダーの設定
*************************************/
$(function() {
	var text = $(".user_text").val();
	// 値があればプレースホルダーを非表示にし、フォーカスをテキストエリアに合わせる
	if(text.length > 0) {
		$(".placeholder").hide();
		$(".user_text").focus();
	}
	// プレースホルダーがクリックでもテキストボックスにフォーカスを移す
	$(".placeholder").click(function() {
		// this(現在)のprev(ひとつ前の要素)にfocus(フォーカスを移す)
		$(this).prev().focus();
	});
	// keydown キーを押した直後(テキストに値が入る前)
	// 未入力時に全角/半角でも消えてしまう
	// keyCode229が全角/半角だが,全角時はどのアルファベット入力でも
	// 229になるので判断が難しいので諦める(ツイッターは出来ているけど･･･)
	$(".user_text").keydown(function(e) {
		// 押されたキーがバックスペース以外なら消す
		if(e.keyCode != 8) {
			$(this).next().hide();
		}
	});
	// keyup キーから指を話した瞬間(テキストに値が入ったあと)
	// その時に空ならテキストエリアに値がないということなのでプレースホルダーを表示
	$(".user_text").keyup(function(e) {
		var text = $(this).val();
		if(text.length == 0) {
			$(this).next().show();
		}
	});
	// テキストエリアからフォーカスが外れたとき
	$(".user_text").blur(function() {
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
  確認画面ボタンクリック時
*************************************/
$(function() {
	// クリックされたとき
	$(".diary_kakunin").click(function() {
		// 値が入っていれば確認画面へ移動する
		var text = $(".user_text").val();
		if(text.length > 0) {
			$(".diary_form").trigger("submit");
		}else{
			alert("本文が入力されていません");
		}
	});
});
/************************************
  Tabキーを半角スペース4つに変換
*************************************/
$(function() {
	$(".user_text").keydown(function(e) {
		// 9がTabキー
		if(e.keyCode == 9) {
			// デフォルトのアクションを停止(フォーカス移動)
			e.preventDefault();
			// コピペしたメソッドを使用(現在の位置に文字を追加)
			// \tはタブでテキストエリア上では半角スペース8個分だけど,シンタックス上だと4つになるあので\tでいく
			$(".user_text").insertAtCaret("\t");
		}
	});
});
/************************************
  CODEボタンクリック時 クリックされればidを取得し,それを追加するように設定する
*************************************/
$(function() {
	// よく使う言語は別に用意 PHP Perl Python
	$(".lang_code").click(function() {
		$(".placeholder").hide();
		var lang = $(this).attr("id");
		$(".user_text").insertAtCaret("<code " + lang + ">\n// ここにコードを記述してください。\n\n</code>");			
	});
	$(".code_area").click(function() {
		$(".placeholder").hide();
		var lang = $(".code option:selected").attr("id");
		$(".user_text").insertAtCaret("<code " + lang + ">\n// ここにコードを記述してください。\n\n</code>");			
	});
	// 選択カーソルに文字を追加する(コピペ) メソッドを追加するらしい extend
	// IEかそうでないかで処理をわけている(多分)
	$.fn.extend({
		insertAtCaret: function(v) {
			var o = this.get(0);
			o.focus();
			if (jQuery.browser.msie) {
				var r = document.selection.createRange();
				r.text = v;
				r.select();
			}else{
				var s = o.value;
				var p = o.selectionStart;
				var np = p + v.length;
				o.value = s.substr(0, p) + v + s.substr(p);
				o.setSelectionRange(np, np);
			}
		}
	});
});
/************************************
  閉じるor更新発生時
*************************************/
// includeで読み込んでいるせいか,テキストボックス等の値が更新すると消えるので
// 閉じるor更新時にAjaxでセッションを保存させる
// 処理の順番のせいか結構な確率でできないときがある...
$(function() {
    $(window).bind("beforeunload",function() {
		// 適当な要素に一度フォーカスを移す
		$(".diary_kakunin").focus();
		var text = $(".user_text").val();
		$.post("Ajax/diary_session.php",{text:text});
	});  
	
});
	