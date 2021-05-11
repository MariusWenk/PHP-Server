<?php
        require_once 'config.inc.php';

        $roomID = $_GET['roomID'];
        $playerID = $_GET['playerID'];

        $initialisiert = db_fetch(db_query_prepared("SELECT Initialisiert FROM rooms WHERE RoomID=?",[$roomID]))[0];

        $spielerAnzahl = db_fetch(db_query_prepared("SELECT PlayerID FROM players WHERE RoomID=? ORDER BY PlayerID DESC LIMIT 1",[$roomID]))[0] + 1;
        
        $i=0;
        $name = new SplFixedArray($spielerAnzahl);
        $role = new SplFixedArray($spielerAnzahl);
        $status = new SplFixedArray($spielerAnzahl);
        $AmZug = new SplFixedArray($spielerAnzahl);
        $CardsSelected = new SplFixedArray($spielerAnzahl);
        $empty = new SplFixedArray($spielerAnzahl);
        $treasure = new SplFixedArray($spielerAnzahl);
        $trap = new SplFixedArray($spielerAnzahl);
        $kartenGesamt = new SplFixedArray($spielerAnzahl);

        while($i < $spielerAnzahl){
            $name[$i] = db_fetch(db_query_prepared("SELECT Name FROM players WHERE RoomID=? AND PlayerID=?",[$roomID, $i]))[0];
            $role[$i] = db_fetch(db_query_prepared("SELECT Role FROM players WHERE RoomID=? AND PlayerID=?",[$roomID, $i]))[0];
            $status[$i] = db_fetch(db_query_prepared("SELECT Status FROM players WHERE RoomID=? AND PlayerID=?",[$roomID, $i]))[0];
            $AmZug[$i] = db_fetch(db_query_prepared("SELECT AmZug FROM players WHERE RoomID=? AND PlayerID=?",[$roomID, $i]))[0];
            $CardsSelected[$i] = db_fetch(db_query_prepared("SELECT CardsSelected FROM players WHERE RoomID=? AND PlayerID=?",[$roomID, $i]))[0];
            $empty[$i] = db_fetch(db_query_prepared("SELECT Leer FROM players WHERE RoomID=? AND PlayerID=?",[$roomID, $i]))[0];
            $treasure[$i] = db_fetch(db_query_prepared("SELECT Gold FROM players WHERE RoomID=? AND PlayerID=?",[$roomID, $i]))[0];
            $trap[$i] = db_fetch(db_query_prepared("SELECT Feuerfalle FROM players WHERE RoomID=? AND PlayerID=?",[$roomID, $i]))[0];
            $kartenGesamt[$i] = $empty[$i] + $treasure[$i] + $trap[$i];
            if($AmZug[$i]){
                $spielerAmZugIndex = $i;
            }
            if($CardsSelected[$i]){
                $spielerCardsSelectedIndex = $i;
            }
            $i++;
        }
        $spielerMenu = db_fetch(db_query_prepared("SELECT SpielerMenu FROM players WHERE RoomID=? AND PlayerID=?",[$roomID, $playerID]))[0];
        $linkMenu = db_fetch(db_query_prepared("SELECT LinkMenu FROM players WHERE RoomID=? AND PlayerID=?",[$roomID, $playerID]))[0];
        
        if($initialisiert){
            $gameMenu = db_fetch(db_query_prepared("SELECT GameMenu FROM game WHERE RoomID=?",[$roomID]))[0];  
            $emptyGen = db_fetch(db_query_prepared("SELECT LeerGen FROM game WHERE RoomID=?",[$roomID]))[0];
            $emptyDisc = db_fetch(db_query_prepared("SELECT LeerDisc FROM game WHERE RoomID=?",[$roomID]))[0];
            $treasureGen = db_fetch(db_query_prepared("SELECT GoldGen FROM game WHERE RoomID=?",[$roomID]))[0];
            $treasureDisc = db_fetch(db_query_prepared("SELECT GoldDisc FROM game WHERE RoomID=?",[$roomID]))[0];
            $trapGen = db_fetch(db_query_prepared("SELECT FeuerfallenGen FROM game WHERE RoomID=?",[$roomID]))[0];
            $trapDisc = db_fetch(db_query_prepared("SELECT FeuerfallenDisc FROM game WHERE RoomID=?",[$roomID]))[0];
            $karteSelected = db_fetch(db_query_prepared("SELECT KarteSelected FROM game WHERE RoomID=?",[$roomID]))[0];
            $karteSelectedPosition = db_fetch(db_query_prepared("SELECT KarteSelectedPosition FROM game WHERE RoomID=?",[$roomID]))[0];
            $karteSelectedPosition = db_fetch(db_query_prepared("SELECT KarteSelectedPosition FROM game WHERE RoomID=?",[$roomID]))[0];
            $gewinner = db_fetch(db_query_prepared("SELECT Winner FROM game WHERE RoomID=?",[$roomID]))[0];
            $gameText = db_fetch(db_query_prepared("SELECT GameText FROM game WHERE RoomID=?",[$roomID]))[0];
        }else{
            $gameMenu = 0; //0 hier wichtig
            $emptyGen = 0;
            $emptyDisc = 0;
            $treasureGen = 0;
            $treasureDisc = 0;
            $trapGen = 0;
            $trapDisc = 0;
            $karteSelected = "Keine";
            $karteSelectedPosition = 0;
            $karteSelectedPosition = 0;
            $gewinner = "Niemand";
            $gameText = "";
        }
?>