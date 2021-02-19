<?php
require_once(dirname(__FILE__) . '/models/User.php');
require_once('error_util.php');
session_start();

header('charset=UTF-8');




$errors = [];

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = '';
    if(
        isset($_POST['email']) 
        && ($email = trim($_POST['email']))
        && ! empty($email)
    ) {
        if(! mb_ereg_match('^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$', $email)) {
            $errors['email'] = 'メールアドレスを入力してください。';
        }
    } else {
        $errors['email'] = 'emailを入力して下さい。';
    }

    $name = '';
    if(
        isset($_POST['name'])
        && ($name = trim($_POST['name']))
        && !empty($name)
    ) {
        if(mb_strlen($name) >= 255) {
            $errors['name'] = '255未満にしてください。';
        }
    } else {
        $errors['name'] = 'nameを入力して下さい。';
    }


    if(isset($_POST['password'])) {
        $password = $_POST['password'];
    } else {
        $errors['password'] = 'passwordを入力して下さい。';
    }

    if(count($errors) == 0) {
        $user = User::create(
            [
                'email' => $email,
                'name' => $name,
                'password' => password_hash($password, PASSWORD_DEFAULT)
            ]
        );
        $_SESSION['user_id'] = $user->id;
    }
}

if(isset($_SESSION['user_id'])) {
    header('Location: /');
    exit;
}


?>

<html>
<head>
<title>登録</title>

</head>
<body>
    <form method="POST">
        <div>
            <div>email:<input type="text" name="email"></div>
            <?php showError($errors, 'email')?>
        </div>
        <div>name:<input type="text" name="name">
            <?php showError($errors, 'name')?>
        </div>
        <div>
            password:<input type="text" name="password">
        <?php showError($errors, 'password')?>
        </div>
        <input type="submit" value="登録">
    </form>
</body>
</html>