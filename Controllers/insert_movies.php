<?php

include "../Connections/connection.php";
require_once __DIR__ . '/../Models/Model.php';
require_once __DIR__ . '/../Models/Movies.php';  // <-- include Movies model

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

// Use $_POST and $_FILES because this is a multipart/form-data upload
$data = $_POST;

// Check required fields
$required = ["title", "description", "genre", "duration_minutes", "release_date", "rating", "language", "trailer_url", "director", "actors", "showtime"];

foreach ($required as $field) {
    if (empty($data[$field])) {
        http_response_code(400);
        echo json_encode(["error" => "Missing field: $field"]);
        exit;
    }
}

// Check the file upload
if (!isset($_FILES['poster_url']) || $_FILES['poster_url']['error'] !== UPLOAD_ERR_OK) {
    http_response_code(400);
    echo json_encode(['error' => 'File not uploaded or upload error']);
    exit;
}

// Move uploaded file
$uploadDir = __DIR__ . '/../../cinema-booking-frontend/Assets/';
$file_name = basename($_FILES['poster_url']['name']);
$destinationPath = $uploadDir . $file_name;

if (!move_uploaded_file($_FILES['poster_url']['tmp_name'], $destinationPath)) {
    http_response_code(500);
    echo json_encode(["error" => "Failed to move uploaded file"]);
    exit;
}

// Set DB connection
Model::setDB($mysqli);

// Prepare data to create movie
$dataForCreate = [
    "title" => $data["title"],
    "description" => $data["description"],
    "genre" => $data["genre"],
    "duration_minutes" => $data["duration_minutes"],
    "release_date" => $data["release_date"],
    "rating" => $data["rating"],
    "language" => $data["language"],
    "poster_url" => $file_name, // just the filename, path relative to frontend assets
    "trailer_url" => $data["trailer_url"],
    "director" => $data["director"],
    "actors" => $data["actors"],
    "showtime" => $data["showtime"],
];

// Create the movie record
$movies = Movies::create($dataForCreate);

if ($movies) {
    echo json_encode(["success" => true, "movie" => $movies->toArray()]);
} else {
    http_response_code(500);
    echo json_encode(["error" => "Failed to create movie"]);
}
