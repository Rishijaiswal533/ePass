<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $district = $_POST['district'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($district != "" && $email != "" && $password != "") {
       $host = "localhost";
$username = "id21514481_root";
$password = "Rishi@123";
$database = "id21514481_db";
$conn = mysqli_connect($host, $username, $password, $database);

// Check if the connection was successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

        $sql = "SELECT password FROM users WHERE district = ? AND email = ?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("ss", $district, $email);
            $stmt->execute();
            $stmt->bind_result($dbPassword);
            $stmt->fetch();
            $stmt->close();

            if ($password === $dbPassword) {
                // Redirect to user1.html on successful login
                header("Location: admin1.php");
                exit();
            } else {
                echo "Invalid email or password";
            }
        }

        $conn->close();
    } else {
        echo "Please fill in all fields.";
    }
}
?>
