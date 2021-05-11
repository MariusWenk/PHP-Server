<?php
require_once 'config.inc.php';

$roomID = $_GET['roomID'];
$playerID = $_GET['playerID'];

$spielerAnzahl = db_fetch(db_query("SELECT PlayerID FROM players WHERE RoomID=$roomID ORDER BY PlayerID DESC LIMIT 1")) + 1;

$runde = db_fetch(db_query("SELECT Runde FROM game WHERE RoomID=$roomID"));

$leer = db_fetch(db_query("SELECT LeerGen FROM game WHERE RoomID=$roomID")) - db_fetch(db_query("SELECT LeerDisc FROM game WHERE RoomID=$roomID"));
$gold = db_fetch(db_query("SELECT GoldGen FROM game WHERE RoomID=$roomID")) - db_fetch(db_query("SELECT GoldDisc FROM game WHERE RoomID=$roomID"));
$feuerfalle = db_fetch(db_query("SELECT FeuerfallenGen FROM game WHERE RoomID=$roomID")) - db_fetch(db_query("SELECT FeuerfallenDisc FROM game WHERE RoomID=$roomID"));

$ges = (5-$runde) * $spielerAnzahl;
$i=0;
while($i < $spielerAnzahl){
    db_query("UPDATE players SET Leer=0 WHERE PlayerID=$i AND RoomID=$roomID");
    db_query("UPDATE players SET Gold=0 WHERE PlayerID=$i AND RoomID=$roomID");
    db_query("UPDATE players SET Feuerfalle=0 WHERE PlayerID=$i AND RoomID=$roomID");
    $j=0;
    while($j<(5-$runde)){
        $r = rand(1,$ges);
        if($r<=$leer){
            db_query("UPDATE players SET Leer=Leer+1 WHERE PlayerID=$i AND RoomID=$roomID");
            $leer--;
        } else if($r>($ges-$feuerfalle)){
            db_query("UPDATE players SET Feuerfalle=Feuerfalle+1 WHERE PlayerID=$i AND RoomID=$roomID");
            $feuerfalle--;
        } else{
            db_query("UPDATE players SET Gold=Gold+1 WHERE PlayerID=$i AND RoomID=$roomID");
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
        db_query( "UPDATE players SET UpdateNecessary=true WHERE RoomID=$roomID AND PlayerID=$playerID");
    }
    $i++;
}

?>