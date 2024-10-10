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

// Check the request method
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Collect data from POST request
    $temperature = $_POST['temperature'] ?? null;
    $humidity = $_POST['humidity'] ?? null;
    $speed = $_POST['speed'] ?? null;
    $fuel = $_POST['fuel'] ?? null;
    $gear = $_POST['gear'] ?? null;
    $gps = $_POST['gps'] ?? null;
    $updated_at = date('Y-m-d H:i:s');  // Auto insert the current date and time
    
    // Check if required data is provided
    if (!is_null($temperature) && !is_null($humidity) && !is_null($speed) && !is_null($fuel) && !is_null($gear) && !is_null($gps)) {

        // Prepare an SQL statement to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO tbl_car_dashboard (temperature, humidity, speed, fuel, gear, gps, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("dddisds", $temperature, $humidity, $speed, $fuel, $gear, $gps, $updated_at);

        // Execute the statement
        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Data inserted successfully"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to insert data"]);
        }

        // Close the statement
        $stmt->close();
    } else {
        echo json_encode(["status" => "error", "message" => "Incomplete data"]);
    }

} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {

    // If GET method, fetch data from the database
    $query = "SELECT id, temperature, humidity, speed, fuel, gear, gps, updated_at FROM tbl_car_dashboard ORDER BY updated_at DESC";
    $result = $conn->query($query);

    // Check if data is available
    if ($result->num_rows > 0) {
        $data = [];

        // Fetch all rows and push them into an array
        while($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        // Return the data as JSON
        echo json_encode(["status" => "success", "data" => $data]);
    } else {
        echo json_encode(["status" => "error", "message" => "No data found"]);
    }

} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
}

// Close the database connection
$conn->close();
?>
