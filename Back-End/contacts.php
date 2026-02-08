<?php
session_start(); //use this so we can access $_SESSION
header("Content-Type: application/json");
require "db.php";
require "auxiliary.php";

if (!isset($_SESSION['user_id'])) {
        echo json_encode(["status" => "failed", "error" => "Not authenticated"]);
        exit;
    }

function getRequestInfo(){
    return json_decode(file_get_contents("php://input"), true);
}   

$info = getRequestInfo();
$action = $info['action'] ?? '';

switch ($action)
{
    case ("create"):
        //create contact logic
        $firstname = $info['firstname'];
        $lastname = $info['lastname'];
        $email = $info['email'];
        $phone = $info['phone'];
        $user_id = $_SESSION['user_id']; //$_SESSION is another super global array that stores information saved on the client (browser)
        $created = date('Y-m-d H:i:s');

        $conn->query("
        INSERT INTO contacts (firstname, lastname, email, phone, user_id, created)
        VALUES ('$firstname', '$lastname', '$email', '$phone', '$user_id', '$created')
        ");

        echo json_encode(["status" => "success", "contact_id" => $conn->insert_id]);
        break;

    case ("read"):
        //read contact logic
        $all_contacts = $conn->query("
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
        FROM contacts;
        ");

        echo $all_contacts;
        return $all_contacts;

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