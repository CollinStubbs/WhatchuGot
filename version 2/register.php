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
		$message = "Please Enter all the fields";
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<?php 
	echo $message ;
?>
<form action="register.php" method="post" name="registerationFrom">
Username<br />
<input name="uName" type="text" /><br />
Password<br />
<input name="uPassword" type="password" /><br />
First Name<br />
<input name="fName" type="text" /><br />
Last Name<br />
<input name="lName" type="text" /><br />
Email<br />
<input name="uEmail" type="text" /><br />
University<br />
 <select name="uUniversity" size="1">
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
 </select><br />
<button name="submit" type="submit">Submit</button>
</form>
</body>
</html>