<?php

include("php/database.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST['fullname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $gender = $_POST['gender'];

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $query = "INSERT INTO admin (fname, username, email, password, gender) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, "sssss", $fullname, $username, $email, $hashed_password, $gender);
    mysqli_stmt_execute($stmt);

    header("Location: admin_user.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
    <link rel="stylesheet" href="css/adminuser.css">
    <link rel="stylesheet" href="css/topsidenavbars.css">
</head>
<body>
    <header class="header">
        <nav class="topnav">
            <a class="active" href="index.php">Logout</a>
            <a href="#about">About</a>
            <a href="">Contact</a>
            <a class="logout-btn" href="index.php">Home</a>
        </nav>
    </header>
    <section class="main">
        <div class="card-body">
            <div class="logo-main">Admin Panel - Add Admin</div>
            <div class="container">
                <h1>Add New Admin</h1>
                <form action="add_admin.php" method="POST">
                    <label for="fullname">Full Name:</label>
                    <input type="text" id="fullname" name="fullname" required><br><br>
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" required><br><br>
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required><br><br>
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required><br><br>
                    <label for="gender">Gender:</label>
                    <input type="text" id="gender" name="gender" required><br><br>
                    <button type="submit">Add Admin</button>
                </form>
            </div>
        </div>
    </section>
    <script src="js/adminuser.js"></script>
</body>
</html>
