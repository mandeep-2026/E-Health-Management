<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="a.css">
</head>

<body>
    <div class="container">
        <h1>Contact Us</h1>
        <form method="POST" action="">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="message">Message:</label>
            <textarea id="message" name="message" required></textarea>

            <input type="submit" name="submit" value="SUBMIT">
        </form>
    </div>

    <?php
    // Check if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
        // Collect and sanitize form data
        $name = htmlspecialchars(trim($_POST['name']));
        $email = htmlspecialchars(trim($_POST['email']));
        $message = htmlspecialchars(trim($_POST['message']));

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
        $sql = "INSERT INTO contact (name, email, message) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) {
            // Bind parameters to the query
            mysqli_stmt_bind_param($stmt, "sss", $name, $email, $message);

            // Execute the query
            if (mysqli_stmt_execute($stmt)) {
                echo "<div style='color: green; font-weight: bold;'>Thank you, $name! Your message has been successfully submitted.</div>";
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
