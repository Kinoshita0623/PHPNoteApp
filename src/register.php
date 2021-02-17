<?php
session_start();

header('charset=UTF-8');

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION["user_id"] = "";
}

if(isset($_SESSION["user_id"])) {
    header("Location: /");
    exit;
}


?>

<html>
<head>
<title>登録</title>

</head>
<body>
    <form method="POST">
        <div>email:<input type="text" ></div>
        <div>name:<input type="text"></div>
        <div>password:<input type="text"></div>
        <input type="submit" value="登録">
    </form>
</body>
</html>