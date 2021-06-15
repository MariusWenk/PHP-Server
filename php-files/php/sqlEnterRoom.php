<?php
require_once 'config.inc.php';

$values = $_POST;
$name = $values['nickname'];
$roomID = $values['roomID'];

$spielerAnzahl = db_fetch(db_query_prepared("SELECT PlayerID FROM players WHERE RoomID=:roomID ORDER BY PlayerID DESC LIMIT 1", array($roomID)))['PlayerID'] + 1;

$nameVergeben = false;
$i=0;
while($i < $spielerAnzahl){
    $nameOthers = db_fetch(db_query_prepared("SELECT Name FROM players WHERE RoomID=:roomID AND PlayerID=:i", array($roomID, $i)))['players'];
    if($nameOthers == $name){
        $nameVergeben = true;
    }
    $i++;
}

if(!$nameVergeben){

    $language = "deutsch";
    foreach($values as $key => $value){
        if($value == true){
            $language = $key;
        }
    }

    $playerID = db_fetch(db_query_prepared("SELECT PlayerID FROM players WHERE RoomID=:roomID ORDER BY PlayerID DESC LIMIT 1", array($roomID)))['PlayerID'] + 1;

    db_query_prepared("INSERT INTO players VALUES (:roomID, :playerID, :name, '', 'NR',false,true,false,false,0,0,0,false)", array($roomID, $playerID, $name));

    $spielerAnzahl = db_fetch(db_query_prepared("SELECT PlayerID FROM players WHERE RoomID=:roomID ORDER BY PlayerID DESC LIMIT 1", array($roomID)))['PlayerID'] + 1;
    $i=0;
    while($i<$spielerAnzahl){
        if($i != $playerID){
            db_query_prepared( "UPDATE players SET UpdateNecessary=true WHERE RoomID=:roomID AND PlayerID=:playerID", array($roomID, $playerID));
        }
        $i++;
    }
}

if($nameVergeben){
    header("Location: joinroom.php?roomID=".$roomID."&textID=1");
}else{
    header("Location: game.php?roomID=".$roomID."&playerID=".$playerID);
}

?>