<?php



session_start();

// Check if the user is not logged in, then redirect to login page
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$conn = new mysqli('localhost', 'root', '', 'project_db');
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

$from_to_options = "";
$departure_arrival_options = "";
$type_options = "";


$conn = new mysqli('localhost', 'root', '', 'project_db');
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

$from_to_options = "";
$departure_arrival_options = "";
$type_options = "";

// Fetch options for 'from_to' dropdown
$result = $conn->query("SELECT DISTINCT from_to FROM ticket_info");
while ($row = $result->fetch_assoc()) {
    $from_to_options .= "<option>{$row['from_to']}</option>";
}

// Fetch options for 'departure_arrival' dropdown
$result = $conn->query("SELECT DISTINCT departure_arrival FROM ticket_info");
while ($row = $result->fetch_assoc()) {
    $departure_arrival_options .= "<option>{$row['departure_arrival']}</option>";
}

// Fetch options for 'type' dropdown
$result = $conn->query("SELECT DISTINCT type FROM ticket_info");
while ($row = $result->fetch_assoc()) {
    $type_options .= "<option>{$row['type']}</option>";
}

// Fetch data from ticket_info table
$table_data = "";
$result = $conn->query("SELECT * FROM ticket_info");
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $table_data .= "<tr>
                            <td>{$row['from_to']}</td>
                            <td>{$row['departure_arrival']}</td>
                            <td>{$row['type']}</td>
                            <td>{$row['price']}</td>
                        </tr>";
    }
} else {
    $table_data = "<tr><td colspan='4'>NO TICKETS AVAILABLE</td></tr>";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chu Chu Express</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .ticket-info-table {
            width: 100%;
            border-collapse: collapse;
        }

        .ticket-info-table th, .ticket-info-table td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        .ticket-info-table th {
            background-color: #4CAF50;
            color: white;
        }

        .ticket-info-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .ticket-info-table tr:hover {
            background-color: #ddd;
        }

    </style>
</head>

<body>
    <div class="header">
        <h1 class="header-title">Chu Chu Express</h1>
    </div>
    <div class="container">
        <table class="ticket-info-table">
            <tr>
                <th>From-To</th>
                <th>Departure-Arrival</th>
                <th>Type</th>
                <th>Price</th>
            </tr>
            <?php echo $table_data; ?>
        </table>
        <form action="purchase_ticket.php" method="post">
            <label for="from_to">From-To:</label>
            <select id="from_to" name="from_to">
                <?php echo $from_to_options; ?>
            </select>
            <br>
            <label for="departure_arrival">Departure-Arrival:</label>
            <select id="departure_arrival" name="departure_arrival">
                <?php echo $departure_arrival_options; ?>
            </select>
            <br>
            <label for="type">Type:</label>
            <select id="type" name="type">
                <?php echo $type_options; ?>
            </select>
            <br>
            <label for="price">Price:</label>
            <input type="text" id="price" name="price" readonly>
            <br>
            <input type="submit" value="Purchase Ticket">
        </form>
    </div>

    <script>
        document.getElementById('from_to').addEventListener('change', updatePrice);
        document.getElementById('departure_arrival').addEventListener('change', updatePrice);
        document.getElementById('type').addEventListener('change', updatePrice);

        function updatePrice() {
            var from_to = document.getElementById('from_to').value;
            var departure_arrival = document.getElementById('departure_arrival').value;
            var type = document.getElementById('type').value;

            // Make an AJAX request to fetch the price
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById('price').value = this.responseText;
                }
            };
            xhttp.open("GET", "get_price.php?from_to=" + from_to + "&departure_arrival=" + departure_arrival + "&type=" + type, true);
            xhttp.send();
        }
    </script>
</body>

</html>
