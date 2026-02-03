<?php
header("Content-Type: application/json");
require "db.php";

$action = $_POST['action'] ?? '';

switch ($action){
    case 'signup':
        //signup logic
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $username =  $_POST['username'];
        $password = $_POST['password'];

        $conn->query("
        INSERT INTO users (firstname, lastname, username, password)
        VALUES ('$firstname', '$lastname', '$username', '$password')
        ");

        echo json_encode(["status"=>"ok", "user_id" => $conn->insert_id]);
        break;
    
    case 'login':
        //login logic
        break;
    
    default:
        break;
}

?>