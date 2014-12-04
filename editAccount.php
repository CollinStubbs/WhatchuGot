<?php require_once("session.php"); ?>
<?php require("func.php"); ?>
<?php $links=check_logged_in_admin(); ?>
<?php $account_id = $_GET["id"]; ?>

<?php
	$accounts = null;
	if ($_GET["id"]){
		$account_id = $_GET["id"];
		$accounts = getAccountByID($account_id);	
	}
	$message = "";
	$foundErrors = 0;
	// form is submitted
	if(isset($_POST['submit'])){
		$name = $account_id;
		$fName = $_POST["fName"];
		$lName = $_POST["lName"];
		$uEmail = $_POST["uEmail"];
		$accountT = $_POST["accountType"];
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
				updateUser($account_id, $fName, $lName, $uEmail, $accountT, $university);
				$message = "{$name} has been successfully updated";
				redirect_to_page("accounts.php");
		}
				require("closeDatabase.php");
	}
	else
	{
		$name  = "";
		$fName = "";
		$lName = "";
		$password = "";
		$uEmail = "";
		$message = "Fill out the information below to register with us!";
	}
?>
<!DOCTYPE html>
<html>
    
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>User Registration</title>
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
                <a class="navbar-brand page-scroll" href="index.php">Whatchu Got?</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li class="hidden">
                        <a href="#page-top"></a>
                    </li>
                    <?php echo $links ?>
                    <li>
                        <a class="page-scroll" href="logout.php">Log-out</a>
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
                <?php 
                    echo $message ;
                ?>
                </div>
               <form action="editAccount.php?id=<?php echo $accounts["username"] ?>" method="post" name="registerationFrom">
                   <label>Username<input type="text" class="form-control input-lg ContactInput" name="uName" value="<?php echo $accounts["username"]; ?>" disabled></label><br>
                   <label>First Name<input class="form-control input-lg ContactInput" type="text" name="fName" value="<?php echo $accounts["fname"]; ?>"></label><br>
                   <label>Last Name<input type="text" class="form-control input-lg ContactInput" name="lName" value="<?php echo $accounts["lname"]; ?>"></label><br>
                   <label>Email<input type="text" class="form-control input-lg ContactInput" name="uEmail" value="<?php echo $accounts["email"]; ?>" ></label><br>
                   <label>Acount Type 
                   <select name="accountType" style="color:#000;" size="1">
						<?php 
                            $confirmation = array("STUDENT", "ADMIN"); 
                            for ($i = 0; $i < 2; $i++){
                            echo "<option value=\"{$confirmation[$i]}\" ";
                            if ($accounts["accountType"] == $confirmation[$i])
                                echo "selected ";
                                echo ">{$confirmation[$i]}</option>";
                            }
     
                        ?>
 					</select><br />
                   </label><br> 
                   <label>University 
                   <select name="uUniversity" style="color:#000;" size="1">
						<?php 
                            $uni = array("", "Brock", "Centennial", "Durham College - Oshawa", "Durham College - Whitby", "McMaster", 
											"Queens", "Ryerson", "Seneca", "Trent University", "UofT - Downtown", "UofT - Scarborough" ,
											"UofT - St. George", "UOIT-Downtown", "UOIT-North", "Western University", "Western University", "York University"); 
                            for ($i = 0; $i < sizeof($uni); $i++){
                            echo "<option value=\"{$uni[$i]}\" ";
                            if ($accounts["university"] == $uni[$i])
                                echo "selected ";
                                echo ">{$uni[$i]}</option>";
                            }
     
                        ?>
 					</select><br />
                   </label><br> <br>                
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

