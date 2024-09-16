<?php
// เปิดการแสดงข้อผิดพลาดเพื่อการดีบัก
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// ข้อมูลการเชื่อมต่อฐานข้อมูล
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

// ค่าที่ใช้สำหรับกรอง
$start_date = isset($_POST['start_date']) ? $_POST['start_date'] : '';
$end_date = isset($_POST['end_date']) ? $_POST['end_date'] : '';
$min_moisture = isset($_POST['min_moisture']) ? (int)$_POST['min_moisture'] : 0;
$max_moisture = isset($_POST['max_moisture']) ? (int)$_POST['max_moisture'] : 100;
$sort_by = isset($_POST['sort_by']) ? $_POST['sort_by'] : 'timestamp DESC';

// กำหนดตัวแปรสำหรับผลลัพธ์
$data = [];

if ($start_date && $end_date) {
    $sql = "SELECT moisture_value_1, moisture_value_2, moisture_value_3, timestamp FROM sensor_readings
            WHERE timestamp BETWEEN ? AND ?
            AND (moisture_value_1 BETWEEN ? AND ? OR moisture_value_2 BETWEEN ? AND ? OR moisture_value_3 BETWEEN ? AND ?)
            ORDER BY $sort_by";
    
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $start_date .= " 00:00:00";
        $end_date .= " 23:59:59";
        $stmt->bind_param('ssiiiiii', $start_date, $end_date, $min_moisture, $max_moisture, $min_moisture, $max_moisture, $min_moisture, $max_moisture);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moisture Data</title>
    <link rel="stylesheet" href="display1_data.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: url(imges/img77.png) no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #ffffff;
        }

        .container {
            width: 90%;
            border: 2px solid rgba(255, 255, 255, 0.2);
            max-width: 1000px;
            backdrop-filter: blur(8px);
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            max-height: 75vh;
            position: relative;
            margin: auto;
            text-align: center;
        }

       /* ปุ่มย้อนกลับ */
.back-button {
    display: inline-block;
    margin-bottom: 20px;
    padding: 12px 24px;
    background-color: rgba(255, 255, 255, 0.15);
    color: #ffffff;
    text-decoration: none;
    border-radius: 8px;
    font-size: 18px;
    transition: background-color 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease;
    position: absolute;
    top: 20px;
    left: 20px;
    border: 2px solid rgba(255, 255, 255, 0.25);
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.4);
}

.back-button:hover {
    background-color: rgba(230, 26, 26, 0.8);
    transform: scale(1.1);
    box-shadow: 0 6px 15px rgba(255, 0, 0, 0.5);
}
        h1 {
            position: sticky;
            top: 0;
            background-color: rgba(14, 10, 10, 0.7);
            color: #ffffff;
            margin-bottom: 30px;
            font-size: 28px;
            font-weight: 700;
            padding: 10px;
            border-bottom: 2px solid rgba(255, 255, 255, 0.3);
            z-index: 10;
        }

        table.data-table {
            width: 100%;
            border-collapse: collapse;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            background: rgba(255, 255, 255, 0.8);
            margin-left: auto;
            margin-right: auto;
            border-radius: 10px;
            overflow: hidden;
        }

        thead {
            display: block;
            width: 100%;
            background: linear-gradient(90deg, rgba(255, 223, 0, 1) 0%, rgba(255, 193, 7, 1) 100%);
            color: #000000;
        }

        tbody {
            display: block;
            width: 100%;
            max-height: 50vh;
            overflow-y: scroll;
            scrollbar-width: none;
        }

        tbody::-webkit-scrollbar {
            display: none;
        }

        th, td {
            padding: 15px;
            text-align: center;
            vertical-align: middle;
            border: 1px solid rgba(0, 0, 0, 0.1);
            word-wrap: break-word;
        }

        th {
            font-weight: 700;
        }

        tr {
            display: table;
            width: 100%;
            table-layout: fixed;
        }

        tr:hover {
            background-color: rgba(226, 226, 226, 0.8);
            cursor: pointer;
        }

        .no-data {
            text-align: center;
            padding: 10px;
            font-size: 16px;
            color: #666;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 6px;
            border: 1px solid #ddd;
            margin-top: 20px;
        }

        .color-box {
            width: 50px;
            height: 20px;
            display: inline-block;
            margin-right: 10px;
            border-radius: 5px;
            vertical-align: middle;
        }

        .very-high-moisture { background-color: rgba(75, 192, 192, 0.8); }
        .high-moisture { background-color: rgba(255, 159, 64, 0.8); }
        .moderate-moisture { background-color: rgba(255, 205, 86, 0.8); }
        .low-moisture { background-color: rgba(255, 99, 132, 0.8); }
    </style>
</head>
<body>
    <a href="view_data.php" class="back-button"><</a>
    <div class="container">
        <h1>Moisture Readings</h1>

        <!-- ช่องแสดงข้อมูล -->
        <?php if (!empty($data)): ?>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Moisture Value 1 (%)</th>
                        <th>Moisture Value 2 (%)</th>
                        <th>Moisture Value 3 (%)</th>
                        <th>Timestamp</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $row): ?>
                        <tr>
                            <td>
                                <div class="color-box <?php echo getColorClass($row['moisture_value_1']); ?>"></div>
                                <?php echo htmlspecialchars($row['moisture_value_1']); ?>
                            </td>
                            <td>
                                <div class="color-box <?php echo getColorClass($row['moisture_value_2']); ?>"></div>
                                <?php echo htmlspecialchars($row['moisture_value_2']); ?>
                            </td>
                            <td>
                                <div class="color-box <?php echo getColorClass($row['moisture_value_3']); ?>"></div>
                                <?php echo htmlspecialchars($row['moisture_value_3']); ?>
                            </td>
                            <td><?php echo htmlspecialchars($row['timestamp']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="no-data">No data available for the selected filters</div>
        <?php endif; ?>
    </div>
</body>
</html>

<?php
// ฟังก์ชันเพื่อกำหนดคลาสสีตามค่าความชื้น
function getColorClass($moisture_value) {
    if ($moisture_value >= 71) {
        return 'very-high-moisture';
    } elseif ($moisture_value >= 41) {
        return 'high-moisture';
    } elseif ($moisture_value >= 21) {
        return 'moderate-moisture';
    } else {
        return 'low-moisture';
    }
}
?>
