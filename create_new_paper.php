<?php
session_start();
//login check -- needs to be reviewed by person wrinting login
if(isset($_SESSION["auth"])){
    $_SESSION["error"] = "not logged in";
    header("Location: login.php");
}
//**********!!!!!!!!!!!!!!!!! 
//person handling login needs to pass it here
$facultyID = $_SESSION["facultyID"];
setcookie("facultyID","".$facultyID);
?>
<!doctype html>
<html lang="en">
    <head>
        <title>Faculty | Create Paper</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
        <link rel="stylesheet" href="styles/faculty_home.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>
    </head>

    <body>
        <header class="container-fluid header-base row">
                <div class="col-md-6">
                    <div class="text-left">
                        <a href="faculty_home.php"><h3 class="top-title">Faculty Portal</h3></a>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="text-right">
                        <form action="faculty_home.php" method="post">
                            <input type="submit" class="btn btn-secondary top-but" value="Sign Out" name="signout">
                            <?php
                            if(isset($_POST['signout'])){
                                unset($_SESSION['user_type']);
                                header("Location: faculty_login.php");
                            }
                            ?>
                        </form>
                    </div>
                </div>
            </header>

        <div class="container">
            <form id="paper-meta" action="faculty-submit-paper.php" method="post">
                <div class="paper-params">
                    <div class="form-group">
                        <label for="duration">Paper Duration in minutes</label>
                        <input type="number" min="1" class="form-control" name="paper-duration" id="paper-duration" placeholder="Enter duration">
                        <small id="emailHelp" class="form-text text-muted">Make sure you enter this in minutes</small>
                    </div>
                    <div class="form-group">
                        <label for="marks">Total marks</label>
                        <input type="number" min="1" class="form-control" name="paper-marks" id="paper-marks" placeholder="Enter marks">
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="date">Date</label>
                        <input class="form-control" id="paper-datetime" name="paper-datetime" placeholder="MM/DD/YYY" type="datetime-local"/>
                        <small id="datetime-help" class="form-text text-muted">Choose date and time of examination</small>
                    </div>
                </div>
            </form>

            <!--question creator-->
            <div class="container creator">
                <div class="form-group aa">
                        <textarea class="form-control" name="question" id="paper-question" placeholder="Enter your question"></textarea>
                        <div class="text-left butsec">
                            <span class="add-to">Adding to </span>
                            <button type="button" id="A" class="btn btn-secondary act" onclick="section('A')">Section A</button>
                            <button type="button" id="B" class="btn btn-secondary" onclick="section('B')">Section B</button>
                            <button type="button" id="C" class="btn btn-secondary" onclick="section('C')">Section C</button>
                        </div>
                </div>

                <div class="form-group b">
                    <button type="button" class="btn btn-secondary" onclick=sub()>Submit paper</button>
                    <button type="button" class="btn btn-primary paper-add" onclick=addQ()>Add question</button>
                </div>
            </div>

            <!--created questions-->
            <div class="container text-center q-title" id="questions">
                <h3>Questions</h3>
            </div>
        </div>
        <script type="text/javascript">
            var questionsA = [];
            var questionsB = [];
            var questionsC = [];
            var questions = [questionsA,questionsB,questionsC];
            var count = 0;
            var prevText;
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

            var questionsDiv = document.getElementById("questions");
            function addQ(){
                var text = $("#paper-question").val();
                if($.trim(text) == ""){
                    alert("Question can't be empty");
                    return;
                }
                count++;
                var question = {questionNumber:count.toString(),questionText:text};
                questions[currentSection].push(question);
                prevText = text;
                console.log(JSON.stringify(questions))
                $("#paper-question").val("").focus();


                var card = '<div class="container text-left question"><p class="t"><span class="qnum">' + count + '</span>' + text + '</p></div>';
                questionsDiv.innerHTML += card;
            }

            $("#paper-meta").submit(function(event){
                sub();
                event.preventDefault();
            });

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


            function sub(){
                var questionsF = JSON.stringify(questions);
                var duration = $("#paper-duration").val();
                var total = $("#paper-marks").val();
                var datetime = $("#paper-datetime").val();

                if(questions.length <= 0){
                    alert("Please enter questions");
                    return;
                }

                if($.trim(duration) == "" || $.trim(total) == "" || $.trim(datetime) == ""){
                    alert("Please fill in all the fields");
                    return;
                } 
                

                //ajax
                $.ajax({
                    type : "POST",  //type of method
                    url  : "create-paper-api.php",
                    data : { "paper-duration" : duration, "paper-marks" : total, "paper-datetime" : datetime,"paper-questions" : questionsF, facultyID : getCookie("facultyID") },
                    success: function(res){  
                        alert("Paper created successfully!");
                        window.location.replace("faculty_home.php");
                    }
                });
                console.log(questionsF,duration,total,datetime);
            }

            
        </script>
    </body>
</html>