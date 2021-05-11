<?php

$heroku = false;

if(!$heroku){
    define('DB_HOST','database');
    // define('DB_USER','tds');
    // define('DB_PASSWORD','tdsW!nichtsosicher');
    // define('DB_NAME','tempelDesSchreckens');
    // define('DB_PORT','3306');
    define('DB_USER','root');
    define('DB_PASSWORD','data');
    define('DB_PORT','3306');

    try{
        $dsn = 'mysql:host='.DB_HOST.';port='.DB_PORT;
        if(defined('DB_NAME')){
            $dsn .= ';dbname='.DB_NAME;
        }
        $conn = new PDO($dsn,DB_USER,DB_PASSWORD);
    } catch(PDOException $e){
        echo "Connection failed: ".$e -> getMessage();
    }
} else{
    $db = parse_url(getenv("DATABASE_URL"));

    $conn = new PDO("pgsql:" . sprintf(
        "host=%s;port=%s;user=%s;password=%s;dbname=%s",
        $db["host"],
        $db["port"],
        $db["user"],
        $db["pass"],
        ltrim($db["path"], "/")
    ));
}

$conn -> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

?>