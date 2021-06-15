<?php

global $linkstring;

define('LINK','http://localhost:8080');

$linkstring = LINK."/joinroom.inc.php?textID=0&roomID=";

require_once 'config_db.inc.php';
require_once 'functions_db.inc.php';
require_once 'functions_get.inc.php';
require_once 'data_game_variables.inc.php';

?>