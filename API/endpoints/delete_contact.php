<?php
require "../default_endpoint.php";

//If the request method used to this endpoint was not GET, then return error
if ($_SERVER['REQUEST_METHOD'] !== 'DELETE')
{
    echo json_encode(["status"=>"error", "message"=>"Invalid HTTP request, only DELETE is accepted"]);
    exit;
}

function delete_contact($info, $conn)
{
    //delete contact logic
    $user_id = $info['user_id'];
    $id = $info['id'];

    $stmt = $conn->prepare("
    DELETE FROM contacts
    WHERE id = ? AND user_id = ?;
    ");

    $stmt->bind_param("ii", $id, $user_id);
    $stmt->execute();

    if ($stmt->affected_rows === 0) {
        echo json_encode(["status" => "failed", "error" => "not found"]);
    } else {
        echo json_encode(["status" => "success"]);
    }
    $stmt->close();

}

delete_contact($info, $conn);

?>
