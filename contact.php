<?php
	$message = "";
	// form is submitted
	if(isset($_POST['submit'])){
		$name = $_POST["name"];
		$email = $_POST["email"];
		$comment = $_POST["comment"];
		if (!isset($name) || empty($name)){
			$message = "Please enter name <br />";
		}
		else if (!isset($email) || empty($email)){
			$message .= "Email Can not be empty<br />";
		}
		else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$message .= "Invalid email format <br />"; 
		}
		else if (!isset($comment) || empty($comment)){
			$message .= "Please enter a message <br />";
		}
		else 
		{
            require("func.php");
			date_default_timezone_set('US/Eastern');
  			$currtime = time();
  			$datedb = date('Y-m-d H:i:s', $currtime);
		    $message = sendMessageToAdmin($name, $email, $comment, $datedb);
			
		}
	}
	else
	{
		$name = "";
		$email= "";
		$comment = "";
		$message = "Please fill-in all the fields to send a message!";
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
                <a class="navbar-brand page-scroll" href="index.html">Whatchu Got?</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li class="hidden">
                        <a href="#page-top"></a>
                    </li>
                    <li>
                        <a class="page-scroll" href="login.php">Log-in</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="about.html">About</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="team.html">Team</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="contact.php">Contact</a>
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
                    ?></div>
                </div>
               <form action="contact.php" method="post">
                <label>Full Name<input class="form-control input-lg ContactInput" type="text" name="name" value="<?php echo $name; ?>" ></label><br><br>
                <label>Email<input type="text" class="form-control input-lg ContactInput" name="email" value="<?php echo $email; ?>"></label><br><br>
                Message : <textarea class="form-control" name="comment" rows="6" cols="50" value="<?php echo $comment; ?>"></textarea><br>
                <button name="submit" type="submit" class="btn btn-lg btn-success" style="background-color:#007C87">Submit</button>
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

