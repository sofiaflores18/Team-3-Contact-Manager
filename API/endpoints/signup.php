<?php
header('Content-Type: application/json');

require "../default_endpoint.php";

/**
 * Only allow POST requests
 */
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        "status" => "error",
        "message" => "Invalid request method. POST required."
    ]);
    exit;
}

/**
 * Read and decode JSON body
 */
$raw = file_get_contents("php://input");
$info = json_decode($raw, true);

if (!$info) {
    http_response_code(400);
    echo json_encode([
        "status" => "error",
        "message" => "Invalid JSON payload"
    ]);
    exit;
}

/**
 * Validate required fields
 */
$required = ['firstname', 'lastname', 'username', 'email', 'phone', 'password'];
foreach ($required as $field) {
    if (empty($info[$field])) {
        http_response_code(422);
        echo json_encode([
            "status" => "error",
            "message" => "Missing field: $field"
        ]);
        exit;
    }
}

/**
 * Sanitize + assign
 */
$firstname = trim($info['firstname']);
$lastname  = trim($info['lastname']);
$username  = trim($info['username']);
$email     = trim($info['email']);
$phone     = trim($info['phone']);
$password  = password_hash($info['password'], PASSWORD_DEFAULT);
$created   = date('Y-m-d H:i:s');

/**
 * Insert user
 */
$stmt = $conn->prepare(
    "INSERT INTO users 
     (firstname, lastname, username, email, phone, password_user, created)
     VALUES (?, ?, ?, ?, ?, ?, ?)"
);

if (!$stmt) {
    http_response_code(500);
    echo json_encode([
        "status" => "error",
        "message" => "Database prepare failed"
    ]);
    exit;
}

$stmt->bind_param(
    "sssssis",
    $firstname,
    $lastname,
    $username,
    $email,
    $phone,
    $password,
    $created
);

/**
 * Execute and handle errors
 */
if (!$stmt->execute()) {
    if ($stmt->errno === 1062) {
        http_response_code(409);
        echo json_encode([
            "status" => "error",
            "message" => "Username or email already exists"
        ]);
    } else {
        http_response_code(500);
        echo json_encode([
            "status" => "error",
            "message" => "Database error: " . $stmt->error
        ]);
    }
    $stmt->close();
    exit;
}

/**
 * Success
 */
$user_id = $conn->insert_id;
$stmt->close();

echo json_encode([
    "status" => "success",
    "message" => "Account creation successful!",
    "user_id" => $user_id
]);
?>