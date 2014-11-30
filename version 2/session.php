<?php
	session_start();
	function userSession(){
		if(isset($_SESSION["user_id"])){
			return htmlentities($_SESSION["user_id"]);
		}		
	}
	function typeSession(){
		return htmlentities($_SESSION["user_type"]);
	}
	function user_university(){
		if(isset($_SESSION["user_uni"])){
			return htmlentities($_SESSION["user_uni"]);
		}		
	}
?>