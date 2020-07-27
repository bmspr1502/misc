<?php
//paper ID
$id = $_GET['id'];
//echo "id = " . $id . '<br>';

session_start();
//login check
if(!(isset($_SESSION["auth"]) && isset($_SESSION["user_type"]) && isset($_SESSION["user_ID"]) && ($_SESSION["auth"]==session_id()))){
    //not logged in
    session_destroy();
    header("Location: student_login.php");
    die();
} 

setcookie("auth",$_SESSION["auth"]);
setcookie("user_type",$_SESSION["user_type"]);
setcookie("user_ID",$_SESSION["user_ID"]);
setcookie("paper_ID",$id);

include 'DB.php';


$query= $mysqli->prepare("SELECT * FROM `faculty_papers` WHERE `paper_id`=".$id);
$query->execute();
$quiz_row = $query->get_result();
$quiz_row = $quiz_row->fetch_all();
$query->close();


$questions = $quiz_row[0][5];
$questions = json_decode(stripslashes($questions));


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

        <div class="container questions-container text-center" id="questionsA">
            <h2 class="tit">Section A</h2>
            <?php
                $questionsA = $questions[0];
                shuffle($questionsA);
                foreach($questionsA as $questionObj){
                    if($questionObj->image){
                       $image = '<div><img class="qcard-img" width="400" src='.$questionObj->image.'></div>'; 
                    } else {
                        $image = "";
                    }
                    echo '
                        <div class="container text-left student_question_card">
                            <p class="t"><span class="qnum">'.$questionObj->questionNumber.'</span>'.$questionObj->questionText.'</p>
                            '.$image.'
                        </div>
                    ';
                }
            ?>
        </div>

        <div class="container questions-container text-center" id="questionsB">
            <h2 class="tit">Section B</h2>
            <?php
                $questionsB = $questions[1];
                shuffle($questionsB);
                foreach($questionsB as $questionObj){
                    if($questionObj->image){
                        $image = '<div><img class="qcard-img" width="400" src='.$questionObj->image.'></div>'; 
                    } else {
                        $image = "";
                    }
                    echo '
                        <div class="container text-left student_question_card">
                            <p class="t"><span class="qnum">'.$questionObj->questionNumber.'</span>'.$questionObj->questionText.'</p>
                            '.$image.'
                        </div>
                    ';
                }
            ?>
        </div>

        <div class="container questions-container text-center" id="questionsC">
            <h2 class="tit">Section C</h2>
            <?php
                $questionsC = $questions[2];
                shuffle($questionsC);
                foreach($questionsC as $questionObj){
                    if($questionObj->image){
                        $image = '<div><img class="qcard-img" width="400" src='.$questionObj->image.'></div>'; 
                    } else {
                        $image = "";
                    }
                    echo '
                        <div class="container text-left student_question_card">
                            <p class="t"><span class="qnum">'.$questionObj->questionNumber.'</span>'.$questionObj->questionText.'</p>
                            '.$image.'
                        </div>
                    ';
                }
            ?>
        </div>
            
        <p>
            <form action="submit_answer.php" method="post" id="answer_form">
                <input type="file"  accept=".pdf" name="answer" id="file" onchange="loadFile(event)" style="display: none;">
            </form>
        </p>
        <div class="text-center upload-btn">
            <div id="uploaded-file"></div>
            <button class="btn btn-primary btn-lg" type="button" id="the_button" onclick="answer_button()">
                Upload Answer
            </button>
        </div>

        <script type="text/javascript">

            var isStart = false;
            var unique_submission_ID;
            var unique_submission_URL;

            var isValidFileUploaded = false;

            function make_final_submission(){
                console.log(isStart,minutes,unique_submission_ID,unique_submission_URL);
                if(isStart && minutes >= 0 && unique_submission_ID && unique_submission_URL){
                    if(minutes==0 && seconds <= 0){
                        window.location.replace("user_time_up.php");
                        return;
                    }
                    var flag = true;

                    $.ajaxSetup({async: false});
                    $.ajax({
                        url: "finish_test.php",
                        type: "POST",
                        data: {"submission_ID":unique_submission_ID,"paper_URL":unique_submission_URL},
                        success: function(response) {
                            if(response === "error"){
                                alert("Error starting exam");
                                flag = false;
                                return;
                            } else {
                                if(response === "success"){
                                    alert("submission successfull");
                                }
                            }
                        },
                        error: function(jqXHR, textStatus, errorMessage) {
                            alert("Error starting exam.");
                            flag = false;
                            return; 
                        }
                    });

                    if(!flag){
                        alert("Error making submission");
                    }
                    
                } else {
                    console.log("making final sub failed");
                }
            }

            function loadFile(event){
                var sub_button = $("#the_button");
                if(event.target.files[0].type != "application/pdf"){
                    $("#file").val("");
                    sub_button.html("Upload Answer");
                    sub_button.removeClass("submit-button");
                    alert("Please upload a pdf file");
                } else {
                    console.log("success");
                    sub_button.html("Submit Answer");
                    sub_button.addClass("submit-button");
                    $("#uploaded-file").html(event.target.files[0].name);
                    $("#uploaded-file").addClass("file-text-end");
                    isValidFileUploaded = true;
                } 
            }

            function answer_button(){
                if(!isStart){
                    alert("You haven't started the test");
                    return;
                }
                if(!isValidFileUploaded){
                    $("#file").click();
                } else {
                    if(minutes >= 0){
                        if(minutes==0 && seconds <= 0){
                            window.location.replace("user_time_up.php");
                            return;
                        }
                        var blobFile = $('#file')[0].files[0];
                        var formData = new FormData();
                        formData.append("file", blobFile);


                        $.ajaxSetup({async: false});
                        $.ajax({
                            url: "submit_answer.php",
                            type: "POST",
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(response) {
                                if(response === "typeerror"){
                                    alert("Please upload a PDF only.")
                                } else if(response === "uploaderror"){
                                    alert("There was an error uploading your file. Please try later");
                                } else {
                                    unique_submission_URL = response;
                                    console.log("saved pdf to server");
                                    make_final_submission();
                                }
                            },
                            error: function(jqXHR, textStatus, errorMessage) {
                                alert("Error uploading file. Please try later"); 
                            }
                        });

                    } else {
                        window.location.replace("user_time_up.php");
                    }
                }
            }

            var sections = ["A","B","C"];
            var currentSection = 0;
            function section(val){
                if(val === 'A'){
                    currentSection = 0;
                    //handle the buttons
                    $("#A").addClass("act");
                    $("#B").removeClass("act");
                    $("#C").removeClass("act");
                    
                    //handle content
                    if(isStart){
                        $("#questionsA").addClass("current-q");
                        $("#questionsB").removeClass("current-q");
                        $("#questionsC").removeClass("current-q");
                    }

                } else if(val === 'B'){
                    currentSection = 1;
                    //handle buttons
                    $("#B").addClass("act");
                    $("#A").removeClass("act");
                    $("#C").removeClass("act");

                    //handle content
                    if(isStart){
                        $("#questionsB").addClass("current-q");
                        $("#questionsA").removeClass("current-q");
                        $("#questionsC").removeClass("current-q");
                    }

                } else if(val === 'C'){
                    currentSection = 2;
                    //handle buttons
                    $("#C").addClass("act");
                    $("#A").removeClass("act");
                    $("#B").removeClass("act");

                    //handle content
                    if(isStart){
                        $("#questionsC").addClass("current-q");
                        $("#questionsA").removeClass("current-q");
                        $("#questionsB").removeClass("current-q");
                    }

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

                isStart = true;

                if(minutes <= 0){
                    clearInterval(t);
                    timeUp = true;
                    alert("Time Up");
                    window.location.replace("user_time_up.php");
                }
            }

            function timer() {
                if(isStart){
                    alert("The exam has already been started");
                    return; 
                }
                var flag = true;

                $.ajaxSetup({async: false});
                $.ajax({
                    url: "start_test.php",
                    type: "POST",
                    data: {"user_ID":getCookie("user_ID"),"paper_ID":getCookie("paper_ID")},
                    success: function(response) {
                        if(response === "error"){
                            alert("Error starting exam");
                            flag = false;
                            return;
                        } else if(response === "alreadyexists" && isStart){
                            alert("Exam has already begun");
                            flag = false;
                            return;
                        } else {
                            unique_submission_ID = parseInt(response);
                            if(!unique_submission_ID){
                                alert("Sorry, you have already made a submission");
                                flag = false;
                                return;
                            }
                            console.log(unique_submission_ID);
                        }
                    },
                    error: function(jqXHR, textStatus, errorMessage) {
                        alert("Error starting exam.");
                        flag = false;
                        return; 
                    }
                });

                //at this point we have a unique ID that indetifies this submission,
                // use this id when entering the URL in the database
                // URL is obatined from the answer_button function

                if(!flag){
                    return
                }

                add();
                if(isStart){
                    section(sections[currentSection]);
                }
                t = setInterval(add, 1000);
            } 

            function getCookie(name) {
                // Split cookie string and get all individual name=value pairs in an array
                var cookieArr = document.cookie.split(";");
                
                // Loop through the array elements
                for(var i = 0; i < cookieArr.length; i++) {
                    var cookiePair = cookieArr[i].split("=");
                    
                    /* Removing whitespace at the beginning of the cookie name
                    and compare it with the given string */
                    if(name == cookiePair[0].trim()) {
                        // Decode the cookie value and return
                        return decodeURIComponent(cookiePair[1]);
                    }
                }
                
                // Return null if not found
                return null;
            }
        </script>

    </body>
</html>