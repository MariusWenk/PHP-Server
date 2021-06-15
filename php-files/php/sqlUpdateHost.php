<?php 
require_once 'config.inc.php';

$playerID = $_GET['playerID'];
$roomID = $_GET['roomID'];
$spielerAnzahl = db_fetch(db_query_prepared("SELECT PlayerID FROM players WHERE RoomID=:roomID ORDER BY PlayerID DESC LIMIT 1", array($roomID)))['PlayerID'] + 1;

if($spielerAnzahl > 1){
    db_query_prepared( "UPDATE players SET Status='' WHERE PlayerID=:playerID AND RoomID=:roomID", array($playerID, $roomID));
    if($spielerAnzahl-1-$playerID > 0){
        $newID = $playerID+1;
            db_query_prepared( "UPDATE players SET Status='Host' WHERE PlayerID=:newID AND RoomID=:roomID", array($newID, $roomID));
    } else{
        db_query_prepared( "UPDATE players SET Status='Host' WHERE PlayerID=0 AND RoomID=:roomID", array($roomID));
    }
}

$i=0;
while($i<$spielerAnzahl){
    if($i != $playerID){
        db_query_prepared( "UPDATE players SET UpdateNecessary=true WHERE RoomID=:roomID AND PlayerID=:playerID", array($roomID, $playerID));
    }
    $i++;
}

?>