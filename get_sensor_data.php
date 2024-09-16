<?php
// การเชื่อมต่อฐานข้อมูล
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "moisture_data";

$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// รับค่าเซ็นเซอร์จาก URL
$sensor = $_GET['sensor'];

// กำหนดฟิลด์ที่จะแสดงตามเซ็นเซอร์ที่เลือก
$sensor_field = "moisture_value_" . $sensor;

// Query ดึงข้อมูลค่าความชื้นล่าสุด
$sql = "SELECT $sensor_field AS moisture_value FROM sensor_readings ORDER BY timestamp DESC LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode($row);
} else {
    echo json_encode(['moisture_value' => 'N/A']);
}

$conn->close();
?>
