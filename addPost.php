<?php
	$message = "";
	// form is submitted
	if(isset($_POST['submit'])){
		$name = "andrew";
		$category = $_POST["category"];
		$title = $_POST["title"];
		$description = $_POST["description"];
		$file = "";
		$image = "";
		$image_name="";
		if (isset($_FILES['image']['tmp_name'])) {
			$file=$_FILES['image']['tmp_name'];
			$image = addslashes(file_get_contents($_FILES['image']['tmp_name']));
 			$image_name= addslashes($_FILES['image']['name']);
		}
		if (!isset($title) || empty($title)){
			$message = "Please enter title <br />";
			
		}
		else if (!isset($description) || empty($description)){
			$message .= "Please write description<br />";
		}
		else 
		{
			date_default_timezone_set('US/Eastern');
  			$currtime = time();
  			$datedb = date('Y-m-d H:i:s', $currtime);
			require_once("cred.php");
			$query = "Insert INTO posts (postid, username, date, categoryId, title, 		description, adminStatus, status, image, imageName)
			VALUES ('','{$name}','{$datedb}', '{$category}','{$title}','{$description}', 'Pending', 'available', '{$image}','{$image_name}')";
			$result = mysql_query($query);
			if (!$result){
				die("Database query failed.");
			}
			else{
				$message = "Ad has been succesfully sent";
				// close the database connection
				mysql_close($conn);
			}
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
<form action="addPost.php" method="post" enctype="multipart/form-data" name="addroom">
 Category<br />
 <select name="category" size="1">
 	<option value="0"></option>
 	<option value="1">Textbooks</option>
    <option value="2">Media</option>
    <option value="3">Rentals</option>
    <option value="4">Events / Meetups</option>
    <option value="5">Tutoring</option>
    <option value="6">Electronics</option>
    <option value="7">Jobs</option>
    <option value="8">Furniture</option>
    <option value="9">Services</option>
    <option value="10">Other</option>
 </select><br />
 Title<br />
 <input name="title" type="text" /><br />
 Description<br />
 <textarea class="form-control" name="description" rows="6" cols="50" value=""></textarea><br>
 Select Image: <br />
 <input type="file" name="image"><br /><br />
<button name="submit" type="submit"  style="background-color:#007C87">Submit</button>
</form>
</body>
</html>