<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include "includes/header.php";
$isLoggedIn = isset($_SESSION['user_id']); 
?>



<div class="container">

    <!-- Title -->
    <div class="section-title">
        <h1 class="display-5 fw-bold">Desktop App Development</h1>
        <p class="text-muted">Building powerful and scalable desktop applications for every platform</p>
    </div>

    <!-- Technology Logos -->
    <div class="text-center tech-logos mb-5">
        <img src="https://img.icons8.com/color/96/c-sharp-logo.png" alt="C#">
        <img src="https://img.icons8.com/color/96/java-coffee-cup-logo--v1.png" alt="Java">
        <img src="https://img.icons8.com/color/96/electron.png" alt="Electron">
        <img src="https://img.icons8.com/color/96/dot-net.png" alt=".NET">
        <img src="https://img.icons8.com/color/96/python--v1.png" alt="Python">
        <img src="https://img.icons8.com/color/96/c-plus-plus-logo.png" alt="C++">
        <img src="https://img.icons8.com/fluency/96/visual-basic.png" alt="Visual Basic">
        <img src="https://img.icons8.com/color/96/qt.png" alt="Qt">
        <img src="https://img.icons8.com/fluency/96/node-js.png" alt="Node.js">
        <img src="https://img.icons8.com/color/96/windows8.png" alt="WPF">
    </div>

    <!-- Company Desktop Performance -->
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="performance-box text-center">
                <h4>30+ Desktop Apps</h4>
                <p>Reliable, fast, and intuitive applications across Windows, Linux, and macOS.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="performance-box text-center">
                <h4>Enterprise-Grade Systems</h4>
                <p>We build scalable software that meets professional enterprise demands.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="performance-box text-center">
                <h4>Secure & Offline Capable</h4>
                <p>All apps are built with offline support, encryption, and role-based access.</p>
            </div>
        </div>
    </div>

    <!-- Why Choose Us Section -->
    <div class="why-choose-us">
        <h4>Why Choose Us for Desktop Development?</h4>
        <ul>
            <li>Expertise in cross-platform development</li>
            <li>Support for legacy and modern tech stacks</li>
            <li>Strong focus on UI/UX and system performance</li>
            <li>Post-launch support and documentation</li>
            <li>Integration with APIs, hardware, and databases</li>
        </ul>
    </div>

    <!-- Hire Us Button -->
    <div class="text-center spacer">
        <button class="hire-btn btn-lg" onclick="handleHire()">Hire Us</button>
    </div>

</div>
<script>

    function handleHire() {
        const isLoggedIn = <?= $isLoggedIn ? 'true' : 'false' ?>;
        if (isLoggedIn) {
            window.location.href = 'service_form.php';
        } else {
            alert('You must login to hire this service.');
        }
    }
</script>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<?php
include "includes/footer.php";
?>
