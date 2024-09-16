<?php
// กำหนดข้อมูลการเชื่อมต่อกับฐานข้อมูล
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "moisture_data";

// สร้างการเชื่อมต่อกับฐานข้อมูล
$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("การเชื่อมต่อไม่สำเร็จ: " . $conn->connect_error);
}

// รับพารามิเตอร์เซ็นเซอร์จากการร้องขอ
$sensor = isset($_GET['sensor']) ? intval($_GET['sensor']) : 1;

// ตรวจสอบว่าเซ็นเซอร์เป็น 1, 2, หรือ 3
if ($sensor < 1 || $sensor > 3) {
    $sensor = 1; // ตั้งค่าเป็นเซ็นเซอร์ 1 หากค่าไม่ถูกต้อง
}

// คำสั่ง SQL เพื่อดึงข้อมูล
$sql = "SELECT timestamp, moisture_value_$sensor AS moisture_value FROM sensor_readings ORDER BY timestamp DESC LIMIT 100";
$result = $conn->query($sql);

// สร้างอาร์เรย์เพื่อเก็บข้อมูล
$data = array();

if ($result->num_rows > 0) {
    // ดึงข้อมูลแต่ละแถวและเพิ่มไปยังอาร์เรย์
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

// ส่งข้อมูลในรูปแบบ JSON
header('Content-Type: application/json');
echo json_encode($data);

// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();
?>
