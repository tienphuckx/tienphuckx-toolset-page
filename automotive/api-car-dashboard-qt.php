<?php
header("Content-Type: application/json");

define("HOST", "127.0.0.1");
define("USER", "544261");
define("PASSWORD", "tienphuckx");
define("DB", "544261");

function get_db_connection() {
    $connect = new mysqli(HOST, USER, PASSWORD, DB);
    if ($connect->connect_error) {
        die("Connection failed: " . $connect->connect_error);
    }
    return $connect;
}

$conn = get_db_connection();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    // Fetch only the newest record, ordered by `updated_at` in descending order and limited to 1
    $query = "SELECT id, temperature, humidity, speed, fuel, gear, gps, updated_at 
              FROM tbl_car_dashboard 
              ORDER BY updated_at DESC 
              LIMIT 1";
    
    $result = $conn->query($query);

    // Check if data is available
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();  // Fetch the newest row

        // Return the data as JSON
        echo json_encode(["status" => "success", "data" => $row]);
    } else {
        echo json_encode(["status" => "error", "message" => "No data found"]);
    }

} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
}

// Close the database connection
$conn->close();
?>
