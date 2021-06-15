<?php
require_once 'config.inc.php';

$roomID = $_GET['roomID'];
$playerID = $_GET['playerID'];
$newName = $_GET['newName'];

$spielerAnzahl = db_fetch(db_query_prepared("SELECT PlayerID FROM players WHERE RoomID=:roomID ORDER BY PlayerID DESC LIMIT 1", array($roomID)))['PlayerID'] + 1;

$nameVergeben = false;
$i=0;
while($i < $spielerAnzahl){
    $nameOthers = db_fetch(db_query_prepared("SELECT Name FROM players WHERE RoomID=:roomID AND PlayerID=:i", array($roomID, $i)))['players'];
    if($nameOthers == $newName){
        $nameVergeben = true;
    }
    $i++;
}

if(!$nameVergeben){
    db_query_prepared("UPDATE players SET Name=:newName WHERE PlayerID=:playerID AND RoomID=:roomID", array($newName, $playerID, $roomID));

    $spielerAnzahl = db_fetch(db_query_prepared("SELECT PlayerID FROM players WHERE RoomID=:roomID ORDER BY PlayerID DESC LIMIT 1", array($roomID)))['PlayerID'] + 1;
    $i=0;
    while($i<$spielerAnzahl){
        if($i != $playerID){
            db_query_prepared("UPDATE players SET UpdateNecessary=true WHERE RoomID=:roomID AND PlayerID=:playerID", array($roomID, $playerID));
        }
        $i++;
    }
}

?>