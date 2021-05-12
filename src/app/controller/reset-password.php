<?php

    require_once('../model/user.php');
    
    $username = addslashes($_POST['username']);
    $resetPasswordToken = addslashes(($_POST['resetPasswordToken']));
    $newpassword = addslashes($_POST['newpassword']);
    $confirmpassword = addslashes(($_POST['confirmpassword']));

    if(empty($username)) {
        $warning = 'empty username field';
        include('../view/pages/reset-password/index.php');
        exit;
    }
    if(empty($resetPasswordToken)) {
        $warning = 'empty token field';
        include('../view/pages/reset-password/index.php');
        exit;
    }
    if(empty($newpassword)) {
        $warning = 'empty new password field';
        include('../view/pages/reset-password/index.php');
        exit;
    }
    if(empty($confirmpassword)) {
        $warning= 'empty password confirmation field';
        include('../view/pages/sign-up/index.php');
        exit;
    }
    if($confirmpassword != $newpassword) {
        $warning= 'please confirm your password';
        include('../view/pages/sign-up/index.php');
        exit;
    }

    $obj_user = new User($username, null, $newpassword, null, $resetPasswordToken, null, null);

    $obj_user -> reset_password();

?>