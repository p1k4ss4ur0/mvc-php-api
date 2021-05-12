<!DOCTYPE html>
<html lang="en">
<head>
    <title>sign in</title>
    <meta charset="UTF-8">
    </head>
<body>
    <p>sign in</p>

    <form action="/mvc-php-api/src/app/controller/sign-in.php" method="post">
        <input
            type="text"
            name="username"
            placeholder="username"
            maxlength="30"
        >
        <br><br>
        <input
            type="password"
            name="password"
            placeholder="password"
            maxlength="32"
        >
        <p><?php
            if(!empty($warning)) {
                echo $warning;
            }
        ?></p>
        <input type="submit" value="submit">   
    </form>
</body>
</html>
