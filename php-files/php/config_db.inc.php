<?php

$heroku = false;

if(!$heroku){
    define('DB_ROOT_HOST','database');
    define('DB_ROOT_USER','root');
    define('DB_ROOT_PASSWORD','data');
    define('DB_ROOT_PORT','3306');

    define('DB_HOST','database');
    define('DB_USER','tds');
    define('DB_PASSWORD','tdsW!nichtsosicher');
    define('DB_PORT','3306');

    define('DB_NAME','tempeldesschreckens');
} else{
    $db = parse_url(getenv("DATABASE_URL"));

    define('DB_HOST',$db["host"]);
    define('DB_USER',$db["user"]);
    define('DB_PASSWORD',$db["pass"]);
    define('DB_PORT',$db["port"]);
    
    // $conn = new PDO("pgsql:" . sprintf(
    //     "host=%s;port=%s;user=%s;password=%s;dbname=%s",
    //     $db["host"],
    //     $db["port"],
    //     $db["user"],
    //     $db["pass"],
    //     ltrim($db["path"], "/")
    // ));
}

?>