<?php
session_destroy();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CEG Exam Portal</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400" rel="stylesheet" /> <!-- https://fonts.google.com/ -->
    <link href="css/bootstrap.min.css" rel="stylesheet" /> <!-- https://getbootstrap.com/ -->
    <link href="fontawesome/css/all.min.css" rel="stylesheet" /> <!-- https://fontawesome.com/ -->
    <link href="css/templatemo-diagoona.css" rel="stylesheet" />

</head>

<body>
    <div class="tm-container">        
        <div>
            <div class="tm-row pt-4">
                <div class="tm-col-left">
                    <div class="tm-site-header media">
                        <i class=""></i>
                        <div class="media-body">
                            <h1 class="tm-sitename text-uppercase">Exam Portal</h1>
                        </div>        
                    </div>
                </div>
                <div class="tm-col-right">
                </div>
            </div>
            
            <div class="tm-row">
                <div class="tm-col-left"></div>
                <main class="tm-col-right">
                    <section class="tm-content">
                        <h2 class="mb-2 tm-content-title">Student Login</h2>
                        <p class="mb-2">Blah bla blah isntructions</p>
                        <hr class="mb-2">
                        <p class="mb-3"></p>                        
                        <a href="student_login.php" class="btn btn-primary">Student Login</a>
                        <p class="mb-5"></p>
                    </section>
                    <section class="tm-content">
                        <h2 class="mb-2 tm-content-title">Faculty Login</h2>
                        <p class="mb-2">Blah bla blah isntructions again</p>
                        <hr class="mb-2">
                        <p class="mb-2"></p>                        
                        <a href="faculty_login.php" class="btn btn-primary">Faculty Login</a>
                    </section>
                </main>
            </div>
        </div>        


        <!-- Diagonal background design -->
        <div class="tm-bg">
            <div class="tm-bg-left"></div>
            <div class="tm-bg-right"></div>
        </div>
    </div>

    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.backstretch.min.js"></script>
</body>
</html>