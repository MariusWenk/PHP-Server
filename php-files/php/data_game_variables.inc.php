<?php
        require_once 'config.inc.php';

        $roomID = $_GET['roomID'];
        $playerID = $_GET['playerID'];

        $initialisiert = db_fetch(db_query("SELECT Initialisiert FROM rooms WHERE RoomID=$roomID"));

        $spielerAnzahl = db_fetch(db_query("SELECT PlayerID FROM players WHERE RoomID=$roomID ORDER BY PlayerID DESC LIMIT 1")) + 1;
        
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
            $name[$i] = db_fetch(db_query("SELECT Name FROM players WHERE RoomID=$roomID AND PlayerID=$i"));
            $role[$i] = db_fetch(db_query("SELECT Role FROM players WHERE RoomID=$roomID AND PlayerID=$i"));
            $status[$i] = db_fetch(db_query("SELECT Status FROM players WHERE RoomID=$roomID AND PlayerID=$i"));
            $AmZug[$i] = db_fetch(db_query("SELECT AmZug FROM players WHERE RoomID=$roomID AND PlayerID=$i"));
            $CardsSelected[$i] = db_fetch(db_query("SELECT CardsSelected FROM players WHERE RoomID=$roomID AND PlayerID=$i"));
            $empty[$i] = db_fetch(db_query("SELECT Leer FROM players WHERE RoomID=$roomID AND PlayerID=$i"));
            $treasure[$i] = db_fetch(db_query("SELECT Gold FROM players WHERE RoomID=$roomID AND PlayerID=$i"));
            $trap[$i] = db_fetch(db_query("SELECT Feuerfalle FROM players WHERE RoomID=$roomID AND PlayerID=$i"));
            $kartenGesamt[$i] = $empty[$i] + $treasure[$i] + $trap[$i];
            if($AmZug[$i]){
                $spielerAmZugIndex = $i;
            }
            if($CardsSelected[$i]){
                $spielerCardsSelectedIndex = $i;
            }
            $i++;
        }
        $spielerMenu = db_fetch(db_query("SELECT SpielerMenu FROM players WHERE RoomID=$roomID AND PlayerID=$playerID"));
        $linkMenu = db_fetch(db_query("SELECT LinkMenu FROM players WHERE RoomID=$roomID AND PlayerID=$playerID"));
        
        if($initialisiert){
            $gameMenu = db_fetch(db_query("SELECT GameMenu FROM game WHERE RoomID=$roomID"));  
            $emptyGen = db_fetch(db_query("SELECT LeerGen FROM game WHERE RoomID=$roomID"));
            $emptyDisc = db_fetch(db_query("SELECT LeerDisc FROM game WHERE RoomID=$roomID"));
            $treasureGen = db_fetch(db_query("SELECT GoldGen FROM game WHERE RoomID=$roomID"));
            $treasureDisc = db_fetch(db_query("SELECT GoldDisc FROM game WHERE RoomID=$roomID"));
            $trapGen = db_fetch(db_query("SELECT FeuerfallenGen FROM game WHERE RoomID=$roomID"));
            $trapDisc = db_fetch(db_query("SELECT FeuerfallenDisc FROM game WHERE RoomID=$roomID"));
            $karteSelected = db_fetch(db_query("SELECT KarteSelected FROM game WHERE RoomID=$roomID"));
            $karteSelectedPosition = db_fetch(db_query("SELECT KarteSelectedPosition FROM game WHERE RoomID=$roomID"));
            $karteSelectedPosition = db_fetch(db_query("SELECT KarteSelectedPosition FROM game WHERE RoomID=$roomID"));
            $gewinner = db_fetch(db_query("SELECT Winner FROM game WHERE RoomID=$roomID"));
            $gameText = db_fetch(db_query("SELECT GameText FROM game WHERE RoomID=$roomID"));
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