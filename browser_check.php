<?php
//this bit of code has to go on top of every php file that is written for this project
$browser = $_SERVER["HTTP_USER_AGENT"];
//echo $browser; ---remove this line in production
//basically all we need to do is check if this  variable, has a certain string in it
//this string will uniquely identify the SE browser
//call this php through the browser (SEB) and see what it prints and then paste string into the variable below
$required_target = "SEB";
if(strpos($browser, $required_target) !== false){
    echo "<script>
            window.location.href = 'faculty_home.php';
            </script>";
} else {
    echo "Sorry, this browser is not supported.";
    die();
}


?>