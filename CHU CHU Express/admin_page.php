<?php
session_start();

// Check if the user is logged in as admin
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'ADMIN') {
    header("Location: login.php"); // Redirect to login page if not logged in as admin
    exit();
}
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

        <form action="admin_ticket.php" method="post">
            <input type="submit" value="Add/Remove Train Data">
        </form>

        <form action="admin_user.php" method="post">
            <input type="submit" value="Modify User Data">
        </form>
    </div>
</body>

</html>
