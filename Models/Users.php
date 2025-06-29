<?php
require_once("Model.php");

class Users extends Model{
    private int $id;
    private string $name;
    private string $email;
    private string $password_hash;
    private string $phone_number;
    private int $is_admin;
    private string $favorite_genres;
    private string $date_of_birth;
    private string $created_at;
    protected static string $table = "users";
    public function __construct(array $data){
        $this->id = $data["id"];
        $this->name = $data["name"];
        $this->email = $data["email"];
        $this->phone_number = $data["phone_number"];
        $this->password_hash = $data["password_hash"];
        $this->is_admin = $data["is_admin"];
        $this->favorite_genres = $data["favorite_genres"];
        $this->date_of_birth = $data["date_of_birth"];
        $this->created_at = $data["created_at"];
    }
    public function getId(): int {
    return $this->id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function setName(string $name): void {
        $this->name = $name;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function setEmail(string $email): void {
        $this->email = $email;
    }

    public function getPasswordHash(): string {
        return $this->password_hash;
    }

    public function setPasswordHash(string $password_hash): void {
        $this->password_hash = $password_hash;
    }

    public function getPhoneNumber(): string {
        return $this->phone_number;
    }

    public function setPhoneNumber(string $phone_number): void {
        $this->phone_number = $phone_number;
    }

    public function getIsAdmin(): bool {
        if($this->is_admin==0){
            return false;
        }
        else{
            return true;
        }
        
    }

    public function setIsAdmin(int $is_admin): void {
        $this->is_admin = $is_admin;
    }

    public function getFavoriteGenres(): string {
        return $this->favorite_genres;
    }

    public function setFavoriteGenres(string $favorite_genres): void {
        $this->favorite_genres = $favorite_genres;
    }

    public function getDateOfBirth(): string {
        return $this->date_of_birth;
    }

    public function setDateOfBirth(string $date_of_birth): void {
        $this->date_of_birth = $date_of_birth;
    }

    public function getCreatedAt(): string {
        return $this->created_at;
    }

    public function setCreatedAt(string $created_at): void {
        $this->created_at = $created_at;
    }
    public function toArray():array{
        return [$this->id, $this->name, $this->email, $this->phone_number, $this->is_admin, $this->favorite_genres, $this->date_of_birth, $this->created_at];
    }

}


