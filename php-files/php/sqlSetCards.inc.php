<?php
require_once 'config.inc.php';

$roomID = $_GET['roomID'];
$playerID = $_GET['playerID'];

$spielerAnzahl = db_fetch(db_query_prepared("SELECT PlayerID FROM players WHERE RoomID=? ORDER BY PlayerID DESC LIMIT 1", array($roomID)))['PlayerID'] + 1;

$runde = db_fetch(db_query_prepared("SELECT Runde FROM game WHERE RoomID=?", array($roomID)))[0];

$leer = db_fetch(db_query_prepared("SELECT LeerGen FROM game WHERE RoomID=?", array($roomID)))['LeerGen'] - db_fetch(db_query_prepared("SELECT LeerDisc FROM game WHERE RoomID=?", array($roomID)))['LeerDisc'];
$gold = db_fetch(db_query_prepared("SELECT GoldGen FROM game WHERE RoomID=?", array($roomID)))['GoldGen'] - db_fetch(db_query_prepared("SELECT GoldDisc FROM game WHERE RoomID=?", array($roomID)))['GoldDisc'];
$feuerfalle = db_fetch(db_query_prepared("SELECT FeuerfallenGen FROM game WHERE RoomID=?", array($roomID)))['FeuerfallenGen'] - db_fetch(db_query_prepared("SELECT FeuerfallenDisc FROM game WHERE RoomID=?", array($roomID)))['FeuerfallenDisc'];

$ges = (5-$runde) * $spielerAnzahl;
$i=0;
while($i < $spielerAnzahl){
    db_query_prepared("UPDATE players SET Leer=0 WHERE PlayerID=? AND RoomID=?", array($i, $roomID));
    db_query_prepared("UPDATE players SET Gold=0 WHERE PlayerID=? AND RoomID=?", array($i, $roomID));
    db_query_prepared("UPDATE players SET Feuerfalle=0 WHERE PlayerID=? AND RoomID=?", array($i, $roomID));
    $j=0;
    while($j<(5-$runde)){
        $r = rand(1,$ges);
        if($r<=$leer){
            db_query_prepared("UPDATE players SET Leer=Leer+1 WHERE PlayerID=? AND RoomID=?", array($i, $roomID));
            $leer--;
        } else if($r>($ges-$feuerfalle)){
            db_query_prepared("UPDATE players SET Feuerfalle=Feuerfalle+1 WHERE PlayerID=? AND RoomID=?", array($i, $roomID));
            $feuerfalle--;
        } else{
            db_query_prepared("UPDATE players SET Gold=Gold+1 WHERE PlayerID=? AND RoomID=?", array($i, $roomID));
            $gold--;
        }
        $ges--;
        $j++;
    }
    $i++;
}

$i=0;
while($i<$spielerAnzahl){
    if($i != $playerID){
        db_query_prepared( "UPDATE players SET UpdateNecessary=true WHERE RoomID=? AND PlayerID=?", array($roomID, $playerID));
    }
    $i++;
}

?>