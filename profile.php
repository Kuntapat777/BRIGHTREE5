<?php
// เริ่มต้นเซสชัน
session_start();

// ตรวจสอบว่าผู้ใช้เข้าสู่ระบบแล้วหรือไม่
if (!isset($_SESSION['username'])) {
    // ถ้าไม่มีผู้ใช้เข้าสู่ระบบ ให้เปลี่ยนไปยังหน้า login
    header('Location: login.php');
    exit();
}

// ดึงชื่อผู้ใช้จากเซสชัน
$username = $_SESSION['username'];

// เชื่อมต่อฐานข้อมูล (เปลี่ยนค่าพารามิเตอร์ตามที่คุณใช้)
$servername = "localhost";
$dbname = "user_management";
$dbuser = "root";
$dbpass = "";

$conn = new mysqli($servername, $dbuser, $dbpass, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ดึงข้อมูลของผู้ใช้จากฐานข้อมูล
$sql = "SELECT full_name, email, phone_number FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // แสดงข้อมูลผู้ใช้
    $user = $result->fetch_assoc();
} else {
    // ถ้าไม่มีข้อมูลผู้ใช้
    echo "No user data found.";
}
$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="profile.css">
</head>
<body>
    <section class="profile">
        <h1>Profile Information</h1>
        <form>
            <div class="profile-field">
                <label for="full_name">Full Name:</label>
                <input type="text" id="full_name" value="<?php echo htmlspecialchars($user['full_name']); ?>" disabled>
            </div>
            <div class="profile-field">
                <label for="username">Username:</label>
                <input type="text" id="username" value="<?php echo htmlspecialchars($username); ?>" disabled>
            </div>
            <div class="profile-field">
                <label for="email">Email:</label>
                <input type="email" id="email" value="<?php echo htmlspecialchars($user['email']); ?>" disabled>
            </div>
            <div class="profile-field">
                <label for="phone_number">Phone Number:</label>
                <input type="text" id="phone_number" value="<?php echo htmlspecialchars($user['phone_number']); ?>" disabled>
            </div>
        </form>
    </section>

    <script src="profile.js"></script>
</body>
</html>
