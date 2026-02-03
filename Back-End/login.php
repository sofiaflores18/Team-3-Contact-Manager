<?php
header("Content-Type: application/json");
require "db.php";

$action = $_POST['action'] ?? '';

switch ($action)
{
    case 'signup':
        //signup logic
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $username =  $_POST['username'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $password_user = $_POST['password'];
        $created = date('Y-m-d H:i:s');

        $conn->query("
        INSERT INTO users (firstname, lastname, username, email, phone, password_user, created)
        VALUES ('$firstname', '$lastname', '$username', '$email', '$phone', '$password_user', '$created')
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