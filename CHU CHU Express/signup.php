<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $repassword = $_POST['repassword'];
    $phone = $_POST['phone'];

    // Validate if passwords match
    if ($password !== $repassword) {
        echo "<script>
                alert('Passwords do not match!');
                window.location.href = 'signup.php';
              </script>";
        exit();
    }

    $conn = mysqli_connect('localhost', 'root', '', 'project_db');
    if ($conn->connect_error) {
        die('Check your connection' . $conn->connect_error);
    } else {
        // Check if username already exists
        $check_query = "SELECT * FROM users WHERE username = '$username'";
        $result = $conn->query($check_query);

        if ($result->num_rows > 0) {
            echo "<script>
                    alert('Username already exists. Please choose a different username.');
                    window.location.href = 'signup.php';
                  </script>";
            exit(); // Stop further execution
        } else {
            // Insert new user
            $stmt = $conn->prepare("INSERT INTO users (username, pass, cpass, phone) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $username, $password, $repassword, $phone);
            $stmt->execute();
            echo "<script>
                    alert('Account created successfully!');
                    window.location.href = 'login.php';
                  </script>";
            $stmt->close();
        }

        $conn->close();
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chu Chu Express - Sign Up</title>
    <link rel="stylesheet" href="styles.css"> 
</head>
<body>
    <div class="container">
        <h1>Chu Chu Express</h1>
        <form action="" method="post" onsubmit="return validateForm()">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" placeholder="User name" required>
            <br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Enter password" required>
            <br>
            <label for="repassword">Re-enter Password:</label>
            <input type="password" id="repassword" name="repassword" placeholder="Confirm password" required>
            <br>
            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone" placeholder="Phone number" required>
            <br>

            <input type="submit" value="Submit">

            
        </form>
    </div>

    <script>
        function validateForm() {
            var password = document.getElementById("password").value;
            var rePassword = document.getElementById("repassword").value;

            if (password !== rePassword) {
                alert("Passwords do not match!");
                return false; // Prevent form submission
            }

            return true; // Allow form submission
        }
    </script>


    <div class="signup-text">
        <p>Already have an account?</p><p></p> <a href="login.php">Log in here</a></p>
    </div>
</body>
</html>
