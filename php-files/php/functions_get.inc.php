<?php
function get_var_name($var){
    //only works if no variables have the same values
    foreach($GLOBALS as $var_name => $value) {
        if ($value === $var) {
            return $var_name;
        }
    }

    return false;
}

?>