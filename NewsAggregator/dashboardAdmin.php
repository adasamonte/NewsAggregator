<?php
// Start the session
session_start();

// Database connection
$host = 'localhost';
$username = 'root'; 
$password = ''; 
$database = 'horoscope'; 

$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_zodiac'])) {
    $zodiac_name = $_POST['zodiac_name'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $description = $_POST['description'];


    $image_path = 'ZodiacSignImages/' . basename($_FILES['zodiac_image']['name']);
    if (move_uploaded_file($_FILES['zodiac_image']['tmp_name'], $image_path)) {
        $stmt = $conn->prepare("INSERT INTO zodiac_signs (name, start_date, end_date, description, image_path) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $zodiac_name, $start_date, $end_date, $description, $image_path);

        if ($stmt->execute()) {
            $success_message = "Zodiac sign added successfully!";
        } else {
            $error_message = "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $error_message = "Image upload failed.";
    }
}


if (isset($_GET['delete_zodiac'])) {
    $zodiac_id = $_GET['delete_zodiac'];
    $delete_stmt = $conn->prepare("DELETE FROM zodiac_signs WHERE id = ?");
    $delete_stmt->bind_param("i", $zodiac_id);
    
    if ($delete_stmt->execute()) {
        $success_message = "Zodiac sign added successfully!";
    } else {
        $error_message = "Error: " . $delete_stmt->error;
    }
    $delete_stmt->close();
}


$zodiac_result = $conn->query("SELECT * FROM zodiac_signs");
$users_result = $conn->query("SELECT * FROM horoscope_info");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #1a1a1a; 
            color: #e0e0e0; 
            font-family: 'Arial', sans-serif;
            background-image: url('https://www.transparenttextures.com/patterns/stardust.png');
            background-size: cover;
            animation: fadeIn 2s ease-in-out;
        }
        
        @keyframes fadeIn {
            0% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
        }
        .navbar {
            background-color: #2e3c29; 
        }
        .navbar a {
            color: #f0c68c; 
        }
        .container {
            margin-top: 40px;
        }
        .alert {
            border-radius: 10px;
        }
        .card {
            background-color: #2e3c29; 
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
            border: 1px solid #64a64d; 
        }
        .card h2, .card h3 {
            color: #f0c68c; 
        }
        .form-control {
            background-color: #333; 
            border: 1px solid #64a64d; 
            color: #fff;
        }
        .btn-primary {
            background-color: #7a9d55;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: bold;
        }
        .btn-primary:hover {
            background-color: #6b8e47; 
        }
        .table-striped {
            background-color: #2e3c29;
            color: #e0e0e0;
        }
        .table-striped thead {
            background-color: #333;
            color: #f0c68c; 
        }
        .table-striped tbody tr:hover {
            background-color: #3c4f34;
        }
        .logout-btn {
            background-color: #7a9d55;
            color: #fff;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            font-size: 1.2em;
            font-weight: bold;
        }
        .logout-btn:hover {
            background-color: #6b8e47;
        }
    </style>
</head>
<body>
    
    <nav class="navbar navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Admin Dashboard</a>
        </div>
    </nav>
    
    <div class="container">
        <h2 class="text-center">Manage Zodiac Signs</h2>

        <?php if (isset($success_message)): ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php endif; ?>
        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <div class="card">
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="zodiac_name" class="form-label">Zodiac Name</label>
                    <input type="text" class="form-control" id="zodiac_name" name="zodiac_name" required>
                </div>
                <div class="mb-3">
                    <label for="start_date" class="form-label">Start Date</label>
                    <input type="date" class="form-control" id="start_date" name="start_date" required>
                </div>
                <div class="mb-3">
                    <label for="end_date" class="form-label">End Date</label>
                    <input type="date" class="form-control" id="end_date" name="end_date" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="zodiac_image" class="form-label">Upload Zodiac Image</label>
                    <input type="file" class="form-control" id="zodiac_image" name="zodiac_image" accept="image/*" required>
                </div>
                <button type="submit" name="add_zodiac" class="btn btn-primary">Add Zodiac Sign</button>
            </form>
        </div>

        <hr>
        <h2 class="mt-4 text-center">List of Zodiac Signs</h2>
        <div class="card">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Description</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($zodiac = $zodiac_result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $zodiac['id']; ?></td>
                            <td><?php echo $zodiac['name']; ?></td>
                            <td><?php echo $zodiac['start_date']; ?></td>
                            <td><?php echo $zodiac['end_date']; ?></td>
                            <td><?php echo $zodiac['description']; ?></td>
                            <td><img src="<?php echo $zodiac['image_path']; ?>" alt="Zodiac Image" width="50"></td>
                            <td>
                                <a href="?delete_zodiac=<?php echo $zodiac['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this Zodiac sign?')">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <hr>
        <h2 class="mt-4 text-center">List of Users</h2>
        <div class="card">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Full Name</th>
                        <th>Gender</th>
                        <th>Date of Birth</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($user = $users_result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $user['id']; ?></td>
                            <td><?php echo $user['fullname']; ?></td>
                            <td><?php echo $user['gender']; ?></td>
                            <td><?php echo $user['birth_date']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <!-- Form for logout -->
        <form method="POST" action="logout.php" style="margin-top: 20px;">
            <button type="submit" class="logout-btn">Log Out</button>
        </form>
    </div>
</body>
</html>
<?php $conn->close(); ?>
