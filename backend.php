<?php
session_start();
include 'includes/connection.php';

// Set active tab
$active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'enrollments';


 // adjust this to your actual DB connection script

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submit_course'])) {
        // Get course form data
        $title = $_POST['title'];
        $description = $_POST['course_desc'];
        $duration = $_POST['duration'];
        $teacher = $_POST['teacher'];

        // Image upload handling
        $course_img = $_FILES['course_img'];
        $img_name = $course_img['name'];
        $img_tmp = $course_img['tmp_name'];
        $img_error = $course_img['error'];

        if ($img_error === 0) {
            // Get file extension
            $img_ext = strtolower(pathinfo($img_name, PATHINFO_EXTENSION));

            // Generate unique image name
            $img_new_name = uniqid('', true) . '.' . $img_ext;

            // Use absolute path for more reliability
            $img_upload_path = __DIR__ . '/uploads/course_images/' . $img_new_name;

            // Move uploaded file
            if (move_uploaded_file($img_tmp, $img_upload_path)) {
                // Prepare and execute insert query
                $stmt = $conn->prepare("INSERT INTO course (title, description, duration, teacher, course_img) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("sssss", $title, $description, $duration, $teacher, $img_new_name);

                if ($stmt->execute()) {
                    $_SESSION['message'] = 'Course added successfully!';
                    $_SESSION['active_tab'] = 'addcourse';
                } else {
                    $_SESSION['message'] = 'Error adding course to the database.';
                }

                $stmt->close();
            } else {
                $_SESSION['message'] = 'Failed to upload image.';
            }
        } else {
            $_SESSION['message'] = 'Error uploading image. Error code: ' . $img_error;
        }

        // Redirect back to admin panel
        header("Location: admin.php?tab=" . ($_SESSION['active_tab'] ?? 'addcourse'));
        exit();
    }
}


// Load data for tabs
$enrollments = $conn->query("SELECT e.id, u.id as user_id, u.name, c.title as course_title, e.status 
                           FROM enrollment e 
                           JOIN user u ON e.user_id = u.id 
                           JOIN course c ON e.course_id = c.id 
                           ORDER BY e.status, e.id DESC");

// Fetch Service Requests (uncommented)
$services = $conn->query("SELECT s.id, u.id as user_id, u.name, s.project_type, s.project_details, s.status 
                          FROM service s 
                          JOIN user u ON s.user_id = u.id 
                          ORDER BY s.status, s.id DESC");


// Set active tab from session if available
if (isset($_SESSION['active_tab'])) {
    $active_tab = $_SESSION['active_tab'];
    unset($_SESSION['active_tab']);
}
?>