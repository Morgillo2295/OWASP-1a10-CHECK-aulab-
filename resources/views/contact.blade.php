<x-layouts.app title="Contact">
  <div class="container mt-5">
    <div class="row justify-content-center mb-4">
      <div class="col-12 text-center">
        <h1 class="display-4 fw-bold text-primary mb-2"><i class="bi bi-envelope-at me-2"></i>Contact Us</h1>
        <p class="lead text-muted">We'd love to hear from you! Fill out the form below or reach us by email.</p>
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col-md-10 col-lg-8">
        <div class="card shadow-lg border-0 rounded-4">
          <div class="card-body p-4">
            <form action="mailto:info@cyberblog.com" method="POST" enctype="text/plain">
              <div class="mb-3">
                <label for="name" class="form-label fw-semibold">Your Name</label>
                <input type="text" class="form-control rounded-pill" id="name" name="name" placeholder="Enter your name" required>
              </div>
              <div class="mb-3">
                <label for="email" class="form-label fw-semibold">Your Email</label>
                <input type="email" class="form-control rounded-pill" id="email" name="email" placeholder="Enter your email" required>
              </div>
              <div class="mb-3">
                <label for="message" class="form-label fw-semibold">Message</label>
                <textarea class="form-control rounded-4" id="message" name="message" rows="5" placeholder="Type your message here..." required></textarea>
              </div>
              <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold"><i class="bi bi-send me-1"></i>Send</button>
              </div>
            </form>
            <div class="mt-4 text-center text-muted">
              <i class="bi bi-envelope-fill me-2"></i>Or email us directly at <a href="mailto:info@cyberblog.com" class="fw-semibold text-primary">info@cyberblog.com</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</x-layouts.app> 