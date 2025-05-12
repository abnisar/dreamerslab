<?php
session_start();
include 'includes/connection.php';

if (isset($_GET['id'], $_GET['action'], $_GET['user_id'])) {
    $id = $_GET['id'];
    $action = $_GET['action'];
    $user_id = $_GET['user_id'];

    if ($action === 'Approved' || $action === 'Decline') {
        $stmt = $conn->prepare("UPDATE service SET status = ? WHERE id = ? AND user_id = ?");
        $stmt->bind_param("sii", $action, $id, $user_id);
        
        if ($stmt->execute()) {
            $_SESSION['message'] = 'Service request has been ' . $action .'!';
        } else {
            $_SESSION['message'] = 'Error updating service request status.';
        }

        $stmt->close();
        $message = $_SESSION['message'];
        $notif_stmt = $conn->prepare("insert into notifications(user_id, message) values (?, ?)");
        $notif_stmt->bind_param("is", $user_id, $message);
        $notif_stmt->execute();
        $notif_stmt->close();
    } else {
        $_SESSION['message'] = "Invalid action specified.";
    }
} else {
    $_SESSION['message'] = "Missing parameters.";
}

// Redirect back to the admin panel
header("Location: ../admin.php?tab=services");
exit();
?>
