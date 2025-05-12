<?php
session_start();
include 'includes/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'], $_POST['notification_id'])) {
    $user_id = $_SESSION['user_id'];
    $notification_id = intval($_POST['notification_id']);

    // Make sure the notification belongs to the user
    $stmt = $conn->prepare("DELETE FROM notifications WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $notification_id, $user_id);
    $stmt->execute();
    $stmt->close();
}

header("Location: " . $_SERVER['HTTP_REFERER']); // Redirect back
exit;
