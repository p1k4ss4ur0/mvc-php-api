<!DOCTYPE html>
<html lang="en">
<head>
    <title>reset password</title>
    <meta charset="UTF-8">
</head>
<body>
    <p>resset password</p>

    <form action="/mvc-php-api/src/app/controller/reset-password.php" method="post">
        <input
            type="text"
            name="username"
            placeholder="username"
        >
        <br><br>
        <input
            type="text"
            name="resetPasswordToken"
            placeholder="token"
        >
        <br><br>
        <input
            type="password"
            name="newpassword"
            placeholder="new password"
        >
        <br><br>
        <input
            type="password"
            name="confirmpassword"
            placeholder="confirm password"
            minlength="5"
            maxlength="32"
        >
        <p><?php
            if(!empty($warning)) {
                echo $warning;
            }
        ?></p>
        <input type="submit" value="submit">
        <br>
    </form>
</body>
</html>
