<?php
session_Start();
header("charset=utf-8");

if($_SERVER['REQUEST_METHOD'] == "POST") {
    $_SESSION['user_id'] = "";
}

if(isset($_SESSION["user_id"])) {
    header("Location: /");
    exit;
}

?>

<html>
<title>
ログイン
</title>
<body>
<form action="/login.php" method="POST">
    <div>email:<input type="text" hint="メールアドレス"></div>
        <div>password: <input type="password"></div>
        <input type="submit">
    </form>
</body>
</html>
