<?php
include 'browser_check.php';
session_start();
if(isset($_SESSION['user_type'])){
    if($_SESSION['user_type'] == 'faculty'){
        header("Location: faculty_home.php");
    } else if($_SESSION['user_type'] == 'student'){
        header("Location: user_home.php");
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <title>Home</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/faculty_home.css">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
</head>

<body>
<header class="container-fluid header-base">
    <h2 style="text-align: center">Home</h2>
</header>
<div class="container">
        <div class="container papers-container section">
            <!--Show currently active papers and a button to create one-->
            <div class="section-title">
                Choose your mode
            </div>
            <a href="faculty_login.php">
                <div class="paper pap text-center">
                    <div class="action">Faculty Login</div>
                </div>
            </a>
            <a href="student_login.php">
                <div class="paper pap text-center">
                    <div class="action">Student Login</div>
                </div>
            </a>
            <a href="add_user.php">
                <div class="paper pap text-center">
                    <div class="action">Add User</div>
                </div>
            </a>
        </div>
</div>
</body>
</html>