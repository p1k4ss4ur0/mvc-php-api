<!DOCTYPE html>
<html lang="en">
<head>
    <title>forgot password</title>
    <meta charset="UTF-8">
</head>
<body>
    <p>forgot password</p>

    <form action="/mvc-php-api/src/app/controller/forgot-password.php" method="post">
        <input
            type="text"
            name="username"
            placeholder="username"
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
        <input type="submit" value="submit">
        <br>
    </form>
</body>
</html>
