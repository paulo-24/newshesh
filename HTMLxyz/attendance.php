<?
    include("php/database.php");

    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Attendance</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
        <link rel="stylesheet" href="css/attendance.css">
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
                <li><a href="attendance.php" class="btn-active"><i class="fas fa-check"></i>Attendance</a></li>
                <!--  <li><a href="employeelist.html"><i class="fas fa-users"></i>Employee List</a></li> -->
                <li><a href="positionlist.php"><i class="fas fa-user-tie"></i>Position List</a></li>
                <li><a href="schedule.html"><i class="fas fa-credit-card"></i>Schedule</a></li>
                <li><a href="DailyTimeRecord.html"><i class="fas fa-equals"></i>DTR</a></li>
                <li><a href="admin_user.php"><i class="fas fa-user"></i>Admin Users</a></li> 
            </ul>
        </div>
        </section> 
        <main class="main">  
            <div class="card-body">
                <div class="logo-main">Attendance List</div>
                <div class="attendance">
                    <div class="attendance-list">  
                        <table id="attendanceTable" class="table">
                                <div class="reset-button-container">
                        <button id="resetAttendance" class="btn-reset">Reset Table</button>
                    </div>
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Morning In</th>
                                <th>Morning Out</th>
                                <th>Afternoon In</th>
                                <th>Afternoon Out</th>
                                <th>AM Total Hours</th>
                                <th>PM Total Hours</th>
                                <th>Total AM and PM</th> 
                                <th>Status</th>
                                <th>OT In</th>
                                <th>OT Out</th>
                                <th>OT Total Hours</th>
                            </tr>

                            </thead>
                            <tbody>
                                <!-- Dito ilalagay ng script ang attendance data -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        </main>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="js/camera.js"></script> <!-- Include camera.js -->
        <script>

    $(document).ready(function() {
        console.log("Document is ready.");

        // Function to format total hours and minutes
        function formatHours(totalHours) {
        var hours = Math.floor(totalHours);
        var minutes = Math.floor((totalHours - hours) * 60);
        
        // Formatting hours and minutes
        var formattedHours = hours < 10 ? '0' + hours : hours;
        var formattedMinutes = minutes < 10 ? '0' + minutes : minutes;

        return formattedHours + ':' + formattedMinutes;
    }


        function fetchAttendanceData() {
            console.log("Fetching Attendance data...")
            $.ajax({
                url: 'attendance_employee.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    action: 'getAttendance'
                },
                success: function(data) {
                    console.log("Received data:", data);
                    populateAttendanceTable(data);
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }

        function populateAttendanceTable(data) {
            console.log("Populating table with data:", data);
            var table = $('#attendanceTable tbody');
            table.empty();

            $.each(data, function(index, record) {
                // Format time values to 12-hour format AND TO BE DELETED
                var morningIn = record.formatted_morning_time_in|| '';
                var morningOut = record.formatted_morning_time_out|| '';
                var afternoonIn = record.formatted_afternoon_time_in|| '';
                var afternoonOut = record.formatted_afternoon_time_out|| '';
                var otIn = record.formatted_overtime_time_in|| '';
                var otOut = record.formatted_overtime_time_out|| '';

                var morningTotal = parseFloat(record.morning_total_hours);
                var afternoonTotal = parseFloat(record.afternoon_total_hours);
                var overtimeTotal = parseFloat(record.overtime_total_hours);

                // Calculate overall total hours
                var overallTotalHours = morningTotal + afternoonTotal;

                // Calculate morning total hours -FIXED
                var morningHours = Math.floor(morningTotal);    
                var morningMinutes = Math.floor((morningTotal - morningHours) * 60);
                var formattedMorningTotal = formatHours(morningTotal);

                // Calculate afternoon total hours 
                var afternoonHours = Math.floor(afternoonTotal);
                var afternoonMinutes = Math.floor((afternoonTotal - afternoonHours) * 60);
                var formattedAfternoonTotal = formatHours(afternoonTotal);


                var formattedMorningTotal = isNaN(morningTotal) ? '' : formatHours(morningTotal);
                var formattedAfternoonTotal = isNaN(afternoonTotal) ? '' : formatHours(afternoonTotal); 
                var formattedOverallTotal = isNaN(overallTotalHours) ? '' : formatHours(overallTotalHours);
                var formattedOvertimeTotalHours = isNaN(overtimeTotal) ? '' : formatHours(overtimeTotal)

                var row = '<tr>' +
                    '<td>' + record.name + '</td>' +
                    '<td>' + morningIn + '</td>' +
                    '<td>' + morningOut + '</td>' +
                    '<td>' + afternoonIn + '</td>' +
                    '<td>' + afternoonOut + '</td>' +
                    '<td>' + formattedMorningTotal + '</td>' +
                    '<td>' + formattedAfternoonTotal + '</td>' +
                    '<td>' + formattedOverallTotal + '</td>' + // Display the overall total hours
                    '<td>' + record.status + '</td>' +
                    '<td>' + otIn + '</td>' +
                    '<td>' + otOut + '</td>' +
                    '<td>' + formattedOvertimeTotalHours + '</td>' +
                    '</tr>';

                table.append(row);
            });

            // Attach click event to delete buttons
            $('.btn-delete').on('click', function(e) {
                e.preventDefault();
                var recordId = $(this).data('id');
                deleteAttendanceRecord(recordId);
            });

            // Attach click event to reset button
            $('#resetAttendance').on('click', function() {
                console.log("Resetting Attendance Table...");
                resetAttendance();
            });

            // Function to reset the attendance table
            function resetAttendance() {
                $.ajax({
                    url: 'delete_attendance.php',
                    type: 'POST',
                    data: {
                        action: 'resetAttendance'
                    },
                    success: function(response) {
                        console.log(response);
                        // Clear the table after successful reset
                        $('#attendanceTable tbody').empty();
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            }

            // Attach click event to download links
            $('.download-link').on('click', function(e) {
                e.preventDefault();
                var base64Image = $(this).data('image');
                downloadImage(base64Image);
            });
        }

        // Function to convert base64 string to a Blob object and download it
        function downloadImage(base64Image) {
            // Your download image function here
        }

        // Function to format time to 12-hour format AND TO BE DELETED
        function formatTime(timeString) {
        if (!timeString) return ''; // Handle empty time values

        // Check if timeString is in 'Y-m-d H:i:s' format
        if (/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/.test(timeString)) {
            var time = new Date(timeString);
            var formattedTime = time.toLocaleString('en-US', {
                hour: 'numeric',
                minute: 'numeric',
                hour12: true
            });

            return formattedTime;
        } else {
            return timeString; // Return as is if not in expected format
        }
    }
        fetchAttendanceData();
    });

        </script>
    </body>
    </html>