<?php
require_once(dirname(__FILE__) . '/models/User.php');
require_once('escape.php');

session_Start();
header("charset=utf-8");
if(is_null($_SESSION["user_id"])) {
    header("Location: /login.php");
    exit;
}

$user = User::find($_SESSION['user_id']);
$notes = $user->notes();
?>

<html>
<head>
    <title>セッションテスト</title>
</head>
    <body>
        <?php if(isset($_SESSION['user_id'])) : ?>
            <?= h($user->name) ?>さんこんにちは
            <form action="/logout.php" method="POST">
                <input type="submit" value="ログアウト">
            </form>
            <div>
                <?php foreach($notes as $note) : ?>
                    <div>
                        <div>
                            <h3><?= h($note->title) ?></h3>
                        </div>
                        <div>
                            <?= h($note->text) ?>
                        </div>
                    </div>
                <? endforeach; ?>
                <a href="/create.php">新規作成</a>
            </div>
        <?php else : ?>
            ログインされていません。
        <?php endif ; ?>
    </body>
</html>