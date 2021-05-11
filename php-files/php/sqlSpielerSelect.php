<?php
require_once 'config.inc.php';

$roomID = $_GET['roomID'];
$playerID = $_GET['playerID'];
$select = $_GET['select'];

$spielerAnzahl = db_fetch(db_query("SELECT PlayerID FROM players WHERE RoomID=$roomID ORDER BY PlayerID DESC LIMIT 1"))[0] + 1;
$chooseCardStatus = db_fetch(db_query("SELECT ChooseCardStatus FROM game WHERE RoomID=$roomID"))[0];

if($chooseCardStatus == 0){
    db_query("UPDATE game SET ChooseCardStatus=1 WHERE RoomID=$roomID");

    db_query("UPDATE game SET GameMenu=2 WHERE RoomID=$roomID");

    $i=0;
    while($i < $spielerAnzahl){
        db_query("UPDATE players SET CardsSelected=false WHERE RoomID=$roomID AND PlayerID=$i");
        $i++;
    }
    db_query("UPDATE players SET CardsSelected=true WHERE RoomID=$roomID AND PlayerID=$select");

    $i=0;
    while($i<$spielerAnzahl){
        if($i != $playerID){
            db_query("UPDATE players SET UpdateNecessary=true WHERE RoomID=$roomID AND PlayerID=$playerID");
        }
        $i++;
    }
}

?>