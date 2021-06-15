<?php
require_once 'config.inc.php';

$roomID = $_GET['roomID'];
$playerID = $_GET['playerID'];
$select = $_GET['select'];

$spielerAnzahl = db_fetch(db_query_prepared("SELECT PlayerID FROM players WHERE RoomID=? ORDER BY PlayerID DESC LIMIT 1", array($roomID)))['PlayerID'] + 1;
$chooseCardStatus = db_fetch(db_query_prepared("SELECT ChooseCardStatus FROM game WHERE RoomID=?", array($roomID)))['ChooseCardStatus'];

if($chooseCardStatus == 1){
    db_query_prepared("UPDATE game SET ChooseCardStatus=0 WHERE RoomID=?", array($roomID));

    $player = 0;
    $i=0;
    while($i < $spielerAnzahl){
        db_query_prepared("UPDATE players SET AmZug=false WHERE PlayerID=$i AND RoomID=?", array($roomID));
        $playerSelected = db_fetch(db_query_prepared("SELECT CardsSelected FROM players WHERE RoomID=? AND PlayerID=?", array($roomID, $i)))['CardsSelected'];
        if($playerSelected){
            $player = $i;
        }
        $i++;
    }

    $empty = db_fetch(db_query_prepared("SELECT Leer FROM players WHERE RoomID=? AND PlayerID=?", array($roomID, $player)))['Leer'];
    $treasure = db_fetch(db_query_prepared("SELECT Gold FROM players WHERE RoomID=? AND PlayerID=?", array($roomID, $player)))['Gold'];
    $trap = db_fetch(db_query_prepared("SELECT Feuerfalle FROM players WHERE RoomID=? AND PlayerID=?", array($roomID, $player)))['Feuerfalle'];
    $kartenGesamt = $empty + $treasure + $trap;

    $r = rand(1,$kartenGesamt);
    if($r<=$empty){
        db_query_prepared("UPDATE players SET Leer=Leer-1 WHERE PlayerID=? AND RoomID=?", array($player, $roomID));
        db_query_prepared("UPDATE game SET LeerDisc=LeerDisc+1 WHERE RoomID=?", array($roomID));
        $karteSelected = "Leer";
    } else if($r>($kartenGesamt-$trap)){
        db_query_prepared("UPDATE players SET Feuerfalle=Feuerfalle-1 WHERE PlayerID=? AND RoomID=?", array($player, $roomID));
        db_query_prepared("UPDATE game SET FeuerfallenDisc=FeuerfallenDisc+1 WHERE RoomID=?", array($roomID));
        $karteSelected = "Feuerfalle";
    } else{
        db_query_prepared("UPDATE players SET Gold=Gold-1 WHERE PlayerID=? AND RoomID=?", array($player, $roomID));
        db_query_prepared("UPDATE game SET GoldDisc=GoldDisc+1 WHERE RoomID=?", array($roomID));
        $karteSelected = "Gold";
    }

    db_query_prepared("UPDATE players SET AmZug=true WHERE PlayerID=? AND RoomID=?", array($player, $roomID));

    db_query_prepared("UPDATE game SET GameMenu=3 WHERE RoomID=?", array($roomID));

    db_query_prepared("UPDATE game SET CardsPlayed=CardsPlayed+1 WHERE RoomID=?", array($roomID));
    db_query_prepared("UPDATE game SET KarteSelected=? WHERE RoomID=?", array($karteSelected, $roomID));
    db_query_prepared("UPDATE game SET KarteSelectedPosition=? WHERE RoomID=?", array($select, $roomID));

    $cardsPlayed = db_fetch(db_query_prepared("SELECT CardsPlayed FROM game WHERE RoomID=?", array($roomID)))['CardsPlayed'];
    $runde = db_fetch(db_query_prepared("SELECT Runde FROM game WHERE RoomID=?", array($roomID)))['Runde'];

    if($cardsPlayed == $spielerAnzahl && $runde != 4){
        $rundeText = $runde+1;
        $text = "Die ".$rundeText.". Runde ist vorüber. Die Karten werden nun neu verteilt.";
        db_query_prepared("UPDATE game SET GameText=? WHERE RoomID=?", array($text, $roomID));
    }else{
        $text = "";
        db_query_prepared("UPDATE game SET GameText=? WHERE RoomID=?", array($text, $roomID));
    }

    $i=0;
    while($i<$spielerAnzahl){
        if($i != $playerID){
            db_query_prepared( "UPDATE players SET UpdateNecessary=true WHERE RoomID=? AND PlayerID=?", array($roomID, $playerID));
        }
        $i++;
    }
}

?>