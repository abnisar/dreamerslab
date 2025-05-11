<?php
session_start();
include 'includes/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
  $email    = mysqli_real_escape_string($conn, $_POST['email']);
  $password = mysqli_real_escape_string($conn, $_POST['password']);

  $sql = "SELECT * FROM user WHERE email = '$email' LIMIT 1";
  $result = $conn->query($sql);

  if ($result && $result->num_rows === 1) {
    $row = $result->fetch_assoc();

    if (password_verify($password, $row['password'])) {
      // ✅ Login successful
      $_SESSION['user_id'] = $row['id'];
      $_SESSION['user_name']  = $row['name'];
      $_SESSION['user_email'] = $row['email'];
      header("Location: index.php");
      exit();
    } else {
      $error = "❌ Incorrect password!";
    }
  } else {
    $error = "❌ Email not found!";
  }
}
?>

<?php include 'includes/header.php'; ?>
<?php if (isset($error)) : ?>
  <div class="alert alert-danger text-center"><?= $error ?></div>
<?php endif; ?>

<body class="form-page">

  <div class="form-container">
    <h2 class="text-center mb-4">TechHub Login</h2>
    <form action="login.php" method="POST">
      <div class="mb-3">
        <label for="email" class="form-label">Email address</label>
        <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" required>
      </div>

      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
        <div class="text-end mt-1">
          <a href="forgot_password.php" class="text-decoration-none small">Forgot Password?</a>
        </div>
      </div>


      <button type="submit" name="login" class="btn btn-primary">Login</button>

      <div class="mt-3 text-center">
        Don't have an account? <a href="signup.php">Sign up</a>
      </div>
    </form>
  </div>

</body>

<?php include 'includes/footer.php'; ?>