<?php

//Imports
require "../default_endpoint.php";


//Signup function
function signup($info, $conn)
{
    //signup logic
    $firstname = $info['firstname'] ?? null;
    $lastname = $info['lastname'] ?? null;
    $username =  $info['username'] ?? null;
    $email = $info['email'] ?? null;
    $phone = $info['phone'] ?? null;
    $password_user = password_hash($info['password'], PASSWORD_DEFAULT);

    //DEBUG
    error_log("HASHED: " . $password_user);
    error_log("INPUT: " . $info['password']);
    
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
            http_response_code(409);
            echo json_encode([
                "status" => "error",
                "message" => "Username or email already exists"
            ]);
            }

        else
        {
            echo "Error ({$stmt->errno}): " . $stmt->error;
        }
    }

    //Store the user_id from the id generated when inserting this user into mysql
    $user_id = $conn->insert_id;

    $stmt->close();

    echo json_encode([
        "status" => "success", 
        "message" => "Account creation successful!", 
        "user_id" => $user_id
    ]);
}


//Main Function Logic
    //If the request method used to this endpoint was not POST, then return error
if ($_SERVER['REQUEST_METHOD'] !== 'POST')
{
    echo json_encode(["status"=>"error", "message"=>"Invalid HTTP request, only POST is accepted"]);
    exit;
}

    //Otherwise, call the signup function

$info = getRequestInfo();
signup($info, $conn);
?>