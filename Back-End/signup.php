<?php
require "auxiliary.php";
require "db.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Content-Type: application/json");

//Signup function
function signup()
{
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
    "sssssss",  // all param bound as strings
    $firstname,
    $lastname,
    $username,
    $email,
    $phone,
    $password_user,
    $created
    );

    if (!$stmt->execute())
    {
        if ($stmt->errno === 1062) 
        { //1062 is the error code for duplicate entry
            echo json_encode(["status" => "Error 409 Conflict", "message" => "username already exists, error: " . $stmt->errno]);
        }

        else
        {
            echo "Error ({$stmt->errno}): " . $stmt->error;
        }
    }

    //Store the user_id from the id generated when inserting this user into mysql
    $user_id = $conn->insert_id;

    $stmt->close();

    echo json_encode(value: ["status" => "success", "message" => "Account creation successful!", "user_id" => $user_id]);
}


if ($_SERVER['REQUEST_METHOD'] !== 'POST')
{
    echo json_encode(["status"=>"error", "message"=>"Invalid HTTP request, only POST is accepted"]);
    exit;
}

$action = $info['action'] ?? '';
signup();



?>