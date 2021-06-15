<?php
require_once 'config.inc.php';

$roomID = $_GET['roomID'];
$playerID = $_GET['playerID'];

$spielerAnzahl = db_fetch(db_query_prepared("SELECT PlayerID FROM players WHERE RoomID=:roomID ORDER BY PlayerID DESC LIMIT 1", array($roomID)))['PlayerID'] + 1;


$goldDisc = db_fetch(db_query_prepared("SELECT GoldDisc FROM game WHERE RoomID=:roomID", array($roomID)))['GoldDisc'];
$goldGen = db_fetch(db_query_prepared("SELECT GoldGen FROM game WHERE RoomID=:roomID", array($roomID)))['GoldGen'];
$feuerfallenDisc = db_fetch(db_query_prepared("SELECT FeuerfallenDisc FROM game WHERE RoomID=:roomID", array($roomID)))['FeuerfallenDisc'];
$feuerfallenGen = db_fetch(db_query_prepared("SELECT FeuerfallenGen FROM game WHERE RoomID=:roomID", array($roomID)))['FeuerfallenGen'];

$check = true;

if($goldDisc == $goldGen){
    db_query_prepared("UPDATE game SET GameMenu=4 WHERE RoomID=:roomID", array($roomID));
    db_query_prepared("UPDATE game SET Winner='Abenteurer' WHERE RoomID=:roomID", array($roomID));
    $check = false;
}else if($feuerfallenDisc == $feuerfallenGen){
    db_query_prepared("UPDATE game SET GameMenu=4 WHERE RoomID=:roomID", array($roomID));
    db_query_prepared("UPDATE game SET Winner='Waechterinnen' WHERE RoomID=:roomID", array($roomID));
    $check = false;
}else{
    db_query_prepared("UPDATE game SET GameMenu=1 WHERE RoomID=:roomID", array($roomID));
}

$cardsPlayed = db_fetch(db_query_prepared("SELECT CardsPlayed FROM game WHERE RoomID=:roomID", array($roomID)))['CardsPlayed'];

if($cardsPlayed == $spielerAnzahl){
    db_query_prepared("UPDATE game SET CardsPlayed=0 WHERE RoomID=:roomID", array($roomID));
    db_query_prepared("UPDATE game SET Runde=Runde+1 WHERE RoomID=:roomID", array($roomID));
}

$runde = db_fetch(db_query_prepared("SELECT Runde FROM game WHERE RoomID=:roomID", array($roomID)))['Runde'];

if($runde == 4){
    db_query_prepared("UPDATE game SET GameMenu=4 WHERE RoomID=:roomID", array($roomID));
    db_query_prepared("UPDATE game SET Winner='Waechterinnen' WHERE RoomID=:roomID", array($roomID));
    $check = false;
}

$i=0;
while($i<$spielerAnzahl){
    if($i != $playerID){
        db_query_prepared( "UPDATE players SET UpdateNecessary=true WHERE RoomID=:roomID AND PlayerID=:playerID", array($roomID, $playerID));
    }
    $i++;
}

if($cardsPlayed == $spielerAnzahl && $check){
    header("Location: sqlSetCards.php?roomID=".$roomID."&playerID=".$playerID);
}

?>