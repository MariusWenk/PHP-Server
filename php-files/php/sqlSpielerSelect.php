<?php
require_once 'config.inc.php';

$roomID = $_GET['roomID'];
$playerID = $_GET['playerID'];
$select = $_GET['select'];

$spielerAnzahl = db_fetch(db_query_prepared("SELECT PlayerID FROM players WHERE RoomID=:roomID ORDER BY PlayerID DESC LIMIT 1", array($roomID)))['PlayerID'] + 1;
$chooseCardStatus = db_fetch(db_query_prepared("SELECT ChooseCardStatus FROM game WHERE RoomID=:roomID", array($roomID)))['ChooseCardStatus'];

if($chooseCardStatus == 0){
    db_query_prepared("UPDATE game SET ChooseCardStatus=1 WHERE RoomID=:roomID", array($roomID));

    db_query_prepared("UPDATE game SET GameMenu=2 WHERE RoomID=:roomID", array($roomID));

    $i=0;
    while($i < $spielerAnzahl){
        db_query_prepared("UPDATE players SET CardsSelected=false WHERE RoomID=:roomID AND PlayerID=:i", array($roomID, $i));
        $i++;
    }
    db_query_prepared("UPDATE players SET CardsSelected=true WHERE RoomID=:roomID AND PlayerID=:select", array($roomID, $select));

    $i=0;
    while($i<$spielerAnzahl){
        if($i != $playerID){
            db_query_prepared("UPDATE players SET UpdateNecessary=true WHERE RoomID=:roomID AND PlayerID=:playerID", array($roomID, $playerID));
        }
        $i++;
    }
}

?>