<?php
$servername = "localhost";
$username = "root"; // ใช้รหัสผ่านที่ตั้งไว้ใน MySQL
$password = ""; // รหัสผ่าน MySQL (ปกติไม่มีรหัสผ่านเริ่มต้นคือว่าง)
$dbname = "moisture_data";

// เชื่อมต่อกับฐานข้อมูล
$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// รับข้อมูลจาก POST
$moisture_value_1 = $_POST['moisture_value_1'];
$moisture_value_2 = $_POST['moisture_value_2'];
$moisture_value_3 = $_POST['moisture_value_3'];

// เตรียมคำสั่ง SQL
$sql = "INSERT INTO sensor_readings (moisture_value_1, moisture_value_2, moisture_value_3) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ddd", $moisture_value_1, $moisture_value_2, $moisture_value_3);

// ประมวลผลคำสั่ง
if ($stmt->execute()) {
    echo "New record created successfully";
} else {
    echo "Error: " . $stmt->error;
}

// ปิดการเชื่อมต่อ
$stmt->close();
$conn->close();
?>
