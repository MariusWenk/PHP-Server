<?php

global $linkstring;

define('LINK','http://localhost:8080');

$linkstring = LINK."/joinroom.php?textID=0&roomID=";

include 'config_db.inc.php';
include 'functions_db.inc.php';
include 'data_game_variables.inc.php';

?>