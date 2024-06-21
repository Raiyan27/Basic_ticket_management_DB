<?php
session_set_cookie_params(0);
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $conn = mysqli_connect('localhost', 'root', '', 'project_db');
    if ($conn->connect_error) {
        die('Check your connection' . $conn->connect_error);
    }

    if (!empty($username) && !empty($password)) {
        // Read from database
        $query = "SELECT * FROM users WHERE username = '$username' AND pass = '$password'";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $user_data = mysqli_fetch_assoc($result);

            if ($username === 'ADMIN') {
                $_SESSION['username'] = 'ADMIN';
                echo "<script>
                    alert('WELCOME ADMIN');
                    window.location.href = 'admin_page.php';
                    </script>";
                die;
            } else {
                $_SESSION['username'] = $username; 
                echo "<script>
                    alert('Login successful! Welcome');
                    window.location.href = 'user_page.php';
                    </script>";
                die;
            }
            
        } else {
            echo "<script>
            alert('Login Failed! Username/Password is incorrect!');
            window.location.href = 'login.php';
            </script>";
        }
    } else {
        echo "<script>
            alert('Wrong username or password!');
            window.location.href = 'login.php';
            </script>";
    }
}

session_destroy();
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chu Chu Express - Login</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="welcome-message">
        <h1>Welcome to Chu Chu Express!</h1>
    </div>
    <div class="container">
        <h1>Login To Proceed</h1>
        <form action="" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" placeholder="User name" required>
            <br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Password" required>
            <br>
            <input type="submit" value="Submit">
        </form>
    </div>
    <div class="signup-text">
        <p>Don't have an account?</p> 
        <p>Sign up instead!</p>
        <a href="signup.php">Sign Up</a>
    </div>
</body>
</html>
