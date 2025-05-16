<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Appointment Form</title>
    <link rel="stylesheet" href="a.css">
</head>

<body>
    <div class="container">
        <h1>Appointment Form</h1>
        <form  method="post">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required><br><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br><br>

            <label for="phone">Phone Number:</label>
            <input type="tel" id="phone" name="phone" required><br><br>

            <label for="date">Appointment Date:</label>
            <input type="date" id="date" name="date" required><br><br>

            <label for="time">Appointment Time:</label>
            <input type="time" id="time" name="time" required><br><br>

            <label for="doctor">Choose Doctor:</label>
            <select id="doctor" name="doctor" required>
                <option value="Dr. S">Dr. Smith</option>
                <option value="Dr. Patel">Dr. Patel</option>
                <option value="Dr. Lee">Dr. Lee</option>
            </select><br><br>

            <label for="symptoms">Symptoms:</label>
            <textarea id="symptoms" name="symptoms" rows="5" cols="40" required></textarea><br><br>

            <input type="submit" value="Book Appointment" name="submit">
        </form>
    </div>

    <?php
    // Check if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
        // Collect form data with sanitization
        $name = htmlspecialchars(trim($_POST['name']));
        $email = htmlspecialchars(trim($_POST['email']));
        $phone = htmlspecialchars(trim($_POST['phone']));
        $date = htmlspecialchars(trim($_POST['date']));
        $time = htmlspecialchars(trim($_POST['time']));
        $doctor = htmlspecialchars(trim($_POST['doctor']));
        $symptoms = htmlspecialchars(trim($_POST['symptoms']));

        // Database connection details
        $host = 'localhost';
        $user = 'root';
        $pass = '';
        $dbname = 'health';

        // Connect to MySQL
        $conn = mysqli_connect($host, $user, $pass, $dbname);

        // Check connection
        if (!$conn) {
            echo "<p style='color:red;'>Connection failed: " . mysqli_connect_error() . "</p>";
            exit;
        }

        // Prepare SQL query
        $sql = "INSERT INTO appointment (name, email, phone, date, time, doctor, symptoms) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) {
            // Bind parameters to the query
            mysqli_stmt_bind_param($stmt, "sssssss", $name, $email, $phone, $date, $time, $doctor, $symptoms);

            // Execute the query
            if (mysqli_stmt_execute($stmt)) {
                echo "<div style='color: green; font-weight: bold;'>Appointment successful! Welcome, " . htmlspecialchars($name) . ".</div>";
            } else {
                echo "<p style='color:red;'>Error inserting data: " . mysqli_error($conn) . "</p>";
            }

            // Close the statement
            mysqli_stmt_close($stmt);
        } else {
            echo "<p style='color:red;'>Failed to prepare the SQL statement.</p>";
        }

        // Close the connection
        mysqli_close($conn);
    }
    ?>
</body>

</html>