<?php
class Movies_Services{
    public static function All_Movies_to_Array($Movies_db){
        $result=[];
        foreach($Movies_db as $a){
            $result[]=$a->toArray();
        }
        return $result;
    }

    public static function Movies_Title_imageURL($Movies_db){
        $movies = [];
        while ($row = $Movies_db->fetch_assoc()) {
            $movies[] = [
                'title' => $row['title'],
                'poster_url' => $row['poster_url'] 
            ];
        }
        return $movies;
    }

    public static function Movie_checks_attributes_exsist($data){
        $required = ["title", "description", "genre", "duration_minutes", "release_date", "rating", "language", "trailer_url", "director", "actors", "showtime"];
        foreach ($required as $field) {
            if (empty($data[$field])) {
                echo json_encode(["error" => "Missing field: "]);
                return "error";
            }
        }
        return "success";

    }

    public static function Check_file_uploaded(){
        if (!isset($_FILES['poster_url']) || $_FILES['poster_url']['error'] !== UPLOAD_ERR_OK) {
            echo json_encode(['error' => 'File not uploaded or upload error']);
            return "error";
            
        }
        return "success";
    }
    public static function Move_Upload_Image(){
        $uploadDir = __DIR__ . '/../../cinema-booking-frontend/Assets/';
        $file_name = basename($_FILES['poster_url']['name']);
        $destinationPath = $uploadDir . $file_name;

        if (!move_uploaded_file($_FILES['poster_url']['tmp_name'], $destinationPath)) {
            http_response_code(500);
            echo json_encode(["error" => "Failed to move uploaded file"]);
            return "error";
        }
        return "sucess";

    }
}