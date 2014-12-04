<?php require_once("session.php"); ?>
<?php
	if ($_GET["id"]){
	require("cred.php");
	require("func.php");
	$statement = $conn->prepare("DELETE from posts WHERE  postid = :id LIMIT 1");
	$statement->bindParam(":id", $_GET["id"]);
	$statement->execute();
	  $statement->setFetchMode(PDO::FETCH_ASSOC);
	  if (!$statement){
				die("Database query failed inside checkUserNameExist .");
	  }
	  else{
		  	redirect_to_page("posts.php");
	  }
	  require("closeDatabase.php");
	}
	else{
		echo "Nothing is Done";
	}
?>