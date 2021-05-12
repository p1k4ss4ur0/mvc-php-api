<?php
    if(isset($_SESSION['user_id']) == false || $_SESSION == null) {
        header("location: http://localhost/mvc-php-api");
        exit; 
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>home</title>
    <meta charset="UTF-8">
    </head>
<body>
    <p>home</p>

    <h1>welcome <?php echo $_SESSION['username']; ?>!</h1>
    
    <button><a href="/mvc-php-api/src/app/view/pages/forgot-password/index.php">resset password</a></button> 
    <button><a href="/mvc-php-api/src/app/controller/sign-out.php">log out</a></button>

    <br>

    <?php
        if(!isset($_SESSION['user_image']) || $_SESSION == null) {
            $_SESSION['user_image'] = "defaultUserImage.jpg";
        }
        echo '<img src="/mvc-php-api/src/database/user-img/'.$_SESSION['user_image'].'" style="width: 50%; height: 50%;">'
    ?>
    
</body>
</html>


