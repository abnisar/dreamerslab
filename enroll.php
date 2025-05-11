<?php
session_start();

include "includes/connection.php";

$user_id = $_SESSION["user_id"] ?? null;
$course_id = $_GET['course_id'] ?? null;

if ($user_id && $course_id) {
    // Check if already enrolled
    $check_stmt = $conn->prepare("SELECT * FROM enrollment WHERE course_id = ? AND user_id = ?");
    $check_stmt->bind_param("ii", $course_id, $user_id);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        $_SESSION['message'] = "You are already enrolled in this course.";
        $_SESSION['message_type'] = "warning";
    } else {
        $stmt = $conn->prepare('INSERT INTO enrollment(course_id, user_id, status) VALUES (?, ?, ?)');
        if ($stmt) {
            $status = 'requested';
            $stmt->bind_param('iis', $course_id, $user_id, $status);
            if ($stmt->execute()) {
                $_SESSION['message'] = "Enrolled successfully!";
                $_SESSION['message_type'] = "success";
            } else {
                $_SESSION['message'] = "Enrollment failed. Please try again.";
                $_SESSION['message_type'] = "danger";
            }
            $stmt->close();
        } else {
            $_SESSION['message'] = "Database error. Please try again.";
            $_SESSION['message_type'] = "danger";
        }
    }

    $check_stmt->close();
} else {
    $_SESSION['message'] = "Please log in first to enroll in a course.";
    $_SESSION['message_type'] = "warning";
}

header('Location: course.php');
exit;
