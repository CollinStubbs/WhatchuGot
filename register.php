<?php
	$message = "";
	$foundErrors = 0;
	// form is submitted
	if(isset($_POST['submit'])){
		$name = $_POST["uName"];
		$uPassword = $_POST["uPassword"];
		$fName = $_POST["fName"];
		$lName = $_POST["lName"];
		$uEmail = $_POST["uEmail"];
		$university = $_POST["uUniversity"];
		if (!isset($name) || empty($name)){
			$message = "Please enter userName <br />";
			$foundErrors = 1;
		}
		if (!isset($fName) || empty($fName)){
			$message .= "Please enter first name <br />";
			$foundErrors = 1;
		}
		if (!isset($lName) || empty($lName)){
			$message .= "Please enter last name <br />";
			$foundErrors = 1;
		}
		if (!isset($uEmail) || empty($uEmail)){
			$message .= "Email Can not be empty<br />";
			$foundErrors = 1;
		}
		else if (!filter_var($uEmail, FILTER_VALIDATE_EMAIL)) {
			$message .= "Invalid email format <br />";
			$foundErrors = 1; 
		}
		if (!isset($university) || empty($university)){
			$message .= "Please select university <br />";
			$foundErrors = 1;
		}
		if ($foundErrors == 0){
				require_once("cred.php");
				include("func.php");
				$userFound = checkUserNameExist($name);
				if ($userFound == "true"){
					$message = "Please enter another userName {$fName} is taken <br />";
				}
				else{
					registerUser($name, $uPassword, $fName, $lName, $uEmail, $university);
					$message = "{$name} has been successfully registered";
				}
				require("closeDatabase.php");
		}
	}
	else
	{
		$message = "Fill out the information below to register with us!";
	}
?>
<!DOCTYPE html>
<html>
    
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Final Proj.</title>
        <meta name="description" content="Final Project">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css.css">
        
        <!-- Bootstrap Core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="css/agency.css" rel="stylesheet">

        <!-- Custom Fonts -->
        <link href="font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="http://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
        <link href='http://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700' rel='stylesheet' type='text/css'>
    </head>
        <body>
            <!-- Navigation -->
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand page-scroll" href="login.html">Whatchu Got?</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li class="hidden">
                        <a href="#page-top"></a>
                    </li>
                    <li>
                        <a class="page-scroll" href="register.html">Log-in</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="about.html">About</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="team.html">Team</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="contact.html">Contact</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>
<!-- Header -->
    <header class="aboutpage">
        <div class="container">
            <div class="contact-text">
                <div class="body-lead-in">
                <?php 
                    echo $message ;
                ?>
                </div>
                </div>
               <form action="register.php" method="post" name="registerationFrom">
                   <label><input type="text" class="form-control input-lg ContactInput" name="uName" placeholder="Username"></label><br><br>
                   <label><input class="form-control input-lg ContactInput" type="text" name="fName" placeholder="First Name"></label><br><br>
                   <label><input type="text" class="form-control input-lg ContactInput" name="lName" placeholder="Last Name"></label><br><br>
                   
                   <label><input type="text" class="form-control input-lg ContactInput" name="uEmail" placeholder="Email Address"></label><br><br>
                   <label><input type="text" class="form-control input-lg ContactInput" name="uPassword" placeholder="Password"></label><br><br>                   
                   
                   
                    <select name="uUniversity" style="color: #000;" size="1">
                        <option value="0"></option>
                        <option value="Brock">Brock</option>
                        <option value="Centennial">Centennial</option>
                        <option value="Durham College - Oshawa">Durham College - Oshawa</option>
                        <option value="Durham College - Whitby">Durham College - Whitby</option>
                        <option value="George Brown">George Brown</option>
                        <option value="McMaster">McMaster</option>
                        <option value="Queens">Queens</option>  
                        <option value="Ryerson">Ryerson</option>
                        <option value="Seneca">Seneca</option>
                        <option value="Trent University">Trent University</option>
                        <option value="UofT - Downtown">UofT - Downtown</option>
                        <option value="UofT - Scarborough">UofT - Scarborough</option>
                        <option value="UofT - St. George">UofT - St. George</option>
                        <option value="UOIT-Downtown">UOIT-Downtown</option>
                        <option value="UOIT-North">UOIT-North</option>
                        <option value="Western University">Western University</option>
                        <option value="York University">York University</option>
                     </select><br /><br />
                   
                   <button type="submit" class="btn btn-lg btn-success" name="submit" style="background-color:#007C87">Submit</button>
                </form>            
        </div>
    </header>
               

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
    <script src="js/classie.js"></script>
    <script src="js/cbpAnimatedHeader.js"></script>

    <!-- Contact Form JavaScript -->
    <script src="js/jqBootstrapValidation.js"></script>
    <script src="js/contact_me.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="js/agency.js"></script>
 </body>
</html>

