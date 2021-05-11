<?php
require_once 'config.inc.php';

$values = $_POST;
$name = $values['nickname'];
$roomID = $values['roomID'];

$spielerAnzahl = db_fetch(db_query("SELECT PlayerID FROM players WHERE RoomID=$roomID ORDER BY PlayerID DESC LIMIT 1")) + 1;

$nameVergeben = false;
$i=0;
while($i < $spielerAnzahl){
    $nameOthers = db_fetch(db_query("SELECT Name FROM players WHERE RoomID=$roomID AND PlayerID=$i"));
    if($nameOthers == $name){
        $nameVergeben = true;
        $playerID = $i;
    }
    $i++;
}

if(!$nameVergeben){
    header("Location: joinroom.php?roomID=".$roomID."&textID=1");
}else{
    header("Location: game.php?roomID=".$roomID."&playerID=".$playerID);
}

?>