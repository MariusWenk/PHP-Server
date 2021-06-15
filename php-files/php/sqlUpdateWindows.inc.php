<?php   
require_once 'config.inc.php';

$playerID = $_GET['playerID'];
$roomID = $_GET['roomID'];
$spielerMenu = $_GET['spielerMenu'];
$linkMenu = $_GET['linkMenu'];

db_query_prepared( "UPDATE players SET SpielerMenu=:spielerMenu WHERE PlayerID=:playerID AND RoomID=:roomID", array('spielerMenu'=>$spielerMenu, 'playerID'=>$playerID, 'roomID'=>$roomID))[0];
db_query_prepared( "UPDATE players SET LinkMenu=:linkMenu WHERE PlayerID=:playerID AND RoomID=:roomID", array('linkMenu'=>$linkMenu, 'playerID'=>$playerID, 'roomID'=>$roomID))[0];

?>