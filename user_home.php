<?php
session_start();
//login check -- needs to be reviewed by person writing login

if(isset($_SESSION["user_type"])){
    if($_SESSION["user_type"] == 'student'){

include 'DB.php';
//need to perform check to see if student's enrolled courses matched this paricular paper
//also perform a timing check to see id the required time has crossed
//use an async ajax call to do that
$query= $mysqli->prepare("SELECT * FROM `faculty_papers`");
$query->execute();
$all_papers = $query->get_result();
$all_papers = $all_papers->fetch_all();
$query->close();
?>

<!doctype html>
<html lang="en">
    <head>
        <title>Student | Home</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
        <link rel="stylesheet" href="styles/faculty_home.css">
        <link rel="stylesheet" href="styles/general.css">
        <link rel="stylesheet" href="styles/style_student.css">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    </head>

    <body>
        <header class="container-fluid header-base row">
                <div class="col-md-6">
                    <div class="text-left">
                        <h3 class="top-title">Student Portal</h3>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="text-right">
                        <form action="student_login.php" method="post">
                            <input type="submit" class="btn btn-secondary top-but" value="Sign Out" name="signout">
                            <?php
                            if(isset($_POST['signout'])){
                                unset($_SESSION['user_type']);
                                header("Location: student_login.php");
                            }
                            unset($_SESSION['user_type']);
                            header("Location: student_login.php");
                            ?>
                        </form>
                    </div>
                </div>
        </header>



        <div class="container main-section">
            <div class="card-header">
                Active Papers
            </div>
            
            <ul class="list-group list-group flush">
                
                <?php
                foreach($all_papers as $paper){
                    $ID = $paper[0];
                    $marks = $paper[4];
                    $time = $paper[3];
                    echo '<div class="student_paper row">';
                        echo '<div class="col-md-4 text-left">';
                            echo '<div class="info-group">Paper ID: '.$ID.'</div>';
                            echo '<div class="info-group">Maximum Marks: '.$marks.'</div>';
                            echo '<div class="info-group">Total Time: '.$marks.' minutes</div>';
                            echo '<div class="info-group">
                                <a href="quiz.php?id=' . $ID . '">
                                    <input type="button" class="btn btn-primary ex-but" value="Take Exam">
                                </a>
                            </div>';
                        echo '</div>';
                        echo '<div class="col-md-8 text-center">';
                            echo '<div class="info-group-2">Course ID</div>';
                            echo '<div class="info-group-2">Course Name</div>';
                            echo '<div class="info-group-2">Professor</div>';
                        echo '</div>';
                    echo '</div>';
                }
                ?>
            </ul>
        </div>
    </body>
</html>

<?php
    }   
} else{
    echo 'Not Signed in';
    header("Location: student_login.php");
}
?>