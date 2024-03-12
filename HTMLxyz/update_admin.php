<?php
include("php/database.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['admin_id'])) {
    $admin_id = $_POST['admin_id'];
    $fullname = $_POST['fname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $gender = $_POST['gender'];

    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $query = "UPDATE admin SET fname=?, username=?, email=?, password=?, gender=? WHERE id=?";
        $stmt = mysqli_prepare($connection, $query);
        mysqli_stmt_bind_param($stmt, "sssssi", $fullname, $username, $email, $hashed_password, $gender, $admin_id);
        mysqli_stmt_execute($stmt);
    } else {
        $query = "UPDATE admin SET fname=?, username=?, email=?, gender=? WHERE id=?";
        $stmt = mysqli_prepare($connection, $query);
        mysqli_stmt_bind_param($stmt, "ssssi", $fullname, $username, $email, $gender, $admin_id);
        mysqli_stmt_execute($stmt);
    }
    header("Location: admin_user.php");
    exit;
} else {
    header("Location: admin_user.php");
    exit;
}
?>
