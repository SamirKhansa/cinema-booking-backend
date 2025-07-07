<?php 
abstract class Model{

    protected static string $table;
    protected static string $primary_key = "id";
    protected static mysqli $db;



    public static function setDB(mysqli $mysqli) {
    static::$db = $mysqli;
}

    public static function find( array $arr){
        $sql = sprintf("Select * from %s WHERE %s = ?", 
                        static::$table, 
                        $arr["element"]);
        
        $query = static::$db->prepare($sql);;
        $query->bind_param($arr["type"], $arr["value"]);
        $query->execute();

        $data = $query->get_result()->fetch_assoc();

        return $data;
    }

    public static function all(mysqli $mysqli){
        $sql = sprintf("Select * from %s", static::$table);
        
        $query = static::$db->prepare($sql);
        $query->execute();

        $data = $query->get_result();

        $objects = [];
        while($row = $data->fetch_assoc()){
            $objects[] = new static($row);
        }

        return $objects;
    }

    public static function DeleteAll(mysqli $mysqli): bool{
        $sql = sprintf("DELETE from %s", static::$table);
        
        $query =  static::$db->prepare($sql);
        $query->execute();


        return true; 
    }


    public static function delete(mysqli $mysqli, int $id): bool{
        $sql = sprintf("DELETE from %s WHERE id=?", static::$table, static::$primary_key);
        
        $query =  static::$db->prepare($sql);
        $query->execute();
        $query = $mysqli->prepare($sql);
        $query->bind_param("i", $id);
        $query->execute();

        $data = $query->get_result()->fetch_assoc();
        if($data){
            return true;
        }
        else{
            return false;
        }
         
    }

    public static function create(array $data):?static{
        $columns = array_keys($data);
        $placeholders = implode(", ", array_fill(0, count($columns), "?"));
        $columnsList = implode(", ", $columns);
        $sql = "INSERT INTO " . static::$table . " ($columnsList) VALUES ($placeholders)";
        $stmt = static::$db->prepare($sql);
        if (!$stmt) {
        return null; 
        }

        print_r($stmt);
        
        $types = str_repeat("s", count($columns));
        $values = array_values($data);
        $stmt->bind_param($types, ...$values);

        
        if ($stmt->execute()) {
            
            $insertedId = static::$db->insert_id;
            $arr=["element"=>"id","value"=>$insertedId,"type"=>"i"];
            return static::find($arr);
        } else {
            return null; 
        }
    } 

    public function update(): bool {
        
        $props = get_object_vars($this);
        
        
        $id = $props[static::$primary_key];
        unset($props[static::$primary_key]);
        

        
        $columns = array_keys($props);
        $setClause = implode(" = ?, ", $columns) . " = ?";

        
        $sql = "UPDATE " . static::$table . " SET $setClause WHERE " . static::$primary_key . " = ?";

        $stmt = static::$db->prepare($sql);
        

        if (!$stmt) {
            return false; 
        }

        
        $types = str_repeat("s", count($props)) . "i";

        
        
        $values = array_values($props);
        $values[] = $id;

        print_r($values[2]);
        
        $stmt->bind_param($types, ...$values);

        
        return $stmt->execute();
    }



   
}