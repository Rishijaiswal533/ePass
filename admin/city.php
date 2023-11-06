<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
        }

        h1 {
            text-align: center;
        }

        table {
            margin: 0 auto;
            border-collapse: collapse;
            width: 100%; /* Set table width to 100% */
            background-color: white;
            border: 1px solid #ddd;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        th, td {
            text-align: center;
            padding: 10px;
            border: 1px solid #ddd;
        }

        th {
            background-color: #2c5686;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .view-button {
            background-color: green;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }

        .view-button:hover {
            background-color: darkgreen;
        }
    </style>
</head>
<body>
    <?php
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

    // Define the tables to fetch data from
    $tables = ['y1', 'y2', 'emg', 'n2'];

    // Initialize an empty array to store the results
    $resultsArray = [];

    // Fetch data from each table
    foreach ($tables as $table) {
        // Query the database to retrieve all data from each table
        $sql = "SELECT * FROM $table";
        $results = mysqli_query($conn, $sql);

        if ($results) {
            // Fetch and store the results in the array
            while ($row = mysqli_fetch_assoc($results)) {
                $resultsArray[] = $row;
            }
            mysqli_free_result($results); // Free the result set
        } else {
            echo "Error in query for $table: " . mysqli_error($conn);
        }
    }

    // Display the results
    echo "<h1>All Data</h1>";
    echo "<table style='width: 100%;'>"; // Set table width to 100%
    
    // Create table headers based on column names from the first row of data
    if (!empty($resultsArray)) {
        echo "<tr>";
        foreach (array_keys($resultsArray[0]) as $column) {
            echo "<th>$column</th>";
        }
        echo "<th>Action</th>"; // Add an extra column for the "View" button
        echo "</tr>";
    }
    
    foreach ($resultsArray as $row) {
        echo "<tr>";
        foreach ($row as $value) {
            echo "<td>" . $value . "</td>";
        }
        // Pass the token as a query parameter to view.php when the "View" button is clicked
        echo "<td><button class='view-button' onclick='viewToken(\"{$row['token']}\")'>View</button></td>";
        echo "</tr>";
    }
    echo "</table";

    // Close the database connection
    mysqli_close($conn);
    ?>
   
</body>
<script>
        function viewToken(token) {
            // Redirect to view.php with the token as a query parameter
            window.location.href = "view.php?token=" + token;
        }
    </script>
</html>
