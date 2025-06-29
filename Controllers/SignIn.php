<?php
// Include your DB connection and models
include "../Connections/connection.php";
require_once __DIR__ . '/../Models/Model.php';
require_once __DIR__ . '/../Models/Users.php';

// Set DB connection once
Model::setDB($mysqli);

// Set header to accept JSON
header("Content-Type: application/json");

// Get raw POST data
$json = file_get_contents('php://input');
$data = json_decode($json, true);

if (!$data) {
    http_response_code(400);
    echo json_encode(["error" => "Invalid JSON"]);
    exit;
}

// Basic validation example
$required = ["name", "email", "password", "phone_number", "favorite_genres", "date_of_birth"];
foreach ($required as $field) {
    if (empty($data[$field])) {
        http_response_code(400);
        echo json_encode(["error" => "Missing field: $field"]);
        exit;
    }
}

// Prepare data for create()
// Hash the password
$dataForCreate = [
    "name" => $data["name"],
    "email" => $data["email"],
    "password_hash" => password_hash($data["password"], PASSWORD_DEFAULT),
    "phone_number" => $data["phone_number"],
    "is_admin" => 0, // default for new users
    "favorite_genres" => $data["favorite_genres"],
    "date_of_birth" => $data["date_of_birth"],
    "created_at" => date("Y-m-d H:i:s")
];

// Create the user
$user = Users::create($dataForCreate);

if ($user) {
    echo json_encode(["success" => true, "user" => $user->toArray()]);
} else {
    http_response_code(500);
    echo json_encode(["error" => "Failed to create user"]);
}
