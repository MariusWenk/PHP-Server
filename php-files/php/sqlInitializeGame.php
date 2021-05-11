<?php
require_once 'config.inc.php';

$roomID = $_GET['roomID'];
$playerID = $_GET['playerID'];

$spielerAnzahl = db_fetch(db_query("SELECT PlayerID FROM players WHERE RoomID=$roomID ORDER BY PlayerID DESC LIMIT 1"))[0] + 1;

$emptyGen = db_fetch(db_query("SELECT Leer FROM doors WHERE Spielerzahl=$spielerAnzahl "))[0];
$treasureGen = db_fetch(db_query("SELECT Gold FROM doors WHERE Spielerzahl=$spielerAnzahl"))[0];
$trapGen = db_fetch(db_query("SELECT Feuerfallen FROM doors WHERE Spielerzahl=$spielerAnzahl"))[0];

$abenteurer = db_fetch(db_query("SELECT Abenteurer FROM roles WHERE Spielerzahl=$spielerAnzahl"))[0];
$waechterinnen = db_fetch(db_query("SELECT Waechterinnen FROM roles WHERE Spielerzahl=$spielerAnzahl"))[0];

$ges = $abenteurer + $waechterinnen;
$i = 0;
while($i < $spielerAnzahl){
    $r = rand(1, $ges-$i);
    if($r<=$abenteurer){
        db_query("UPDATE players SET Role='Abenteurer' WHERE PlayerID=$i AND RoomID='$roomID'");
        $abenteurer--;
    } else{
        db_query("UPDATE players SET Role='Waechterin' WHERE PlayerID=$i AND RoomID='$roomID'");
        $waechterinnen--;
    }
    $i++;
}

$r2 = rand(0,($spielerAnzahl-1));
db_query("UPDATE players SET AmZug=false WHERE PlayerID=0 AND RoomID='$roomID'");
db_query("UPDATE players SET AmZug=true WHERE PlayerID=$r2 AND RoomID='$roomID'");

db_query("INSERT INTO game VALUES ($roomID, $emptyGen, $treasureGen, $trapGen, 0, 0, 0, 0, $spielerAnzahl, 0, 1, 'Leer', 0, '', '', 0)");

db_query("UPDATE rooms SET Initialisiert=true WHERE RoomID='$roomID'");

header("Location: sqlSetCards.php?roomID=".$roomID."&playerID=".$playerID);

?>