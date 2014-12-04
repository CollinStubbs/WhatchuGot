<?php require_once("session.php"); ?>

<?php
function try_logging_in($user, $pass){
	  require("cred.php");
	  $statement = $conn->prepare("SELECT username, password, accountType, university from users WHERE  username = :id");
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
				redirect_to_page("userdash.php");
			}
			else{
				$_SESSION["user_id"] = $user;
				$_SESSION["user_type"] = "STUDENT";
				$_SESSION["user_uni"] = $row['university'];
				redirect_to_page("userdash.php");
			}
		  }
		  else
		  {
			  redirect_to_page("login.php");
		  }
	  }
}
function checkUserNameExist($user){
	  $userFound = "";
	  require("cred.php");
	  $statement = $conn->prepare("SELECT username from users WHERE  username = :id");
	  $statement->bindParam(":id", $user);
	  $statement->execute();
	  $statement->setFetchMode(PDO::FETCH_ASSOC);
	  if (!$statement){
				die("Database query failed.");
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

function getUserNameByPostID($post_ID){
	$userFound = "";
	require("cred.php");
	$statement = $conn->prepare("SELECT postid, username from posts WHERE  postid = :id");
	  $statement->bindParam(":id", $post_ID);
	  $statement->execute();
	  $statement->setFetchMode(PDO::FETCH_ASSOC);
	  if (!$statement){
			die("Database query failed in get user.");
	  }
	  else{
		  $row = $statement->fetch();

		  	$userFound = $row['username'];

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
	$links = "<li><a class=\"page-scroll\" href=\"AdminMessages.php\">Admin Messages</a></li>";
	$links .= "<li><a class=\"page-scroll\" href=\"AllMessages.php\">Messages</a></li>";
	$links .= "<li><a class=\"page-scroll\" href=\"accounts.php\">Accounts</a></li>";
	$links .= "<li><a class=\"page-scroll\" href=\"posts.php\">Posts</a></li>";
	$links .= "<li><a class=\"page-scroll\" href=\"about.php\">About</a></li>";
	$links .= "<li><a class=\"page-scroll\" href=\"team.php\">Team</a></li>";
	return $links;
}
function check_logged_in_student(){
$links = "";
if (!logged_in()){
		redirect_to_page("login.php?message=\"NeedAdmin\"");
	}
else {
		if ($_SESSION['user_type'] == "ADMIN"){
			$links = "<li><a class=\"page-scroll\" href=\"AdminMessages.php\">Admin Messages</a></li>";
			$links .= "<li><a class=\"page-scroll\" href=\"AllMessages.php\">Messages</a></li>";
			$links .= "<li><a class=\"page-scroll\" href=\"accounts.php\">Accounts</a></li>";
			$links .= "<li><a class=\"page-scroll\" href=\"posts.php\">Posts</a></li>";
			$links .= "<li><a class=\"page-scroll\" href=\"about.php\">About</a></li>";
			$links .= "<li><a class=\"page-scroll\" href=\"team.php\">Team</a></li>";
		}
		else{
			$links = "<li><a class=\"page-scroll\" href=\"AllMessages.php\">Messages</a></li>";
			$links .= "<li><a class=\"page-scroll\" href=\"posts.php\">My Posts</a></li>";
			$links .= "<li><a class=\"page-scroll\" href=\"about.php\">About</a></li>";
			$links .= "<li><a class=\"page-scroll\" href=\"team.php\">Team</a></li>";
			$links .= "<li><a class=\"page-scroll\" href=\"contact.php\">Contact</a></li>";
		}
	}
	return $links;
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

function updatePost($post_id, $category, $title, $description, $postStatus, $adminStatus){
			$message = "";
			date_default_timezone_set('US/Eastern');
			$currtime = time();
			$datedb = date('Y-m-d H:i:s', $currtime);
			require("cred.php");
			$statement = null;
			if ($_SESSION["user_type"] != "ADMIN"){
				$query = "update posts SET categoryId = ?, title = ?, description = ?, status = ? WHERE postid = ?";
				$statement = $conn->prepare($query);
				$statement->execute(array($category,$title,$description, $postStatus, $post_id));
			}
			else{
				$query = "update posts SET categoryId = ?, title = ?, description = ?, status = ?, adminStatus = ? WHERE postid = ?";
				$statement = $conn->prepare($query);
				$statement->execute(array($category,$title,$description, $postStatus, $adminStatus, $post_id));
			}
    		$statement->execute();
			
			$numRowsAffected = $statement->rowCount();
			if ($numRowsAffected == 0){
				$message = "{$query} Database statment failed.";
			}
			else{
				$message = "Ad has been succesfully updated";
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
		  
		  $msgTable = "<table width=\"100%\" border=\"1\">";
			$msgTable .= "<tr><th>Date</th><th>Full Name</th><th>Email</th>";
			$msgTable .= "<th>Message</th></tr>";
			for ($i = 0; $i <$statement->rowCount(); $i++) {
				$row = $statement->fetch();
				$msgTable .= "<tr><td>" . $row["date"] ."</td>";
				$msgTable .= "<td>" . $row["fullName"] . "</td>";
				$msgTable .= "<td>" . $row["email"] . "</td>";
				$msgTable .= "<td>" . $row["message"] . "</td>";
				$msgTable .= "<td><a href=\"deleteContactMessage.php?id=" . $row["contactId"]. "\" onclick=\"return confirm('Are you sure?')\">Delete</a></td>"  ;
				$msgTable .= "</tr>";
			}
			$msgTable .= "</table>";
	  }
	  require("closeDatabase.php");
	  return $msgTable;
}

function getMessageByUserName($uname){
	require("cred.php");
	$msgTable = "";
	  $statement = $conn->prepare("SELECT * from message where recieverId = :username");
	  $statement->bindValue(":username", $uname);
	  $statement->execute();
	  $statement->setFetchMode(PDO::FETCH_ASSOC);
	  if (!$statement){
				die("Database query failed. Can't access contact message");
	  }
	  else{
		  
		  $msgTable = "<table width=\"100%\" border=\"1\">";
			$msgTable .= "<tr><th>Post ID</th><th>Date</th><th>Sender Email</th><th>Message</th><th>Action</th>";
			$msgTable .= "</tr>";
			for ($i = 0; $i <$statement->rowCount(); $i++) {
				$row = $statement->fetch();
				$msgTable .= "<tr><td>" . $row["postId"] ."</td>";
				$msgTable .= "<td>" . $row["date"] ."</td>";
				$msgTable .= "<td>" . $row["senderEmail"] . "</td>";
				$msgTable .= "<td>" . $row["message"] . "</td>";
				$msgTable .= "<td><a href=\"deleteStudentMessage.php?id=" . $row["messageId"]. "\" onclick=\"return confirm('Are you sure?')\">Delete</a></td>"  ;
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
	  $statement = $conn->prepare("SELECT * from posts where status= :status and adminStatus = :adminStatus order by date DESC");
	  $statement->bindValue(":status", "Available");
	  $statement->bindValue(":adminStatus", "Confirmed");
	  $statement->execute();
	  $statement->setFetchMode(PDO::FETCH_ASSOC);
	  if (!$statement){
				die("Database query failed. Can't access contact message");
	  }
	  else{
		  
		  $msgTable = "<table width=\"100%\" border=\"1\">";
			$msgTable .= "<tr><th>Post ID</th><th>Title</th><th>Description</th><th>University</th><th>Date</th><th>Image</th><th>Link</th>";
			for ($i = 0; $i <$statement->rowCount(); $i++) {
				$row = $statement->fetch();
				$msgTable .= "<tr><td>" . $row["postid"] ."</td>";
				$msgTable .= "<td>" . $row["title"] . "</td>";
				$msgTable .= "<td>" . $row["description"] . "</td>";
				$msgTable .= "<td>" . $row["university"] . "</td>";
				$msgTable .= "<td>" . $row["date"] . "</td>";
				$msgTable .= "<td><img src=\"showPost.php?id=" .$row["postid"] ."\"width='128' height='128' /></td>";
				$msgTable .= "<td><a href=\"message.php?id=" . $row["postid"]. "\">Send Message</a></td>";
				$msgTable .= "</tr>";
			}
			$msgTable .= "</table>";
	  }
	  require("closeDatabase.php");
	  return $msgTable;
	
}
function getPostByUserAndType($uname, $type){
	require("cred.php");
	$msgTable = "";
	if ($type == "ADMIN")
		$statement = $conn->prepare("SELECT * from posts order by date DESC");
	else
		$statement = $conn->prepare("SELECT * from posts WHERE username = :username");
	$statement->bindValue(":username", $uname);
	$statement->execute();
	$statement->setFetchMode(PDO::FETCH_ASSOC);
	  if (!$statement){
				die("Database query failed. Can't access contact message");
	  }
	  else{
		  
		  $msgTable = "<table width=\"100%\" border=\"1\">";
			$msgTable .= "<tr><th>Post ID</th><th>Title</th><th>Description</th>";
			if ($type == "ADMIN")
				$msgTable .= "<th>Admin Status</th><th>Username</th>";
			$msgTable .= "<th>University</th><th>Date</th><th>Image</th><th>Status</th><th colspan='3'>Action</th>";
			for ($i = 0; $i <$statement->rowCount(); $i++) {
				$row = $statement->fetch();
				$msgTable .= "<tr><td>" . $row["postid"] ."</td>";
				$msgTable .= "<td>" . $row["title"] . "</td>";
				$msgTable .= "<td>" . $row["description"] . "</td>";
				if ($type == "ADMIN"){
					$msgTable .= "<td>" . $row["adminStatus"] . "</td>";
					$msgTable .= "<td>" . $row["username"] . "</td>";
				}
				$msgTable .= "<td>" . $row["university"] . "</td>";
				$msgTable .= "<td>" . $row["date"] . "</td>";
				$msgTable .= "<td><img src=\"showPost.php?id=" .$row["postid"] ."\"width='128' height='128' /></td>";
				$msgTable .= "<td>" . $row["status"] . "</td>";
				$msgTable .= "<td><a href=\"editPost.php?id=" . $row["postid"]. "\">Edit</a></td>";
				$msgTable .= "<td><a href=\"deletePost.php?id=" . $row["postid"]. "\" onclick=\"return confirm('Are you sure you want to Delete the Post?')\">Delete</a></td>";
				$msgTable .= "<td><a href=\"postToTwitter.php?tweet=" . $row["title"].  " - " .$row["description"]. 
							"\" onclick=\"return confirm to twitter?\')\">Post To<br />Twitter</a></td>";
				$msgTable .= "</tr>";
			}
			$msgTable .= "</table>";
	  }
	  require("closeDatabase.php");
	  return $msgTable;
}


function getPostById($post_id){
	require("cred.php");
	$msgTable[] = null;
	$statement = $conn->prepare("SELECT * from posts WHERE postid = :postid");
	$statement->bindValue(":postid", $post_id);
	$statement->execute();
	$statement->setFetchMode(PDO::FETCH_ASSOC);
	  if (!$statement){
				die("Database query failed. Can't access contact message");
	  }
	  else{
		  $row = $statement->fetch();
		  $msgTable["postid"] = $row["postid"];
		  $msgTable["title"] = $row["title"];
		  $msgTable["description"] = $row["description"];
		  $msgTable["adminStatus"] = $row["adminStatus"];
		  $msgTable["categoryId"] = $row["categoryId"];
		  $msgTable["status"] = $row["status"];
		  $msgTable["university"] = $row["university"];
	  }
	  require("closeDatabase.php");
	  return $msgTable;
}



function getAccountByID($account_id){
	require("cred.php");
	$actTable[] = null;
	$statement = $conn->prepare("SELECT * from users WHERE username = :account_id");
	$statement->bindValue(":account_id", $account_id);
	$statement->execute();
	$statement->setFetchMode(PDO::FETCH_ASSOC);
	  if (!$statement){
				die("Database query failed. Can't access contact message");
	  }
	  else{
		  $row = $statement->fetch();
		  $actTable["username"] = $row["username"];
		  $actTable["fname"] = $row["fname"];
		  $actTable["lname"] = $row["lname"];
		  $actTable["email"] = $row["email"];
		  $actTable["accountType"] = $row["accountType"];
		  $actTable["university"] = $row["university"];
	  }
	  require("closeDatabase.php");
	  return $actTable;
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
function sendMessageToUser($name, $post_id, $email, $comment, $datedb){
	require("cred.php");
	$message = "";
	$userName = getUserNameByPostID(2);
	if ($userName != "Not Found"){
		$statement = $conn->prepare("INSERT INTO message(senderEmail, recieverId, date, message, postId) 
									values (:senderEmail, :recieverId, :date, :message, :postId)");
		$statement->bindValue(":senderEmail", $email);
		$statement->bindValue(":recieverId", $userName); 
		$statement->bindValue(":date", $datedb); 
		$statement->bindValue(":message", $comment); 
		$statement->bindValue(":postId", $post_id); 
		$statement->execute();
		$numRowsAffected = $statement->rowCount();
		if ($numRowsAffected == 0){
			$message = "Database statment failed. in dkdskdsk";
		}
		else{
			$message = "Message has been sent";
		}
		require("closeDatabase.php");
	}
	return $message;
}

function getAllAccounts(){
	require("cred.php");
	  $statement = $conn->prepare("SELECT * from users");
	  $statement->execute();
	  $statement->setFetchMode(PDO::FETCH_ASSOC);
	  if (!$statement){
				die("Database query failed. inside try_logging_in");
	  }
	  else{
		  $msgTable = "<table width=\"100%\" border=\"1\">";
			$msgTable .= "<tr><th>Username</th><th>First Name</th><th>Last Name</th><th>Email</th>";
			$msgTable .= "<th>Account Type</th><th>University</th><th colspan='2'>Action</th>";
			for ($i = 0; $i <$statement->rowCount(); $i++) {
				$row = $statement->fetch();
				$msgTable .= "<tr><td>" . $row["username"] ."</td>";
				$msgTable .= "<td>" . $row["fname"] . "</td>";
				$msgTable .= "<td>" . $row["lname"] . "</td>";
				$msgTable .= "<td>" . $row["email"] . "</td>";
				$msgTable .= "<td>" . $row["accountType"] . "</td>";
				$msgTable .= "<td>" . $row["university"] . "</td>";
				$msgTable .= "<td><a href=\"editAccount.php?id=" . $row["username"]. "\">Edit</a></td>";
				$msgTable .= "<td><a href=\"deleteAccount.php?id=" . $row["username"]. "\" onclick=\"return confirm('Are you sure you want to Delete the Account?')\">Delete</a></td>";
				$msgTable .= "</tr>";
			}
			$msgTable .= "</table>";
	  }
	  require("closeDatabase.php");
	  return $msgTable;
}

function updateUser($name, $fName, $lName, $uEmail, $accountT, $university){
			$message = "";
			require("cred.php");
			$query = "update users SET fname = ?, lname = ?, email = ?, accountType = ?, university = ? WHERE username = ?";
			$statement = $conn->prepare($query);
			$statement->execute(array($fName,$lName, $uEmail, $accountT, $university, $name));
    		$statement->execute();
			
			$numRowsAffected = $statement->rowCount();
			if ($numRowsAffected == 0){
				$message = "Database statment failed.";
			}
			else{
				$message = "Ad has been succesfully updated";
			}
			require("closeDatabase.php");
			return $message;
}

function DeletePostByUsername($uName){
	require("cred.php");
	$statement = $conn->prepare("DELETE from posts WHERE username = :username");
	$statement->bindValue(":username", $uName);
	$statement->execute();
	$statement->setFetchMode(PDO::FETCH_ASSOC);
	  if (!$statement){
				die("Database query failed. Can't access contact message");
	  }
	  else{
		  require("closeDatabase.php");
	  }
}

function navigationLinks(){
	$links =  null;
	if (!logged_in()){
		$links = "<li><a class=\"page-scroll\" href=\"login.php\">Log-in</a></li>";
		$links .= "<li><a class=\"page-scroll\" href=\"about.php\">About</a></li>";
		$links .= "<li><a class=\"page-scroll\" href=\"team.php\">Team</a></li>";
		$links .= "<li><a class=\"page-scroll\" href=\"contact.php\">Contact</a></li>";
		$links .= "<li><a class=\"page-scroll\" href=\"viewPost.php\">View Post</a></li>";
	}
	else {
		if ($_SESSION['user_type'] == "ADMIN"){
			$links = "<li><a class=\"page-scroll\" href=\"AdminMessages.php\">Admin Messages</a></li>";
			$links .= "<li><a class=\"page-scroll\" href=\"AllMessages.php\">Messages</a></li>";
			$links .= "<li><a class=\"page-scroll\" href=\"accounts.php\">Accounts</a></li>";
			$links .= "<li><a class=\"page-scroll\" href=\"posts.php\">Posts</a></li>";
			$links .= "<li><a class=\"page-scroll\" href=\"about.php\">About</a></li>";
			$links .= "<li><a class=\"page-scroll\" href=\"team.php\">Team</a></li>";
			$links .= "<li><a class=\"page-scroll\" href=\"logout.php\">logout</a></li>";
		}
		else {
			$links = "<li><a class=\"page-scroll\" href=\"AllMessages.php\">Messages</a></li>";
			$links .= "<li><a class=\"page-scroll\" href=\"posts.php\">My Posts</a></li>";
			$links .= "<li><a class=\"page-scroll\" href=\"posts.php\">Posts</a></li>";
			$links .= "<li><a class=\"page-scroll\" href=\"about.php\">About</a></li>";
			$links .= "<li><a class=\"page-scroll\" href=\"team.php\">Team</a></li>";
			$links .= "<li><a class=\"page-scroll\" href=\"contact.php\">Contact</a></li>";
		}
	}
	return $links;
}

?>

