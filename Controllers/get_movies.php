<?php
header('Content-Type: application/json');
include '../Connections/connection.php'; // your DB connection

$sql=$mysqli->prepare("SELECT title, poster_url FROM movies");
$sql->execute();
$result = $sql->get_result();

$movies = [];
while ($row = $result->fetch_assoc()) {
    $movies[] = [
        'title' => $row['title'],
        'poster_url' => $row['poster_url']  // just the filename, e.g. "Shrek.jpg"
    ];
}

echo json_encode($movies);
