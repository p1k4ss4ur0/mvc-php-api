<?php

    setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
    date_default_timezone_set('America/Sao_Paulo');

    class User {
        protected $username;
        protected $password;
        protected $newpassword;
        protected $email;
        protected $resetPasswordToken;
        protected $resetPasswordTokenExpires;
        protected $user_image_name;

        function __construct(
            $username,
            $password,
            $newpassword,
            $email,
            $resetPasswordToken,
            $resetPasswordTokenExpires,
            $user_image_name
        ) {
            $this -> username = $username;
            $this -> password = $password;
            $this -> newpassword = $newpassword;
            $this -> email = $email;
            $this -> resetPasswordToken = $resetPasswordToken;
            $this -> resetPasswordTokenExpires = $resetPasswordTokenExpires;
            $this -> user_image_name = $user_image_name;
        }
        function sign_in() {
            require_once('../../database/index.php');
            
            $signInQuery = "
                SELECT
                    user_id, username, user_image
                FROM 
                    users
                WHERE
                    username = ':u' and password = md5(':p')
            ";

            $signInQuery = str_replace(':u', $this->username, $signInQuery);
            $signInQuery = str_replace(':p', $this->password, $signInQuery);

            $signInQueryResult = $database -> DB() -> query($signInQuery);
            
            $affectedRows = mysqli_num_rows($signInQueryResult);

            if($affectedRows == 0) {
                $warning = "credentials not found";
                include('../view/pages/sign-in/index.php');
                exit;
            }
            if($affectedRows == 1) {
                session_start();
                $user_data = $signInQueryResult->fetch_assoc();
                
                $_SESSION['user_id'] = $user_data['user_id'];
                $_SESSION['username'] = $user_data['username'];
                $_SESSION['user_image'] = $user_data['user_image'];

                include('../view/pages/home/index.php');
                exit;
            }
            
        }
        function sign_up() {
            require_once('../../database/index.php');
    
            $signUpQuery = "
                SELECT
                    username
                FROM 
                    users
                WHERE
                    username = ':u'
            ";
            
            $signUpQuery = str_replace(':u', $this->username, $signUpQuery);

            $signUpQueryResult = $database -> DB() -> query($signUpQuery);

            $affectedRows = mysqli_num_rows($signUpQueryResult);

            if($affectedRows >= 1) {
                $warning = 'this user already exist';
                include('../view/pages/sign-up/index.php');
                exit;
            }
            elseif ($affectedRows == 0) {
            
            $signUpQuery = "
                INSERT INTO
                    users(username, password, email, user_image)
                VALUES 
                    (':u', md5(':p'), ':e', '{$this->user_image_name}')
            ";

            $signUpQuery = str_replace(':u', $this->username, $signUpQuery);
            $signUpQuery = str_replace(':e', $this->email, $signUpQuery);
            $signUpQuery = str_replace(':p', $this->password, $signUpQuery);
            
            $database -> DB() -> query($signUpQuery);
    
            $warning = 'SIGN ON SUCESSFUL! now please sign up';
            include('../view/pages/sign-in/index.php');
            exit;
            }
    
        }
        function forgot_password() {
            require_once('../../database/index.php');

            $verifyUserExistenceQuery = "
                SELECT
                    user_id, username
                FROM
                    users
                WHERE
                    username = ':u'
            ";

            $verifyUserExistenceQuery = str_replace(':u', $this->username, $verifyUserExistenceQuery);

            $verifyUserExistenceQuery = $database -> DB() -> query($verifyUserExistenceQuery);

            $affectedRows = mysqli_num_rows($verifyUserExistenceQuery);

            if($affectedRows == 0) {
                $warning = 'user doesnt exist';
                include('../view/pages/forgot-password/index.php');
                exit;
            }
            elseif($affectedRows == 1) {

                $resetPasswordTokenQuery = "
                    UPDATE
                        users
                    SET
                        reset_password_token = ('{$this->resetPasswordToken}')
                    WHERE 
                        username = '{$this->username}'
                ";
                $database -> DB() -> query($resetPasswordTokenQuery);

                $resetPasswordTokenExpiresQuery = "
                    UPDATE
                        users
                    SET
                        reset_password_token_expires = ('{$this->resetPasswordTokenExpires}')
                    WHERE 
                        username = '{$this->username}'
                ";

                $database -> DB() -> query($resetPasswordTokenExpiresQuery);

                $to = $this -> email;
                $subject = "password token";
                $message = "
                    <html>
                        <head>
                            <title>reset password token</title>
                        </head>
                    <body>
                        {$this->username}, this is you reset password token: {$this->resetPasswordToken}
                    </body>
                    </html>
                ";
                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                $headers .= 'From: <tiagoonofre335@gmail.com>' . "\r\n";
                mail($to,$subject,$message,$headers);

                $warning = "Check out your email";
                include('../view/pages/reset-password/index.php');
            }
        }
        function reset_password() {
            require_once('../../database/index.php');

            $getUserTokenQuery = "
                SELECT
                    reset_password_token
                FROM
                    users
                WHERE
                    username = ':username'
            ";

            $getUserTokenQuery = str_replace(':username', $this->username, $getUserTokenQuery);

            $token = $database -> DB() -> query($getUserTokenQuery);
            $token = $token -> fetch_assoc();

            $resetPasswordTokenExpires = "
                SELECT
                    reset_password_token_expires
                FROM
                    users
                WHERE
                    username = ':username'
            ";

            $resetPasswordTokenExpires = str_replace(':username', $this->username, $resetPasswordTokenExpires);

            $resetPasswordTokenExpires = $database -> DB() -> query($resetPasswordTokenExpires);
            $resetPasswordTokenExpires = $resetPasswordTokenExpires -> fetch_assoc();

            if($token != null) {
                if($token['reset_password_token'] != $this->resetPasswordToken) {
                    $warning = "invalid token";
                    include('../view/pages/reset-password/index.php');
                    exit;
                }
                $now = date("Y-m-d h:i:s");
                if($now > $resetPasswordTokenExpires['reset_password_token_expires']) {
                    $warning ="token expired";
                    include('../view/pages/reset-password/index.php');
                    exit;
                } 
                if($now < $resetPasswordTokenExpires['reset_password_token_expires']) {
                    if($token['reset_password_token'] == $this->resetPasswordToken) {
                        $updatePasswordQuery = "
                            UPDATE
                                users
                            SET 
                                password = md5(':newpassword')
                            WHERE
                                username = ':username'
                        ";

                        $updatePasswordQuery = str_replace(':newpassword', $this->newpassword, $updatePasswordQuery);
                        $updatePasswordQuery = str_replace(':username', $this->username, $updatePasswordQuery);

                        $database -> DB() -> query($updatePasswordQuery);

                        $deleteTokenQuery = "
                            UPDATE
                                users
                            SET
                                reset_password_token = NULL
                            WHERE
                                username = ':username'
                        ";

                        $deleteTokenQuery = str_replace(':username', $this->username, $deleteTokenQuery);
        
                        $database -> DB() -> query($deleteTokenQuery);

                        $deleteTokenExpiresQuery = "
                            UPDATE
                                users
                            SET
                                reset_password_token_expires = NULL
                            WHERE
                                username = ':username'
                        ";

                        $deleteTokenExpiresQuery = str_replace(':username', $this->username, $deleteTokenExpiresQuery);
        
                        $database -> DB() -> query($deleteTokenExpiresQuery);

                        $warning = "password changed, please sign in again";
                        include('../view/pages/sign-in/index.php');
                        exit;
                    }
                }

            } else {
                $warning ="user not found";
                include('../view/pages/reset-password/index.php');
                exit;
            }
        }
        function sign_out() {
            session_start();

            unset($_SESSION['user_id']);
            
            session_destroy();
        
            header("location: http://localhost/mvc-php-api");
        }
    }
    
?>