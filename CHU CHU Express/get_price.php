<?php
$conn = new mysqli('localhost', 'root', '', 'project_db');
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

$from_to = $_GET['from_to'];
$departure_arrival = $_GET['departure_arrival'];
$type = $_GET['type'];

$sql = "SELECT price FROM ticket_info WHERE from_to = '$from_to' AND departure_arrival = '$departure_arrival' AND type = '$type'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo $row['price'];
} else {
    echo "Ticket for this route/seat type is not avalilabe.";
}

$conn->close();
?>
