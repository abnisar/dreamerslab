<?php
session_start();
include 'includes/header.php'; ?>

<?php
if (isset($_SESSION['message'])): ?>
    <div class="alert alert-<?= $_SESSION['message_type'] ?> text-center alert-dismissible fade show" role="alert">
        <?= $_SESSION['message'] ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php unset($_SESSION['message'], $_SESSION['message_type']); ?>
<?php endif;

$searchQuery = '';
$durationFilter = '';
$params = [];
$types = '';

$sql = "SELECT * FROM course WHERE 1";

if (!empty($_POST['search'])) {
    $searchQuery = '%' . $_POST['search'] . '%';
    $sql .= " AND (title LIKE ? OR description LIKE ? OR teacher LIKE ?)";
    $types .= 'sss';
    $params[] = $searchQuery;
    $params[] = $searchQuery;
    $params[] = $searchQuery;
}

if (!empty($_POST['duration'])) {
    $durationFilter = $_POST['duration'];
    $sql .= " AND duration = ?";
    $types .= 's';
    $params[] = $durationFilter;
}

$stmt = $conn->prepare($sql);

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();
?>

<body>

    <section class="courses-section py-5">
        <div class="container">
            <h2 class="text-center mb-4 text-teal">Our Courses</h2>

            <!-- Search & Filter -->
            <div class="row mb-4">
                <div class="col-md-6 offset-md-3">
                    <form method="POST" class="d-flex justify-content-between align-items-center">
                        <input type="text" class="form-control me-2" name="search" placeholder="Search Courses..." value="<?= isset($_POST['search']) ? htmlspecialchars($_POST['search']) : '' ?>">

                        <select class="form-select me-2" name="duration">
                            <option value="">Filter by Duration</option>
                            <option value="2 Weeks" <?= isset($_POST['duration']) && $_POST['duration'] == '2 Weeks' ? 'selected' : '' ?>>2 Weeks</option>
                            <option value="1 Months" <?= isset($_POST['duration']) && $_POST['duration'] == '1 Months' ? 'selected' : '' ?>>1 Months</option>
                            <option value="3 Months" <?= isset($_POST['duration']) && $_POST['duration'] == '3 Months' ? 'selected' : '' ?>>3 Months</option>
                            <option value="6 Months" <?= isset($_POST['duration']) && $_POST['duration'] == '6 Months' ? 'selected' : '' ?>>6 Months</option>
                        </select>

                        <button class="btn btn-primary" type="submit">Apply</button>
                    </form>
                </div>
            </div>

            <!-- Courses Grid -->
            <div class="row g-4">
                <?php while ($course = $result->fetch_assoc()) : ?>
                    <div class="col-md-4">
                        <div class="card shadow-sm border-light h-100">
                            <?php
                            $imagePath = "uploads/course_images/course_placeholder.jpg"; // default
                            if (!empty($course['course_img']) && file_exists("uploads/course_images/" . $course['course_img'])) {
                                $imagePath = "uploads/course_images/" . $course['course_img'];
                            }
                            ?>
                            <img src="<?= $imagePath ?>" class="card-img-top" alt="Course Image" style="height: 200px; object-fit: cover;">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title text-teal"><?= htmlspecialchars($course['title']) ?></h5>
                                <p class="card-text"><?= substr(htmlspecialchars($course['description']), 0, 100) . '...' ?></p>
                                <p class="text-muted">Duration: <?= htmlspecialchars($course['duration']) ?></p>
                                <p class="text-muted">Instructor: <?= htmlspecialchars($course['teacher']) ?></p>
                                <p class="text-muted">Created at: <?= htmlspecialchars($course['created_at']) ?></p>
                                <div class="mt-auto">
                                    <?php if (isset($_SESSION['user_id'])): ?>
                                        <a href="includes/enroll.php?course_id=<?= $course['id'] ?>" class="btn btn-success w-100">Enroll Now</a>
                                    <?php else: ?>
                                        <button type="button" class="btn btn-success w-100" onclick="alert('Please login first to enroll in a course.')">Enroll Now</button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>

        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

<?php
$conn->close();
include 'includes/footer.php';
?>