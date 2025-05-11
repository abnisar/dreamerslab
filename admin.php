<?php
include 'backend.php';
// include 'includes/header.php'; 
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Panel - Dreamers Lab</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card {
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        .nav-tabs .nav-link.active {
            background-color: #343a40;
            color: white;
            border-color: #343a40;
        }

        .admin-header {
            background-color: #343a40;
            color: white;
            padding: 1.5rem;
            border-radius: 10px;
            margin-bottom: 2rem;
        }

        .tab-content {
            padding: 20px 0;
        }
    </style>
</head>

<body class="bg-light"></body>
<div class="container mt-5">
    <div class="admin-header text-center">
        <h2>Dreamers Lab - Admin Panel</h2>
    </div>

    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-info text-center"><?= $_SESSION['message'];
                                                    unset($_SESSION['message']); ?></div>
    <?php endif; ?>

    <!-- Tabs Navigation -->
    <ul class="nav nav-tabs mb-4" id="adminTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link <?= $active_tab === 'enrollments' ? 'active' : '' ?>"
                href="admin.php?tab=enrollments">Course Enrollments</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link <?= $active_tab === 'services' ? 'active' : '' ?>"
                href="admin.php?tab=services">Service Requests</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link <?= $active_tab === 'addcourse' ? 'active' : '' ?>"
                href="admin.php?tab=addcourse">Add Course</a>
        </li>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content" id="adminTabsContent">
        <!-- Enrollments Tab -->
        <div class="tab-pane fade <?= $active_tab === 'enrollments' ? 'show active' : '' ?>" id="enrollments">
            <?php while ($row = $enrollments->fetch_assoc()): ?>
                <div class="card mb-3">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h5><?= htmlspecialchars($row['name']) ?> requested to enroll in <?= htmlspecialchars($row['course_title']) ?></h5>
                            <p>
                                <strong>Status:</strong>
                                <span class="status-badge status-<?= strtolower($row['status']) ?>">
                                    <?= ucfirst($row['status']) ?>
                                </span>
                            </p>
                        </div>
                        <div>
                            <?php if ($row['status'] === 'Requested'): ?>
                                <a href="enrollment_status.php?id=<?= $row['id'] ?>&action=Approved&user_id=<?= $row['user_id'] ?>" class="btn btn-success me-2">Accept</a>
                                <a href="enrollment_status.php?id=<?= $row['id'] ?>&action=Decline&user_id=<?= $row['user_id'] ?>" class="btn btn-danger">Decline</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>

        <!-- Add Course Tab -->
        <div class="tab-pane fade <?= $active_tab === 'addcourse' ? 'show active' : '' ?>" id="addcourse">
            <div class="card p-4">
                <h5>Add New Course</h5>
                <form action="admin.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="title" class="form-label">Course Name</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="course_desc" class="form-label">Description</label>
                        <textarea class="form-control" id="course_desc" name="course_desc" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="duration" class="form-label">Duration</label>
                        <input type="text" class="form-control" id="duration" name="duration" required>
                    </div>
                    <div class="mb-3">
                        <label for="teacher" class="form-label">Teacher</label>
                        <input type="text" class="form-control" id="teacher" name="teacher" required>
                    </div>
                    <div class="mb-3">
                        <label for="course_img" class="form-label">Course Image</label>
                        <input type="file" class="form-control" id="course_img" name="course_img" required>
                    </div>
                    <button type="submit" name="submit_course" class="btn btn-primary">Add Course</button>
                </form>
            </div>
        </div>

        <!-- Service Requests Tab -->
        <div class="tab-pane fade <?= $active_tab === 'services' ? 'show active' : '' ?>" id="services">
            <?php while ($row = $services->fetch_assoc()): ?>
                <div class="card mb-3">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h5><?= htmlspecialchars($row['name']) ?> requested service: <?= htmlspecialchars($row['service_type']) ?></h5>
                            <p><?= htmlspecialchars($row['details']) ?></p>
                        </div>
                        <div>
                            <a href="approve_service.php?id=<?= $row['id'] ?>" class="btn btn-success me-2">Approve</a>
                            <a href="decline_service.php?id=<?= $row['id'] ?>" class="btn btn-danger">Decline</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>


    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Activate the correct tab on page load
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const activeTab = urlParams.get('tab') || 'enrollments';

        // Show the active tab
        const tabPane = document.getElementById(activeTab);
        if (tabPane) {
            tabPane.classList.add('show', 'active');
        }
    });
</script>
</body>

</html>