<?php
require_once 'config.inc.php';

$roomID = $_GET['roomID'];
$playerID = $_GET['playerID'];

$spielerAnzahl = db_fetch(db_query("SELECT PlayerID FROM players WHERE RoomID=$roomID ORDER BY PlayerID DESC LIMIT 1")) + 1;


$goldDisc = db_fetch(db_query("SELECT GoldDisc FROM game WHERE RoomID=$roomID"));
$goldGen = db_fetch(db_query("SELECT GoldGen FROM game WHERE RoomID=$roomID"));
$feuerfallenDisc = db_fetch(db_query("SELECT FeuerfallenDisc FROM game WHERE RoomID=$roomID"));
$feuerfallenGen = db_fetch(db_query("SELECT FeuerfallenGen FROM game WHERE RoomID=$roomID"));

$check = true;

if($goldDisc == $goldGen){
    db_query("UPDATE game SET GameMenu=4 WHERE RoomID=$roomID");
    db_query("UPDATE game SET Winner='Abenteurer' WHERE RoomID=$roomID");
    $check = false;
}else if($feuerfallenDisc == $feuerfallenGen){
    db_query("UPDATE game SET GameMenu=4 WHERE RoomID=$roomID");
    db_query("UPDATE game SET Winner='Waechterinnen' WHERE RoomID=$roomID");
    $check = false;
}else{
    db_query("UPDATE game SET GameMenu=1 WHERE RoomID=$roomID");
}

$cardsPlayed = db_fetch(db_query("SELECT CardsPlayed FROM game WHERE RoomID=$roomID"));

if($cardsPlayed == $spielerAnzahl){
    db_query("UPDATE game SET CardsPlayed=0 WHERE RoomID=$roomID");
    db_query("UPDATE game SET Runde=Runde+1 WHERE RoomID=$roomID");
}

$runde = db_fetch(db_query("SELECT Runde FROM game WHERE RoomID=$roomID"));

if($runde == 4){
    db_query("UPDATE game SET GameMenu=4 WHERE RoomID=$roomID");
    db_query("UPDATE game SET Winner='Waechterinnen' WHERE RoomID=$roomID");
    $check = false;
}

$i=0;
while($i<$spielerAnzahl){
    if($i != $playerID){
        db_query( "UPDATE players SET UpdateNecessary=true WHERE RoomID=$roomID AND PlayerID=$playerID");
    }
    $i++;
}

if($cardsPlayed == $spielerAnzahl && $check){
    header("Location: sqlSetCards.php?roomID=".$roomID."&playerID=".$playerID);
}

?>