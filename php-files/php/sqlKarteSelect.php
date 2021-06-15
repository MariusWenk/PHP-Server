<?php
require_once 'config.inc.php';

$roomID = $_GET['roomID'];
$playerID = $_GET['playerID'];
$select = $_GET['select'];

$spielerAnzahl = db_fetch(db_query_prepared("SELECT PlayerID FROM players WHERE RoomID=:roomID ORDER BY PlayerID DESC LIMIT 1", array($roomID)))['PlayerID'] + 1;
$chooseCardStatus = db_fetch(db_query_prepared("SELECT ChooseCardStatus FROM game WHERE RoomID=:roomID", array($roomID)))['ChooseCardStatus'];

if($chooseCardStatus == 1){
    db_query_prepared("UPDATE game SET ChooseCardStatus=0 WHERE RoomID=:roomID", array($roomID));

    $player = 0;
    $i=0;
    while($i < $spielerAnzahl){
        db_query_prepared("UPDATE players SET AmZug=false WHERE PlayerID=$i AND RoomID=:roomID", array($roomID));
        $playerSelected = db_fetch(db_query_prepared("SELECT CardsSelected FROM players WHERE RoomID=:roomID AND PlayerID=:i", array($roomID, $i)))['CardsSelected'];
        if($playerSelected){
            $player = $i;
        }
        $i++;
    }

    $empty = db_fetch(db_query_prepared("SELECT Leer FROM players WHERE RoomID=:roomID AND PlayerID=:player", array($roomID, $player)))['Leer'];
    $treasure = db_fetch(db_query_prepared("SELECT Gold FROM players WHERE RoomID=:roomID AND PlayerID=:player", array($roomID, $player)))['Gold'];
    $trap = db_fetch(db_query_prepared("SELECT Feuerfalle FROM players WHERE RoomID=:roomID AND PlayerID=:player", array($roomID, $player)))['Feuerfalle'];
    $kartenGesamt = $empty + $treasure + $trap;

    $r = rand(1,$kartenGesamt);
    if($r<=$empty){
        db_query_prepared("UPDATE players SET Leer=Leer-1 WHERE PlayerID=:player AND RoomID=:roomID", array($player, $roomID));
        db_query_prepared("UPDATE game SET LeerDisc=LeerDisc+1 WHERE RoomID=:roomID", array($roomID));
        $karteSelected = "Leer";
    } else if($r>($kartenGesamt-$trap)){
        db_query_prepared("UPDATE players SET Feuerfalle=Feuerfalle-1 WHERE PlayerID=:player AND RoomID=:roomID", array($player, $roomID));
        db_query_prepared("UPDATE game SET FeuerfallenDisc=FeuerfallenDisc+1 WHERE RoomID=:roomID", array($roomID));
        $karteSelected = "Feuerfalle";
    } else{
        db_query_prepared("UPDATE players SET Gold=Gold-1 WHERE PlayerID=:player AND RoomID=:roomID", array($player, $roomID));
        db_query_prepared("UPDATE game SET GoldDisc=GoldDisc+1 WHERE RoomID=:roomID", array($roomID));
        $karteSelected = "Gold";
    }

    db_query_prepared("UPDATE players SET AmZug=true WHERE PlayerID=:player AND RoomID=:roomID", array($player, $roomID));

    db_query_prepared("UPDATE game SET GameMenu=3 WHERE RoomID=:roomID", array($roomID));

    db_query_prepared("UPDATE game SET CardsPlayed=CardsPlayed+1 WHERE RoomID=:roomID", array($roomID));
    db_query_prepared("UPDATE game SET KarteSelected=:karteSelected WHERE RoomID=:roomID", array($karteSelected, $roomID));
    db_query_prepared("UPDATE game SET KarteSelectedPosition=:select WHERE RoomID=:roomID", array($select, $roomID));

    $cardsPlayed = db_fetch(db_query_prepared("SELECT CardsPlayed FROM game WHERE RoomID=:roomID", array($roomID)))['CardsPlayed'];
    $runde = db_fetch(db_query_prepared("SELECT Runde FROM game WHERE RoomID=:roomID", array($roomID)))['Runde'];

    if($cardsPlayed == $spielerAnzahl && $runde != 4){
        $rundeText = $runde+1;
        $text = "Die ".$rundeText.". Runde ist vorüber. Die Karten werden nun neu verteilt.";
        db_query_prepared("UPDATE game SET GameText=:text WHERE RoomID=:roomID", array($text, $roomID));
    }else{
        $text = "";
        db_query_prepared("UPDATE game SET GameText=:text WHERE RoomID=:roomID", array($text, $roomID));
    }

    $i=0;
    while($i<$spielerAnzahl){
        if($i != $playerID){
            db_query_prepared( "UPDATE players SET UpdateNecessary=true WHERE RoomID=:roomID AND PlayerID=:playerID", array($roomID, $playerID));
        }
        $i++;
    }
}

?>