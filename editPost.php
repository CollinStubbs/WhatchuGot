<?php require_once("session.php"); ?>
<?php require("func.php"); ?>
<?php $links=check_logged_in_student(); ?>
<?php $post_id = $_GET["id"]; ?>
<?php
	$posts = null;
	if ($_GET["id"] && $_GET["id"]!= 0){
		$post_id = $_GET["id"];
		$posts = getPostById($post_id);	
	}
    $message = "";
    // form is submitted
    if(isset($_POST['submit'])){
		$post_id = $_GET["id"];
        $category = $_POST["category"];
        $title = $_POST["title"];
		$postStatus = $_POST["post_status"];
        $description = $_POST["description"];
		if ($_SESSION["user_type"] == "ADMIN"){
			$adminStatus = $_POST["confirmation"];
		}
        $image = "";
        $imageProperties="";
        if (isset($_FILES['image']['tmp_name'])) {
            $file=$_FILES['image']['tmp_name'];
            if(!empty($_FILES['image']['tmp_name'])){
                $image = addslashes(file_get_contents($_FILES['image']['tmp_name']));
                $imageProperties = getimageSize($_FILES['image']['tmp_name']);
            }
        }
        if (!isset($title) || empty($title)){
            $message = "Please enter title <br />";
            
        }
        else if (!isset($description) || empty($description)){
            $message .= "Please write description<br />";
        }
        else 
        {
            	$message = updatePost($post_id, $category, $title, $description, $postStatus, $adminStatus);
				redirect_to_page("posts.php");
             
        }
    }
    else
    {
        $message = "Please fill-in all the fields.";
    }
?>
<!DOCTYPE html>
<html>
    
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Edit Post</title>
        <meta name="description" content="Final Project">
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
            <div class="about-text">
                <div class="body-lead-in"><?php 
    echo $message ;
?></div>
</div>
<form action="editPost.php?id=<?php echo $posts["postid"] ?>" method="post" enctype="multipart/form-data" name="addroom">
 Category<br />
 <select name="category" style="color:#000;" size="1">
 <?php
 	$categ = array("Textbooks", "Media", "Rentals", "Events / Meetups", "Tutoring", "Electronics", "Jobs", "Furniture", "Services", "Other"); 
	for ($i = 1; $i <= 10; $i++){
		echo "<option value=\"{$i}\" ";
		if ($posts["categoryId"] == $i)
			echo "selected ";
		echo ">{$categ[$i-1]}</option>";
	}
 
 ?>
 </select><br />
 Title<br />
 <input name="title" type="text" value="<?php echo $posts["title"] ?>" style="color:#000;"/><br />
 Description<br />
 <textarea class="form-control" name="description" rows="6" cols="50"><?php echo $posts["description"] ?></textarea><br>
<?php 
	if ($_SESSION["user_type"] == "ADMIN"){
		$widget1 = "Admin Confirmation<select name=\"confirmation\" style=\"color:#000;\" size=\"1\">";
        $confirmation = array("Pending", "Confirmed"); 
        for ($i = 0; $i < 2; $i++){
        	$widget1 .= "<option value=\"{$confirmation[$i]}\" ";
            if ($posts["adminStatus"] == $confirmation[$i])
            	$widget1 .= "selected ";
            $widget1 .= ">{$confirmation[$i]}</option>";
        }
		$widget1 .= "</select><br /><br />";
		echo $widget1;
	}
	$widget2 = "Status <select name=\"post_status\" style=\"color:#000;\" size=\"1\">";
    $status = array("Available", "Sold"); 
    for ($i = 0; $i < 2; $i++){
        $widget2 .= "<option value=\"{$status[$i]}\" ";
        if ($posts["status"] == $status[$i])
            $widget2 .= "selected ";
            $widget2 .= ">{$status[$i]}</option>";
        }
	$widget2 .= "</select><br />";
	echo $widget2;
?>
<br /> <br /><button name="submit" type="submit"  style="background-color:#007C87">Update</button>
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

