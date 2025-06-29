<?php
require("../Connections/connection.php");

$query="CREATE TABLE users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    phone_number VARCHAR(20),
    is_admin TINYINT(1) NOT NULL DEFAULT 0,
    favorite_genres VARCHAR(200),
    date_of_birth DATE NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
)";

$execute=$mysqli->prepare($query);
$execute->execute();