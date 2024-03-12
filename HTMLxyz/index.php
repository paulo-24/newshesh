<?php
include("php/database.php");

if(isset($_POST['employeeSelect']) && isset($_POST['action'])) {
    $employeeName = $_POST['employeeSelect'];
    $action = $_POST['action']; // "Time In" or "Time Out"

    // I-save ang time stamp sa attendance table
    $sql = "INSERT INTO attendance (employee_name, action, datetime) VALUES ('$employeeName', '$action', NOW())";
    if(mysqli_query($connection, $sql)) {
        echo "Record added successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($connection);
    }
}

if (isset($_POST['employeeSelect']) && isset($_POST['action'])) {
    $employeeName = $_POST['employeeSelect'];
    $action = $_POST['action']; // "Time In" or "Time Out"

    // Check if it's morning or afternoon
    date_default_timezone_set('Asia/Manila');
    $currentTime = date("H:i:s");
    $isMorning = strtotime($currentTime) >= strtotime('08:00:00') && strtotime($currentTime) <= strtotime('12:00:00');
    $isAfternoon = strtotime($currentTime) >= strtotime('13:00:00') && strtotime($currentTime) <= strtotime('17:00:00');

    if ($isMorning) {
        $shiftType = "morning";
    } elseif ($isAfternoon) {
        $shiftType = "afternoon";
    } else {
        echo "You can only Time In/Out during morning (8am-12pm) or afternoon (1pm-5pm)";
        exit();
    }

    // Save the timestamp to the appropriate column based on shift type
    $columnToSet = $shiftType . "_time_" . strtolower($action);
    $sql = "UPDATE attendance SET $columnToSet = NOW() WHERE employee_name = '$employeeName'";
    
    if (mysqli_query($connection, $sql)) {
        echo "Record added successfully for $shiftType $action.";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($connection);
    }
}

mysqli_close($connection);
?>

  <!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" href="css/index.css">
    <script>
    function captureImage() {
              const canvas = document.createElement('canvas');
              const video = document.getElementById('video');
              canvas.width = video.videoWidth;
              canvas.height = video.videoHeight;
              canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);

              const image = canvas.toDataURL('image/png');

              // Set the image data as value of hidden input fieldindex.html
              document.getElementById('imageData').value = image;

              // Submit the form
              document.getElementById('imageForm').submit();
          }

          // Function to download the image
          function downloadImage(imageUrl) {
              const a = document.createElement('a');
              a.href = imageUrl;
              a.download = 'captured_image.png';
              document.body.appendChild(a);
              a.click();
              document.body.removeChild(a);
          }
      </script>

  </head>
  <body>
    <header class="header">
      <img src="images/bigbrewpic2.jpg" class="logo">
      <a class="text"><div class="br-name">BigBrew Baliwasan</div></a>
      <div class="selection">
        
        <a href="Schedule_Index.html">SCHEDULE</a>
        <a href="login_page.php" target="_self">SIGN IN</a>
      </div>
    </header>
    
    <img src="images/bigbrewpic3.jpg" class="img">
    
    <div class="container">
      <h2>Employee's Login</h2>
      <form id="loginForm" action="#" method="post">
        <div class="form-group">
          <label for="employeeSelect">Select Employee:</label>
          <select id="employeeSelect" name="employeeSelect" required>
            <option value="">--Select Employee--</option>
            <?php
            include("php/database.php");

            if (!$connection) {
              die("Connection failed: " . mysqli_connect_error());
            }
    
            $sql = "SELECT name FROM employees";
            $result = mysqli_query($connection, $sql);
    
            if (mysqli_num_rows($result) > 0) {
              while ($row = mysqli_fetch_assoc($result)) {
                echo '<option value="' . $row["name"] . '">' . $row["name"] . '</option>';
              }
            } else {
              echo "<option value=''>No employees found</option>";
            }

            mysqli_close($connection);
            ?>
          </select>
        </div>
        <div class="form-group">
          <button id="time-in-btn" type="button">Time In</button>
          <button id="time-out-btn" type="button">Time Out</button>
          <button id="overtime-time-in-btn" type="button">Overtime Time In</button>
          <button id="overtime-time-out-btn" type="button">Overtime Time Out</button>
        </div> 
      </form>
    </div>

    <!-- MODAL -->
  <div class="bg-modal">
    <div class="modal-content">
        <div class="close">+</div>
        <h2 class="title-hed" id="modal-title">-Staff Attendance-</h2>
        
        <div class="camera-effect">
            <!-- Camera -->
            <form id="imageForm" action="save_image.php" method="post">
                <video id="video" class="video" width="640" height="480" autoplay></video><br>
                <input type="hidden" id="imageData" name="image" value="">
                <ion-icon class="icon" name="camera-outline" onclick="captureImage()"></ion-icon>
            </form>
        </div>

        <canvas id="canvas" class="canvas" width="500" height="400"></canvas>
        
        <div class="clock" id="clock">00:00:00</div>
        
        <div class="modal-btns">
            <button id="modal-action-btn" onclick="captureImage()">Confirm</button>
            <button class="close-modal">Cancel</button>
        </div>
    </div>
  </div>





        <script>
          
          navigator.mediaDevices.getUserMedia({ video: true })
              .then(function(stream) {
                  const videoElement = document.getElementById('video');
                  videoElement.srcObject = stream;
              })
              .catch(function(err) {
                  console.error('Error accessing the camera: ', err);
              });

          // Listen for form submission response
          document.getElementById('imageForm').addEventListener('submit', function(event) {
              event.preventDefault(); // Prevent form from submitting normally
              
              // Submit form data using Fetch API
              fetch('save_image.php', {
                  method: 'POST',
                  body: new FormData(event.target)
              })
              .then(response => response.json())
              .then(data => {
                  if (data.success) {
                      downloadImage(data.imageUrl); // Call download function if success
                  } else {
                      alert('Failed to save image.');
                  }
              })
              .catch(error => {
                  console.error('Error:', error);
                  alert('An error occurred. Please try again.');
              });

            })
        </script>
      
        <!--<script src="js/camera.js"></script>-->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="js/index.js"></script>
        <script src="js/realtimeclock.js"></script> 
        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

        <script>
    // Function to handle Time In button click
    document.getElementById('overtime-time-in-btn').addEventListener('click', function() {
        document.getElementById('employeeSelect').value = "<?php echo $employeeName; ?>";
        document.getElementById('overtime-time-in-btn').click();
    });

    // Function to handle Time Out button click
    document.getElementById('overtime-time-out-btn').addEventListener('click', function() {
        document.getElementById('employeeSelect').value = "<?php echo $employeeName; ?>";
        document.getElementById('overtime-time-out-btn').click();
    });
  </script>
  </body> 
  </html>