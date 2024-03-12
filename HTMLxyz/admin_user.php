<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payroll Metrics</title>
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
    <section class="sidebar">
        <div class="logo-sidebar">ADMIN</div>
        <ul>
            <li><a href="dashboard.html"><i class="fas fa-box"></i>Dashboard</a></li>
            <li><a href="employeeform.html"><i class="fas fa-paperclip"></i>Employee Registration</a></li>
            <li><a href="attendance.php"><i class="fas fa-check"></i>Attendance</a></li>
            <!-- <li><a href="employeelist.html"><i class="fas fa-users"></i>Employee List</a></li> -->
            <li><a href="positionlist.php"><i class="fas fa-user-tie"></i>Position List</a></li>
            <li><a href="schedule.html"><i class="fas fa-credit-card"></i>Schedule</a></li>
            <li><a href="DailyTimeRecord.html"><i class="fas fa-equals"></i>DTR</a></li>
            <li><a href="admin_user.php" class="btn-active"><i class="fas fa-user"></i>Admin Users</a></li> 
        </ul>
    </section>
    <main class="main">  
        <div class="card-body">
            <div class="logo-main">Admin Panel</div>
            <div class="container">
                <h1>Admin List Identity</h1>
                <table>
                    <thead>
                        <tr>
                            <th>Full Name</th>
                            <th>User Name</th>
                            <th>Email</th>
                            <th>Gender</th>
                            <th class="action">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include("php/database.php");

                        $query = "SELECT * FROM admin";
                        $result = mysqli_query($connection, $query);

                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>" . $row['fname'] . "</td>";
                                echo "<td>" . $row['username'] . "</td>";
                                echo "<td>" . $row['email'] . "</td>";
                                 
                                echo "<td>" . $row['gender'] . "</td>";
                                echo "<td>";
                                echo "<a href='edit_admin.php?id=" . $row['id'] . "' class='button-btn'><i class='fas fa-edit'></i></a>";
                                echo "| ";
                                echo "<a href='delete_admin.php?id=" . $row['id'] . "' class='button-btn' onclick='return confirm(\"Are you sure you want to delete this admin?\")'><i class='fas fa-trash-alt'></i></a>";
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6'>No admins found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
                <button id="addButton" onclick="openModal()">Add Admin</button>
            </div>
        </div>    
    </main>
    <div class="bg-modal" id="modal">
        <div class="modal-content">
            <div class="close">+</div>
                <h2 class="title-hed">-Admin Registration-</h2>
                    <form action="add_admin.php" method="POST">
                        <input type="text" name="fullname" placeholder="Fullname" required>
                        <input type="text" name="username" placeholder="Username" required>
                        <input type="email" name="email" placeholder="Email" required>
                        <input type="password" name="password" placeholder="Password" required>
                        <input type="password" name="password" placeholder="Re-enter Password" required>
                        <input type="text" name="gender" placeholder="Gender" required>
                        <button type="submit" class="button-btn">Submit</button>
            </form>
        </div>
    </div>    
    <script src="js/adminuser.js"></script>
    <script>
        function openModal() {
            document.getElementById('modal').style.display = 'flex';
        }
        function closeModal() {
            document.getElementById('modal').style.display = 'none';
        }
    </script>
</body>
</html>
