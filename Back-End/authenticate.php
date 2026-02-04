<?php
header("Content-Type: application/json");
require "db.php";
session_start(); //use this so we can access $_SESSION

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


        //Store the user_id from the id generated when inserting this user into mysql
        $user_id = $conn->insert_id;
        $_SESSION['user_id'] = $user_id;

        echo json_encode(["status" => "success", "user_id" => $user_id]);
        break;
    
    case 'login':
        //login logic
        break;
    
    default:
        echo json_encode(["status"=>"failed", "key_error"=>"unknown action"]);
        break;
}

?>