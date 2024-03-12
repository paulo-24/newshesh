<?php
session_start();
include("php/database.php");

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $employee_id = $_GET['id'];

    $sql = "SELECT * FROM employees WHERE employee_id = $employee_id";
    $result = mysqli_query($connection, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
    } else {
        echo "Employee not found.";
        exit;
    }
} else {
    echo "Invalid request.";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $employee_id = $_POST['employee_id'];
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $department = $_POST['department'];
    $salary = $_POST['salary'];
    $start_date = $_POST['start_date'];

    $sql = "UPDATE employees SET name='$name', gender='$gender', department='$department', salary='$salary', start_date='$start_date' WHERE employee_id = $employee_id";

    if (mysqli_query($connection, $sql)) {
        header("Location: positionlist.php");
        exit;
    } else {
        echo "Error updating record: " . mysqli_error($connection);
    }
}

mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Employee</title>
</head>
<body>
    <h1>Edit Employee</h1>
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <input type="hidden" name="employee_id" value="<?php echo $row['employee_id']; ?>">
        Name: <input type="text" name="name" value="<?php echo $row['name']; ?>"><br><br>
        Gender: <input type="text" name="gender" value="<?php echo $row['gender']; ?>"><br><br>
        Department: <input type="text" name="department" value="<?php echo $row['department']; ?>"><br><br>
        Salary: <input type="text" name="salary" value="<?php echo $row['salary']; ?>"><br><br>
        Start Date: <input type="text" name="start_date" value="<?php echo $row['start_date']; ?>"><br><br>
        <input type="submit" value="Submit">
    </form>
</body>
</html>
