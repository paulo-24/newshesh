<?php
session_start();
include("php/database.php");

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $employee_id = $_GET['id'];

    $sql = "DELETE FROM employees WHERE employee_id = $employee_id";

    if (mysqli_query($connection, $sql)) {
        header("Location: positionlist.php");
        exit;
    } else {
        echo "Error deleting record: " . mysqli_error($connection);
    }
}

mysqli_close($connection);
?>
