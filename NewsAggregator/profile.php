<?php
session_start();
include("connect.php");

// Check if user is logged in
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION["username"];

// Fetch user ID
$user_query = "SELECT ID FROM users WHERE email = ?";
$stmt = mysqli_prepare($conn, $user_query);
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
$user_result = mysqli_stmt_get_result($stmt);

if ($user_row = mysqli_fetch_assoc($user_result)) {
    $user_id = $user_row["ID"];
} else {
    die("User not found.");
}

// Search functionality
$search_query = isset($_GET["search"]) ? trim($_GET["search"]) : "";

// Sorting functionality
$sort_by = isset($_GET["sort_by"]) ? $_GET["sort_by"] : "date_saved_desc"; // Default to most recently saved

$valid_sorts = [
    "title_asc" => "title ASC",
    "date_saved_desc" => "id DESC", // Assuming "id" represents the order of saving
    "published_desc" => "published_at DESC"
];

$order_by = $valid_sorts[$sort_by] ?? "id DESC"; // Default sorting

// Fetch saved articles with optional search filter
if ($search_query) {
    $articles_query = "SELECT * FROM saved_articles WHERE user_id = ? 
                       AND (title LIKE ? OR description LIKE ?) 
                       ORDER BY $order_by";
    $search_param = "%" . $search_query . "%";
    $stmt = mysqli_prepare($conn, $articles_query);
    mysqli_stmt_bind_param($stmt, "iss", $user_id, $search_param, $search_param);
} else {
    $articles_query = "SELECT * FROM saved_articles WHERE user_id = ? ORDER BY $order_by";
    $stmt = mysqli_prepare($conn, $articles_query);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
}

mysqli_stmt_execute($stmt);
$articles_result = mysqli_stmt_get_result($stmt);

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container">
    <h2 class="mt-5">Welcome, <?php echo htmlspecialchars($username); ?>!</h2>
    <h3>Your Saved Articles</h3>

    <!-- Search and Sort Form -->
    <form method="GET" action="profile.php" class="mb-3">
        <div class="row">
            <div class="col-md-6">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Search articles..." value="<?php echo htmlspecialchars($search_query); ?>">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </div>
            <div class="col-md-6">
                <select name="sort_by" class="form-select" onchange="this.form.submit()">
                    <option value="date_saved_desc" <?php echo ($sort_by == "date_saved_desc") ? "selected" : ""; ?>>Recently Saved</option>
                    <option value="published_desc" <?php echo ($sort_by == "published_desc") ? "selected" : ""; ?>>Newest Published</option>
                    <option value="title_asc" <?php echo ($sort_by == "title_asc") ? "selected" : ""; ?>>Alphabetically (A-Z)</option>
                </select>
            </div>
        </div>
    </form>

    <?php if (mysqli_num_rows($articles_result) > 0): ?>
        <ul class="list-group">
            <?php while ($article = mysqli_fetch_assoc($articles_result)): ?>
                <li class="list-group-item">
                    <h4><?php echo htmlspecialchars($article["title"]); ?></h4>
                    <p><strong>Published on:</strong> <?php echo date("F j, Y, g:i a", strtotime($article["published_at"])); ?></p>
                    <p><?php echo htmlspecialchars($article["description"]); ?></p>
                    <a href="<?php echo htmlspecialchars($article["url"]); ?>" target="_blank" class="btn btn-primary">Read More</a>
                </li>
            <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <p>No saved articles found.</p>
    <?php endif; ?>

    <a href="dashboard.php" class="btn btn-secondary mt-3">Back to Dashboard</a>
</div>

</body>
</html>
