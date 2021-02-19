<?php

function csrfToken()
{

$token = hash('sha256', substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyz'), 0, 8));
$_SESSION['_token'] = $token;
?>

<input type="hidden" name="_token" value="<?= $token ?>">
<?php
}

function checkCsrfToken()
{
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $token = $_POST['_token'];
    }else{
        $token = $_GET['_token'];
    }
    if(
        ! (isset($_SESSION['_token']) 
        && isset($token) 
        && !empty($_SESSION['_token'])
        && !empty($token)
        && $_SESSION['_token'] == $token)
    ) {
        // csrf token無効
        http_response_code(419);
        exit();
    }
}


?>