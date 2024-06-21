<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

$conn = new mysqli('localhost', 'root', '', 'project_db');
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

$query = "SELECT * FROM purchases WHERE username = '$username'";
$result = $conn->query($query);

if (!$result) {
    die("Error retrieving purchased tickets: " . $conn->error);
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchased Tickets</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .container {
            font-family: Arial, sans-serif;
            text-align: center;
            margin-top: 50px;
        }

        .purchase-ticket {
            border-collapse: collapse;
            width: 100%;
        }

        .purchase-ticket th, .purchase-ticket td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        .purchase-ticket th {
            background-color: #4CAF50;
            color: white;
        }

        .no-tickets {
            font-size: 24px;
            font-weight: bold;
            color: #4CAF50;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Your Purchased Tickets</h1>
        <?php if ($result->num_rows > 0) : ?>
            <table class="purchase-ticket">
                <tr>
                    <th>From-To</th>
                    <th>Departure-Arrival</th>
                    <th>Type</th>
                    <th>Price</th>
                    <th>Time of Purchase</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()) : ?>
                    <tr>
                        <td><?php echo $row['from_to']; ?></td>
                        <td><?php echo $row['departure_arrival']; ?></td>
                        <td><?php echo $row['type']; ?></td>
                        <td><?php echo $row['price']; ?></td>
                        <td><?php echo $row['time_of_purchase']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else : ?>
            <div class="no-tickets">NO TICKETS PURCHASED</div>
        <?php endif; ?>
    </div>
</body>

</html>


