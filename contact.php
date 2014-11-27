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
			date_default_timezone_set('US/Eastern');
  			$currtime = time();
  			$datedb = date('Y-m-d H:i:s', $currtime);
			require_once("cred.php");
			$query = "Insert INTO contact (fullName, email, message, date)
			VALUES ('{$name}','{$email}','{$comment}', '{$datedb}')";
			$result = mysql_query($query);
			if (!$result){
				die("Database query failed.");
			}
			else{
				$message = "The message has been sent to Admin";
				// close the database connection
				mysql_close($conn);
				$name = "";
				$email = "";
				$comment = "";
			}
		}
	}
	else
	{
		$name = "";
		$email= "";
		$comment = "";
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
<form action="contact.php" method="post">
<label>Full Name<input class="form-control input-lg ContactInput" type="text" name="name" value="<?php echo $name; ?>" ></label><br><br>
<label>Email<input type="text" class="form-control input-lg ContactInput" name="email" value="<?php echo $email; ?>"></label><br><br>
Message : <textarea class="form-control" name="comment" rows="6" cols="50" value="<?php echo $comment; ?>"></textarea><br>
<button name="submit" type="submit"  style="background-color:#007C87">Submit</button>
</form>
</body>
</html>