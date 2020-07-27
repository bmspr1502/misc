<?php
include "DB.php";

$unique_submision_url = $mysqli->real_escape_string($_POST["paper_URL"]);
$unique_submission_ID = (int)($_POST["submission_ID"]);

$start = date("Y-m-d H:i:s");

$statement = $mysqli->prepare("UPDATE `student_papers` set `paper_URL`=? WHERE `unique_submission_ID`=?");
$statement->bind_param("si", $unique_submision_url, $unique_submission_ID);
$statement->execute();
if($statement->affected_rows <= 0){
    echo "error";
    die();
}
$statement->close();


echo "success from make final submission";
?>