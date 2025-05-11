<?php include 'includes/header.php'; ?>

<body>

  <section class="contact-page py-5">
    <div class="container">
      <div class="text-center mb-5">
        <h2 class="text-teal fw-bold">Contact Us</h2>
        <p class="text-muted">We’d love to hear from you. Please reach out with any questions or feedback.</p>
      </div>

      <div class="row g-5">
        <!-- Contact Form -->
        <div class="col-lg-7">
          <div class="form-container">
            <form>
              <div class="mb-3">
                <label for="name" class="form-label">Your Name</label>
                <input type="text" id="name" class="form-control" placeholder="Enter your name" required />
              </div>
              <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" id="email" class="form-control" placeholder="Enter your email" required />
              </div>
              <div class="mb-3">
                <label for="message" class="form-label">Message</label>
                <textarea id="message" class="form-control" rows="5" placeholder="Write your message here..." required></textarea>
              </div>
              <button type="submit" class="btn btn-primary w-100">Send Message</button>
            </form>
          </div>
        </div>

        <!-- Contact Details -->
        <div class="col-lg-5">
          <div class="contact-details p-4 rounded shadow-sm bg-white">
            <h4 class="text-teal mb-4">Get in Touch</h4>
            <p><i class="fas fa-map-marker-alt me-2"></i>123 Tech Street, Innovation City, Pakistan</p>
            <p><i class="fas fa-phone me-2"></i>+92 300 1234567</p>
            <p><i class="fas fa-envelope me-2"></i>support@coursezone.com</p>

            <div class="social-links mt-4">
              <a href="#"><i class="fab fa-facebook-f"></i></a>
              <a href="#"><i class="fab fa-twitter"></i></a>
              <a href="#"><i class="fab fa-linkedin-in"></i></a>
              <a href="#"><i class="fab fa-instagram"></i></a>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>

</body>

<?php include 'includes/footer.php'; ?>

