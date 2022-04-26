<?php
/** database connection **/
$mysqli = new mysqli("localhost","root","","demo");

// Check connection
if ($mysqli->connect_errno) 
{
  echo "Failed to connect to MySQL: " . $mysqli->connect_error;
  exit();
}
?>