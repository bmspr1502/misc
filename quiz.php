<?php
$id = $_GET['id'];
//echo "id = " . $id . '<br>';
session_start();

//login check -- needs to be reviewed by person writing login

if(isset($_SESSION["user_type"])){
if($_SESSION["user_type"] == 'student'){

include 'DB.php';

$query= $mysqli->prepare("SELECT * FROM `faculty_papers` WHERE `paper_id`=".$id);
$query->execute();
$quiz_row = $query->get_result();
$quiz_row = $quiz_row->fetch_all();
$query->close();

print_r($quiz_row);

foreach ($quiz_row as $item) {
    $questions = json_decode(stripslashes($item[5]), true);
    $_SESSION['questions'] = $questions;
}

?>
<!doctype html>
<html lang="en">
    <head>
        <title>User Dash Board</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
        <link rel="stylesheet" href="styles/faculty_home.css">
        <link rel="stylesheet" href="styles/general.css">
        <link rel="stylesheet" href="styles/style_student.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    </head>

    <body>
        <header class="container-fluid header-base">
            <div class="row">
                <div class="col-md-6">
                    <div class="text-left">
                        <h3 class="top-title">Student Portal</h3>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="text-right">
                        <form action="user_home.php" method="post">
                            <input type="submit" class="btn btn-secondary top-but" value="Back Home">
                        </form>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row exam-info-header">
                <div class="col-md-4">
                    <span class="timer-container">
                        <span id="minutes"><?php echo $quiz_row[0][3]; ?></span>
                        <span> : </span>
                        <span id="seconds">00</span>
                    </span>
                    <input type="button" class="btn btn-primary" value="Start Exam" onclick="timer()">
                </div>
                <div class="col-md-8 text-right">
                    <input type="button" id="A" class="btn btn-secondary act" value="Section A" onclick="section('A')">
                    <input type="button" id="B" class="btn btn-secondary" value="Section B" onclick="section('B')">
                    <input type="button" id="C" class="btn btn-secondary" value="Section C" onclick="section('C')">
                </div>  
            </div>
        </header>

        <div class="container questions-container current-q" id="questionsA">
        </div>

        <div class="container questions-container" id="questionsB">
        </div>

        <div class="container questions-container" id="questionsC">
        </div>

        <script type="text/javascript">


            var currentSection = 0;
            function section(val){
                if(val === 'A'){
                    currentSection = 0;
                    $("#A").addClass("act");
                    $("#B").removeClass("act");
                    $("#C").removeClass("act");
                } else if(val === 'B'){
                    currentSection = 1;
                    $("#B").addClass("act");
                    $("#A").removeClass("act");
                    $("#C").removeClass("act");
                } else if(val === 'C'){
                    currentSection = 2;
                    $("#C").addClass("act");
                    $("#A").removeClass("act");
                    $("#B").removeClass("act");
                }
            }

            var minText = $("#minutes");
            var secText = $("#seconds");

            var t;
            var timeUp = false;
            var minutes = parseInt(minText.html());
            var seconds = 0

            function add(){
                if(timeUp == true){
                    return;
                }
                if(seconds == 0){
                    seconds = 60;
                    minutes--;
                }
                seconds--;
                seconds = seconds % 60;
                secT = Math.abs(seconds);
                secText.html(secT);
                minText.html(minutes.toString());

                if(minutes <= 0){
                    clearInterval(t);
                    timeUp = true;
                    alert("Time Up");
                    window.location.replace("user_home.php");
                }
            }

            function timer() {
                add();
                t = setInterval(add, 1000);
            } 
        </script>

    </body>
</html>
<?php
}
} else{
    echo 'Not Signed in';
    header("Location: student_login.php");
}