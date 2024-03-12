<?php
include("php/database.php");

if(isset($_POST['action']) && $_POST['action'] === 'resetAttendance') {
    // SQL query to delete all records from the attendance table
    $sql = "DELETE FROM attendance";
    
    if(mysqli_query($connection, $sql)) {
        echo "Attendance table cleared successfully";
    } else {
        echo "Error clearing attendance table: " . mysqli_error($connection);
    }
} else {
    echo "Invalid action";
}

mysqli_close($connection);
?>
