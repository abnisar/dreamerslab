<?php
session_start();
include 'includes/connection.php';

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$error = '';
$success = '';

// Fetch current user data
$sql = "SELECT * FROM user WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $gender = $_POST['gender'];
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate input
    if (empty($name) || empty($email) || empty($gender)) {
        $error = "Please fill in all required fields.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } elseif (!empty($new_password) && $new_password !== $confirm_password) {
        $error = "New passwords do not match.";
    } else {
        // Check for duplicate email
        $sql = "SELECT id FROM user WHERE email = ? AND id != ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $email, $user_id);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $error = "Email is already taken.";
        } else {
            // Handle profile image upload
            $profile_img = $user['profile_img']; // fallback to existing
            if (isset($_FILES['profile_img']) && $_FILES['profile_img']['error'] == 0) {
                $target_dir = "uploads/profile_images/";
                if (!is_dir($target_dir)) {
                    mkdir($target_dir, 0755, true);
                }
                $imageFileType = strtolower(pathinfo($_FILES["profile_img"]["name"], PATHINFO_EXTENSION));
                $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
                if (in_array($imageFileType, $allowed_types)) {
                    $new_filename = uniqid() . '.' . $imageFileType;
                    $target_file = $target_dir . $new_filename;
                    if (move_uploaded_file($_FILES["profile_img"]["tmp_name"], $target_file)) {
                        // Delete old image
                        if (!empty($profile_img) && file_exists($profile_img)) {
                            unlink($profile_img);
                        }
                        $profile_img = $target_file;
                    } else {
                        $error = "Failed to upload profile image.";
                    }
                } else {
                    $error = "Only JPG, JPEG, PNG, and GIF files are allowed.";
                }
            }

            // If everything okay, update user
            if (empty($error)) {
                if (!empty($new_password)) {
                    if (password_verify($current_password, $user['password'])) {
                        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                    } else {
                        $error = "Current password is incorrect.";
                    }
                } else {
                    $hashed_password = $user['password']; // keep old
                }

                if (empty($error)) {
                    $sql = "UPDATE user SET name = ?, email = ?, password = ?, gender = ?, profile_img = ? WHERE id = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("sssssi", $name, $email, $hashed_password, $gender, $profile_img, $user_id);
                    if ($stmt->execute()) {
                        $success = "Profile updated successfully.";
                        $_SESSION['user_name'] = $name;
                        $_SESSION['user_email'] = $email;
                        $user['name'] = $name;
                        $user['email'] = $email;
                        $user['gender'] = $gender;
                        $user['profile_img'] = $profile_img;
                    } else {
                        $error = "Failed to update profile.";
                    }
                }
            }
        }
    }
}
?>

<?php include 'includes/header.php'; ?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Update Profile</h2>

    <?php if (!empty($error)) : ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <?php if (!empty($success)) : ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php endif; ?>

    <form action="update_profile.php" method="POST" enctype="multipart/form-data">
        <div class="row mb-3">
            <div class="col-md-4 text-center">
                <img src="<?= !empty($user['profile_img']) ? $user['profile_img'] : 'assets/images/default_avatar.png' ?>" alt="Profile Image" class="rounded-circle" width="150" height="150">
                <div class="mt-3">
                    <input type="file" name="profile_img" class="form-control">
                </div>
            </div>
            <div class="col-md-8">
                <div class="mb-3">
                    <label for="name" class="form-label">Full Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="gender" class="form-label">Gender</label>
                    <select class="form-select" id="gender" name="gender" required>
                        <option value="Male" <?= $user['gender'] == 'Male' ? 'selected' : '' ?>>Male</option>
                        <option value="Female" <?= $user['gender'] == 'Female' ? 'selected' : '' ?>>Female</option>
                        <option value="Other" <?= $user['gender'] == 'Other' ? 'selected' : '' ?>>Other</option>
                    </select>
                </div>
                <hr>
                <h5>Change Password</h5>
                <div class="mb-3">
                    <label for="current_password" class="form-label">Current Password</label>
                    <input type="password" class="form-control" id="current_password" name="current_password" placeholder="Enter current password">
                </div>
                <div class="mb-3">
                    <label for="new_password" class="form-label">New Password</label>
                    <input type="password" class="form-control" id="new_password" name="new_password" placeholder="Enter new password">
                </div>
                <div class="mb-3">
                    <label for="confirm_password" class="form-label">Confirm New Password</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm new password">
                </div>
                <button type="submit" class="btn btn-primary">Update Profile</button>
            </div>
        </div>
    </form>
</div>

<?php include 'includes/footer.php'; ?>
