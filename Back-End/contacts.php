<?php
session_start(); //use this so we can access $_SESSION
header("Content-Type: application/json");
require "db.php";
require "auxiliary.php";


//Get information from the POST request
$info = getRequestInfo();
$action = $info['action'] ?? '';

if (isset($info['user_id'])) {
    echo json_encode(["authenticated" => true, "user_id" => $info['user_id']]);
} else {
    echo json_encode(["authenticated" => false]);
}


switch ($action)
{
    case ("create"):
        //create contact logic
        $firstname = $info['firstname'];
        $lastname = $info['lastname'];
        $email = $info['email'];
        $phone = $info['phone'];
        $user_id = $info['user_id'];
        $created = date('Y-m-d H:i:s');

        $conn->query("
        INSERT INTO contacts (firstname, lastname, email, phone, user_id, created)
        VALUES ('$firstname', '$lastname', '$email', '$phone', '$user_id', '$created')
        ");

        echo json_encode(["status" => "success", "contact_id" => $conn->insert_id]);
        break;

    case ("read"):
        //read contact logic
        $user_id = $info['user_id'];

        $limit = 20;
        $offset = 0;

        $result = $conn->query("
        SELECT JSON_ARRAYAGG(
            JSON_OBJECT(
                'id', id,
                'firstname', firstname,
                'lastname', lastname,
                'email', email,
                'phone', phone,
                'user_id', user_id,
                'created', created
            )
        ) AS contacts
        FROM contacts
        WHERE user_id = $user_id
        LIMIT $limit OFFSET $offset;
        ");

        $row = $result->fetch_assoc();
        echo $row['contacts'];
        return $row['contacts'];
        break;

    case ("update"):
        //update contact logic
        break;

    case ("delete"):
        //delete contact logic
        break;
    
    case ("search"):
        //search contact logic
        break;

    default:
        echo json_encode(["status"=>"failed", "key_error"=>"unknown action"]);
        break;
}

?>