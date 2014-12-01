<?php 
require("cred.php");
require("func.php");
//select the image
$statement = $conn->prepare("SELECT * from posts where postid=20");
	  $statement->execute();
	  $statement->setFetchMode(PDO::FETCH_ASSOC);
	  $row = $statement->fetch();
	  if (!$statement){
				die("Database query failed. Can't access contact message");
	  }
	  else{
		$num = $statement->rowCount();
		if( $num ){
    		//if found
		$decoded_image = base64_decode($row['Image']);
		header("Content-type: image/jpeg");
		echo $decoded_image;
		exit;
		}
		else{
			echo "Not Found";
		}
	  }
?>
