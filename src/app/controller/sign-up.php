<?php

    require_once('../model/user.php');

    $username = addslashes($_POST['username']);
    $password = addslashes($_POST['password']);
    $confirmpassword = addslashes($_POST['confirmpassword']);
    $email = addslashes($_POST['email']);
    $user_img_name = basename($_FILES["user_img"]["name"]);
    
    
    if(empty($username) && empty($password) && empty($confirmpassword)) {
        $warning = 'please inform your credentials to sign up';
        include('../view/pages/sign-up/index.php');
        exit;
    }
    if(empty($username) && empty($password)) {
        $warning = 'empty username and password field';
        include('../view/pages/sign-up/index.php');
        exit;
    }
    if(empty($username)) {
        $warning = 'empty username field';
        include('../view/pages/sign-up/index.php');
        exit;
    }
    if(empty($password)) {
        $warning = 'empty password field';
        include('../view/pages/sign-up/index.php');
        exit;
    }
    if(empty($confirmpassword)) {
        $warning= 'empty password confirmation field';
        include('../view/pages/sign-up/index.php');
        exit;
    }
    if($confirmpassword != $password) {
        $warning= 'please confirm your password';
        include('../view/pages/sign-up/index.php');
        exit;
    }
    if(empty($user_img_name)) {
        $user_img_name = "defaultUserImage.jpg";
    }

    move_uploaded_file($_FILES["user_img"]["tmp_name"], $_SERVER['DOCUMENT_ROOT']."/mvc-php-api/src/database/user-img/".$user_img_name);

    $obj_user = new User($username, $password, null, $email, null, null, $user_img_name);

    $obj_user -> sign_up();

?>