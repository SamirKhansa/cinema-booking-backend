<?php
require("../Connections/connection.php");

$query="CREATE TABLE movies (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description Text NOT NULL,
    genre VARCHAR(100) NOT NULL,
    duration_minutes INT,
    release_date DATE NOT NULL,
    rating VARCHAR(10) NOT NULL,
    language VARCHAR(100) NOT NULL,
    poster_url VARCHAR(255) NOT NULL,
    trailer_url VARCHAR(255),
    director VARCHAR(100),
    actors TEXT
)";

$execute=$mysqli->prepare($query);
$execute->execute();