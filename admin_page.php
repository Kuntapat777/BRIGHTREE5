<?php
// ข้อมูลการเชื่อมต่อฐานข้อมูล
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "contact_db";

// สร้างการเชื่อมต่อ
$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("การเชื่อมต่อล้มเหลว: " . $conn->connect_error);
}

// ดึงข้อมูล
$sql = "SELECT * FROM contact_form";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>หน้าแอดมิน</title>
    <link rel="stylesheet" href="admin_page.css">
</head>
<body>
    <h1>ข้อมูลการส่งข้อความ</h1>
    <table>
        <thead>
            <tr>
                <th>ชื่อ</th>
                <th>นามสกุล</th>
                <th>อีเมล</th>
                <th>ข้อความ</th>
                <th>ไฟล์แนบ</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['first_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['last_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['message']); ?></td>
                    <td><?php echo $row['attachment'] ? "<a href='uploads/" . htmlspecialchars($row['attachment']) . "'>ดาวน์โหลด</a>" : "ไม่มีไฟล์"; ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>

<?php
$result->free();
$conn->close();
?>