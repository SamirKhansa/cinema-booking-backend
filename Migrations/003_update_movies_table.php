<?php 
require "../connection/connection.php";

$query="ALTER TABLE movies ADD COLUMN showtime TIME NOT NULL";
$execute = $mysqli->prepare($query);
$execute->execute();
