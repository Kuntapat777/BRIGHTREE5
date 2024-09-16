<?php
header('Content-Type: application/json');

// เชื่อมต่อฐานข้อมูล
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "moisture_data";

$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ดึงข้อมูลจากฐานข้อมูล
$sql = "SELECT timestamp, moisture_value_1, moisture_value_2, moisture_value_3 FROM sensor_readings
 ORDER BY timestamp DESC LIMIT 100";
$result = $conn->query($sql);

$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data['timestamps'][] = $row['timestamp'];
        $data['moisture_values_1'][] = $row['moisture_value_1'];
        $data['moisture_values_2'][] = $row['moisture_value_2'];
        $data['moisture_values_3'][] = $row['moisture_value_3'];
    }
} else {
    $data['timestamps'] = [];
    $data['moisture_values_1'] = [];
    $data['moisture_values_2'] = [];
    $data['moisture_values_3'] = [];
}

echo json_encode($data);
$conn->close();
?>
