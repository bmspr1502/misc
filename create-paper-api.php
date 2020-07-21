<?php
include 'DB.php';

$duration = $mysqli->real_escape_string($_POST["paper-duration"]);
$marks = $mysqli->real_escape_string($_POST["paper-marks"]);
$deadline = $mysqli->real_escape_string($_POST["paper-datetime"]);
$questions = $mysqli->real_escape_string($_POST["paper-questions"]);
$faculty = $mysqli->real_escape_string($_POST["facultyID"]);

$statement = $mysqli->prepare("INSERT INTO `faculty_papers` (`paper_duration`, `total_marks`, `paper-due`, `question_data`, `faculty_ID`) VALUES (?, ?, ?, ?, ?)");
$statement->bind_param("iissi", $duration, $marks, $deadline, $questions,$faculty);
$statement->execute();
?>