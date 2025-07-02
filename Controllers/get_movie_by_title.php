<?php
header('Content-Type: application/json');
include '../Connections/connection.php'; // adjust path if needed

if (!isset($_GET['title'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Title is required']);
    exit;
}

$title = $_GET['title'];

$stmt = $mysqli->prepare("SELECT * FROM movies WHERE title = ?");
$stmt->bind_param("s", $title);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $movie = $result->fetch_assoc();
    echo json_encode($movie);
} else {
    echo json_encode([]);
}
