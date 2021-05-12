<?php

    if($_SERVER['REQUEST_URI'] == '/mvc-php-api/src/database/') {
        header('location: http://localhost/mvc-php-api');
    }   

    $settings = parse_ini_file('settings.ini', true);

    class Database {
        private $settings;

        function __construct($settings) {
            $this -> host     = $settings['database']['host'];
            $this -> user     = $settings['database']['user'];
            $this -> password = $settings['database']['password'];
            $this -> dbname   = $settings['database']['dbname'];
        }
        function DB() {
            global $settings;
            return $mvc_php_api = new mysqli(
                $this -> host,
                $this -> user,
                $this -> password,
                $this -> dbname
            );
        }
    }
    
    $database = new Database($settings);

?>
