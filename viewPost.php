<?php require("func.php"); ?>
<?php

?>
<!DOCTYPE html>
<html>
    
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>View Posts</title>
        <meta name="description" content="Final Project">
        <link rel="stylesheet" href="css.css">
        
        <!-- Bootstrap Core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="css/agency.css" rel="stylesheet">
        <link href="css/whatchugot.css" rel="stylesheet">

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
                    <li>
                        <a class="page-scroll" href="login.php">Log-in</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="about.php">About</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="team.php">Team</a>
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
    <header class="adminpage">
        <div class="container" style="height:80%;">
            <div class="viewtext">
            <div id="actionHeader">
            <select name="univeristy" id="univeristy" onChange="filterUniversity()">
            	<option value="0">All University</option>
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
            </select>
        </div>
        	<br /><br />
            <?php 
                $posts = getAllPost();
                echo $posts;
            ?>
            </div>
        </div>
    </header>
    <div>
    	
    </div>
               
	
    <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
    <script src="what.js" type="text/javascript"></script>
 </body>
</html>
