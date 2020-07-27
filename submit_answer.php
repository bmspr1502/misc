<?php
$target_dir = "student_answers/";
$today = date("m.d.y.H.i.s"); 
$out = hash('md5', $today);

$filename = $_FILES['file']['name'];

$imageType = pathinfo($filename,PATHINFO_EXTENSION);
$imageType = strtolower($imageType);
if($imageType != "pdf") {
    echo "typeerror";
    die();
 }

$targetURL = $target_dir.$out.".".$imageType;

if(move_uploaded_file($_FILES['file']['tmp_name'],$targetURL)){
    echo $targetURL;
 }else{
    echo "filecreationerror";
 }
?>