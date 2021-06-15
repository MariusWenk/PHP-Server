<?php
require_once 'config.inc.php';

$values = $_POST;
$name = $values['nickname'];
$roomID = $values['roomID'];

$spielerAnzahl = db_fetch(db_query_prepared("SELECT PlayerID FROM players WHERE RoomID=? ORDER BY PlayerID DESC LIMIT 1", array($roomID)))['PlayerID'] + 1;

$nameVergeben = false;
$i=0;
while($i < $spielerAnzahl){
    $nameOthers = db_fetch(db_query_prepared("SELECT Name FROM players WHERE RoomID=? AND PlayerID=?", array($roomID, $i)))['players'];
    if($nameOthers == $name){
        $nameVergeben = true;
        $playerID = $i;
    }
    $i++;
}

if(!$nameVergeben){
    header("Location: joinroom.inc.php?roomID=".$roomID."&textID=1");
}else{
    header("Location: game.inc.php?roomID=".$roomID."&playerID=".$playerID);
}

?>