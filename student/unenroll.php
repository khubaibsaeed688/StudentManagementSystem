<?php
session_start();
include "../config/db_connect.php";

$enrollmentID = $_GET['id'];


$sql = "DELETE FROM enrollments WHERE enrollmentID = $enrollmentID";
    
    if (mysqli_query($conn, $sql)) {
        header("Location: my_courses.php?success=enrolled");
        exit();
    }else {
        echo "Error: " . mysqli_error($conn);
    }

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}
if ($_SESSION['role'] !== 'student') {
  header("Location: ../index.php");
  exit();
}
?>