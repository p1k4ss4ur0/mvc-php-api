<?php

    require_once('../model/user.php');

    $username = addslashes($_POST['username']);
    $password = addslashes($_POST['password']);

    if(empty($username) && empty($password)) {
        $warning = 'empty username and password field';
        include('../view/pages/sign-in/index.php');
        exit;
    }
    if(empty($username)) {
        $warning = 'empty username field';
        include('../view/pages/sign-in/index.php');
        exit;
    }
    if(empty($password)) {
        $warning = 'empty password field';
        include('../view/pages/sign-in/index.php');
        exit;
    }

    $obj_user = new User($username, $password, null, null, null, null, null);
    
    $obj_user -> sign_in();
    
?>