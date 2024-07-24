<?php
/* --------------------------------------------------
 * 必要なファイルを読み込む
 * -------------------------------------------------- */
require_once 'private/bootstrap.php';

/* --------------------------------------------------
 * セッション開始
 * -------------------------------------------------- */
session_start();
/* --------------------------------------------------
 * 送られてきた値を取得する
 * セッションにも保存しておく
 * -------------------------------------------------- */
$name = $_POST['name'];
$escaped_name = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
$content =  $_POST['content'];
$escaped_content = htmlspecialchars($content, ENT_QUOTES, 'UTF-8');
$_SESSION['name'] = $escaped_name;
$_SESSION['content'] = $escaped_content;

/* --------------------------------------------------
 * 値のバリデーションを行う
 *
 * 入力された値が正しいフォーマットで送られているかを確認する
 * 今回は値が入力されているかのみを確認する
 * -------------------------------------------------- */

if($escaped_name == '' || $escaped_content == '') {
    redirect('/index.php');
}

/* --------------------------------------------------
 * 確認画面と登録画面で利用するトークンを発行する
 * 今回は時刻をトークンとする
 * -------------------------------------------------- */
$token = strval(time());
$_SESSION['token'] = $token;

?>

<!-- 描画するHTML -->
<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>投稿確認</title>
</head>
<body>
    <header>
        <h1>確認</h1>
    </header>
    <main>
        <div>下記の内容で投稿しますがよろしいですか?</div>
        <table>
            <tbody>
            <tr><th>名前</th><td><?= htmlspecialchars($escaped_name,ENT_QUOTES, 'UTF-8'); ?></td></tr>
            <tr><th>投稿内容</th><td><?=htmlspecialchars($escaped_content,ENT_QUOTES, 'UTF-8'); ?></td></tr>
            </tbody>
        </table>
        <form action="post_complete.php" method="post">
            <input type="hidden" name="token" value="<?= $token ?>">
            <button type="submit">投稿</button>
        </form>
    </main>
    <footer>
        <hr>
        <div>_〆(・ω・;)</div>
    </footer>
</body>
</html>
