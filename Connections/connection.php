<?php
$db_host="localhost";
$db_name="Cinema";
$db_user="root";
$db_pass=null;

$mysqli=new mysqli($db_host, $db_user, $db_pass, $db_name);
if($mysqli->connect_error){
    echo "Connection Failed"+ $mysqli->connect_error;
}
// echo "Connection Successful";
