<?php
require __DIR__ . "/../models/Article.php";
require __DIR__ . "/../connection/connection.php";
require_once __DIR__ . '/../Models/Model.php';
require_once __DIR__ . '/../Models/Movies.php'; 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Content-Type: application/json");

class ClientController{

    public static function LogIn(){
        global $mysqli;
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(204);
            exit;
        }


        $rawInput = file_get_contents('php://input');
        $payload  = json_decode($rawInput, true);
        $data     = $payload ?: $_POST;

        $result=Client_Services::LogIn_check_Email_Password_Exist($data);
        if($result=="error"){
            exit();
        }

        $email    = trim($data['email']);
        $password = $data['password'];        
        
        $array=["element"=>"email", "value"=>$data, "type"=>'s'];
        $user=Model::find($array);

        $result=Client_Services::Verify_Password_Authenticity($password,$user);
        
        if($result=="error"){
            http_response_code(401);
            echo json_encode(['error' => 'Invalid email or password']);
            exit();

        }
        exit();
    }



}