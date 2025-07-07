<?php
class Client_Services{
    public static function LogIn_check_Email_Password_Exist($data){
        if (empty($data['email']) || empty($data['password'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing email or password']);
            return "error";
            
        }
        return "success";

    }

    public static function Verify_Password_Authenticity($password, $user){
        if ($user && password_verify($password, $user['password'])) {
            unset($user['password']);           // never ship the hash
            echo json_encode([
                'status'  => 200,
                'message' => 'Login successful',
                'user'    => $user
            ]);
            return "success";
        }
        return "error";
    }
}