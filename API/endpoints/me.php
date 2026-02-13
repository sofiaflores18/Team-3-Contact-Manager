<?php
require "../default_endpoint.php";

function get_user_info($info, $conn)
{
    $user_id = $info['user_id'];

    $stmt = $conn->prepare(
        "SELECT username, password_user 
        FROM users 
        WHERE id = ?"
    );

    $stmt->bind_param("i", $user_id);
    $stmt->execute();

    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if (!$user) {
        http_response_code(404);
        echo json_encode(["error" => "User not found"]);
        exit;
    }

    // Example response for /me
    echo json_encode([
        "username" => $user["username"],
        "password_hash" => $user["password_user"]
    ]);
}

//Main Function Logic
    //If the request method used to this endpoint was not GET, then return error
if ($_SERVER['REQUEST_METHOD'] !== 'GET')
{
    echo json_encode(["status"=>"error", "message"=>"Invalid HTTP request, only GET is accepted"]);
    exit;
}

get_user_info($info, $conn);
?>