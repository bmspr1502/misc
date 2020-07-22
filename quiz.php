<?php
$id = $_GET['id'];
//echo "id = " . $id . '<br>';
session_start();

//login check -- needs to be reviewed by person writing login

if(isset($_SESSION["auth"])){
    $_SESSION["error"] = "not logged in";
    header("Location: login.php");
}

include 'DB.php';

$query= $mysqli->prepare("SELECT * FROM `faculty_papers` WHERE `paper_id`=".$id);
$query->execute();
$quiz_row = $query->get_result();
$quiz_row = $quiz_row->fetch_all();
$query->close();

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
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
</head>

<body>
<header class="container-fluid header-base">
    <h2 style="text-align: center">Paper No. <?php echo $id;?></h2>
</header>

<div class="container">
    <div class="card">
        <!--Show currently active papers and a button to create one-->
        <div class="card-header">

            <div class="row">
                <div class="col">Faculty Id: <?php echo $quiz_row[0][1];?></div>
                <div class="col">Total Marks: <?php echo $quiz_row[0][4];?></div>
                <div class="col">Time: <?php echo $quiz_row[0][3];?> minutes</div>
                <div class="col">Due date <?php echo $quiz_row[0][2];?></div>
            </div>
        </div>
        <div class="card-body">
            <h1>Qn:<div id="qnno" style="display: inline"></div></h1>
            <h1 id="qnvalue"></h1>
        </div>
        <div class="card-footer">
            <button type="button" class="btn btn-primary" id="prev" onclick="showQuestion('prev')">Previous</button>
            <button type="button" class="btn btn-primary" id="next" onclick="showQuestion('next')">Next</button>
        </div>
    </div>
</div>
<script type="text/javascript">
    const xmlhttp = new XMLHttpRequest();
    let qnid=0;
    function showFirstQuestion() {
        qnid = 1;
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("qnvalue").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "quiz-content.php?id=<?php echo $id;?>&qn=1", true);
        xmlhttp.send();
        buttonChange();
    }
    function showQuestion(str){
        if(str==='prev') {
            if(qnid>1) {
                qnid--;
                console.log(qnid);
                xmlhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("qnvalue").innerHTML = this.responseText;
                    }
                };
                xmlhttp.open("GET", "quiz-content.php?id=<?php echo $id;?>&qn=" + qnid, true);
                xmlhttp.send();
            }
        }else if(str==='next') {
            if(qnid< Number(<?php echo count($questions)?>)) {
                qnid++;
                console.log(qnid);
                xmlhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("qnvalue").innerHTML = this.responseText;
                    }
                };
                xmlhttp.open("GET", "quiz-content.php?id=<?php echo $id;?>&qn=" + qnid, true);
                xmlhttp.send();
            }
        }
        buttonChange();
    }
    function buttonChange(){
        document.getElementById('qnno').innerHTML = qnid;
        if(qnid===1){
            document.getElementById('prev').className = 'btn btn-primary disabled';
            document.getElementById('next').className = 'btn btn-primary';
        }else if(qnid===Number(<?php echo count($questions)?>)){
            document.getElementById('prev').className = 'btn btn-primary ';
            document.getElementById('next').className = 'btn btn-primary disabled';
        } else {
            document.getElementById('prev').className = 'btn btn-primary ';
            document.getElementById('next').className = 'btn btn-primary';
        }
    }
    window.onload = showFirstQuestion();
</script>
</body>
</html>
