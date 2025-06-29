<?php
$response=[];
$response["status"]=200;
if(isset($_GET["x"])){

}
$x=$_GET["x"];
if(isset($_GET["y"])){
    $y=$_GET["y"];
}
else{
    $y=10;
}

$z=$y-$x;
// $response=[];
$response["response"]=$z;
echo json_encode($response);

