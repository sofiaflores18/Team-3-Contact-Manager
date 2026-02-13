<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$host = "localhost";
$user = "root";
$password = "";
$db = "contactManager";

$conn = new mysqli($host, $user, $password, $db);

if ($conn->connect_error)
{
    die("Connection Error: ". $conn->connect_error);
}

else
{
  // echo "Connection to database succeeded!\n";
}
?>
