<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
include('db.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM appointments WHERE id = $id";
    mysqli_query($conn, $query);
}

header("Location: admin.php");
exit();
?>