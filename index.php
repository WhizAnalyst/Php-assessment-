<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Polling Unit Results</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        h2.header {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
    </style>
</head>
<body>
    <center><h2 class='header'>Result for any individual polling unit</h2></center>
    <?php
    session_start();
    include('db.php');

    $sql = "SELECT * FROM polling_unit";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "<table>
                <tr>
                    <th>Unique ID</th>
                    <th>Polling Unit ID</th>
                    <th>Ward ID</th>
                    <th>LGA ID</th>
                    <th>Unique Ward ID</th>
                    <th>Polling Unit Number</th>
                    <th>Polling Unit Name</th>
                    <th>Polling Unit Description</th>
                    <th>Latitude</th>
                    <th>Longitude</th>
                    <th>Entered By User</th>
                    <th>Date Entered</th>
                    <th>IP Address</th>
                </tr>";
        while($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>".$row["uniqueid"]."</td>
                    <td>".$row["polling_unit_id"]."</td>
                    <td>".$row["ward_id"]."</td>
                    <td>".$row["lga_id"]."</td>
                    <td>".$row["uniquewardid"]."</td>
                    <td>".$row["polling_unit_number"]."</td>
                    <td>".$row["polling_unit_name"]."</td>
                    <td>".$row["polling_unit_description"]."</td>
                    <td>".$row["lat"]."</td>
                    <td>".$row["long"]."</td>
                    <td>".$row["entered_by_user"]."</td>
                    <td>".$row["date_entered"]."</td>
                    <td>".$row["user_ip_address"]."</td>
                </tr>";
        }
        echo "</table>";
    } else {
        echo "0 results";
    }
    ?>
</body>
</html>
