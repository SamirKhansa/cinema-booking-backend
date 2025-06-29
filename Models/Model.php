<?php 
abstract class Model{

    protected static string $table;
    protected static string $primary_key = "id";
    protected static mysqli $db;
    
    public static function setDB(mysqli $mysqli) {
    static::$db = $mysqli;
}

    public static function find(int $id) {
        $sql = sprintf("SELECT * FROM %s WHERE %s = ?", static::$table, static::$primary_key);

        $query = static::$db->prepare($sql);
        $query->bind_param("i", $id);
        $query->execute();

        $data = $query->get_result()->fetch_assoc();

        return $data ? new static($data) : null;
    }
    public static function all() {
    $sql = sprintf("SELECT * FROM %s", static::$table);

    $query = static::$db->prepare($sql);
    $query->execute();

    $data = $query->get_result();

    $objects = [];
    while ($row = $data->fetch_assoc()) {
        $objects[] = new static($row);
    }

    return $objects;
}

    public function update(): bool {
        // Get all object properties as an associative array
        $props = get_object_vars($this);

        // Extract the primary key value and remove it from the props to update
        $id = $props[static::$primary_key];
        unset($props[static::$primary_key]);

        // Prepare the SET clause like "col1 = ?, col2 = ?, ..."
        $columns = array_keys($props);
        $setClause = implode(" = ?, ", $columns) . " = ?";

        // Prepare the SQL query
        $sql = "UPDATE " . static::$table . " SET $setClause WHERE " . static::$primary_key . " = ?";

        $stmt = static::$db->prepare($sql);

        if (!$stmt) {
            return false; // Prepare failed
        }

        // Build the types string for bind_param (defaulting to string "s" here, adjust if needed)
        $types = str_repeat("s", count($props)) . "i";

        // Values to bind (all properties followed by the primary key for the WHERE clause)
        $values = array_values($props);
        $values[] = $id;

        // Bind parameters dynamically
        $stmt->bind_param($types, ...$values);

        // Execute and return success status
        return $stmt->execute();
    }


    public static function create(array $data): ?static {
    // Extract columns and values from the data array
    $columns = array_keys($data);
    $placeholders = implode(", ", array_fill(0, count($columns), "?"));
    $columnsList = implode(", ", $columns);

    // Prepare the SQL INSERT statement
    $sql = "INSERT INTO " . static::$table . " ($columnsList) VALUES ($placeholders)";

    $stmt = static::$db->prepare($sql);
    if (!$stmt) {
        return null; // Preparation failed
    }

    // Build the types string for bind_param
    // For simplicity, assuming all fields are strings
    $types = str_repeat("s", count($columns));

    // Bind parameters dynamically
    $values = array_values($data);
    $stmt->bind_param($types, ...$values);

    // Execute the query
    if ($stmt->execute()) {
        // Get the ID of the inserted row
        $insertedId = static::$db->insert_id;

        // Retrieve and return the created object
        return static::find($insertedId);
    } else {
        return null; // Insert failed
    }
}

public function delete(): bool {
    $sql = "DELETE FROM " . static::$table . " WHERE " . static::$primary_key . " = ?";

    $stmt = static::$db->prepare($sql);
    if (!$stmt) {
        return false; // Prepare failed
    }

    // Bind the primary key value (assumed integer)
    $primaryKeyValue = $this->{static::$primary_key};
    $stmt->bind_param("i", $primaryKeyValue);

    return $stmt->execute();
}

    
    //Implement the following: 
    //1- update() -> non-static function 
    //2- create() -> static function
    //3- delete() -> non-static function 
}