<?php
session_destroy();
session_start();

?>
<!doctype html>
<html lang="en">
<head>
    <title>Student Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/faculty_home.css">
    <link rel="stylesheet" href="styles/faculty_login.css">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
</head>
<body>
    <header class="container-fluid header-base row">
        <div class="col-md-6">
            <div class="text-left">
                <h3 class="top-title">Student Login</h3>
            </div>
        </div>
        <div class="col-md-6">
            <div class="text-right">
                <form action="index.php" method="post">
                    <input type="submit" class="btn btn-secondary top-but" value="Back Home">
                </form>
            </div>
        </div>
    </header>


<div class="container">

    <div class="container loginItem">
        <form action="student_login.php" method="post">
            <div class="form-group">
                <label class="" for="email">Username or Email</label>
                <input type="text" class="form-control" name='email' placeholder="Enter email" id="email" autocomplete="off">
            </div>
            <div class="form-group">
                <label for="pwd">Password</label>
                <input type="password" class="form-control" name='password' placeholder="Enter password" id="pwd" autocomplete="off">
            </div>
            <div class="form-group text-center button-group">
                <input type="button" class="btn btn-secondary but" name="register" id="register" value="Register"></input>
                <input type="submit" class="btn btn-primary but" name="signin" id="signin" value="Sign In"></input>
            </div>
        </form>
    </div>

    <?php
    echo "fghfh";
        echo "fgfdh";
        include 'DB.php';
//for active papers
        $query= $mysqli->prepare("SELECT * FROM `student_list`");
        $query->execute();
        $list = $query->get_result();
        $list = $list->fetch_all();
        $query->close();

        print_r($list);
        var_dump($_POST);

        $found = false;
        foreach ($list as $user){
            if(($user[2]==$_POST['email']) && ($user[3]==$_POST['password'])){
                $_SESSION['user_type'] = 'student';
                header("Location: user_home.php");
                echo "match_found";
                $found = true;
                break;
            }
        }

        if($found == false){
            echo 'Invalid Email or Password';
        }
    ?>
</div>
</body>