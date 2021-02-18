<?php
require_once('User.php');
session_start();

header('charset=UTF-8');

function showError(&$errors, $key) {
?>
<div class="error">
    <?php if(isset($errors[$key])) : ?>
        <?= $errors[$key] ?>
    <? endif; ?>
</div>
<?php
}


$errors = [];

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = '';
    if(
        isset($_POST['email']) 
        && ($email = trim(htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8')))
        && ! empty($email)
    ) {

    } else {
        $errors['email'] = 'emailを入力して下さい。';
    }

    $name = '';
    if(
        isset($_POST['name'])
        && ($name = trim(htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8')))
        && !empty($name)
    ) {

    } else {
        $errors['name'] = 'nameを入力して下さい。';
    }


    if(isset($_POST['password'])) {
        
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