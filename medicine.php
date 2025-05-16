<!DOCTYPE html>
<html>

<head>
    <title>Buy Medicine Online</title>
    <link rel="stylesheet" href="a.css">
</head>

<body>
    <header>
        <h1>Buy Your Medicine Online</h1>
    </header>

    <main>
    <form method="POST" action="">
            <label for="medicine-name">Medicine Name:</label>
            <input type="text" id="medicine-name" name="medicine" required>

            <label for="quantity">Quantity:</label>
            <input type="number" id="quantity" name="quantity" min="1" required>

            <label for="delivery-address">Delivery Address:</label>
            <textarea id="delivery-address" name="delivery" required></textarea>

            <input type="submit" name="submit" value="SUBMIT">
        </form>
    </main>

    <footer>
        <p>&copy; 2023 Your Pharmacy</p>
    </footer>
    <?php
    // Check if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
        // Collect form data
        $medicine = $_POST['medicine'];
        $quantity = $_POST['quantity'];
        $delivery = $_POST['delivery'];
       

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
        $sql = "INSERT INTO medicine (medicine, quantity, delivery) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) {
            // Bind parameters to the query
            mysqli_stmt_bind_param($stmt, "sss", $medicine, $quantity, $delivery);

            // Execute the query
            if (mysqli_stmt_execute($stmt)) {
                echo "<div style='color: green; font-weight: bold;'>medicine ordered successful! .</div>";
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