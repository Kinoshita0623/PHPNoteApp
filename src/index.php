<?php
session_Start();
header("charset=utf-8");
if(is_null($_SESSION["user_id"])) {
    header("Location: /login.php");
    exit;
}

?>

<html>
<head>
    <title>セッションテスト</title>
</head>
    <body>
        <?php if(isset($_SESSION['user_id'])) : ?>
            ログイン済みです
            <form action="/logout.php" method="POST">
                <input type="submit" value="ログアウト">
            </form>
        <?php else : ?>
            ログインされていません。
        <?php endif ; ?>
    </body>
</html>