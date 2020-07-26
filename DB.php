<?php
//db parameters
$SERVER = 'localhost';
$USERNAME = 'exam';
$PASSWORD = 'exam123';
$DB = 'exam_app_db';

date_default_timezone_set('Asia/Kolkata');

$mysqli = new mysqli($SERVER, $USERNAME, $PASSWORD, $DB);

if ($mysqli->connect_error) {
	exit('Cannot connect to DataBase');
} 

error_reporting(E_ALL);
ini_set('display_errors', 1);

function get_result($statement) {

    $result = array();
    $statement->store_result();
    
    for ($i = 0; $i<$statement->num_rows; $i++) {
        $metadata = $statement->result_metadata();
        $params = array();
    
        while ($field = $metadata->fetch_field() ) {
            $params[] = &$result[$i][$field->name];
        }

        call_user_func_array(array($statement, 'bind_result'), $params);
        $statement->fetch();
    }
    
    return $result;
}

?>