<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
include('db.php');

$message = "";

if (isset($_POST['add_doctor'])) {
    $name = $_POST['name'];
    $specialist = $_POST['specialist'];
    
    // Image Upload Logic
    $target_dir = "image/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
if (!file_exists($target_dir)) {
    mkdir($target_dir, 0777, true);
}

$image_name = $_FILES['image']['name'];
$image_tmp = $_FILES['image']['tmp_name'];

if (!empty($image_name)) {
    $image_name = time() . '_' . basename($image_name);
    $image_folder = $target_dir . $image_name;
    move_uploaded_file($image_tmp, $image_folder);
    } else {
        $image_name = ""; // No image uploaded
    }

    $query = "INSERT INTO doctors (name, specialist, image) VALUES ('$name', '$specialist', '$image_name')";
    if (mysqli_query($conn, $query)) {
        $message = "Doctor added successfully!";
    } else {
        $message = "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Doctor - Admin</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #007bff, #00d2ff);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .card {
            background: #ffffff;
            width: 100%;
            max-width: 500px;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }

        h2 {
            color: #007bff;
            margin-bottom: 20px;
            text-align: center;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
            color: #333;
        }

        input[type="text"], input[type="file"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
        }

        .btn-submit {
            width: 100%;
            padding: 12px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 10px;
        }

        .btn-submit:hover {
            background-color: #218838;
        }

        .btn-back {
            display: block;
            text-align: center;
            margin-top: 15px;
            color: #007bff;
            text-decoration: none;
            font-weight: 600;
        }

        .alert {
            padding: 10px;
            background-color: #d4edda;
            color: #155724;
            border-radius: 6px;
            margin-bottom: 15px;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="card">
    <h2>Add New Doctor</h2>

    <?php if ($message != ""): ?>
        <div class="alert"><?php echo $message; ?></div>
    <?php endif; ?>

    <form action="add_doctor.php" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label>Doctor Name:</label>
            <input type="text" name="name" placeholder="e.g. Dr. Anisur Rahman" required>
        </div>

        <div class="form-group">
            <label>Specialist / Department:</label>
            <input type="text" name="specialist" placeholder="e.g. Cardiologist" required>
        </div>

        <div class="form-group">
            <label>Doctor Photo:</label>
            <input type="file" name="image" accept="image/*">
        </div>

        <button type="submit" name="add_doctor" class="btn-submit">Save Doctor</button>
    </form>

    <a href="admin.php" class="btn-back">← Back to Dashboard</a>
</div>

</body>
</html>