<?php
session_start();
include_once 'browser_check.php';
//login check
if(isset($_SESSION["user_type"])){
   if($_SESSION["user_type"] == 'faculty'){



include 'DB.php';
//for active papers
$query= $mysqli->prepare("SELECT `paper_ID` FROM `faculty_papers` WHERE `status`=0");
$query->execute();
$papers_active_result = $query->get_result();
$papers_active_result = $papers_active_result->fetch_all();
$query->close();



//papers to be evauated
$query = $mysqli->prepare("SELECT `paper_ID` FROM `faculty_papers` WHERE `status`=1");
$query->execute();
$papers_pending_result = $query->get_result();
$papers_pending_result = $papers_pending_result->fetch_all();
$query->close();


//papers that are done
$query= $mysqli->prepare("SELECT `paper_ID` FROM `faculty_papers` WHERE `status`=2");
$query->execute();
$papers_done_result = $query->get_result();
$papers_done_result = $papers_done_result->fetch_all();
$query->close();

?>
<!doctype html>
<html lang="en">
    <head>
        <title>Faculty Home</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
        <link rel="stylesheet" href="styles/faculty_home.css">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    </head>

    <body>
        <header class="container-fluid header-base">
            <div class="text-right">
                <form action="faculty_home.php" method="post">
                    <input type="submit" value="sign out" name="signout">
                    <?php
                    if(isset($_POST['signout'])){
                        unset($_SESSION['user_type']);
                        header("Location: faculty_login.php");
                    }
                    ?>
                </form>
            </div>
        </header>

        <div class="container">
            <div class="container papers-container section">
                <!--Show currently active papers and a button to create one-->
                <div class="section-title">
                    Active Papers
                </div>
                <a href="create_new_paper.php">
                    <div class="paper pap text-center">
                        <div class="action">Create New</div>
                    </div>
                </a>

                <?php
                foreach($papers_active_result as $paper){
                    $ID = $paper[0];
                    echo '<div class="paper text-center">
                    <div class="action">Paper ID '.$ID.'</div>
                    </div>';
                }
                ?>

            </div>
            <div class="container papers-tbc section">
            <div class="section-title">
                    Papers to be Evaluated
                </div>
                <?php
                foreach($papers_pending_result as $paper){
                    $ID = $paper[0];
                    echo '<div class="paper text-center">
                    <div class="action">Paper ID '.$ID.'</div>
                    </div>';
                }
                ?>
            </div>
            <div class="container papers-eval section">
            <div class="section-title">
                    Active Papers
                </div>
                <?php
                foreach($papers_done_result as $paper){
                    $ID = $paper[0];
                    echo '<div class="paper text-center">
                    <div class="action">Paper ID '.$ID.'</div>
                    </div>';
                }
                ?>
            </div>
        </div>
    </body>
       </html>
    <?php
    }
} else{
    echo 'Not Signed in';
    header("Location: faculty_login.php");
    }