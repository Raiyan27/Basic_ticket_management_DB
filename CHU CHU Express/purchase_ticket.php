<?php
session_start();

if (empty($_SESSION['username'])) {
    $_SESSION['message'] = 'Please log in to purchase a ticket.';
    header("Location: login.php"); // Redirect to the login page
    die();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $from_to = $_POST['from_to'];
    $departure_arrival = $_POST['departure_arrival'];
    $type = $_POST['type'];
    $price = $_POST['price'];
    $username = $_SESSION['username']; // Retrieve username from session

    $conn = new mysqli('localhost', 'root', '', 'project_db');
    if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO purchases (from_to, departure_arrival, type, price, username, time_of_purchase) VALUES (?, ?, ?, ?, ?, NOW())");
    $stmt->bind_param("sssss", $from_to, $departure_arrival, $type, $price, $username);

    if ($stmt->execute()) {
        echo "<script>
            alert('Ticket Purchased Successfully!');
            window.location.href = 'user_page.php';
            </script>";
    } else {
        echo "<script>
            alert('Error purchasing ticket. Please try again.');
            window.location.href = 'user_page.php';
            </script>";
    }

    $stmt->close();
    $conn->close();
}
?>
