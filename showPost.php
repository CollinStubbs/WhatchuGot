<?php
	require("cred.php");
	require("closeDatabase.php");
	$conn = mysql_connect($host, $username, $password);
    mysql_select_db($dbname) or die(mysql_error());
    if(isset($_GET['id'])) {
        $sql = "SELECT imageType, imageData FROM posts WHERE postid =" . $_GET['id'];
		$result = mysql_query("$sql") or die("<b>Error:</b> Problem on Retrieving Image BLOB<br/>" . mysql_error());
		$row = mysql_fetch_array($result);
		header("Content-type: " . $row["imageType"]);
        echo $row["imageData"];
	}
	mysql_close($conn);
?>