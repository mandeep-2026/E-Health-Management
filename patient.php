<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Details</title>
    <link rel="stylesheet" href="a.css">
</head>

<body>
    <div class="patient-details">
        <h2>Patient Details</h2>
        <form method="POST" action="">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="age">Age:</label>
            <input type="number" id="age" name="age" required>

            <label for="gender">Gender:</label>
            male<input type="radio" id="male" name="gender" value="Male" required><br>
            female<input type="radio" id="female" name="gender" value="Female" required>
            
            <label for="bloodGroup">Blood Group:</label>
            <input type="text" id="bloodGroup" name="bloodgroup">

            <label for="address">Address:</label>
            <input type="text" id="address" name="address">

            <label for="phoneNumber">Phone Number:</label>
            <input type="tel" id="phoneNumber" name="number" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email"><br>

            <input type="submit" name="submit" value="SUBMIT">
        </form>
    </div>

    <?php
    // Check if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
        // Collect form data
        $name = $_POST['name'];
        $age = $_POST['age'];
        $gender = $_POST['gender'];
        $bloodgroup = $_POST['bloodgroup'];
        $address = $_POST['address'];
        $number = $_POST['number'];
        $email = $_POST['email'];

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
        $sql = "INSERT INTO patient (name, age, gender, bloodgroup, address, number, email) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) {
            // Bind parameters to the query
            mysqli_stmt_bind_param($stmt, "sssssss", $name, $age, $gender, $bloodgroup, $address, $number, $email);

            // Execute the query
            if (mysqli_stmt_execute($stmt)) {
                echo "<div style='color: green; font-weight: bold;'>Registration successful! Welcome, $name.</div>";
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
