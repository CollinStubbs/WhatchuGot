<?php require_once("session.php"); ?>
<?php require("func.php"); ?>
<!DOCTYPE html>
<html>
    
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Team</title>
        <meta name="description" content="Final Project"><meta name="viewport" content="width=device-width, initial-scale=1">
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
                   <?php 
						$links = navigationLinks(); 
						echo $links;
					?>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>

    <section id="team" class="team">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">Who Made This?</h2>
                    <h3 class="section-subheading text-muted">These Wicked Guys!</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="team-member">
                        <img src="img/collin.jpg" class="img-responsive img-circle img-centered" alt="" width="128" height="128">
                        <h4>Collin Stubbs</h4>
                        <p class="text-muted"></p>
                        <ul class="list-inline social-buttons">
                            <li><a href="https://twitter.com/collintstubbs"><i class="rotate fa fa-twitter"></i></a>
                            </li>
                            <li><a href="https://ca.linkedin.com/in/collintstubbs"><i class="rotate fa fa-linkedin"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="team-member">
                        <img src="img/andrew.jpg" class="img-responsive img-circle img-centered" alt="" width="128" height="128">
                        <h4>Andrew Gulla</h4>
                        <p class="text-muted"></p>
                        <ul class="list-inline social-buttons">
                            <li><a href="https://twitter.com/Andrew_Gulla"><i class="rotate fa fa-twitter"></i></a>
                            </li>
                            <li><a href="https://www.linkedin.com/pub/andrew-gulla/45/ab9/763"><i class="rotate fa fa-linkedin"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="team-member">
                        <img src="img/iyosias.jpg" class="img-responsive img-circle img-centered" alt="" width="128" height="128">
                        <h4>Iyosias Tessema</h4>
                        <p class="text-muted"></p>
                        <ul class="list-inline social-buttons">
                            <li><a href="http://ca.linkedin.com/pub/iyosias-tessema/51/a01/643"><i class="rotate fa fa-linkedin"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <br/><br /></div><br />
            </div>
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 text-center">
                    <p class="large text-muted">Through the help of lots of energy drinks and the fear of doing bad on this project, we managed to get it together and create this wonderful website!</p>
                </div>
            </div>
        </div>
    </section>
          
             

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
    <script src="js/classie.js"></script>
    <script src="js/cbpAnimatedHeader.js"></script>

    <!-- Contact Form JavaScript -->
    <script src="js/jqBootstrapValidation.js"></script>
  

    <!-- Custom Theme JavaScript -->
    <script src="js/agency.js"></script>
 </body>
</html>

