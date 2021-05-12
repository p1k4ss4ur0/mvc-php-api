<?php

    require_once('../model/user.php');
    
    $username = addslashes($_POST['username']);
    $email = addslashes($_POST['email']);

    if(empty($username) && empty($password)) {
        $warning = 'empty username and email field';
        include('../view/pages/forgot-password/index.php');
        exit;
    }
    if(empty($username)) {
        $warning = 'empty username field';
        include('../view/pages/forgot-password/index.php');
        exit;
    }
    if(empty($email)) {
        $warning = 'empty email field';
        include('../view/pages/forgot-password/index.php');
        exit;
    }

    $resetPasswordToken = openssl_random_pseudo_bytes(16);
    $resetPasswordToken = bin2hex($resetPasswordToken);

    $resetPasswordTokenExpires = date("Y-m-d h:i:s", strtotime('+1 hours'));
    
    $obj_user = new User($username, null, null, $email, $resetPasswordToken, $resetPasswordTokenExpires, null);

    $obj_user -> forgot_password();

?>