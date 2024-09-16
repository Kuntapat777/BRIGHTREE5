<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "moisture_data";

// สร้างการเชื่อมต่อ
$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Debugging: Check what is received
file_put_contents('error_log.txt', "POST data: " . print_r($_POST, true) . "\n", FILE_APPEND);

if (isset($_POST['moisture_value'])) {
    $moisture_value = floatval($_POST['moisture_value']); // ใช้ floatval สำหรับค่าทศนิยม
    $timestamp = date('Y-m-d H:i:s'); // ใช้เวลาปัจจุบัน
    $sql = "INSERT INTO moisture_readings1 (moisture_value, timestamp) VALUES ($moisture_value, '$timestamp')";

    if ($conn->query($sql) === TRUE) {
        // Echo the inserted data
        $last_id = $conn->insert_id;
        echo "New record created successfully.<br>ID: $last_id - Moisture Value: $moisture_value %<br>";
    } else {
        file_put_contents('error_log.txt', "Error: " . $sql . "<br>" . $conn->error . "\n", FILE_APPEND);
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "No moisture value received";
}

$conn->close();
?>
