<!DOCTYPE html>
<html lang="en">
<head>
    <title>sign up</title>
    <meta charset="utf-8">
</head>
<body>
    <p>sign up</p>
    
    <form action="/mvc-php-api/src/app/controller/sign-up.php" method="POST" enctype="multipart/form-data">
        <input
            type="text"
            name="username"
            placeholder="username"
            minlength="5"
            maxlength="30"
        >
        <br><br>
        <label
            for="user_img"
            style="
                background-color: #fff;
                border: 1px solid black;
                padding: 5px 20px 5px 20px;
                color: #000;
            "
        >
            user image
            <input type="file" name="user_img" id="user_img" style="display: none;">
        </label>
        <br><br>
        <input
            type="password" 
            name="password" 
            placeholder="password"
            minlength="5"
            maxlength="30"
        >
        <br><br>
        <input
            type="password"
            name="confirmpassword"
            placeholder="confirm password"
            minlength="5"
            maxlength="32"
        >
        <br><br>
        <input
            type="email"
            name="email"
            placeholder="email"
        >
        <p><?php
            if(!empty($warning)) {
                echo $warning;
            }
        ?></p>
        <input class="cadastrar" type="submit" value="submit">
    </form>
</body>
</html>