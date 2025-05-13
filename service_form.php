<?php
session_start();
include "includes/connection.php";

$message = '';
$showMessage = false;


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'], $_POST['email'], $_POST['phone'], $_POST['project_type'], $_POST['project_details'], $_POST['budget'], $_POST['timeline'])) {
    // Sanitize inputs
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim( $_POST['phone']);
    $project_type = $_POST['project_type'];
    $project_details = trim($_POST['project_details']);
    $budget = trim($_POST['budget']);
    $timeline = trim($_POST['timeline']);
    $created_at = date('Y-m-d H:i:s');
    $user_id = intval($_SESSION['user_id']);
    $status = 'requested';

    // Check if the required fields are not empty
    if (!empty($name) && !empty($email) && !empty($phone) && !empty($project_type) && !empty($project_details) && !empty($budget) && !empty($timeline)) {
        // SQL insert
        $sql = "INSERT INTO service (name, email, phone, project_type, project_details, budget, timeline, user_id, created_at, status)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $result = $conn->prepare($sql);
        $result->bind_param("ssssssssis", $name, $email, $phone, $project_type, $project_details, $budget, $timeline, $user_id, $created_at,$status);
        if($result->execute()){
           $_SESSION['message'] = "Form submitted successfully! We will get back to you soon.";
        } else {
            $_SESSION['message'] = "Error submitting form: " . $conn->error;
        }
        } else {
        $_SESSION['message'] = "Please fill in all the required fields.";
    }
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Show message if set
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    $showMessage = true;
    unset($_SESSION['message']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Hire Us - Development Services</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="style/service_form_style.css">
</head>
<body>

<div class="container">
  <div class="form-container">
    <!-- Back Arrow -->
    <a href="javascript:history.back()" class="back-btn">&#8592;</a>

    <h2 class="text-center">Hire Us for Your Development Project</h2>

    <!-- Display session message -->
    <?php if ($showMessage): ?>
      <div class="message <?= strpos($message, 'successfully') !== false ? 'success-message' : 'error-message' ?>">
        <?= htmlspecialchars($message) ?>
      </div>
    <?php endif; ?>

    <!-- Form Starts Here -->
    <form method="POST" action="">
      <div class="form-section">
        <div class="form-group">
          <label for="name" class="form-label">Full Name</label>
          <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
          <label for="email" class="form-label">Email Address</label>
          <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
          <label for="phone" class="form-label">Phone Number</label>
          <input type="tel" class="form-control" id="phone" name="phone" required>
        </div>
      </div>

      <div class="form-section">
        <div class="form-group">
          <label for="project_type" class="form-label">Type of Development</label>
          <select class="form-select" id="project_type" name="project_type" required>
            <option value="Desktop Development">Desktop Development</option>
            <option value="Web Development">Web Development</option>
            <option value="App Development">App Development</option>
          </select>
        </div>
      </div>

      <div class="form-section">
        <div class="form-group">
          <label for="project_details" class="form-label">Project Details</label>
          <textarea class="form-control" id="project_details" name="project_details" rows="4" required></textarea>
        </div>
        <div class="form-group">
          <label for="budget" class="form-label">Estimated Budget</label>
          <input type="text" class="form-control" id="budget" name="budget" required>
        </div>
        <div class="form-group">
          <label for="timeline" class="form-label">Expected Timeline</label>
          <input type="text" class="form-control" id="timeline" name="timeline" required>
        </div>
      </div>

      <div class="d-grid gap-2">
        <button type="submit" class="submit-btn">Submit Your Request</button>
      </div>
    </form>
  </div>
</div>

<div class="footer-text">
  <p>Our team will review your request, and you will get more details soon. Thank you for considering us for your development project!</p>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
