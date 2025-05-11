<?php
session_start();
include 'includes/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['reset_password'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $new_password = mysqli_real_escape_string($conn, $_POST['new_password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

    // Validate password match
    if ($new_password !== $confirm_password) {
        echo "<div class='alert alert-danger text-center'>Passwords do not match!</div>";
    } else {
        // Check if email exists
        $sql = "SELECT * FROM user WHERE email = '$email' LIMIT 1";
        $result = $conn->query($sql);

        if ($result && $result->num_rows == 1) {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT); // Hash the password

            // Update the password in the database
            $sql = "UPDATE user SET password='$hashed_password' WHERE email='$email'";

            if ($conn->query($sql)) {
                echo "<div class='alert alert-success text-center'>Password updated successfully. <a href='login.php'>Login now.</a></div>";
            } else {
                echo "<div class='alert alert-danger text-center'>There was an error updating the password. Please try again.</div>";
            }
        } else {
            echo "<div class='alert alert-danger text-center'>Email not found in our database.</div>";
        }
    }
}
?>

<?php include 'includes/header.php'; ?>
<body class="form-page">

  <div class="form-container">
    <h2 class="text-center mb-4">Forgot Password</h2>
    <form action="forgot_password.php" method="POST">
      <div class="mb-3">
        <label for="email" class="form-label">Enter your email address</label>
        <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" required>
      </div>

      <div class="mb-3">
        <label for="new_password" class="form-label">New Password</label>
        <input type="password" class="form-control" id="new_password" name="new_password" placeholder="Enter your new password" required>
      </div>

      <div class="mb-3">
        <label for="confirm_password" class="form-label">Confirm New Password</label>
        <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm your new password" required>
      </div>

      <button type="submit" name="reset_password" class="btn btn-primary">Reset Password</button>

      <div class="mt-3 text-center">
        <a href="login.php">Back to Login</a>
      </div>
    </form>
  </div>

</body>

<?php include 'includes/footer.php'; ?>
