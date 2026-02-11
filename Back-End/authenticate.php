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

        $_SESSION['user_id'] = $user_id;
        $stmt->close();

        echo json_encode(value: ["status" => "success", "message" => "Account creation successful!", "user_id" => $user_id]);
        break;
    

    case 'login':
        $username = $info['username']; // strip characters (whitespace, casing?)
        $password_user = $info['password'];
        $hashed_password = $password_user; // TODO: hash password

        $stmt = $conn->prepare("SELECT * FROM users WHERE username=? AND password_user=?"); 
        $stmt->bind_param("ss", $username, $hashed_password);
        $stmt->execute();
        $result = $stmt->get_result();
        
        // username is unique, should only ever be 1 or 0.
        $num_results = $result->num_rows;

        if($num_results == 1) 
        {
            // matching user found
            $user_id = $result->fetch_assoc()['id'];
            $_SESSION['user_id'] = $user_id;

            echo json_encode(value: ["status" => "success", "message" => "Login successful!", "user_id" => $user_id]);
        } 

        else if($num_results == 0) 
        {
            // no matching users found, login failed
            echo json_encode(["status" => "failure", "message" => "Invalid username or password."]);
        } 
        
        else 
        {
            // error, somehow more than one user match.
            echo "Login failed, multiple account matches found: " . $num_results . " results.";
        }
        
        $stmt->close();
        break;
    
    default:
        echo json_encode(["status"=>"failed", "key_error"=>"unknown action", "action" => $action]);
        break;
}

?>
