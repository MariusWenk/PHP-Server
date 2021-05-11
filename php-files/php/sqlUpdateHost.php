<?php 
require_once 'config.inc.php';

$playerID = $_GET['playerID'];
$roomID = $_GET['roomID'];
$spielerAnzahl = db_fetch(db_query("SELECT PlayerID FROM players WHERE RoomID=$roomID ORDER BY PlayerID DESC LIMIT 1")) + 1;

if($spielerAnzahl > 1){
    db_query( "UPDATE players SET Status='' WHERE PlayerID=$playerID AND RoomID=$roomID");
    if($spielerAnzahl-1-$playerID > 0){
        $newID = $playerID+1;
            db_query( "UPDATE players SET Status='Host' WHERE PlayerID=$newID AND RoomID=$roomID");
    } else{
        db_query( "UPDATE players SET Status='Host' WHERE PlayerID=0 AND RoomID=$roomID");
    }
}

$i=0;
while($i<$spielerAnzahl){
    if($i != $playerID){
        db_query( "UPDATE players SET UpdateNecessary=true WHERE RoomID=$roomID AND PlayerID=$playerID");
    }
    $i++;
}

?>