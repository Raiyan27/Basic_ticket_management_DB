
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Chu Chu Express</title>
    <link rel="stylesheet" href="styles.css">

    <script>
    window.addEventListener('beforeunload', function() {
    var xhttp = new XMLHttpRequest();
    xhttp.open("GET", "logout.php", true);
    xhttp.send();
    });
    
</script>


</head>
<body>
    <div class="container">
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

            if(isset($_SESSION['username'])){
                $username = $_SESSION['username'];
                echo "<h2>Welcome, $username!</h2>";
            }
            else{
                header("Location: customer-login.html");
                die();
            }
        ?>

        <div class="options">
            <a href="ticket_info.php" class="user-type-button">Purchase Tickets</a>
            <a href="purchased_ticket.php" class="user-type-button">View Purchased Tickets</a>
        </div>
    </div>
</body>
</html>
