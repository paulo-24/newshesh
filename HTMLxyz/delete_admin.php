<?php
include("php/database.php");

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $admin_id = $_GET['id'];

    $query = "DELETE FROM admin WHERE id=?";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, "i", $admin_id);
    mysqli_stmt_execute($stmt);

    header("Location: admin_user.php");
    exit;
} else {
    header("Location: admin_user.php");
    exit;
}
?>
