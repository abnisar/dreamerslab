<?php
session_start();
include 'includes/connection.php';

// Check if ID and action parameters exist
if (isset($_GET['id']) && isset($_GET['action']) && isset($_GET['user_id'])) {
    $enrollment_id = (int)$_GET['id'];
    $enrollment_id = (int)$_GET['id'];
    $action = $_GET['action'];
    $user_id = $_GET['user_id'];
    
    // Validate action
    if (in_array($action, ['Approved', 'Decline'])) {
        
        // Update the enrollment status
        $stmt = $conn->prepare("UPDATE enrollment SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $action, $enrollment_id);
        
        if ($stmt->execute()) {
            $_SESSION['message'] = "Enrollment request has been $action.";
        } else {
            $_SESSION['message'] = "Error updating enrollment status.";
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
header("Location: admin.php?tab=enrollments");
exit();
?>