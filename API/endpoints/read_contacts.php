<?php
require "../default_endpoint.php";

//If the request method used to this endpoint was not GET, then return error
if ($_SERVER['REQUEST_METHOD'] !== 'GET')
{
    echo json_encode(["status"=>"error", "message"=>"Invalid HTTP request, only GET is accepted"]);
    exit;
}


function get_contacts($info, $conn)
{
    //read contact logic
    $user_id = $info['user_id'];
    $limit = $info['limit'] ?? 20; //limit is the amount of contacts you want to fetch from the database

    //offset is the amount we want to jump over. For example if the limit was 20, we have just read the first 20 contacts, offset should be 20 when moving forward
    $offset = $info['offset'] ?? 0; 

    $stmt = $conn->prepare("
    SELECT COALESCE(JSON_ARRAYAGG(contact_data), '[]') AS contacts
    FROM (
        SELECT JSON_OBJECT(
            'id', id,
            'firstname', firstname,
            'lastname', lastname,
            'email', email,
            'phone', phone,
            'user_id', user_id,
            'created', created
        ) AS contact_data
        FROM contacts
        WHERE user_id = ?
        LIMIT ? OFFSET ?
    ) AS subquery
    ");

    $stmt->bind_param("iii", $user_id, $limit, $offset);
    $stmt->execute();

    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    echo $row['contacts'] ?? '[]';
}

get_contacts($info, $conn);

?>
