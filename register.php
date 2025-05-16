<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="a.css">
    <script>
        // Function to show alert messages
        function showAlert(message) {
            alert(message);
        }
    </script>
</head>

<body>
    <style>
        #address {
            width: 60%;
        }
        
        #imagepart {
            border: 2px solid black;
            border-radius: 5px;
            padding: 10px;
            width: 60%;
        }
        
        #role {
            border: 2px solid black;
            border-radius: 5px;
            padding: 5px;
            width: 60%;
        }
    </style>
    <div id="headerSection">
        <h1><em>REGISTER NOW</em></h1>
    </div>
    <hr>
    <div id="bodySection">
        <form action="" method="POST">
            <input type="text" name="name" placeholder="Enter name" required>
            <input type="tel" name="mobile" maxlength="10" placeholder="Enter Mobile" required><br><br>
            <input type="email" name="email" placeholder="Enter email" required><br><br>
            <input type="password" name="password" placeholder="Password" required><br><br>
            <input type="submit" name="submit" value="Register">
            <br><br>
            Already a User? <a href="k.php">Login here</a>
        </form>
    </div>
    <?php
    // Check if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
        // Collect form data
        $name = $_POST['name'];
        $email = $_POST['email'];
        $mobile = $_POST['mobile'];
        $password = $_POST['password'];

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
        $sql = "INSERT INTO register (name, email, mobile, password) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) {
            // Bind parameters to the query
            mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $mobile, $password);

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
