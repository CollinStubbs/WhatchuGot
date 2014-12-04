<?php require_once("session.php"); ?>
<?php
	if ($_GET["id"]){
	require("cred.php");
	require("func.php");
	$statement = $conn->prepare("DELETE from users WHERE  username = :id LIMIT 1");
	$statement->bindParam(":id", $_GET["id"]);
	$statement->execute();
	  $statement->setFetchMode(PDO::FETCH_ASSOC);
	  if (!$statement){
				die("Database query failed inside checkUserNameExist .");
	  }
	  else{
		  	DeletePostByUsername($_GET["id"]);
		  	redirect_to_page("accounts.php");
	  }
	  require("closeDatabase.php");
	}
	else{
		echo "Nothing is Done";
	}
?>