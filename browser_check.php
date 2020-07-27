<?php
//this bit of code has to go on top of every php file that is written for this project
$browser = $_SERVER["HTTP_USER_AGENT"];
/*
 * while production comment out the following condition as this makes the file to be only workable in Safe Exam Browser
 */
$required_target = "SEB";
if(!(strpos($browser, $required_target) !== false)){
    echo "Sorry, this browser is not supported.";
    die();
}

?>