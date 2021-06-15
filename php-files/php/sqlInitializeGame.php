<?php
require_once 'config.inc.php';

$roomID = $_GET['roomID'];
$playerID = $_GET['playerID'];

$spielerAnzahl = db_fetch(db_query_prepared("SELECT PlayerID FROM players WHERE RoomID=:roomID ORDER BY PlayerID DESC LIMIT 1", array($roomID)))['PlayerID'] + 1;

$emptyGen = db_fetch(db_query_prepared("SELECT Leer FROM doors WHERE Spielerzahl=:spielerAnzahl ", array($spielerAnzahl)))['Leer'];
$treasureGen = db_fetch(db_query_prepared("SELECT Gold FROM doors WHERE Spielerzahl=:spielerAnzahl", array($spielerAnzahl)))['Gold'];
$trapGen = db_fetch(db_query_prepared("SELECT Feuerfallen FROM doors WHERE Spielerzahl=:spielerAnzahl", array($spielerAnzahl)))['Feuerfallen'];

$abenteurer = db_fetch(db_query_prepared("SELECT Abenteurer FROM roles WHERE Spielerzahl=:spielerAnzahl", array($spielerAnzahl)))['Abenteurer'];
$waechterinnen = db_fetch(db_query_prepared("SELECT Waechterinnen FROM roles WHERE Spielerzahl=:spielerAnzahl", array($spielerAnzahl)))['Waechterinnen'];

$ges = $abenteurer + $waechterinnen;
$i = 0;
while($i < $spielerAnzahl){
    $r = rand(1, $ges-$i);
    if($r<=$abenteurer){
        db_query_prepared("UPDATE players SET Role='Abenteurer' WHERE PlayerID=:i AND RoomID=:roomID", array($i, $roomID));
        $abenteurer--;
    } else{
        db_query_prepared("UPDATE players SET Role='Waechterin' WHERE PlayerID=:i AND RoomID=:roomID", array($i, $roomID));
        $waechterinnen--;
    }
    $i++;
}

$r2 = rand(0,($spielerAnzahl-1));
db_query_prepared("UPDATE players SET AmZug=false WHERE PlayerID=0 AND RoomID=:roomID", array($roomID));
db_query_prepared("UPDATE players SET AmZug=true WHERE PlayerID=:r2 AND RoomID=:roomID", array($r2, $roomID));

db_query_prepared("INSERT INTO game VALUES (:roomID, :emptyGen, :treasureGen, :trapGen, 0, 0, 0, 0, :spielerAnzahl, 0, 1, 'Leer', 0, '', '', 0)", array($roomID, $emptyGen, $treasureGen, $trapGen, $spielerAnzahl));

db_query_prepared("UPDATE rooms SET Initialisiert=true WHERE RoomID=:roomID", array($roomID));

header("Location: sqlSetCards.php?roomID=".$roomID."&playerID=".$playerID);

?>