<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'includes/connection.php';

$profile_img = 'assets/avatar.png';
$notifications = [];

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Fetch profile image
    $stmt = $conn->prepare("SELECT profile_img FROM user WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($img);
    if ($stmt->fetch() && !empty($img)) {
        $profile_img = $img;
    }
    $stmt->close();

    // Fetch notifications
    $stmt = $conn->prepare("SELECT id, message, is_read FROM notifications WHERE user_id = ? ORDER BY created_at DESC LIMIT 5");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $notifications[] = $row;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dreamers Lab</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="style/style.css">
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="index.php">
                <img src="assets/logo.png" alt="Logo" width="50px" height="50px" class="me-2">
                <strong>Dreamers Lab</strong>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navbarNavDropdown">
                <ul class="navbar-nav align-items-center">
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="course.php">Courses</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="servicesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Services
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="servicesDropdown">
                            <li><a class="dropdown-item" href="app_developement.php">Mobile App Development</a></li>
                            <li><a class="dropdown-item" href="web_developement.php">Web Development</a></li>
                            <li><a class="dropdown-item" href="desktop_dev.php">Desktop Development</a></li>
                        </ul>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="aboutus.php">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>

                    <?php if (isset($_SESSION['user_id'])): ?>
                        <!-- Notification Dropdown -->
                        <li class="nav-item dropdown me-3">
                            <a class="nav-link dropdown-toggle position-relative" href="#" id="notificationDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-bell fs-5"></i>
                                <?php if (count($notifications) > 0): ?>
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        <?= count(array_filter($notifications, fn($n) => !$n['is_read'])) ?>
                                    </span>
                                <?php endif; ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end notifications" aria-labelledby="notificationDropdown">
                                <li class="dropdown-header">Notifications</li>
                                <?php if (!empty($notifications)): ?>
                                    <?php foreach ($notifications as $note): ?>
                                        <li class="px-3 py-2 border-bottom notification-item">
                                            <div class="<?= $note['is_read'] ? 'text-muted' : 'fw-bold' ?>">
                                                <?= htmlspecialchars($note['message']) ?>
                                            </div>
                                            <div class="mt-1 notification-actions">
                                                <form method="post" action="includes/delete_notification.php" class="d-inline">
                                                    <input type="hidden" name="notification_id" value="<?= $note['id'] ?>">
                                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                                </form>
                                            </div>
                                        </li>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <li><span class="dropdown-item-text text-muted small">No new notifications</span></li>
                                <?php endif; ?>
                            </ul>
                        </li>

                        <!-- Profile Dropdown -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                                <img src="<?= htmlspecialchars($profile_img) ?>" class="profile-img me-2" alt="Profile">
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="update_profile.php">Profile Edit</a></li>
                                <li><a class="dropdown-item" href="includes/logout.php">Logout</a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item ms-3">
                            <a class="btn btn-outline-light" href="login.php">Login</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Mark all notifications as read on icon click -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const bellIcon = document.querySelector('#notificationDropdown');
            bellIcon?.addEventListener('click', () => {
                fetch('mark_all_read.php', {
                    method: 'POST'
                });
            });
        });
    </script>

</body>

</html>