<?php
require_once('User.php');
require_once('error_util.php');
require_once('escape.php');



session_start();
header("charset=utf-8");

$errors = [];
$email = '';
$password = '';

if($_SERVER['REQUEST_METHOD'] == "POST") {

    session_regenerate_id(false);

    if(isset($_POST['email'])) {
        $email = trim($_POST['email']);
    } else {
        $errors['email'] = 'メールアドレスを入力して下さい。';
    }

    if(isset($_POST['password'])) {
        $password = trim($_POST['password']);
    } else {
        $errors['password'] = 'パスワードを入力して下さい。';
    }

    if(count($errors) == 0) {
        $user = User::findByEmail($email);
        if(password_verify($password, $user->password)) {
            $_SESSION['user_id'] = $user->id;
        } else {
            $errors['email'] = 'email又はpasswordが一致しません。';
            $errors['password'] = $errors['email'];
        }
    }
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
    <div>
        email:<input type="text" hint="メールアドレス" name="email">
        <?php showError($errors, 'email'); ?>
    </div>
    <div>
        password: <input type="password" name="password">
        <?php showError($errors, 'password'); ?>
    </div>
    <input type="submit">
</form>
</body>
</html>
