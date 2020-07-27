<?php
session_start();
$id = intval($_REQUEST['id']);
$qn = $_REQUEST['qn'];
$questions = $_SESSION['questions'];
foreach ($questions as $item){
    if(intval($item['questionNumber']) == $qn){
        echo $item['questionText'];
    }
}