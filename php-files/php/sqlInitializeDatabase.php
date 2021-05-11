<?php
require_once 'functions_db.inc.php';
require_once 'config_db.inc.php';

$pdo = db_connect(false, false);

try{
    db_query_pdo("DROP DATABASE tempeldesschreckens", $pdo);
} catch(PDOException $e){
    echo "PDOException: ".$e -> getMessage();
}
db_query_pdo("CREATE DATABASE tempeldesschreckens", $pdo);

$pdo = null;

db_query("CREATE TABLE rooms (RoomID int NOT NULL, Language varchar(255), Initialisiert boolean, PRIMARY KEY (RoomID));");
db_query("CREATE TABLE players (RoomID int NOT NULL, PlayerID int NOT NULL, Name varchar(255) NOT NULL, Status varchar(255), Role varchar(255), SpielerMenu boolean, LinkMenu boolean, AmZug boolean, CardsSelected boolean, Leer int, Gold int, Feuerfalle int, UpdateNecessary boolean, CONSTRAINT FinalID PRIMARY KEY (RoomID, PlayerID));");
db_query("CREATE TABLE roles (Spielerzahl int NOT NULL, Abenteurer int, Waechterinnen int, PRIMARY KEY (Spielerzahl));");
db_query("CREATE TABLE doors (Spielerzahl int NOT NULL, Leer int, Gold int, Feuerfallen int, PRIMARY KEY (Spielerzahl));");
db_query("CREATE TABLE game (RoomID int NOT NULL, LeerGen int, GoldGen int, FeuerfallenGen int, LeerDisc int, GoldDisc int, FeuerfallenDisc int, CardsPlayed int, SpielerZahl int, Runde int, GameMenu int, KarteSelected varchar(255), KarteSelectedPosition int, Winner varchar(255), GameText varchar(255), ChooseCardStatus int, PRIMARY KEY (RoomID));");

db_query("INSERT INTO rooms VALUES (0, 'deutsch', false)");

db_query("INSERT INTO roles VALUES (3, 2, 2)");
db_query("INSERT INTO roles VALUES (4, 3, 2)");
db_query("INSERT INTO roles VALUES (5, 3, 2)");
db_query("INSERT INTO roles VALUES (6, 4, 2)");
db_query("INSERT INTO roles VALUES (7, 5, 3)");
db_query("INSERT INTO roles VALUES (8, 6, 3)");
db_query("INSERT INTO roles VALUES (9, 6, 3)");
db_query("INSERT INTO roles VALUES (10, 7, 4)");

db_query("INSERT INTO doors VALUES (3, 8, 5, 2)");
db_query("INSERT INTO doors VALUES (4, 12, 6, 2)");
db_query("INSERT INTO doors VALUES (5, 16, 7, 2)");
db_query("INSERT INTO doors VALUES (6, 20, 8, 2)");
db_query("INSERT INTO doors VALUES (7, 26, 7, 2)");
db_query("INSERT INTO doors VALUES (8, 30, 8, 2)");
db_query("INSERT INTO doors VALUES (9, 34, 9, 2)");
db_query("INSERT INTO doors VALUES (10, 37, 10, 3)");
?>