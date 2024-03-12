<?php
include("php/database.php");

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $admin_id = $_GET['id'];

    $query = "SELECT * FROM admin WHERE id = ?";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, "i", $admin_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        $admin = mysqli_fetch_assoc($result);

        $fullname = $admin['fname'];
        $username = $admin['username'];
        $email = $admin['email'];
        $gender = $admin['gender'];

        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Edit Admin</title>
            <link rel="stylesheet" href="css/edit_admin.css">
        </head>
        <body>
            <h1>Edit Admin</h1>
            <form action="update_admin.php" method="POST">
                <input type="hidden" name="admin_id" value="<?php echo $admin_id; ?>">
                <label for="fname">Full Name:</label>
                <input type="text" id="fname" name="fname" value="<?php echo $fullname; ?>"><br><br>
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" value="<?php echo $username; ?>"><br><br>
                <label for="email">Email:</label>
                <input type="text" id="email" name="email" value="<?php echo $email; ?>"><br><br>
                
                <label for="password">New Password:</label> 
                <input type="password" id="password" name="password"><br><br>
                
                <label for="gender">Gender:</label>
                <input type="text" id="gender" name="gender" value="<?php echo $gender; ?>"><br><br>
                <input type="submit" value="Update">
            </form>
        </body>
        </html>
        <?php
    } else { 
        header("Location: admin_user.php");
        exit;
    }
} else {
    header("Location: admin_user.php");
    exit;
}
?>
