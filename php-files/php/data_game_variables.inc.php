<?php
        require_once 'config.inc.php';

        $roomID = $_GET['roomID'];
        $playerID = $_GET['playerID'];

        $initialisiert = db_fetch(db_query_prepared("SELECT Initialisiert FROM rooms WHERE RoomID=?",[$roomID]))['Initialisiert'];

        $spielerAnzahl = db_fetch(db_query_prepared("SELECT PlayerID FROM players WHERE RoomID=? ORDER BY PlayerID DESC LIMIT 1",[$roomID]))['PlayerID'] + 1;
        
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
            $name[$i] = db_fetch(db_query_prepared("SELECT Name FROM players WHERE RoomID=? AND PlayerID=?",[$roomID, $i]))['Name'];
            $role[$i] = db_fetch(db_query_prepared("SELECT Role FROM players WHERE RoomID=? AND PlayerID=?",[$roomID, $i]))['Role'];
            $status[$i] = db_fetch(db_query_prepared("SELECT Status FROM players WHERE RoomID=? AND PlayerID=?",[$roomID, $i]))['Status'];
            $AmZug[$i] = db_fetch(db_query_prepared("SELECT AmZug FROM players WHERE RoomID=? AND PlayerID=?",[$roomID, $i]))['AmZug'];
            $CardsSelected[$i] = db_fetch(db_query_prepared("SELECT CardsSelected FROM players WHERE RoomID=? AND PlayerID=?",[$roomID, $i]))['CardsSelected'];
            $empty[$i] = db_fetch(db_query_prepared("SELECT Leer FROM players WHERE RoomID=? AND PlayerID=?",[$roomID, $i]))['Leer'];
            $treasure[$i] = db_fetch(db_query_prepared("SELECT Gold FROM players WHERE RoomID=? AND PlayerID=?",[$roomID, $i]))['Gold'];
            $trap[$i] = db_fetch(db_query_prepared("SELECT Feuerfalle FROM players WHERE RoomID=? AND PlayerID=?",[$roomID, $i]))['Feuerfalle'];
            $kartenGesamt[$i] = $empty[$i] + $treasure[$i] + $trap[$i];
            if($AmZug[$i]){
                $spielerAmZugIndex = $i;
            }
            if($CardsSelected[$i]){
                $spielerCardsSelectedIndex = $i;
            }
            $i++;
        }
        $spielerMenu = db_fetch(db_query_prepared("SELECT SpielerMenu FROM players WHERE RoomID=? AND PlayerID=?",[$roomID, $playerID]))['SpielerMenu'];
        $linkMenu = db_fetch(db_query_prepared("SELECT LinkMenu FROM players WHERE RoomID=? AND PlayerID=?",[$roomID, $playerID]))['LinkMenu'];
        
        if($initialisiert){
            $gameMenu = db_fetch(db_query_prepared("SELECT GameMenu FROM game WHERE RoomID=?",[$roomID]))['GameMenu'];  
            $emptyGen = db_fetch(db_query_prepared("SELECT LeerGen FROM game WHERE RoomID=?",[$roomID]))['LeerGen'];
            $emptyDisc = db_fetch(db_query_prepared("SELECT LeerDisc FROM game WHERE RoomID=?",[$roomID]))['LeerDisc'];
            $treasureGen = db_fetch(db_query_prepared("SELECT GoldGen FROM game WHERE RoomID=?",[$roomID]))['GoldGen'];
            $treasureDisc = db_fetch(db_query_prepared("SELECT GoldDisc FROM game WHERE RoomID=?",[$roomID]))['GoldDisc'];
            $trapGen = db_fetch(db_query_prepared("SELECT FeuerfallenGen FROM game WHERE RoomID=?",[$roomID]))['FeuerfallenGen'];
            $trapDisc = db_fetch(db_query_prepared("SELECT FeuerfallenDisc FROM game WHERE RoomID=?",[$roomID]))['FeuerfallenDisc'];
            $karteSelected = db_fetch(db_query_prepared("SELECT KarteSelected FROM game WHERE RoomID=?",[$roomID]))['KarteSelected'];
            $karteSelectedPosition = db_fetch(db_query_prepared("SELECT KarteSelectedPosition FROM game WHERE RoomID=?",[$roomID]))['KarteSelectedPosition'];
            $karteSelectedPosition = db_fetch(db_query_prepared("SELECT KarteSelectedPosition FROM game WHERE RoomID=?",[$roomID]))['KarteSelectedPosition'];
            $gewinner = db_fetch(db_query_prepared("SELECT Winner FROM game WHERE RoomID=?",[$roomID]))['Winner'];
            $gameText = db_fetch(db_query_prepared("SELECT GameText FROM game WHERE RoomID=?",[$roomID]))['GameText'];
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