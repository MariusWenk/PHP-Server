<?php

function db_connect($root, $db){
    if($root){
        try{
            $dsn = 'mysql:host='.DB_HOST.';port='.DB_PORT;
            if($db){
                $dsn .= ';dbname='.DB_NAME;
            }
            $conn = new PDO($dsn,DB_USER,DB_PASSWORD);
        } catch(PDOException $e){
            echo "Connection failed: ".$e -> getMessage();
        }
    } else{
        try{
            $dsn = 'mysql:host='.DB_HOST.';port='.DB_PORT;
            if($db){
                $dsn .= ';dbname='.DB_NAME;
            }
            $conn = new PDO($dsn,DB_USER,DB_PASSWORD);
        } catch(PDOException $e){
            echo "Connection failed: ".$e -> getMessage();
        }
    }

    $conn -> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    $conn -> setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $conn;
}

function db_query_pdo($query, $pdo){
    // try{
        $stmt = $pdo->query($query);
    // } catch(PDOException $e){
    //     echo "PDOException: ".$e -> getMessage();
    // }
    return $stmt;
}

function db_query($query){
    $pdo = db_connect(false,true);
    $stmt = db_query_pdo($query, $pdo);
    $pdo = null;
    return $stmt;
}

function db_prepare_stmt($query){
    $pdo = db_connect(false,true);

    $stmt = $pdo->prepare($query);
    $pdo = null;
    return $stmt;
}

function db_query_prepared($query, $values){
    $stmt = db_prepare_stmt($query);
    
//    if(!(strpos($query, '?') > 0)){
//        foreach($values as $val){
//            $key = get_var_name($val);
//            $values_new_keys[$key] = $val;
//        }
//        $values = $values_new_keys;
//    }

    $stmt->execute($values);
    return $stmt;
}

function db_fetch($stmt){
    // Hier immer als ASSOC (siehe db_connect), also in arrayform (alternativ: OBJ (->): $stmt->fetch(PDO::FETCH_ASSOC);)
    $row = $stmt->fetch();
    return $row;
}

function db_fetch_all($stmt){
    $posts = $stmt->fetchAll();
    return posts;
}