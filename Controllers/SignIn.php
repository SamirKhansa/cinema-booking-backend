<?php

include "../Connections/connection.php";
require_once __DIR__ . '/../Models/Model.php';
require_once __DIR__ . '/../Models/Users.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

// Read raw POST data once
$rawInput = file_get_contents('php://input');



$data = json_decode($rawInput, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid JSON']);
    exit;
}

if (!$data || !isset($data['email']) || !isset($data['password'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing email or password']);
    exit;
}


$required = ["name", "email", "password", "phone_number", "favorite_genres", "date_of_birth"];
foreach ($required as $field) {
    if (empty($data[$field])) {
        http_response_code(400);
        echo json_encode(["error" => "Missing field: $field"]);
        exit;
    }
}

// Setup DB connection once
Model::setDB($mysqli);

// Prepare data for creation
$dataForCreate = [
    "name" => $data["name"],
    "email" => $data["email"],
    "password_hash" => password_hash($data["password"], PASSWORD_DEFAULT),
    "phone_number" => $data["phone_number"],
    "is_admin" => 0,
    "favorite_genres" => $data["favorite_genres"],
    "date_of_birth" => $data["date_of_birth"],
    "created_at" => date("Y-m-d H:i:s")
];

// Create user
$user = Users::create($dataForCreate);

if ($user) {
    echo json_encode(["success" => true, "user" => $user->toArray()]);
} else {
    http_response_code(500);
    echo json_encode(["error" => "Failed to create user"]);
}
