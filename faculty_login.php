<?php
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
    <title>Faculty Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/faculty_home.css">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
</head>
<body>
<header class="container-fluid header-base">
    <h2 style="text-align: center">Faculty Login</h2>
    <div class="text-right">
        <button type="submit" onclick="location.href='index.php'" class="btn btn-success">Go to home</button>
    </div>
</header>
<div class="container">
    <form action="faculty_login.php" method="post">
        <div class="form-group">
            <label for="email">Email address:</label>
            <input type="email" class="form-control" name='email' placeholder="Enter email" id="email">
        </div>
        <div class="form-group">
            <label for="pwd">Password:</label>
            <input type="password" class="form-control" name='password' placeholder="Enter password" id="pwd">
        </div>
        <input type="submit" class="btn btn-primary" name="signin" id="signin" value="signin">
    </form>
    <?php
    if(isset($_POST['signin'])){
        include 'DB.php';
//for active papers
        $query= $mysqli->prepare("SELECT * FROM `faculty_list`");
        $query->execute();
        $list = $query->get_result();
        $list = $list->fetch_all();
        $query->close();

        $found = false;
        foreach ($list as $user){
            if(($user[2]==$_POST['email']) && ($user[3]==$_POST['password'])){
                $_SESSION['user_type'] = 'faculty';
                $_SESSION["facultyID"] = $user[0];
                echo 'Login Successful';
                header("Location: faculty_home.php");
                $found = true;
                break;
            }
        }

        if($found == false){
            echo 'user not found';
        }
    }
    ?>
</div>
</body>