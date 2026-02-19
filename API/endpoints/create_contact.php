<?php
require "../default_endpoint.php";

//If the request method used to this endpoint was not POST, then return error
if ($_SERVER['REQUEST_METHOD'] !== 'POST')
{
    echo json_encode(["status"=>"error", "message"=>"Invalid HTTP request, only POST is accepted"]);
    exit;
}

function create_contact($info, $conn)
{
    //create contact logic
        $firstname = $info['firstname'];
        $lastname = $info['lastname'];
        $email = $info['email'];
        $phone = $info['phone'];
        $user_id = $info['user_id'];
        $created = date('Y-m-d H:i:s');

        $stmt = $conn->prepare("
            INSERT INTO contacts
            (firstname, lastname, email, phone, user_id, created)
            VALUES (?, ?, ?, ?, ?, ?) 
        ");

        $stmt->bind_param(
            "ssssis",
            $firstname,
            $lastname,
            $email,
            $phone,
            $user_id,
            $created
        );

        $stmt->execute();
        echo json_encode(["status" => "success", "contact_id" => $conn->insert_id]);
        $stmt->close();
}

create_contact($info, $conn);

?>