<?php
require "../default_endpoint.php";

function login($info, $conn)
{
    
    $username = $info['username']; // strip characters (whitespace, casing?)
    $password_user = $info['password'];
    $hashed_password = password_hash($password_user, PASSWORD_DEFAULT); // TODO: hash password

    $stmt = $conn->prepare("SELECT * FROM users WHERE username=? AND password_user=?"); 
    $stmt->bind_param("ss", $username, $hashed_password);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // username is unique, should only ever be 1 or 0.
    $num_results = $result->num_rows;

    if($num_results == 1) 
    {
        // matching user found
        $user_id = $result->fetch_assoc()['id'];
        $_SESSION['user_id'] = $user_id;

        echo json_encode(value: ["status" => "success", "message" => "Login successful!", "user_id" => $user_id]);
    } 

    else if($num_results == 0) 
    {
        // no matching users found, login failed
        echo json_encode(["status" => "failure", "message" => "Invalid username or password."]);
    } 
    
    else 
    {
        // error, somehow more than one user match.
        echo "Login failed, multiple account matches found: " . $num_results . " results.";
    }
    
    $stmt->close();
}


//If the request method used to this endpoint was not POST, then return error
if ($_SERVER['REQUEST_METHOD'] !== 'POST')
{
    echo json_encode(["status"=>"error", "message"=>"Invalid HTTP request, only POST is accepted"]);
    exit;
}

$info = getRequestInfo();
login($info, $conn);

?>