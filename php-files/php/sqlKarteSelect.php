<?php
require_once 'config.inc.php';

$roomID = $_GET['roomID'];
$playerID = $_GET['playerID'];
$select = $_GET['select'];

$spielerAnzahl = db_fetch(db_query("SELECT PlayerID FROM players WHERE RoomID=$roomID ORDER BY PlayerID DESC LIMIT 1")) + 1;
$chooseCardStatus = db_fetch(db_query("SELECT ChooseCardStatus FROM game WHERE RoomID=$roomID"));

if($chooseCardStatus == 1){
    db_query("UPDATE game SET ChooseCardStatus=0 WHERE RoomID=$roomID");

    $player = 0;
    $i=0;
    while($i < $spielerAnzahl){
        db_query("UPDATE players SET AmZug=false WHERE PlayerID=$i AND RoomID='$roomID'");
        $playerSelected = db_fetch(db_query("SELECT CardsSelected FROM players WHERE RoomID=$roomID AND PlayerID=$i"));
        if($playerSelected){
            $player = $i;
        }
        $i++;
    }

    $empty = db_fetch(db_query("SELECT Leer FROM players WHERE RoomID=$roomID AND PlayerID=$player"));
    $treasure = db_fetch(db_query("SELECT Gold FROM players WHERE RoomID=$roomID AND PlayerID=$player"));
    $trap = db_fetch(db_query("SELECT Feuerfalle FROM players WHERE RoomID=$roomID AND PlayerID=$player"));
    $kartenGesamt = $empty + $treasure + $trap;

    $r = rand(1,$kartenGesamt);
    if($r<=$empty){
        db_query("UPDATE players SET Leer=Leer-1 WHERE PlayerID=$player AND RoomID=$roomID");
        db_query("UPDATE game SET LeerDisc=LeerDisc+1 WHERE RoomID=$roomID");
        $karteSelected = "Leer";
    } else if($r>($kartenGesamt-$trap)){
        db_query("UPDATE players SET Feuerfalle=Feuerfalle-1 WHERE PlayerID=$player AND RoomID=$roomID");
        db_query("UPDATE game SET FeuerfallenDisc=FeuerfallenDisc+1 WHERE RoomID=$roomID");
        $karteSelected = "Feuerfalle";
    } else{
        db_query("UPDATE players SET Gold=Gold-1 WHERE PlayerID=$player AND RoomID=$roomID");
        db_query("UPDATE game SET GoldDisc=GoldDisc+1 WHERE RoomID=$roomID");
        $karteSelected = "Gold";
    }

    db_query("UPDATE players SET AmZug=true WHERE PlayerID=$player AND RoomID='$roomID'");

    db_query("UPDATE game SET GameMenu=3 WHERE RoomID=$roomID");

    db_query("UPDATE game SET CardsPlayed=CardsPlayed+1 WHERE RoomID=$roomID");
    db_query("UPDATE game SET KarteSelected='$karteSelected' WHERE RoomID=$roomID");
    db_query("UPDATE game SET KarteSelectedPosition=$select WHERE RoomID=$roomID");

    $cardsPlayed = db_fetch(db_query("SELECT CardsPlayed FROM game WHERE RoomID=$roomID"));
    $runde = db_fetch(db_query("SELECT Runde FROM game WHERE RoomID=$roomID"));

    if($cardsPlayed == $spielerAnzahl && $runde != 4){
        $rundeText = $runde+1;
        $text = "Die ".$rundeText.". Runde ist vorüber. Die Karten werden nun neu verteilt.";
        db_query("UPDATE game SET GameText='$text' WHERE RoomID=$roomID");
    }else{
        $text = "";
        db_query("UPDATE game SET GameText='$text' WHERE RoomID=$roomID");
    }

    $i=0;
    while($i<$spielerAnzahl){
        if($i != $playerID){
            db_query( "UPDATE players SET UpdateNecessary=true WHERE RoomID=$roomID AND PlayerID=$playerID");
        }
        $i++;
    }
}

?>