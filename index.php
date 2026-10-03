<?php
include('db.php');

$message = "";

if (isset($_POST['book_appointment'])) {
    $patient_name = mysqli_real_escape_string($conn, $_POST['patient_name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $doctor_id = mysqli_real_escape_string($conn, $_POST['doctor_id']);
    $date = mysqli_real_escape_string($conn, $_POST['date']);

    // Get doctor info
    $doc_query = "SELECT * FROM doctors WHERE id = '$doctor_id'";
    $doc_result = mysqli_query($conn, $doc_query);
    $doc_data = mysqli_fetch_assoc($doc_result);
    $doctor_info = $doc_data['name'] . " (" . $doc_data['specialist'] . ")";

    // Check available columns in appointments table
    $columns = array();
    $col_result = mysqli_query($conn, "SHOW COLUMNS FROM appointments");
    while ($col = mysqli_fetch_assoc($col_result)) {
        $columns[] = $col['Field'];
    }

    $insert_fields = array();
    $insert_values = array();

    if (in_array('patient_name', $columns)) { $insert_fields[] = 'patient_name'; $insert_values[] = "'$patient_name'"; }
    elseif (in_array('name', $columns)) { $insert_fields[] = 'name'; $insert_values[] = "'$patient_name'"; }

    if (in_array('phone', $columns)) { $insert_fields[] = 'phone'; $insert_values[] = "'$phone'"; }
    elseif (in_array('mobile', $columns)) { $insert_fields[] = 'mobile'; $insert_values[] = "'$phone'"; }

    if (in_array('doctor', $columns)) { $insert_fields[] = 'doctor'; $insert_values[] = "'$doctor_info'"; }
    elseif (in_array('doctor_name', $columns)) { $insert_fields[] = 'doctor_name'; $insert_values[] = "'$doctor_info'"; }
    elseif (in_array('doctor_id', $columns)) { $insert_fields[] = 'doctor_id'; $insert_values[] = "'$doctor_id'"; }

    if (in_array('date', $columns)) { $insert_fields[] = 'date'; $insert_values[] = "'$date'"; }
    elseif (in_array('appointment_date', $columns)) { $insert_fields[] = 'appointment_date'; $insert_values[] = "'$date'"; }

    if (in_array('status', $columns)) { $insert_fields[] = 'status'; $insert_values[] = "'Pending'"; }

    $sql = "INSERT INTO appointments (" . implode(', ', $insert_fields) . ") VALUES (" . implode(', ', $insert_values) . ")";

    if (mysqli_query($conn, $sql)) {
        $message = "Appointment booked successfully!";
    } else {
        $message = "Error: " . mysqli_error($conn);
    }
}

// Fetch doctors
$doctors_result = mysqli_query($conn, "SELECT * FROM doctors");
?>

// Fetch doctors
$doctors_result = mysqli_query($conn, "SELECT * FROM doctors");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Appointment - City General Hospital</title>
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
            max-width: 600px;
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

        input[type="text"], input[type="date"], select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
        }

        .doctor-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
            gap: 15px;
            margin-top: 10px;
            max-height: 220px;
            overflow-y: auto;
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 8px;
        }
        .doctor-card {
            border: 2px solid #eee;
            border-radius: 8px;
            padding: 8px;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
        }

        .doctor-card:hover {
            border-color: #007bff;
            background-color: #f0f7ff;
        }

        .doctor-card input[type="radio"] {
            display: none;
        }

        .doctor-card input[type="radio"]:checked + .doc-info {
            font-weight: bold;
            color: #007bff;
        }

        .doctor-card input[type="radio"]:checked ~ .doc-img {
            border: 2px solid #007bff;
        }

        .doc-img {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 5px;
            background-color: #eee;
        }

        .btn-submit {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 15px;
        }

        .btn-submit:hover {
            background-color: #0056b3;
        }

        .alert {
            padding: 10px;
            background-color: #d4edda;
            color: #155724;
            border-radius: 6px;
            margin-bottom: 15px;
            text-align: center;
        }

        .admin-link {
            display: block;
            text-align: center;
            margin-top: 15px;
            color: #555;
            text-decoration: none;
            font-size: 13px;
        }
    </style>
</head>
<body>

<div class="card">
    <h2>Book Patient Appointment</h2>

    <?php if ($message != ""): ?>
        <div class="alert"><?php echo $message; ?></div>
    <?php endif; ?>

    <form action="index.php" method="POST">
        <div class="form-group">
            <label>Patient Name:</label>
            <input type="text" name="patient_name" required placeholder="Enter full name">
        </div>

        <div class="form-group">
            <label>Phone Number:</label>
            <input type="text" name="phone" required placeholder="Enter phone number">
        </div>

        <div class="form-group">
            <label>Select Doctor:</label>
            <div class="doctor-list">
                <?php while ($doc = mysqli_fetch_assoc($doctors_result)): ?>
                    <label class="doctor-card">
                        <input type="radio" name="doctor_id" value="<?php echo $doc['id']; ?>" required>
                        <?php 
                            $img_src = !empty($doc['image']) ? "image/" . $doc['image'] : "https://via.placeholder.com/70";
                        ?>
                        <img src="<?php echo $img_src; ?>" class="doc-img" alt="Doctor Photo">
                        <div class="doc-info">
                            <div style="font-size: 13px;"><?php echo $doc['name']; ?></div>
                            <div style="font-size: 11px; color: #666;"><?php echo $doc['specialist']; ?></div>
                        </div>
                    </label>
                <?php endwhile; ?>
            </div>
        </div>

        <div class="form-group">
            <label>Appointment Date:</label>
            <input type="date" name="date" required>
        </div>

        <button type="submit" name="book_appointment" class="btn-submit">Confirm Appointment</button>
    </form>

    <a href="admin.php" class="admin-link">Admin Portal →</a>
</div>

</body>
</html>