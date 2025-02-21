<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $conn = mysqli_connect('localhost', 'root', '', 'newsagg');

    if (!$conn) {
        die("Database connection failed: " . mysqli_connect_error());
    }

    $query = "SELECT * FROM users WHERE email = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['username'] = $username;
        header('Location: ' . ($row["is_admin"] == 1 ? 'dashboardAdmin.php' : 'dashboard.php'));
        exit();
    } else {
        echo "<p>Invalid username or password.</p>";
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form method="post">
        <label for="username">Email:</label>
        <input type="text" id="username" name="username" required>
        <br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br>

        <input type="submit" value="Login">
    </form>

    <p>No account? <a href="register.php">Register here</a></p>
</body>
</html>
