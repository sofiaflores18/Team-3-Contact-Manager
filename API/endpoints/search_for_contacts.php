<?php
require "../default_endpoint.php";

//If the request method used to this endpoint was not GET, then return error
if ($_SERVER['REQUEST_METHOD'] !== 'GET')
{
    echo json_encode(["status"=>"error", "message"=>"Invalid HTTP request, only GET is accepted"]);
    exit;
}

function search_for_contacts($info, $conn)
{
    //firstname search logic only
    $user_id = $info['user_id'];
    $search_term = "%" . ($info['firstname'] ?? '') . "%"; // "%" is the wildcard operator, like the kleene star in regex. It means 0 or more occurances of whatever characters

    $stmt = $conn->prepare("
    SELECT COALESCE(JSON_ARRAYAGG(contact_row), '[]') AS contacts
        FROM (
            SELECT JSON_OBJECT(
                'id', id,
                'firstname', firstname,
                'lastname', lastname,
                'email', email,
                'phone', phone,
                'user_id', user_id,
                'created', created
            ) AS contact_row
            FROM contacts
            WHERE user_id = ? 
            AND firstname LIKE ?
        ) AS results
    ");

    $stmt->bind_param("is", $user_id, $search_term);
    $stmt->execute();

    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    echo $row['contacts'];
}

search_for_contacts($info, $conn);
?>