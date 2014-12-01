<?php require_once("session.php"); ?>
<?php require_once("func.php"); ?>

<?php
	$_SESSION["user_id"] = null;
	$_SESSION["user_type"] = null;
	redirect_to_page("login.php");
?>