<?php
session_start();
include "DB.php";

$user = $mysqli->real_escape_string($_POST["email"]);
$pass = $mysqli->real_escape_string($_POST["password"]);


$query= $mysqli->prepare("SELECT * FROM student_list WHERE `password`=? AND (`name`=? OR `email`=?)");
$query->bind_param("sss",$pass,$user,$user);
$query->execute();
$list = $query->get_result();
$list = $list->fetch_all(MYSQLI_ASSOC);
$query->close();


if(sizeof($list) <= 0){
    $_SESSION["auth"] = "error";
    //echo "error";
    header("Location: student_login.php");
} else {
    $_SESSION["auth"] = session_id();
    $_SESSION["user_type"] = "student";
    $_SESSION["user_ID"] = $list[0]["student_ID"];
    echo "success";
    header("Location: user_home.php");
}
?>