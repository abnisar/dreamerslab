<?php include 'includes/header.php'; ?>


<!-- Carousel Start -->
<div id="homeCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="2500">
  <div class="carousel-inner">

    <!-- Slide 1 -->
    <div class="carousel-item active">
      <img src="assets\Gemini_Generated_Image_dv1hdidv1hdidv1h.jpeg" class="d-block w-100 carousel-img" alt="Slider 1">
      <div class="carousel-overlay"></div>
      <div class="carousel-caption text-center">
        <h1 class="fw-bold text-white">Welcome to Dreamers Lab</h1>
        <p class="lead text-white">Upskill, build, and grow with us.</p>
        <a href="course.php" class="btn btn-success btn-lg mt-3">Explore Courses</a>
      </div>
    </div>

    <!-- Slide 2 -->
    <div class="carousel-item">
      <img src="assets\Gemini_Generated_Image_nlod6bnlod6bnlod.jpeg" class="d-block w-100 carousel-img" alt="Slider 2">
      <div class="carousel-overlay"></div>
      <div class="carousel-caption text-center">
        <h1 class="fw-bold text-white">Your Trusted IT Partner</h1>
        <p class="lead text-white">Custom software, websites, and marketing solutions.</p>
        <a href="services.php" class="btn btn-success btn-lg mt-3">View Services</a>
      </div>
    </div>
  </div>

  <!-- Controls -->
  <button class="carousel-control-prev" type="button" data-bs-target="#homeCarousel" data-bs-slide="prev">
    <span class="carousel-control-prev-icon"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#homeCarousel" data-bs-slide="next">
    <span class="carousel-control-next-icon"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>
  <!-- Indicators -->
  <ol class="carousel-indicators">
    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
    <li data-target="#myCarousel" data-slide-to="1"></li>
    <li data-target="#myCarousel" data-slide-to="2"></li>
  </ol>

<!-- About Section -->
<section class="about py-5">
    <div class="container text-center">
        <h2 class="display-4 mb-4">About Dreamers Lab</h2>
        <p class="lead">Dreamers Lab is your digital growth partner offering certified online courses and professional IT services under one roof.</p>
        <p>Whether you are developing your technical skills or hiring top developers and designers, we ensure quality and trust in everything we deliver.</p>
    </div>
</section>

<!-- Features Section -->
<section class="features py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-4 display-4">Our Core Features</h2>
        <div class="row text-center">
            <div class="col-md-4 mb-4">
                <i class="bi bi-person-check display-4 text-primary mb-3"></i>
                <h4 class="h5 font-weight-bold">Certified Instructors</h4>
                <p>Learn from industry professionals with real-world experience.</p>
            </div>
            <div class="col-md-4 mb-4">
                <i class="bi bi-gear-fill display-4 text-success mb-3"></i>
                <h4 class="h5 font-weight-bold">Custom IT Services</h4>
                <p>Hire developers, designers, and IT specialists for your business.</p>
            </div>
            <div class="col-md-4 mb-4">
                <i class="bi bi-globe2 display-4 text-warning mb-3"></i>
                <h4 class="h5 font-weight-bold">Global Access</h4>
                <p>Join from anywhere, anytime, on any device with 24/7 support.</p>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="testimonials py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-4 display-4">What Our Users Say</h2>
        <div class="row">
            <div class="col-md-6 mb-4">
                <blockquote class="blockquote">
                    <p>"Dreamers Lab helped me grow my career with their amazing web development course. Highly recommended!"</p>
                    <footer class="blockquote-footer">Aisha Khan, Student</footer>
                </blockquote>
            </div>
            <div class="col-md-6 mb-4">
                <blockquote class="blockquote">
                    <p>"Their service team built my business website on time and budget. Great team!"</p>
                    <footer class="blockquote-footer">Faisal Ahmed, Entrepreneur</footer>
                </blockquote>
            </div>
        </div>
    </div>
</section>

<!-- Call-to-Action Section -->
<section class="cta bg-primary text-white text-center py-5">
    <div class="container">
        <h2 class="display-4">Ready to Get Started?</h2>
        <p class="lead">Join Dreamers Lab today and grow with us.</p>
        <a href="course.php" class="btn btn-light btn-lg mt-3">Get Started</a>
    </div>
</section>

<!-- Optional Script Includes (Bootstrap and Font Awesome Icons) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php include 'includes/footer.php'; ?>
