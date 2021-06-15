<?php 
require_once 'config.inc.php';

$playerID = $_GET['playerID'];
$roomID = $_GET['roomID'];

db_query_prepared("UPDATE players SET UpdateNecessary=false WHERE RoomID=? AND PlayerID=?", array($roomID, $playerID));

?>