<?php
session_start(); //use this so we can access $_SESSION
header("Content-Type: application/json");
require "db.php";
require "auxiliary.php";


//Get information from the POST request
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
        echo $row['contacts'] ?? '[]';

        break;

    case ("update"):
        //update contact logic

        $user_id = $info['user_id'] ?? null; //User id
        $id= $info['contact_id'] ?? null; //Contact id
        
        if (!$user_id) {
            echo json_encode(["status"=>"failed", "error"=>"User does not exist."]);
            break;
        }

        else if (!$id){
            echo json_encode(["status"=>"failed", "error"=>"Contact does not exist."]);
            break;
        }

        // Use NULL so COALESCE keeps old values
        $firstname = $info['firstname'] ?? null;
        $lastname  = $info['lastname'] ?? null;
        $email     = $info['email'] ?? null;
        $phone     = $info['phone'] ?? null;

        $query = $conn->prepare("
            UPDATE contacts
            SET firstname = COALESCE(?, firstname),
                lastname  = COALESCE(?, lastname),
                email     = COALESCE(?, email),
                phone     = COALESCE(?, phone)
            WHERE id = ? AND user_id = ?
        ");

        if (!$query) {
            echo json_encode(["status"=>"failed", "error"=>"Prepare failed", "details"=>$conn->error]);
            break;
        }

        $query->bind_param("ssssii", $firstname, $lastname, $email, $phone, $id, $user_id);

        if (!$query->execute()) {
            echo json_encode(["status"=>"failed", "error"=>"failed", "details"=>$query->error]);
            $query->close();
            break;
        }

        if ($query->affected_rows === 0) {
            echo json_encode(["status"=>"failed", "error"=>"no changes"]);
            $query->close();
            break;
        }

        echo json_encode(["status"=>"success"]);
        $query->close();
        break;


    case ("delete"):
        //delete contact logic
        $user_id = $info['user_id'];
        $contact_id = $info['contact_id'];

        $stmt = $conn->prepare("
        DELETE FROM contacts
        WHERE id = ? AND user_id = ?;
        ");

        $stmt->bind_param("ii", $contact_id, $user_id);
        $stmt->execute();

        if ($stmt->affected_rows === 0) {
            echo json_encode(["status" => "failed", "error" => "not found"]);
        } else {
            echo json_encode(["status" => "success"]);
        }
        $stmt->close();

        break;
    
    case ("search"):
        //search contact logic

        //firstname search logic only
        $user_id = $info['user_id'];
        $firstname = $info['firstname'];

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
        AND firstname LIKE '%$firstname%';
      ");

        $row = $result->fetch_assoc();
        echo $row['contacts'];
        break;

    default:
        echo json_encode(["status"=>"failed", "key_error"=>"unknown action"]);
        break;
}

?>