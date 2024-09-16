<?php
// การตั้งค่าการเชื่อมต่อฐานข้อมูล
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_management"; // ปรับชื่อฐานข้อมูลให้ถูกต้อง

// สร้างการเชื่อมต่อ
$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// รับข้อมูลจากฟอร์ม
$full_name = $_POST['full_name'];
$username = $_POST['username'];
$email = $_POST['email'];
$phone_number = $_POST['phone_number'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

// ตรวจสอบว่ารหัสผ่านตรงกันหรือไม่
if ($password !== $confirm_password) {
    echo "Passwords do not match!";
    exit();
}

// การแทรกข้อมูลลงฐานข้อมูล
$sql = "INSERT INTO users (full_name, username, email, phone_number, password) VALUES ('$full_name', '$username', '$email', '$phone_number', '".password_hash($password, PASSWORD_DEFAULT)."')";

if ($conn->query($sql) === TRUE) {
    // ถ้าการสมัครสมาชิกสำเร็จให้แสดงข้อความสำเร็จและเปลี่ยนเส้นทางไปที่หน้า login.html
    echo '<script>
            alert("Registration successful! Redirecting to login page...");
            window.location.href = "login.html";
          </script>';
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
