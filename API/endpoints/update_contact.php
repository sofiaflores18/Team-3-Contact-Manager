<?php
require "../default_endpoint.php";

//If the request method used to this endpoint was not PATCH, then return error
if ($_SERVER['REQUEST_METHOD'] !== 'PATCH')
{
    echo json_encode(["status"=>"error", "message"=>"Invalid HTTP request, only PATCH is accepted"]);
    exit;
}


function update_contact($info, $conn){
    //update contact logic

    $user_id = $info['user_id'] ?? null; //User id
    $id= $info['contact_id'] ?? null; //Contact id
    
    if (!$user_id) {
        echo json_encode(["status"=>"failed", "error"=>"User does not exist."]);
        exit;
    }

    else if (!$id){
        echo json_encode(["status"=>"failed", "error"=>"Contact does not exist."]);
        exit;
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
        exit;
    }

    $query->bind_param("ssssii", $firstname, $lastname, $email, $phone, $id, $user_id);

    if (!$query->execute()) {
        echo json_encode(["status"=>"failed", "error"=>"failed", "details"=>$query->error]);
        $query->close();
        exit;
    }

    if ($query->affected_rows === 0) {
        echo json_encode(["status"=>"failed", "error"=>"no changes"]);
        $query->close();
        exit;
    }

    echo json_encode(["status"=>"success"]);
    $query->close();
}

update_contact($info, $conn);

?>