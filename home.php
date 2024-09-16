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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Webpage</title>
    <link rel="stylesheet" href="home.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
</head>
<body>
    <header>
        <a href="#" class="logo">
            <img src="imges/img9.png" alt="Logo">
        </a>
        <nav>
            <ul class="navlist">
                <li><a href="moisture_selection.html">Moisture</a></li>
                <li><a href="moisture.html">Moisture Graph</a></li>
                <li><a href="view_data.php">View Data</a></li>
                <li><a href="weather.html">Weather Data</a></li>
                <li><a href="contact.html">Contact</a></li>
                <li class="dropdown">     
                    <div class="right-content">
                        <!-- แสดงชื่อผู้ใช้ -->
                        <a href="#" class="nav-btn"><?php echo htmlspecialchars($username); ?></a>
                    </div>
                    <div class="dropdown-content">
                        <a href="profile.php">Profile</a>
                        <a href="#settings">Settings</a>
                        <a href="index.html">Logout</a>
                    </div>
                </li>
            </ul>
        </nav>
    </header>

    <section class="hero">
        <div class="hero-text" data-aos="fade-right" data-aos-duration="1400">
            <h5>Welcome, <?php echo htmlspecialchars($username); ?>!</h5>
            <h1 data-aos="zoom-in-left" data-aos-duration="1400" data-aos-delay="200">
                <span class="bright">BRIGHT</span> <span class="tree">TREE</span>
            </h1>
            <p data-aos="fade-right" data-aos-duration="1400" data-aos-delay="300">
                Let us take care of your trees.
            </p>
        </div>

        <div class="hero-img" data-aos="zoom-in" data-aos-duration="1400">
            <img src="imges/img100.png">
        </div>
    </section>

    <div class="icons">
        <a href="#" data-aos="fade-in" data-aos-duration="1400" data-aos-delay="600"><i class="ri-facebook-circle-fill"></i></a>
        <a href="#" data-aos="fade-right" data-aos-duration="1400" data-aos-delay="700"><i class="ri-youtube-fill"></i></a>
        <a href="#" data-aos="fade-right" data-aos-duration="1400" data-aos-delay="800"><i class="ri-twitter-x-line"></i></a>
    </div>

    <script src="home.js"></script>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init({
            offset: 1,
        });
    </script>
</body>
</html>
