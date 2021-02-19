<?php
require_once(dirname(__FILE__) . '/models/User.php');
require_once(dirname(__FILE__) . '/models/Note.php');
require_once('escape.php');
require_once('error_util.php');
require_once('csrf_token_util.php');


session_start();

header('charset=utf-8');

$user = null;
if(is_null($_SESSION['user_id']) || is_null($user = User::find($_SESSION['user_id']))) {
    header('Location: /login.php');
}

$errors = [];
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    checkCsrfToken();

    if (isset($_POST['title'])) {
        $title = trim($_POST['title']);
    }else{
        $errors['title'] = 'タイトルを入力して下さい。';
    }

    if(isset($_POST['text'])){
        $text = trim($_POST['text']);
    }else{
        $errors['text'] = '本文を入力して下さい。';
    }

    if(count($errors) == 0){
        $result = $user->createNote([
            'title' => $title,
            'text' => $text
        ]);

        if(isset($result)){
            header('Location: /');
            exit();
        }else{
            echo "失敗";
        }
        
    }
    
}


?>
<html>
<head>
<title>メモを作成</title>
</head>
<body>
    <form method="POST">
        <div>
            title: <input type="text" name="title">
            <?php showError($errors, 'title') ?>
        </div>
        <div>
            text: <input type="text" name="text">
            <?php showError($errors, 'text') ?>
        </div>
        <?php csrfToken(); ?>
        <input type="submit">
    </form>
</body>
</html>