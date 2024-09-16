<?php
// ข้อมูลการเชื่อมต่อฐานข้อมูล
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "contact_db";

// สร้างการเชื่อมต่อ
$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // รับข้อมูล POST
    $first_name = isset($_POST['first_name']) ? $_POST['first_name'] : null;
    $last_name = isset($_POST['last_name']) ? $_POST['last_name'] : null;
    $email = isset($_POST['email']) ? $_POST['email'] : null;
    $message = isset($_POST['message']) ? $_POST['message'] : null;

    // ตรวจสอบข้อมูลที่จำเป็น
    if ($first_name === null || $last_name === null || $email === null || $message === null) {
        echo "ข้อผิดพลาด: ข้อมูลบางอย่างขาดหายไป";
        exit;
    }

    // จัดการการอัปโหลดไฟล์
    if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] == UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/';
        $upload_file = $upload_dir . basename($_FILES['attachment']['name']);

        // ตรวจสอบว่าโฟลเดอร์อัปโหลดมีอยู่
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        // ย้ายไฟล์ที่อัปโหลด
        if (!move_uploaded_file($_FILES['attachment']['tmp_name'], $upload_file)) {
            echo "ข้อผิดพลาด: ไม่สามารถย้ายไฟล์";
            exit;
        }
    } else {
        $upload_file = null; // ไม่มีไฟล์ที่อัปโหลดหรือมีข้อผิดพลาดในการอัปโหลด
    }

    // เชื่อมต่อกับฐานข้อมูล
    // ตัวอย่างการเชื่อมต่อ: $conn = new mysqli('localhost', 'username', 'password', 'database');
    // ตรวจสอบการเชื่อมต่อ: if ($conn->connect_error) { die("การเชื่อมต่อล้มเหลว: " . $conn->connect_error); }

    // แทรกข้อมูลลงในฐานข้อมูล
    $sql = "INSERT INTO contact_form (first_name, last_name, email, message, attachment) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sssss', $first_name, $last_name, $email, $message, $upload_file);

    if ($stmt->execute()) {
        echo "ข้อความถูกส่งเรียบร้อยแล้ว";
    } else {
        echo "ข้อผิดพลาด: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>