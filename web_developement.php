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
        <h1 class="display-5 fw-bold">Web Development</h1>
        <p class="text-muted">Crafting modern, scalable websites for businesses and brands worldwide</p>
    </div>

    <!-- Technology Logos -->
    <div class="text-center tech-logos mb-5">
        <img src="https://img.icons8.com/color/96/html-5--v1.png" alt="HTML5" title="HTML5">
        <img src="https://img.icons8.com/color/96/css3.png" alt="CSS3" title="CSS3">
        <img src="https://img.icons8.com/color/96/javascript--v1.png" alt="JavaScript" title="JavaScript">
        <img src="https://img.icons8.com/officel/80/react.png" alt="React" title="React">
        <img src="https://img.icons8.com/ios-filled/100/laravel.png" alt="Laravel" title="Laravel">
        <img src="https://img.icons8.com/color/96/wordpress.png" alt="WordPress" title="WordPress">
        <img src="https://img.icons8.com/ios-filled/96/django.png" alt="Django" title="Django">
        <img src="https://img.icons8.com/ios-filled/96/flask.png" alt="Flask" title="Flask">
        <img src="https://img.icons8.com/color/96/bootstrap.png" alt="Bootstrap" title="Bootstrap">
        <img src="https://img.icons8.com/color/96/tailwind_css.png" alt="Tailwind CSS" title="Tailwind CSS">
        <img src="https://img.icons8.com/color/96/nodejs.png" alt="Node.js" title="Node.js">
        <img src="https://img.icons8.com/color/96/vue-js.png" alt="Vue.js" title="Vue.js">
    </div>


    <!-- Company Web Performance -->
    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="performance-box text-center">
                <h4>100+ Websites Delivered</h4>
                <p>From startups to enterprises, our websites power digital success stories.</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="performance-box text-center">
                <h4>SEO Optimized</h4>
                <p>All projects include built-in SEO to maximize your visibility and reach.</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="performance-box text-center">
                <h4>Responsive Designs</h4>
                <p>Perfect look and performance on desktops, tablets, and mobile devices.</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="performance-box text-center">
                <h4>Custom CMS Solutions</h4>
                <p>Flexible admin panels that allow you to control and scale with ease.</p>
            </div>
        </div>
    </div>

    <!-- Why Choose Us Section -->
    <div class="why-choose-us">
        <h4>Why Choose Us for Web Development?</h4>
        <ul>
            <li>Experienced team of frontend & backend developers</li>
            <li>Focus on performance, security, and usability</li>
            <li>Support for Laravel, React, WordPress, and more</li>
            <li>On-time delivery with affordable pricing</li>
            <li>Free 1-month support after project completion</li>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js">
</script>

<?php
include "includes/footer.php";
?>