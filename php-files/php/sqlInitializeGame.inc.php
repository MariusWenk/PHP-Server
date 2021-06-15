<?php
require_once 'config.inc.php';

$roomID = $_GET['roomID'];
$playerID = $_GET['playerID'];

$spielerAnzahl = db_fetch(db_query_prepared("SELECT PlayerID FROM players WHERE RoomID=? ORDER BY PlayerID DESC LIMIT 1", array($roomID)))['PlayerID'] + 1;

$emptyGen = db_fetch(db_query_prepared("SELECT Leer FROM doors WHERE Spielerzahl=? ", array($spielerAnzahl)))['Leer'];
$treasureGen = db_fetch(db_query_prepared("SELECT Gold FROM doors WHERE Spielerzahl=?", array($spielerAnzahl)))['Gold'];
$trapGen = db_fetch(db_query_prepared("SELECT Feuerfallen FROM doors WHERE Spielerzahl=?", array($spielerAnzahl)))['Feuerfallen'];

$abenteurer = db_fetch(db_query_prepared("SELECT Abenteurer FROM roles WHERE Spielerzahl=?", array($spielerAnzahl)))['Abenteurer'];
$waechterinnen = db_fetch(db_query_prepared("SELECT Waechterinnen FROM roles WHERE Spielerzahl=?", array($spielerAnzahl)))['Waechterinnen'];

$ges = $abenteurer + $waechterinnen;
$i = 0;
while($i < $spielerAnzahl){
    $r = rand(1, $ges-$i);
    if($r<=$abenteurer){
        db_query_prepared("UPDATE players SET Role='Abenteurer' WHERE PlayerID=? AND RoomID=?", array($i, $roomID));
        $abenteurer--;
    } else{
        db_query_prepared("UPDATE players SET Role='Waechterin' WHERE PlayerID=? AND RoomID=?", array($i, $roomID));
        $waechterinnen--;
    }
    $i++;
}

$r2 = rand(0,($spielerAnzahl-1));
db_query_prepared("UPDATE players SET AmZug=false WHERE PlayerID=0 AND RoomID=?", array($roomID));
db_query_prepared("UPDATE players SET AmZug=true WHERE PlayerID=? AND RoomID=?", array($r2, $roomID));

db_query_prepared("INSERT INTO game VALUES (?, ?, ?, ?, 0, 0, 0, 0, ?, 0, 1, 'Leer', 0, '', '', 0)", array($roomID, $emptyGen, $treasureGen, $trapGen, $spielerAnzahl));

db_query_prepared("UPDATE rooms SET Initialisiert=true WHERE RoomID=?", array($roomID));

header("Location: sqlSetCards.inc.php?roomID=".$roomID."&playerID=".$playerID);

?>