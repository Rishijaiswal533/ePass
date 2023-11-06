<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection setup (Replace with your database connection details)
    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "db";
    $conn = mysqli_connect($host, $username, $password, $database);

    // Check if the connection was successful
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Get form data
    $district = $_POST["district"];
    $name = $_POST["name"];
    $serviceType = $_POST["service-type"];
    $vehicleNumber = $_POST["vehicle-number"];
    $mobileNumber = $_POST["mobile-number"];
    $email = $_POST["email"];
    $fromDate = $_POST["from-date"];
    $toDate = $_POST["to-date"];
    $reason = $_POST["reason"];
    $address = $_POST["address"];
    $token = $_POST["token"];
    $status = "waiting"; // Default status

    // SQL query to insert data into the database
    $sql = "INSERT INTO emg (district, name, service_type, vehicle_number, mobile_number, email, from_date, to_date, reason, address, token, status)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'ssssssssssss', $district, $name, $serviceType, $vehicleNumber, $mobileNumber, $email, $fromDate, $toDate, $reason, $address, $token, $status);

    if (mysqli_stmt_execute($stmt)) {
        // Redirect to submit.html with the token as a query parameter
        $redirectURL = "../download/submit.html?token=" . urlencode($token);
        header("Location: " . $redirectURL);
        exit(); // Stop further execution
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
    echo "Token: " . $token . "<br>";
    $redirectURL = "../download/submit.html?token=" . urlencode($token);
    echo "Redirect URL: " . $redirectURL . "<br>";
    
    // Close the statement and database connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>
