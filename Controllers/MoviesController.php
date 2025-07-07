<?php
require __DIR__ . "/../models/Article.php";
require __DIR__ . "/../connection/connection.php";
require_once __DIR__ . '/../Models/Model.php';
require_once __DIR__ . '/../Models/Movies.php'; 
require __DIR__ . "/../Services/Movies_Services.php";
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
class MoviesController{

    public static function get_Specific_movie(){
        global $mysqli;
        if (!isset($_GET['title'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Title is required']);
            exit;
        }

        $title = $_GET['title'];

        $arr=array("element"=>"title","val"=>$title, "type"=>"s");
        $result=Movies::find($arr);
        if ($result) {
            echo json_encode($result);
        } else {
            echo json_encode([]);
        }
    }

    public static function get_all_movie_title_Image_url(){
        global $mysqli;
        $sql=$mysqli->prepare("SELECT title, poster_url FROM movies");
        $sql->execute();
        $result = $sql->get_result();

        $movies=Movies_Services::Movies_Title_imageURL($result);
        echo json_encode($movies);
    }


    public static function insert_movie(){
        global $mysqli;
        $data = $_POST;
        
        if(Movies_Services::Movie_checks_attributes_exsist($data)=="error" || Movies_Services::Check_file_uploaded()=="error"){
            http_response_code(400);
            exit;
        }

        $uploadDir = __DIR__ . '/../../cinema-booking-frontend/Assets/';
        $file_name = basename($_FILES['poster_url']['name']);
        
        if(Movies_Services::Move_Upload_Image($uploadDir,$file_name)=="error"){
            exit();
        }

        
        Model::setDB($mysqli);

        
        $dataForCreate = [
            "title" => $data["title"],
            "description" => $data["description"],
            "genre" => $data["genre"],
            "duration_minutes" => $data["duration_minutes"],
            "release_date" => $data["release_date"],
            "rating" => $data["rating"],
            "language" => $data["language"],
            "poster_url" => $file_name, // just the filename, path relative to frontend assets
            "trailer_url" => $data["trailer_url"],
            "director" => $data["director"],
            "actors" => $data["actors"],
            "showtime" => $data["showtime"],
        ];

        // Create the movie record
        $movies = Movies::create($dataForCreate);

        if ($movies) {
            echo json_encode(["success" => true, "movie" => $movies->toArray()]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "Failed to create movie"]);
        }

    }

}
















?> 


