<?php 

    require_once('../model/user.php');

    $obj_user = new User(null, null, null, null, null, null, null);

    $obj_user -> sign_out();

?>