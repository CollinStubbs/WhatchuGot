<?php
	if ($_GET["id"]){
	require("cred.php");
	require("func.php");
	$statement = $conn->prepare("DELETE from contact WHERE  contactId = :id LIMIT 1");
	$statement->bindParam(":id", $_GET["id"]);
	$statement->execute();
	  $statement->setFetchMode(PDO::FETCH_ASSOC);
	  if (!$statement){
				die("Database query failed inside checkUserNameExist .");
	  }
	  else{
		  redirect_to_page("AdminMessages.php");
	  }
	  require("closeDatabase.php");
	}
	else{
		echo "Nothing is Done";
	}
?>