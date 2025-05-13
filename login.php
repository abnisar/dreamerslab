<?php
session_start();
include 'includes/connection.php';

$error = ""; // Initialize the error message

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
  $email    = trim($_POST['email']);
  $password = $_POST['password'];

  // Admin login shortcut
  if ($email === "admin@gmail.com" && $password === "admin12345") {
    $_SESSION['user_email'] = $email;
    $_SESSION['user_name']  = "Admin";
    $_SESSION['user_id']    = 0;
    header("Location: admin.php");
    exit();
  }

  // User login
  $sql = "SELECT * FROM user WHERE email = ? LIMIT 1";
  $stmt = $conn->prepare($sql);

  if ($stmt) {
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
      $row = $result->fetch_assoc();

      if (password_verify($password, $row['password'])) {
        $_SESSION['user_id']    = $row['id'];
        $_SESSION['user_name']  = $row['name'];
        $_SESSION['user_email'] = $row['email'];
        header("Location: index.php");
        exit();
      } else {
        $error = "Incorrect password!";
      }
    } else {
      $error = "Email not found!";
    }
    $stmt->close();
  } else {
    $error = "Error preparing the query.";
  }
}
?>

<?php include 'includes/header.php'; ?>
<?php if (!empty($error)) : ?>
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