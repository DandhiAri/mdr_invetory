<?php 
function countData($table){
    // $db = \config\database::connect();
    return $db->table($table)->countAllResult();
}

?>