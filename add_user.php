<?php
session_start();
//Checks if already logged in and if yes then redirects to respective pages
include_once 'browser_check.php';
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
    <title>Add New User</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/faculty_home.css">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
</head>
<body>
<header class="container-fluid header-base">
    <h2 style="text-align: center">Add New User</h2>
    <div class="text-right">
        <button type="submit" onclick="location.href='index.php'" class="btn btn-success">Go to home</button>
    </div>
</header>
<div class="container">
    <form action="add_user.php" method="post">
        <div class="form-group">
        <div class="form-check-inline">
            <label class="form-check-label">
                <input type="radio" class="form-check-input" name="type" value="student">Student
            </label>
        </div>
        <div class="form-check-inline">
            <label class="form-check-label">
                <input type="radio" class="form-check-input" name="type" value="faculty">Faculty
            </label>
        </div>
        </div>
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" name='name' placeholder="Enter name" id="name" required>
        </div>
        <div class="form-group">
            <label for="email">Email address:</label>
            <input type="email" class="form-control" name='email' placeholder="Enter email" id="email" required>
        </div>
        <div class="form-group">
            <label for="pwd">Password:</label>
            <input type="password" class="form-control" name='password' placeholder="Enter password" id="pwd" required>
        </div>
        <input type="submit" class="btn btn-primary" name="signup" id="signup" value="Sign UP">
    </form>
    <?php
    if(isset($_POST['signup'])){
        include 'DB.php';
        $name = $mysqli->real_escape_string($_POST["name"]);
        $email = $mysqli->real_escape_string($_POST["email"]);
        $password = $mysqli->real_escape_string($_POST["password"]);

        if($_POST['type']=='faculty'){
            $statement = $mysqli->prepare("INSERT INTO `faculty_list` (`name`, `emailid`,`password` ) VALUES (?, ?, ?)");
            if($statement) {
                $statement->bind_param("sss", $name, $email, $password);
                $statement->execute();
                echo 'Faculty added, redirecting to login page';
                echo "<script>
                         setTimeout(function(){
                            window.location.href = 'faculty_login.php';
                         }, 1500);
                        </script>";
            }else{
                var_dump($mysqli->error);
            }
        } else if($_POST['type']=='student'){
            $statement = $mysqli->prepare("INSERT INTO `student_list` (`name`, `email`,`password` ) VALUES (?, ?, ?)");
            if($statement) {
                $statement->bind_param("sss", $name, $email, $password);
                $statement->execute();
                echo 'Student added, redirecting to student page';
                echo "<script>
                         setTimeout(function(){
                            window.location.href = 'student_login.php';
                         }, 1500);
                        </script>";
            }else{
                var_dump($mysqli->error);
            }
        }else{
            echo 'Select the type of user';
        }

    }

    ?>
</div>
</body>