<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Connection with Alerts</title>
    <link rel="stylesheet" href="a.css">
    <script>
        // Function to show alert messages
        function showAlert(message) {
            alert(message);
        }
    </script>
</head>

<body>
    <h1>LOGIN</h1>
    <form action="#" method="POST">
        E-mail: <input type="email" name="email" required><br><br>
        Password: <input type="password" name="password" required><br><br>
        <input type="submit" name="submit" value="Login">
        <br><br>
        New User? <a href="register.php">Register here</a>
    </form>

    <?php
    // Check if the form is submitted
    if (isset($_POST['submit'])) {
        // Collect form data
        $email = $_POST['email'];
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
        } else {
            // Check if the user exists in the database
            $sql = "SELECT * FROM register WHERE email = ? AND password = ?";
            $stmt = mysqli_prepare($conn, $sql);

            if ($stmt) {
                // Bind parameters to the query
                mysqli_stmt_bind_param($stmt, "ss", $email, $password);

                // Execute the query
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);

                // Check if any row matches
                if (mysqli_num_rows($result) == 1) {
                    echo "<script>showAlert('Login successful! Redirecting...');</script>";
                    echo '<meta http-equiv="refresh" content="5; url=http://localhost:3000/index.html" />';
                } else {
                    echo "<p style='color:red;'>Login failed: Invalid email or password.</p>";
                }

                // Close the statement
                mysqli_stmt_close($stmt);
            } else {
                echo "<p style='color:red;'>Failed to prepare the login statement.</p>";
            }

            // Close the connection
            mysqli_close($conn);
        }
    }
    ?>
</body>

</html>
