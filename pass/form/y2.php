<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Define your database connection parameters
$host = "localhost";
$username = "root";
$password = "";
$database = "db"; // Replace with your actual database name

// Connect to the database
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to generate a 17-digit token (3 alphabets + 14 numbers)
function generateToken() {
    $alphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $token = substr(str_shuffle($alphabet), 0, 3) . mt_rand(10000000000000, 99999999999999);
    return $token;
}

// Process the form data when it's submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Generate a 17-digit token
    $token = generateToken();

    // Extract data from the form
    $district = $_POST["district"];
    $name = $_POST["name"];
    $from_date = $_POST["from_date"];
    $to_date = $_POST["to_date"];
    $mobile = $_POST["mobile"];
    $reason_for_travel = $_POST["reason_for_travel"];
    $brief_reason = $_POST["brief_reason"];
    $type_of_vehicle = $_POST["type_of_vehicle"];
    $vehicle_num = $_POST["vehicle_num"];
    $current_address = $_POST["current_address"];
    $email = $_POST["email"];
    $starting_city = $_POST["starting_city"];
    $ending_city = $_POST["ending_city"];
    $num_of_passengers = $_POST["num_of_passengers"];
    $address_of_destination = $_POST["address_of_destination"];
    $containment_zone = $_POST["containment_zone"];

    // Initialize variables to store co-passenger data
    $p1 = "";
    $p2 = "";
    $p3 = "";
    $p4 = "";
    $p5 = "";
    $p6 = "";

    // Loop through each co-passenger container and store the data
    for ($i = 1; $i <= 6; $i++) {
        $passengerName = $_POST["passenger" . $i . "_name"];
        $passengerAge = $_POST["passenger" . $i . "_age"];
        $passengerGender = $_POST["passenger" . $i . "_gender"];
        $passengerAadhar = $_POST["passenger" . $i . "_aadhar"];

        // Store the co-passenger data in the appropriate variable
        if ($i == 1) {
            $p1 = "$passengerName , $passengerAge , $passengerGender , $passengerAadhar";
        } elseif ($i == 2) {
            $p2 = "$passengerName , $passengerAge , $passengerGender , $passengerAadhar";
        } elseif ($i == 3) {
            $p3 = "$passengerName , $passengerAge , $passengerGender , $passengerAadhar";
        } elseif ($i == 4) {
            $p4 = "$passengerName , $passengerAge , $passengerGender , $passengerAadhar";
        } elseif ($i == 5) {
            $p5 = "$passengerName , $passengerAge , $passengerGender , $passengerAadhar";
        } elseif ($i == 6) {
            $p6 = "$passengerName , $passengerAge , $passengerGender , $passengerAadhar";
        }
    }

    // Insert the data into the database, including co-passenger data
    $sql = "INSERT INTO y2 (token, district, name, from_date, to_date, mobile, reason_for_travel, 
    brief_reason, type_of_vehicle, vehicle_num, current_address, email, starting_city, ending_city, num_of_passengers, 
    address_of_destination, containment_zone, outofstate, status, p1, p2, p3, p4, p5, p6) 
    VALUES ('$token', '$district', '$name', '$from_date', '$to_date', '$mobile', '$reason_for_travel', 
    '$brief_reason', '$type_of_vehicle', '$vehicle_num', '$current_address', '$email', '$starting_city', '$ending_city', 
    '$num_of_passengers', '$address_of_destination', '$containment_zone', 'yes', 'waiting', '$p1', '$p2', '$p3', '$p4', '$p5', '$p6')";
    if ($conn->query($sql) !== TRUE) {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the database connection
    $conn->close();
}

// Redirect to the submit.html page with the token in the URL
if (!empty($token)) {
    header("Location: ../download/submit.html?token=" . urlencode($token));
    exit();
}
?>

