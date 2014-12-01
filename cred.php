<?php
  $host = 'localhost';
  $username = 'root';
  $password = '201274';
  $dbname = 'whatchugot';
  try {
	  # My SQL with PDO_MYSQL
	  $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
  } catch (PDOEXCeption $e) {
	  echo $e->getMessage();
  }
?>