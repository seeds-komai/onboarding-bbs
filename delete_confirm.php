<?php
/* --------------------------------------------------
 * 必要なファイルを読み込む
 * -------------------------------------------------- */
require_once 'private/bootstrap.php';
require_once 'private/database.php';

/* --------------------------------------------------
 * 送られてきた値を取得する
 * セッションにも保存しておく
 * -------------------------------------------------- */
session_start();
$id = $_POST['id'];
$escaped_id = $id;
$_SESSION['id'] = $escaped_id;

/* --------------------------------------------------
 * 値のバリデーションを行う
 *
 * 1.値が入力されているか
 * 2.データベースに対象IDのレコードが存在するか
 * -------------------------------------------------- */
if($id == ''){
    redirect('/index.php');
}
/* --------------------------------------------------
 * 削除する投稿のデータ
 * -------------------------------------------------- */
//DB接続
$connection = connectDB();
//削除する内容を配列に格納
$stmt = $connection->prepare("SELECT * FROM articles WHERE id = :id");
$stmt->bindValue(':id',$id,PDO::PARAM_INT);
$stmt->execute();
$delete_ary = $stmt->fetch(PDO::FETCH_ASSOC);

/* --------------------------------------------------
 * 確認画面と削除画面で利用するトークンを発行する
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
    <title>削除確認</title>
</head>
<body>
    <header>
        <h1>確認</h1>
    </header>
    <main>
        <div>下記の内容を削除しますがよろしいですか?</div>
        <table>
            <tbody>
            <tr><th>名前</th><td><?= htmlspecialchars($delete_ary['name'],ENT_QUOTES, 'UTF-8'); ?></td></tr>
            <tr><th>投稿内容</th><td><?= htmlspecialchars($delete_ary['content'],ENT_QUOTES, 'UTF-8'); ?></td></tr>
            </tbody>
        </table>
        <form action="delete_complete.php" method="post">
            <input type="hidden" name="token" value="<?= $token ?>">
            <button type="submit">削除</button>
        </form>
    </main>
    <footer>
        <hr>
        <div>(　・ω・)ノ⌒■</div>
    </footer>
</body>
</html>
