<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moisture Data</title>
    <link rel="stylesheet" href="view_data.css">
</head>
<body>
    
<a href="home.php" class="back-button">&lt;</a>
    <div class="container">
        
        <h1>Moisture Readings</h1>

        <!-- ฟอร์มกรองข้อมูล -->
        <form class="filter-form" method="POST" action="display1_data.php">
            <div class="form-group">
                <label for="start_date">Start Date:</label>
                <input type="date" id="start_date" name="start_date" required>
            </div>
            <div class="form-group">
                <label for="end_date">End Date:</label>
                <input type="date" id="end_date" name="end_date" required>
            </div>
            <div class="form-group">
                <label for="min_moisture">Min Moisture Value (%):</label>
                <input type="number" id="min_moisture" name="min_moisture" min="0" max="100" required>
            </div>
            <div class="form-group">
                <label for="max_moisture">Max Moisture Value (%):</label>
                <input type="number" id="max_moisture" name="max_moisture" min="0" max="100" required>
            </div>
            <button type="submit" class="submit-button">Filter Data</button>
        </form>
    </div>
</body>
</html>
