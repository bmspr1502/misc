<?php
session_start();
//login check -- needs to be reviewed by person writing login

if(isset($_SESSION["auth"])){
    $_SESSION["error"] = "not logged in";
    header("Location: login.php");
}

include 'DB.php';

$query= $mysqli->prepare("SELECT * FROM `faculty_papers`");
$query->execute();
$all_papers = $query->get_result();
$all_papers = $all_papers->fetch_all();
$query->close();
?>
<!doctype html>
<html lang="en">
<head>
    <title>User Dash Board</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/faculty_home.css">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
</head>

<body>
<header class="container-fluid header-base">
    <h2 style="text-align: center">User Dashboard</h2>
</header>

<div class="container">
    <div class="card">
        <!--Show currently active papers and a button to create one-->
        <div class="card-header">
            Active Papers
        </div>
        <ul class="list-group list-group flush">
        <?php
        foreach($all_papers as $paper){
            $ID = $paper[0];
            $marks = $paper[4];
            $status = intval($paper[6]);
            $txt = '<li class="list-group-item text-center"><a href="quiz.php?id=' . $ID . '">';
            if($status==0) {
                $txt= $txt .'<button type="button" class="btn btn-success btn-block"> ';
            } else if($status==1){
                $txt = $txt . '<button type="button" class="btn btn-warning btn-block disabled">';
            }else if($status==2){
                $txt = $txt . '<button type="button" class="btn btn-danger btn-block disabled">';
            }
            $txt= $txt . ' Paper ID ' . $ID . '<br>
                    Total marks ' . $marks . '
                    </button></a>';
            echo $txt;
        }
        ?>
        </ul>
    </div>

</div>
</body>
</html>
