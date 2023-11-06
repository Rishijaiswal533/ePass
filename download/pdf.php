<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel ePass</title>
    <style>
        .barcode {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 5px;
        }
        body {
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            height: 100%;
            background-color: #ccc;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .page {
            border: 5px solid #000;
            margin: 5%;
            padding: 5px;
            width: 60%;
            text-align: center;
            background-color: white;
        }
        h1 {
            font-size: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="page">
            <div class="header">
                <img src="logo.png" alt="Profile Image" width="80" style="margin: 1%;">
            </div>
            <?php
            $host = "localhost";
            $username = "root";
            $password = "";
            $database = "db";
            $conn = mysqli_connect($host, $username, $password, $database);

            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            if (isset($_GET['token'])) {
                $token = $_GET['token'];
                $table_name = '';

                $query = "SELECT * FROM y1 WHERE token = '$token'";
                $result = mysqli_query($conn, $query);

                if (mysqli_num_rows($result) > 0) {
                    $table_name = 'y1';
                } else {
                    $query = "SELECT * FROM y2 WHERE token = '$token'";
                    $result = mysqli_query($conn, $query);

                    if (mysqli_num_rows($result) > 0) {
                        $table_name = 'y2';
                    } else {
                        $query = "SELECT * FROM n2 WHERE token = '$token'";
                        $result = mysqli_query($conn, $query);

                        if (mysqli_num_rows($result) > 0) {
                            $table_name = 'n2';
                        }
                    }
                }

                if (!empty($table_name)) {
                    $query = "SELECT * FROM $table_name WHERE token = '$token'";
                    while ($row = mysqli_fetch_assoc($result)) {
                        $travel_pass = "Maharashtra Only";
                        if ($row['outofstate'] == "Yes") {
                            $travel_pass = "All Over India";
                        }
                        echo "<h1>Travel ePass - $travel_pass</h1>";
                        echo "<table>";
                        echo "<tr><th>Name</th><td>" . $row['name'] . "</td></tr>";
                        echo "<tr><th>From Date - To Date</th><td>" . $row['from_date'] . " - " . $row['to_date'] . "</td></tr>";
                        echo "<tr><th>Vehicle Number</th><td>" . $row['vehicle_num'] . "</td></tr>";
                        echo "<tr><th>Travel From - To</th><td>" . $row['starting_city'] . " - " . $row['end_city'] . "</td></tr>";
                        echo "<tr><th>Reason of Travel</th><td>" . $row['reason_for_travel'] . "</td></tr>";

                        $co_passengers = array_filter([$row['p1'], $row['p2'], $row['p3'], $row['p4'], $row['p5'], $row['p6']]);
                        echo "<tr><th>Name of Co-passengers</th><td>" . implode("<br>", $co_passengers) . "</td></tr>";
                        echo "</table>";
                    }
                }
            }
            ?>
            <div class="barcode" id="qr-code"></div>
            <p style="text-align:left">1. This is a computer generated QR code verifiable pass. Please carry original ID.proof<br>
2. The passengers shall comply with all Govt. orders issued in connection with COVID- 19<br>
3. All passengers should carry their Aadhaar Card & Medical certificate with them<br>
4. The emergency travel pass is issued as per information submitted online by applicant,
which if found false or misuse of pass, liable for legal prosecution<br>
5. The permission given will not have overriding effect on the powers of local/other state
police authorities to give directions as they deem fit in respect to lockdown</p>
            <button id="download-button" class="btn btn-success" onclick="printAsPDF()" style="background-color: green; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; display: block; margin-left:42%;">Download</button>
        </div>
    </div>
    <script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>
    <script>
        var qrcode = new QRCode(document.getElementById("qr-code"), {
            text: "<?php echo $token; ?>", // Use PHP to insert the token value
            width: 128,
            height: 128
        });
        function printAsPDF() {
            window.print(); // Trigger the browser's print dialog
        }
    </script>
    
</body>
</html>
