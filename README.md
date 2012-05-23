[Hackers](http://penguin.zombie.jp/Hackers_top.php)  

## 実装している機能
* 新規会員登録
* ログイン,自動ログインのシステム
* 日記への投稿(投稿のみ、コメント等はなし)
* コミニュティへの参加,脱退(参加,脱退のみ、掲示板等はまだ)
* レーティングシステム,表示,変更
* [jQuery-Pjax](https://github.com/defunkt/jquery-pjax)を使った必要な部分のみの読み込み
* [SyntaxHighlighter](http://alexgorbatchev.com/SyntaxHighlighter/)を使ったコード表示

## 未実装の機能
* コミュニティの掲示板
* 言語の追加等の設定
* 他人のページを観覧(**重要**)

## 不具合
* コミュニティの参加or脱退を別ページから移動後にすると画面がおかしくなる(設定→コミュニティ等)

## 苦労したところ
* Pjaxを初めて使ったので最初は戸惑ったところ
* 会員登録時の入力チェック(Ajax/check.php)
* SQLインジェクション対策にPEARライブラリを使用
* ページングのアルゴリズム(pjax-parts/Hackers_diary_parts.php)
* レーティングの値受け取り,設定,表示方法  
(pjax-parts/Hackers_main_parts.php , js/Hackers_settei.js , Ajax/slider_out.php)
* データベース設計
* パスワードの暗号化の仕様,登録完了画面での更新対策等