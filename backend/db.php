<?php

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
    echo "Connection to database succeeded!\n";
}

?>