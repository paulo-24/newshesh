<?php
    session_start();
    include("php/database.php");

    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT * FROM employees";
    $result = mysqli_query($connection, $sql);
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Positions</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
        <link rel="stylesheet" href="css/positionlist.css">
        <link rel="stylesheet" href="css/topsidenavbars.css"> 
    </head>
    <body>
        <header class="header">
            <nav class="topnav">
                <a class="active" href="index.php">Logout</a>
                <a href="#about">About</a>
                <a href=" ">Contact</a>
                <a class="logout-btn" href="index.php">Home</a>
            </nav> 
        </header>
        <section class="sidebar">
            <div class="logo-sidebar">ADMIN</div>
            <ul>
                <li><a href="dashboard.html"><i class="fas fa-box"></i>Dashboard</a></li>
                <li><a href="employeeform.html"><i class="fas fa-paperclip"></i>Employee Registration</a></li>
                <li><a href="attendance.php"><i class="fas fa-check"></i>Attendance</a></li>
            <!--  <li><a href="employeelist.html"><i class="fas fa-users"></i>Employee List</a></li> -->
                <li><a href="positionlist.php" class="btn-active"><i class="fas fa-user-tie"></i>Position List</a></li>
                <li><a href="schedule.html"><i class="fas fa-credit-card"></i>Schedule</a></li>
                <li><a href="DailyTimeRecord.html"><i class="fas fa-equals"></i>DTR</a></li>
                <li><a href="admin_user.php"><i class="fas fa-user"></i>Admin Users</a></li> 
            </ul>
        </section>
        <main class="main">  
            <div class="card-body">
                <div class="logo-main">Employee's Position</div>
                <div class="attendance">
                    <div class="attendance-list"> 
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Employee ID</th>
                                    <th>Name</th>
                                    <th>Gender</th>
                                    <th>Position</th> 
                                    <th>Salary</th>
                                    <th>Start Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($result && mysqli_num_rows($result) > 0) {
                                    while($row = mysqli_fetch_assoc($result)) {
                                ?>
                                <tr>
                                    <td><?php echo $row["employee_id"]; ?></td>
                                    <td><?php echo $row["name"]; ?></td>
                                    <td><?php echo $row["gender"]; ?></td>
                                    <td><?php echo $row["department"]; ?></td>
                                    <td><?php echo $row["salary"]; ?></td>
                                    <td><?php echo $row["start_date"]; ?></td>
                                    <td>
                                        <a href='#'  id="addButton" class='button-btn edit-btn' data-id="<?php echo $row['employee_id']; ?>"><i class='fas fa-edit'></i></a>
                                    </td>
                                </tr>
                                <?php
                                    }
                                } else {
                                    echo "<tr><td colspan='5'>No employees found</td></tr>";
                                }
                                mysqli_close($connection);
                                ?>
                            </tbody>
<!-- Modal -->
<div class="bg-modal" id="modal">
    <div class="modal-content">
        <div class="close">+</div>
        <h2 class="title-hed">-Edit Position-</h2>
            <form id="editForm" action="positionlist.php" method="POST"> 
                <input type="hidden" name="employee_id" id="editEmployeeId" value="">
                <input type="text" name="Position" id="Position" placeholder="Position" required>
                <button type="submit" class="button-btn">Submit</button>
            </form>
    </div>
</div>
<script src="js/positionlist.js"></script>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </body>
    </html>

    <?php
    // Handle form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Include database connection
        include("php/database.php");

        // Check if connection is successful
        if (!$connection) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Get form data
        $employee_id = $_POST['employee_id'];
        $position = $_POST['Position'];

        // Update department in the database
        $sql = "UPDATE employees SET department = '$position' WHERE employee_id = '$employee_id'";

        if (mysqli_query($connection, $sql)) {
            // Redirect to a different page to avoid form resubmission
            header("Location: positionlist.php");
            exit(); // Ensure script termination after redirect
        } else {
            echo "Error updating department: " . mysqli_error($connection);
        }

        // Close connection
        mysqli_close($connection);
    }
?>