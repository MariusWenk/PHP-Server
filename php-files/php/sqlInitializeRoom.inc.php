<?php
require_once 'config.inc.php';

$newID = db_fetch(db_query("SELECT RoomID FROM rooms ORDER BY RoomID DESC LIMIT 1"))['RoomID'] + 1;

$values = $_POST;
$name = $values['nickname'];

$language = "deutsch";
foreach($values as $key => $value){
    if($value == true){
        $language = $key;
    }
}

db_query("INSERT INTO rooms VALUES ($newID, '$language',false)");
db_query("INSERT INTO players VALUES ($newID, 0, '$name', 'Host', 'NR',false,true,true,true,0,0,0,false)");

header("Location: game.inc.php?roomID=".$newID."&playerID=0");

?>