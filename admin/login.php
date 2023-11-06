<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $district = $_POST['district'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($district != "" && $email != "" && $password != "") {
        $db_host = 'localhost';
        $db_user = 'root';
        $db_pass = '';
        $db_name = 'token_status_db';

        $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
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
