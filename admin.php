<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
include('db.php');

// Fetch all appointments safely without hardcoded join column
$sql = "SELECT * FROM appointments ORDER BY id DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - City General Hospital</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { background: linear-gradient(135deg, #007bff, #00d2ff); min-height: 100vh; padding: 30px; }
        .container { background: #fff; border-radius: 12px; padding: 25px; box-shadow: 0 10px 25px rgba(0,0,0,0.2); max-width: 1000px; margin: 0 auto; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .header h2 { color: #007bff; }
        .btn-logout { background: #dc3545; color: #fff; padding: 8px 16px; text-decoration: none; border-radius: 6px; font-weight: bold; }
        .action-btns { margin-bottom: 20px; display: flex; gap: 10px; }
        .btn-action { background: #007bff; color: #fff; padding: 10px 15px; text-decoration: none; border-radius: 6px; font-weight: bold; font-size: 14px; }
        .btn-green { background: #28a745; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #007bff; color: white; }
        .status-pending { background: #ffc107; color: #000; padding: 4px 8px; border-radius: 4px; font-weight: bold; font-size: 12px; }
        .status-approved { background: #28a745; color: #fff; padding: 4px 8px; border-radius: 4px; font-weight: bold; font-size: 12px; }
        .btn-approve { background: #28a745; color: #fff; padding: 5px 10px; text-decoration: none; border-radius: 4px; font-size: 12px; margin-right: 5px; }
        .btn-delete { background: #dc3545; color: #fff; padding: 5px 10px; text-decoration: none; border-radius: 4px; font-size: 12px; }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h2>City General Hospital - Admin Dashboard</h2>
        <a href="logout.php" class="btn-logout">Logout</a>
    </div>

    <div class="action-btns">
        <a href="index.php" class="btn-action">Book New Appointment</a>
        <a href="add_doctor.php" class="btn-action btn-green">+ Add New Doctor</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Patient Name</th>
                <th>Phone</th>
                <th>Doctor</th>
                <th>Date</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) { 
                    $p_name = !empty($row['patient_name']) ? $row['patient_name'] : (!empty($row['name']) ? $row['name'] : 'N/A');
                    $p_phone = !empty($row['phone']) ? $row['phone'] : (!empty($row['mobile']) ? $row['mobile'] : (!empty($row['phone_number']) ? $row['phone_number'] : 'N/A'));
                    
                    $raw_doc = !empty($row['doctor']) ? $row['doctor'] : (!empty($row['doctor_name']) ? $row['doctor_name'] : (!empty($row['doctor_id']) ? $row['doctor_id'] : 'N/A'));
                    
                    $p_doctor = $raw_doc;
                    if (is_numeric($raw_doc)) {
                        $doc_q = mysqli_query($conn, "SELECT name FROM doctors WHERE id='$raw_doc'");
                        if ($doc_q && $doc_r = mysqli_fetch_assoc($doc_q)) {
                            $p_doctor = $doc_r['name'];
                        }
                    }

                    $p_date   = !empty($row['date']) ? $row['date'] : (!empty($row['appointment_date']) ? $row['appointment_date'] : 'N/A');
                    $p_status = !empty($row['status']) ? $row['status'] : 'Pending';
            ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo htmlspecialchars($p_name); ?></td>
                <td><?php echo htmlspecialchars($p_phone); ?></td>
                <td><strong><?php echo htmlspecialchars($p_doctor); ?></strong></td>
                <td><?php echo htmlspecialchars($p_date); ?></td>
                <td>
                    <span class="<?php echo ($p_status == 'Approved') ? 'status-approved' : 'status-pending'; ?>">
                        <?php echo htmlspecialchars($p_status); ?>
                    </span>
                </td>
                <td>
                    <?php if ($p_status != 'Approved') { ?>
                        <a href="status_update.php?id=<?php echo $row['id']; ?>&status=Approved" class="btn-approve">Approve</a>
                    <?php } ?>
                    <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn-delete" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
            <?php 
                }
            } else {
                echo "<tr><td colspan='7' style='text-align:center;'>No appointments found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>