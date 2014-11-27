<?php
  $host = 'localhost';
  $username = 'root';
  $password = '201274';
  $conn = mysql_connect($host,$username,$password);
  if (!$conn)  {
    die('Could not connect: ' . mysql_error());
  }
  $dbname = 'whatchugot';
  mysql_select_db($dbname, $conn);
?>