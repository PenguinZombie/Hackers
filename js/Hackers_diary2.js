$(function() {
    // クラスに応じて読み込んでくれる
	/* ローカルでは出来ないみたいなので全て記述する 
    SyntaxHighlighter.autoloader(
        "cpp c /js/scripts/shBrushCpp.js",
        "csharp /js/scripts/shBrushCSharp.js",
        "css /js/scripts/shBrushCss.js",
        "groovy /js/scripts/shBrushGroovy.js",
        "java /js/scripts/shBrushJava.js",
        "javafx /js/scripts/shBrushJavaFX.js",
        "js jscript javascript /js/scripts/shBrushJScript.js",
        "php /js/scripts/shBrushPhp.js",
        "perl /js/scripts/shBrushPerl.js",
        "python /js/scripts/shBrushPython.js",
        "ruby ror rails rails /js/scripts/shBrushRuby.js",
        "scala /js/scripts/shBrushScala.js",
        "sql /js/scripts/shBrushSql.js",
        "vb vbnet /js/scripts/shBrushVb.js"
    );
	*/
    // 右上のツールバー非表示
    SyntaxHighlighter.defaults["toolbar"] = false;
    // ハイライト開始
    SyntaxHighlighter.all();
});