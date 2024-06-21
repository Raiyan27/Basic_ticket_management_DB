<?php
session_start();

// Check if the user is logged in as admin
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'ADMIN') {
    header("Location: login.php"); // Redirect to login page if not logged in as admin
    exit();
}

$conn = mysqli_connect('localhost', 'root', '', 'project_db');
if ($conn->connect_error) {
    die('Check your connection' . $conn->connect_error);
}

// Handle form submission for updating user data
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_user'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $re_enter_password = $_POST['re_enter_password'];
    $phone = $_POST['phone'];

    // Check if passwords match
    if ($password !== $re_enter_password) {
        echo "<script>alert('Passwords don\'t match!');</script>";
    } else {
        // Update user data and save re-entered password in cpass column
        $update_query = "UPDATE users SET pass = '$password', cpass = '$re_enter_password', phone = '$phone' WHERE username = '$username'";
        mysqli_query($conn, $update_query);
        echo "<script>alert('User data updated successfully');</script>";
    }
}

// Get users data
$users_query = "SELECT * FROM users";
$users_result = mysqli_query($conn, $users_query);
$users_rows = mysqli_fetch_all($users_result, MYSQLI_ASSOC);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin User Page</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="container">
        <h1>Welcome, <?php echo $_SESSION['username']; ?>!</h1>

        <h2>User Data</h2>
        <table class="admin-table">
            <tr>
                <th>Username</th>
                <th>Password</th>
                <th>Phone</th>
            </tr>
            <?php foreach ($users_rows as $row) : ?>
                <tr>
                    <td><?php echo $row['username']; ?></td>
                    <td><?php echo $row['pass']; ?></td>
                    <td><?php echo $row['phone']; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>

        <h2>Modify User Data</h2>
        <form action="" method="post" class="modify-form">
            <label for="username">Username:</label>
            <select id="username" name="username">
                <?php foreach ($users_rows as $row) : ?>
                    <option value="<?php echo $row['username']; ?>"><?php echo $row['username']; ?></option>
                <?php endforeach; ?>
            </select>
            <br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <br>
            <label for="re_enter_password">Re-enter Password:</label>
            <input type="password" id="re_enter_password" name="re_enter_password" required>
            <br>
            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone" required>
            <br>
            <input type="submit" name="update_user" value="Update User Data" class="update-button">
        </form>
    </div>
</body>

</html>
