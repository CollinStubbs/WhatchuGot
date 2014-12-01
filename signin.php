<?php
	$loginName = $_POST["loginName"];
	$pass = $_POST["pass"];
	if(isset($_POST['submit'])){
		require_once("cred.php");
		if (isset($loginName) || !empty($loginName)){
			require_once("cred.php");
			include("func.php");
			try_logging_in($loginName, $pass);
			require("closeDatabase.php");
		}
	}
?>