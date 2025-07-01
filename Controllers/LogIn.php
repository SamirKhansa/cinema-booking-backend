<?php
// Include DB connection and models
include "../Connections/connection.php";
require_once __DIR__ . '/../Models/Model.php';
require_once __DIR__ . '/../Models/Users.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");


$rawInput = file_get_contents('php://input');

$data = json_decode($rawInput, true);

if (!$data || !isset($data['email']) || !isset($data['password'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing email or password']);
    exit;
}

$email=$data["email"];
$password=$data["password"];

$sql=$mysqli->prepare("SELECT * FROM users WHERE email = ?");
$sql->bind_param("s",$email);
$sql->execute();
$result=$sql->get_result();
$user=$result->fetch_assoc();
if ($user && password_verify($password, $user['password'])) {
    echo json_encode([
        'status' => '200',
        'message' => 'Login successful',
        'user' => [
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email']
        ]
    ]);
} else {
    // Invalid credentials
    http_response_code(401);
    echo json_encode(['error' => 'Invalid email or password']);
}

