<?php
$target_dir = "QImages/";
$today = date("m.d.y.H.i.s"); 
$out = hash('md5', $today);

$filename = $_FILES['file']['name'];

$imageType = pathinfo($filename,PATHINFO_EXTENSION);
$valid_extensions = array("jpg","jpeg","png");
if( !in_array(strtolower($imageType),$valid_extensions) ) {
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