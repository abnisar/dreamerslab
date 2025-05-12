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
    <h1 class="display-5 fw-bold">Mobile App Development</h1>
    <p class="text-muted">Empowering businesses with cutting-edge mobile solutions</p>
  </div>

  <!-- Technology Logos -->
  <div class="text-center tech-logos mb-5">
  <img src="https://img.icons8.com/color/96/000000/android-os.png" alt="Android" title="Android">
  <img src="https://img.icons8.com/ios-filled/100/000000/ios-logo.png" alt="iOS" title="iOS">
  <img src="https://img.icons8.com/color/96/000000/flutter.png" alt="Flutter" title="Flutter">
  <img src="https://img.icons8.com/color/96/000000/react-native.png" alt="React Native" title="React Native">
  <img src="https://img.icons8.com/color/96/000000/firebase.png" alt="Firebase" title="Firebase">
  <img src="https://img.icons8.com/color/96/000000/swift.png" alt="Swift" title="Swift">
  <img src="https://img.icons8.com/color/96/000000/kotlin.png" alt="Kotlin" title="Kotlin">
  <img src="https://img.icons8.com/color/96/000000/xamarin.png" alt="Xamarin" title="Xamarin">
  <img src="https://img.icons8.com/color/96/000000/cordova.png" alt="Apache Cordova" title="Cordova">
  <img src="https://img.icons8.com/color/96/ionic.png" alt="Ionic" title="Ionic">
</div>


  <!-- Company App Performance -->
  <div class="row g-4 mb-5">
    <div class="col-md-4">
      <div class="performance-box text-center">
        <h4>50+ Apps Launched</h4>
        <p>Our portfolio features over 50 mobile apps across multiple industries.</p>
      </div>
    </div>
    <div class="col-md-4">
      <div class="performance-box text-center">
        <h4>1M+ Downloads</h4>
        <p>Apps developed by us have reached more than 1 million users worldwide.</p>
      </div>
    </div>
    <div class="col-md-4">
      <div class="performance-box text-center">
        <h4>99% Client Satisfaction</h4>
        <p>We take pride in maintaining excellent client relationships and support.</p>
      </div>
    </div>
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
