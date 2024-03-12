<!-- <?php
  session_start();
  
  include("php/database.php");

  
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      
      $fname = $_POST['fname'];
      $username = $_POST['username'];
      $email = $_POST['email'];
      $password = $_POST['password'];
      $confirm_password = $_POST['confirm_password'];
      $gender = $_POST['gender'];  

      $hashed_password = password_hash($password, PASSWORD_DEFAULT);

      $sql = "INSERT INTO admin (fname, username, email, password, gender) VALUES ('$fname', '$username', '$email', '$hashed_password', '$gender')";
      mysqli_query($connection, $sql);

      header("Location: login_page.php");
      exit;
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>
    <link rel="stylesheet" href="css/registrationpage.css">
</head>
<body>
    <div class="container">
        <form action="registration_page.php" method="post" >
            <h2>-Admin Registration-</h2>
            <div class="content">
                <div class="input-box">
                    <label for="name">Fullname</label>
                    <input name="fname" type="text" placeholder="Full Name" required>
                    <label for="name">Username</label>
                    <input name="username" type="text" placeholder=" Username" required>
                </div>
                <div class="input-box">
                <label for="name">Email</label>
                    <input type="email" placeholder="Email" name="email" required>
                    <label for="name">Password</label>
                    <input type="password" placeholder="Password" name="password" required>
                    <label for="name">Confirm Password</label>
                    <input type="password" placeholder="Re-enter Password" name="confirm_password" required> 
                </div>
                <span class="gender-title">Gender</span>
                <div class="gender-category">
                    <input type="radio" id="male" name="gender" value="Male">
                    <label for="male">Male</label>
                    <input type="radio" id="female" name="gender" value="Female">
                    <label for="female">Female</label>
                </div>
                <div class="input-box">
                    <input class="signup" type="submit" value="Sign Up">
                </div>
            </div>
            <div class="alert">
                <p>By clicking Register, you agree to our <a href="#">Terms,</a><a href="#">Privacy Policy,</a> and <a href="#">Cookies Policy.</a></p>
            </div> 
        </form>
        <p>Already have an account? <a href="login_page.php"><span>Log in here</span></a></p>
    </div>
</body>
</html> -->