<?php require_once("session.php"); ?>

<?php
function try_logging_in($user, $pass){
	  require("cred.php");
	  $statement = $conn->prepare("SELECT username, password, accountType, university from users 	  WHERE  username = :id");
	  $statement->bindParam(":id", $user);
	  $statement->execute();
	  $statement->setFetchMode(PDO::FETCH_ASSOC);
	  if (!$statement){
				die("Database query failed. inside try_logging_in");
	  }
	  else{
		  $row = $statement->fetch();
		  //$row = mysql_fetch_assoc($result);
		  $password = $row['password'];
		  // Password_verify() is found in the php library to check
		  // if a password is the same as the hashed version
		  $matchFound = password_verify($pass, $password);
		  
		  if ($user == $row['username'] && $matchFound){
		  	if ($row['accountType'] == 'ADMIN'){
				$_SESSION["user_id"] = $user;
				$_SESSION["user_type"] = "ADMIN";
				$_SESSION["user_uni"] = "Any";
				redirect_to_page("AdminMessages.php");
			}
			else{
				$_SESSION["user_id"] = $user;
				$_SESSION["user_type"] = "STUDENT";
				$_SESSION["user_uni"] = $row['university'];
				redirect_to_page("userdash.html");
			}
		  }
		  else
		  {
			  redirect_to_page("login.php");
		  }
		  //mysql_free_result($result);
		  // close the database connection
	  }
}
function checkUserNameExist($user){
	  $userFound = "";
	  //$query = "select username from users where username = '{$user}'";
	  //$result = mysql_query($query);
	  require("cred.php");
	  $statement = $conn->prepare("SELECT username from users WHERE  username = :id");
	  $statement->bindParam(":id", $user);
	  $statement->execute();
	  $statement->setFetchMode(PDO::FETCH_ASSOC);
	  if (!$statement){
				die("Database query failed inside checkUserNameExist .");
	  }
	  else{
		  $row = $statement->fetch();
		  if ($user == $row['username']){
		  	$userFound = "true";
		  }
		  else
		  {
			  $userFound = "false";
		  }
	  }
	  require("closeDatabase.php");
	  return $userFound;
}

function redirect_to_page($page){
	header("Location: " . $page);
	exit;
}


function encrptPassword($password){
	// Encrypt the password using blowfish cost 10 from the php library
	$hash = password_hash($password, PASSWORD_BCRYPT);
	return $hash;
}

function registerUser($name, $password, $fName, $lName, $uEmail, $university){
	$hashed_password = encrptPassword($password);
	require("cred.php");
	$statement = $conn->prepare("INSERT INTO users(username, fname, lname, email, password, accountType, university) values (:name, :fname, :lname, :email, :password, :type, :university)");
	$statement->bindValue(":name", $name);
	$statement->bindValue(":fname", $fName); 
	$statement->bindValue(":lname", $lName); 
	$statement->bindValue(":email", $uEmail); 
	$statement->bindValue(":password", $hashed_password); 
	$statement->bindValue(":type", "STUDENT"); 
	$statement->bindValue(":university", $university); 
    $statement->execute();
	$numRowsAffected = $statement->rowCount();
	if ($numRowsAffected == 0){
		die("Database statment failed. inside registerUser");
	}
	require("closeDatabase.php");
}

function logged_in(){
	return isset($_SESSION['user_id']);
}

function check_logged_in_admin(){
	if (!logged_in() || $_SESSION['user_type'] != "ADMIN"){
		redirect_to_page("login.php");
	}
}
function check_logged_in_student(){
if (!logged_in()){
		redirect_to_page("login.php");
	}
}
function addPost($name, $category, $title, $description, $imageProperties, $imageData){
			$message = "";
			date_default_timezone_set('US/Eastern');
			$currtime = time();
			$datedb = date('Y-m-d H:i:s', $currtime);
			require_once("cred.php");
			if ($imageData)
			$statement = $conn->prepare("INSERT INTO posts(username, date, categoryId, title, description, adminStatus, status, university, imageType, imageData) values (:name, :date, :category, :title, :description, :adminStatus, :status, :university, '{$imageProperties['mime']}', '{$imageData}')");
			else
			$statement = $conn->prepare("INSERT INTO posts(username, date, categoryId, title, description, adminStatus, status, university) values (:name, :date, :category, :title, :description, :adminStatus, :status, :university)");
			$statement->bindValue(":name", $name);
			$statement->bindValue(":date", $datedb);
			$statement->bindValue(":category", $category); 
			$statement->bindValue(":title", $title);
			$statement->bindValue(":description", $description);
			$statement->bindValue(":adminStatus", "Pending"); 
			$statement->bindValue(":status", "Available");
			$statement->bindValue(":university", $_SESSION["user_uni"]);
    		$statement->execute();
			$numRowsAffected = $statement->rowCount();
			if ($numRowsAffected == 0){
				$message = "Database statment failed.";
			}
			else{
				$message = "Ad has been succesfully sent";
			}
			require("closeDatabase.php");
			return $message;
}

function getContactMessage(){
	require("cred.php");
	$msgTable = "";
	  $statement = $conn->prepare("SELECT * from contact");
	  $statement->execute();
	  $statement->setFetchMode(PDO::FETCH_ASSOC);
	  if (!$statement){
				die("Database query failed. Can't access contact message");
	  }
	  else{
		  
		  $msgTable = "<table width=\"80%\" border=\"1\">";
			$msgTable .= "<tr><th>Date</th><th>Full Name</th><th>Email</th>";
			$msgTable .= "<th>Message</th></tr>";
			for ($i = 0; $i <$statement->rowCount(); $i++) {
				$row = $statement->fetch();
				$msgTable .= "<tr><td>" . $row["date"] ."</td>";
				$msgTable .= "<td>" . $row["fullName"] . "</td>";
				$msgTable .= "<td>" . $row["email"] . "</td>";
				$msgTable .= "<td>" . $row["message"] . "</td>";
				$msgTable .= "<td><a href=\"deleteMessage.php?id=" . $row["contactId"]. "\" onclick=\"return confirm('Are you sure?')\">Delete</a></td>"  ;
				$msgTable .= "</tr>";
			}
			$msgTable .= "</table>";
	  }
	  require("closeDatabase.php");
	  return $msgTable;
}
function getAllPost(){
	require("cred.php");
	$msgTable = "";
	  $statement = $conn->prepare("SELECT * from posts order by date");
	  $statement->execute();
	  $statement->setFetchMode(PDO::FETCH_ASSOC);
	  if (!$statement){
				die("Database query failed. Can't access contact message");
	  }
	  else{
		  
		  $msgTable = "<table width=\"80%\" border=\"1\">";
			$msgTable .= "<tr><th>Post ID</th><th>Title</th><th>Description</th><th>University</th><th>Date</th><th>Image</th>";
			for ($i = 0; $i <$statement->rowCount(); $i++) {
				$row = $statement->fetch();
				$msgTable .= "<tr><td>" . $row["postid"] ."</td>";
				$msgTable .= "<td>" . $row["title"] . "</td>";
				$msgTable .= "<td>" . $row["description"] . "</td>";
				$msgTable .= "<td>" . $row["university"] . "</td>";
				$msgTable .= "<td>" . $row["date"] . "</td>";
				$msgTable .= "<td><img src=\"showPost.php?id=" .$row["postid"] ."\"width='128' height='128' /></td>";
				$msgTable .= "</tr>";
			}
			$msgTable .= "</table>";
	  }
	  require("closeDatabase.php");
	  return $msgTable;
	
}
function getImageByIDNumber(){
	require("cred.php");
	$imageData = "";
	if (isset($_GET['id'])){
		$statement = $conn->prepare("SELECT * from posts order by date WHERE postid=".$id);
	  	$statement->execute();
	  	$statement->setFetchMode(PDO::FETCH_ASSOC);
		if (!$statement){
				die("Database query failed. Can't access contact message");
	  	}
		$row = $statement->fetch();
		$imageData = $row["image"];
		header("content-type: image/jpeg");
		$message = "<img src=\"showPost.php?id=".$id ."\"/>";
		echo $message;
	}
	else {
		echo "Error";
	}
	require("closeDatabase.php");
	
} 

function sendMessageToAdmin($name, $email, $comment, $datedb){
	require("cred.php");
	$statement = $conn->prepare("INSERT INTO contact(fullname, email, message, date) values (:name, :email, :message, :date)");
	$statement->bindValue(":name", $name);
	$statement->bindValue(":email", $email); 
	$statement->bindValue(":message", $comment); 
	$statement->bindValue(":date", $datedb); 
	$statement->execute();
	$numRowsAffected = $statement->rowCount();
	if ($numRowsAffected == 0){
		$message = "Database statment failed.";
	}
	else{
		$message = "Message has been sent";
	}
	require("closeDatabase.php");
	return $message;
	
}

?>

