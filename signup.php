<?php
include 'includes/connection.php';

$message = ''; // default message

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name     = mysqli_real_escape_string($conn, $_POST['name']);
    $email    = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

    // Check if passwords match
    if ($password !== $confirm_password) {
        $message = '<div class="alert alert-danger">Passwords do not match.</div>';
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO user (name, email, password) VALUES ('$name', '$email', '$hashed_password')";

        if ($conn->query($sql) === TRUE) {
            $message = '<div class="alert alert-success">Account created successfully!</div>';
        } else {
            $message = '<div class="alert alert-danger">Error: ' . $conn->error . '</div>';
        }
    }

    $conn->close();
}
?>

<?php include 'includes/header.php'; ?>
<body class="form-page">
  <div class="form-container">
    <h2 class="text-center mb-4">Create Your TechHub Account</h2>

    <!-- Display message here -->
    <?php if (!empty($message)) echo $message; ?>

    <form action="signup.php" method="POST">
      <div class="mb-3">
        <label for="name" class="form-label">Full Name</label>
        <input type="text" class="form-control" id="name" name="name" placeholder="John Doe" required>
      </div>

      <div class="mb-3">
        <label for="email" class="form-label">Email address</label>
        <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" required>
      </div>

      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="Choose a password" required>
      </div>

      <div class="mb-3">
        <label for="confirm_password" class="form-label">Confirm Password</label>
        <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm your password" required>
      </div>

      <button type="submit" name="signup" class="btn btn-success">Sign Up</button>

      <div class="mt-3 text-center">
        Already have an account? <a href="login.php">Login</a>
      </div>
    </form>
  </div>
</body>
<?php include 'includes/footer.php'; ?>
