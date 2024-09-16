<?php
// เปิดการแสดงผลข้อผิดพลาด (สำหรับการพัฒนาเท่านั้น)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// การตั้งค่าการเชื่อมต่อฐานข้อมูล
$servername = "localhost";
$username = "root"; // เปลี่ยนตามการตั้งค่าของคุณ
$password = ""; // เปลี่ยนตามการตั้งค่าของคุณ
$dbname = "user_management";

// สร้างการเชื่อมต่อกับฐานข้อมูล
$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// เริ่มต้น session
session_start();

// รับข้อมูลจากฟอร์ม
$username = $_POST['username'];
$password = $_POST['password'];

// ตรวจสอบข้อมูลในฐานข้อมูลโดยใช้ prepared statements เพื่อป้องกัน SQL Injection
$stmt = $conn->prepare("SELECT full_name, password FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

// ตรวจสอบว่าพบผู้ใช้หรือไม่
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    // ตรวจสอบรหัสผ่านโดยใช้ password_verify
    if (password_verify($password, $row['password'])) {
        // ตั้งค่า session สำหรับชื่อผู้ใช้และชื่อเต็มของผู้ใช้
        $_SESSION['username'] = $username;
        $_SESSION['full_name'] = $row['full_name']; // เก็บชื่อผู้ใช้เต็มใน session
        header("Location: home.php"); // เปลี่ยนหน้าไปยัง home.php
        exit(); // หยุดการทำงานของสคริปต์ที่เหลือ
    } else {
        echo "Invalid password.";
    }
} else {
    echo "User not found.";
}

// ปิด statement และการเชื่อมต่อฐานข้อมูล
$stmt->close();
$conn->close();
?>
