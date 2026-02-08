<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start(); //use this so we can access $_SESSION
header("Content-Type: application/json");

//Imports
require "db.php";
require "auxiliary.php";

$info = getRequestInfo();

$action = $info['action'] ?? '';

switch ($action)
{
    case 'signup':
        //signup logic
        $firstname = $info['firstname'];
        $lastname = $info['lastname'];
        $username =  $info['username'];
        $email = $info['email'];
        $phone = $info['phone'];
        $password_user = $info['password'];
        $created = date('Y-m-d H:i:s');

        $stmt = $conn->prepare(
        "INSERT INTO users 
        (firstname, lastname, username, email, phone, password_user, created)
        VALUES (?, ?, ?, ?, ?, ?, ?)"
        );

        $stmt->bind_param(
        "sssssss",
        $firstname,
        $lastname,
        $username,
        $email,
        $phone,
        $password_user,
        $created
        );

        $stmt->execute();

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
