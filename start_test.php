<?php
include "DB.php";

$user_ID = (int)($_POST["user_ID"]);
$paper_ID = (int)($_POST["paper_ID"]);

$start = date("Y-m-d H:i:s");

$statement = $mysqli->prepare("SELECT * FROM `student_papers` WHERE `student_ID`=? AND `paper_ID`=?");
$statement->bind_param("ii", $user_ID, $paper_ID);
$statement->execute();
$l = $statement->get_result()->fetch_all();
if(sizeof($l) > 0){
    echo "alreadyexists";
    die();
}
$statement->close();

$statement = $mysqli->prepare("INSERT INTO `student_papers` (`student_ID`, `paper_ID`, `start_time`) VALUES (?, ?, ?)");
$statement->bind_param("iis", $user_ID, $paper_ID, $start);
$statement->execute();

if ($statement->affected_rows < 0){
	 echo "error";
	 die();
}
$statement->close();

$statement = $mysqli->prepare("SELECT * FROM `student_papers` WHERE `student_ID`=? AND `paper_ID`=? AND `start_time`=?");
$statement->bind_param("iis", $user_ID, $paper_ID,$start);
$statement->execute();
$l = $statement->get_result()->fetch_all(MYSQLI_ASSOC);
if(sizeof($l) <= 0){
    echo "error";
    die();
}
$statement->close();

echo $l[0]["unique_submission_ID"];
?>