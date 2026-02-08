<?php
session_start(); //use this so we can access $_SESSION
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


        //Store the user_id from the id generated when inserting this user into mysql
        $user_id = $conn->insert_id;
        $_SESSION['user_id'] = $user_id;

        echo json_encode(["status" => "success", "user_id" => $user_id]);
        break;
    
    case 'login':
        $username = $_POST['username'];
        $password_user = $_POST['password']
        // hash password here
        $hashed_password = $password_user
        $conn->query("
        SELECT * FROM users WHERE username='{$username}' AND password='{$hashed_password}'
        ");
        break;
    
    default:
        echo json_encode(["status"=>"failed", "key_error"=>"unknown action"]);
        break;
}

?>