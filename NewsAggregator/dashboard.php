<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION["username"])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

$username = $_SESSION["username"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - News Aggregator</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }
        .navbar {
            background-color: #007bff;
        }
        .navbar a {
            color: white !important;
        }
        .dashboard-container {
            max-width: 900px;
            margin: 50px auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .welcome-msg {
            font-size: 1.5rem;
            font-weight: bold;
            color: #333;
        }
        .card {
            margin-top: 20px;
        }
        .logout-btn {
            margin-top: 20px;
        }
    </style>
</head>
<body>

<!-- Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="#">News Aggregator</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="news_app.php">Go to News</a>
                </li>
                <li class="nav-item">
                    <form method="POST" action="logout.php">
                        <button type="submit" class="btn btn-danger btn-sm">Log Out</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Dashboard Content -->
<div class="dashboard-container">
    <h2 class="text-center welcome-msg">Welcome, <?php echo htmlspecialchars($username); ?>!</h2>
    
    <div class="row">
        <!-- News Section -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Latest News</h4>
                    <p>Click below to read the latest news on topics of your interest.</p>
                    <a href="news_app.php" class="btn btn-primary">Go to News</a>
                </div>
            </div>
        </div>

        <!-- Profile Section -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Your Profile</h4>
                    <p>Manage your preferences and account settings.</p>
                    <a href="profile.php" class="btn btn-secondary">View Profile</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Logout Button -->
    <form method="POST" action="logout.php" class="logout-btn text-center">
        <button type="submit" class="btn btn-danger">Log Out</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
