<?php
require_once("Model.php");

class Movies extends Model {
    private int $id;
    private string $title;
    private string $description;
    private string $genre;
    private int $duration_minutes;
    private string $release_date;
    private string $rating;
    private string $language;
    private string $poster_url;
    private string $trailer_url;
    private string $director;
    private string $actors;
    protected static string $table = "movies";

    public function __construct(array $data){
        $this->title = $data["title"];
        $this->description = $data["description"];
        $this->genre = $data["genre"];
        $this->duration_minutes = $data["duration_minutes"];
        $this->release_date = $data["release_date"];
        $this->rating = $data["rating"];
        $this->language = $data["language"];
        $this->poster_url = $data["poster_url"];
        $this->trailer_url = $data["trailer_url"];
        $this->director = $data["director"];
        $this->actors = $data["actors"];
    }

    
    public function getId(): int {
        return $this->id;
    }
    

    
    public function getTitle(): string {
        return $this->title;
    }
    public function setTitle(string $title): void {
        $this->title = $title;
    }

    
    public function getDescription(): string {
        return $this->description;
    }
    public function setDescription(string $description): void {
        $this->description = $description;
    }

    
    public function getGenre(): string {
        return $this->genre;
    }
    public function setGenre(string $genre): void {
        $this->genre = $genre;
    }

    
    public function getDurationMinutes(): int {
        return $this->duration_minutes;
    }
    public function setDurationMinutes(int $duration): void {
        $this->duration_minutes = $duration;
    }

    
    public function getReleaseDate(): string {
        return $this->release_date;
    }
    public function setReleaseDate(string $release_date): void {
        $this->release_date = $release_date;
    }

    public function getRating(): string {
        return $this->rating;
    }
    public function setRating(string $rating): void {
        $this->rating = $rating;
    }

    
    public function getLanguage(): string {
        return $this->language;
    }
    public function setLanguage(string $language): void {
        $this->language = $language;
    }

   
    public function getPosterUrl(): string {
        return $this->poster_url;
    }
    public function setPosterUrl(string $poster_url): void {
        $this->poster_url = $poster_url;
    }

    
    public function getTrailerUrl(): string {
        return $this->trailer_url;
    }
    public function setTrailerUrl(string $trailer_url): void {
        $this->trailer_url = $trailer_url;
    }

    public function getDirector(): string {
        return $this->director;
    }
    public function setDirector(string $director): void {
        $this->director = $director;
    }


    public function getActors(): string {
        return $this->actors;
    }
    public function setActors(string $actors): void {
        $this->actors = $actors;
    }
    public function toArray(): array {
    return [
        'id' => $this->id,'title' => $this->title, 'description' => $this->description,'genre' => $this->genre,'duration_minutes' => $this->duration_minutes,'release_date' => $this->release_date,
        'rating' => $this->rating,'language' => $this->language,'poster_url' => $this->poster_url,'trailer_url' => $this->trailer_url,'director' => $this->director,'actors' => $this->actors
    ];
}
}
