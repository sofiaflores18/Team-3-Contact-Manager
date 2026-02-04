<?php
header("Content-Type: application/json");
require "db.php";

session_start(); //use this so we can access $_SESSION

$action = $_POST['action'] ?? '';

switch ($action)
{
    case ("create"):
        //create contact logic
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
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