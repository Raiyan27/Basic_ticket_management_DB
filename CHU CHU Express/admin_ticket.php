<?php
session_start();

// Check if the user is logged in as admin
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'ADMIN') {
    header("Location: login.php"); 
    exit();
}

$conn = mysqli_connect('localhost', 'root', '', 'project_db');
if ($conn->connect_error) {
    die('Check your connection' . $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_row'])) {
    $from_to = $_POST['from_to'];
    $departure_arrival = $_POST['departure_arrival'];
    $price = $_POST['price'];
    $type = $_POST['type'];

   
    $check_query = "SELECT * FROM ticket_info WHERE from_to = '$from_to' AND departure_arrival = '$departure_arrival' AND type = '$type'";
    $check_result = mysqli_query($conn, $check_query);

    if ($check_result && mysqli_num_rows($check_result) > 0) {
        echo "<script>alert('Data already exists!');</script>";
    } else {
        
        $stmt = $conn->prepare("INSERT INTO ticket_info (from_to, departure_arrival, price, type) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssds", $from_to, $departure_arrival, $price, $type);
        $stmt->execute();
        $stmt->close();

        echo "<script>alert('Data inserted successfully');</script>";
    }
}


$ticket_info_query = "SELECT * FROM ticket_info";
$ticket_info_result = mysqli_query($conn, $ticket_info_query);
$ticket_info_rows = mysqli_fetch_all($ticket_info_result, MYSQLI_ASSOC);


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['remove_row'])) {
    $selected_row = $_POST['selected_row'];

    list($from_to, $departure_arrival, $type) = explode("|", $selected_row);

    $stmt = $conn->prepare("DELETE FROM ticket_info WHERE from_to = ? AND departure_arrival = ? AND type = ?");
    $stmt->bind_param("sss", $from_to, $departure_arrival, $type);
    $stmt->execute();
    $stmt->close();

    header("Location: admin_page.php"); 
    exit();
}


$query = "SELECT from_to, departure_arrival, type FROM ticket_info";
$result = mysqli_query($conn, $query);
$options = "";

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $options .= "<option value='{$row['from_to']}|{$row['departure_arrival']}|{$row['type']}'>{$row['from_to']} - {$row['departure_arrival']} - {$row['type']}</option>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="container">
        <h1>Welcome, <?php echo $_SESSION['username']; ?>!</h1>

        <h2>Ticket Info</h2>
        <table class="admin-table">
            <tr>
                <th>From-To</th>
                <th>Departure-Arrival</th>
                <th>Price</th>
                <th>Type</th>
            </tr>
            <?php foreach ($ticket_info_rows as $row) : ?>
                <tr>
                    <td><?php echo $row['from_to']; ?></td>
                    <td><?php echo $row['departure_arrival']; ?></td>
                    <td><?php echo $row['price']; ?></td>
                    <td><?php echo $row['type']; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>

        <h2>Add New Train Data</h2>
        
        <form action="" method="post" class="add-form">
            <label for="from_to">From-To:</label>
            <input type="text" id="from_to" name="from_to" required>
            <br>
            <label for="departure_arrival">Departure-Arrival:</label>
            <input type="text" id="departure_arrival" name="departure_arrival" required>
            <br>
            <label for="price">Price:</label>
            <input type="number" id="price" name="price" required>
            <br>
            <label for="type">Type:</label>
            <select id="type" name="type" required>
                <option value="VIP">VIP</option>
                <option value="Business">Business</option>
                <option value="Economy">Economy</option>
            </select>
            <br>
            <input type="submit" name="add_row" value="Add Row" class="add-button">
        </form>

        <script>
            function confirmRemove() {

        return confirm("Are you sure you want to remove this row?");
    }

    function showRemoveSuccessAlert() {
        alert("Removed successfully!");
    }
</script>
</script>

<h2>Remove Existing Train Data</h2>
        <!-- Remove row form with dropdown menu -->
        <form action="" method="post" class="remove-form" onsubmit="return confirmRemove();">
            <label for="selected_row">Select Train Data To Remove:</label>
            <select id="selected_row" name="selected_row">
                <?php echo $options; ?>
            </select>
            <br>
            <input type="submit" name="remove_row" value="Remove" class="remove-button">
        </form>
    </div>
</body>

</html>
