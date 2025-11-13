<footer class="footer-container">
  <div class="container">
    <div class="footer-content">
      <!-- Logo and Branding -->
      <div class="footer-brand">
        <div class="logo-wrapper">
          <img src="https://saphotel.in/test/demo_files/admin/sri_logo.jpg" alt="Showbase Logo" class="footer-logo">
          <h3 class="brand-name">Showbase</h3>
        </div>
        <p class="brand-description">Innovative tech solutions for the modern world</p>
      </div>
      
      <!-- Quick Links -->
      <div class="footer-links">
        <h4 class="links-title">Quick Links</h4>
        <ul class="links-list">
          <li><a href="../index.php" class="link-item">Home</a></li>
          <li><a href="dashboard.php" class="link-item">Templates</a></li>
          <li><a href="ats_checker.php" class="link-item">Resume Checker</a></li>
          <li><a href="contact.php" class="link-item">Contact Us</a></li>
        </ul>
      </div>
      
      <!-- Contact Info -->
      <div class="footer-contact">
        <h4 class="contact-title">Get In Touch</h4>
        <div class="contact-item">
          <i class="fas fa-envelope"></i>
          <span>info@showbase.com</span>
        </div>
        <div class="contact-item">
          <i class="fas fa-phone"></i>
          <span>+91 6379162739</span>
        </div>
        <div class="contact-item">
          <i class="fas fa-map-marker-alt"></i>
          <span>Chennai , India</span>
        </div>
      </div>
      
      <!-- Newsletter -->
      <div class="footer-newsletter">
        <h4 class="newsletter-title">Subscribe to Our Newsletter</h4>
        <p class="newsletter-description">Get the latest updates and offers</p>
        <form class="newsletter-form">
          <input type="email" placeholder="Your email address" class="newsletter-input">
          <button type="submit" class="newsletter-btn">Subscribe</button>
        </form>
      </div>
    </div>
    
    <!-- Social Media & Copyright -->
    <div class="footer-bottom">
      <div class="copyright">
        <p>© 2024 Showbase | All rights reserved | Made with ❤️ by Showbase</p>
      </div>
      
      <div class="social-icons">
        <a href="https://facebook.com" class="social-icon facebook" aria-label="Facebook">
          <i class="fab fa-facebook-f"></i>
        </a>
        <a href="https://twitter.com" class="social-icon twitter" aria-label="Twitter">
          <i class="fab fa-twitter"></i>
        </a>
        <a href="https://instagram.com" class="social-icon instagram" aria-label="Instagram">
          <i class="fab fa-instagram"></i>
        </a>
        <a href="https://linkedin.com" class="social-icon linkedin" aria-label="LinkedIn">
          <i class="fab fa-linkedin"></i>
        </a>
        <a href="https://wa.me/6379162739" class="social-icon whatsapp" aria-label="WhatsApp" target="_blank">
          <i class="fab fa-whatsapp"></i>
        </a>
      </div>
    </div>
  </div>
  
  <!-- Decorative Elements -->
  <div class="footer-decoration">
    <div class="decoration-circle circle-1"></div>
    <div class="decoration-circle circle-2"></div>
    <div class="decoration-circle circle-3"></div>
  </div>
</footer>

<!-- Font Awesome for social icons -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>

<style>
  /* CSS Variables for Color Palette */
  :root {
    --dark-navy: #0B0F19;
    --deep-gray: #1A1F2B;
    --neon-purple: #7C3AED;
    --electric-blue: #3B82F6;
    --aqua-accent: #22D3EE;
    --gradient-1: linear-gradient(135deg, var(--dark-navy) 0%, var(--deep-gray) 100%);
    --gradient-2: linear-gradient(135deg, var(--neon-purple) 0%, var(--electric-blue) 100%);
    --gradient-3: linear-gradient(135deg, var(--electric-blue) 0%, var(--aqua-accent) 100%);
    --gradient-border: linear-gradient(135deg, var(--neon-purple), var(--electric-blue), var(--aqua-accent));
  }

  /* Footer Container */
  .footer-container {
    background: var(--gradient-1);
    color: #fff;
    padding: 4rem 0 2rem;
    position: relative;
    overflow: hidden;
    margin-top: 5rem;
    box-shadow: 0 -5px 20px rgba(0, 0, 0, 0.3);
  }

  .footer-container::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 2px;
    background: var(--gradient-border);
    animation: gradient-shift 3s ease infinite;
  }

  @keyframes gradient-shift {
    0% { background-position: 0% center; }
    50% { background-position: 100% center; }
    100% { background-position: 0% center; }
  }

  .container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 2rem;
    font-family: 'Poppins', sans-serif;
  }

  .footer-content {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 2rem;
    margin-bottom: 3rem;
  }

  /* Footer Branding */
  .footer-brand {
    display: flex;
    flex-direction: column;
    gap: 1rem;
  }

  .logo-wrapper {
    display: flex;
    align-items: center;
    gap: 0.75rem;
  }

  .footer-logo {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    border: 2px solid var(--aqua-accent);
    box-shadow: 0 0 15px rgba(34, 211, 238, 0.5);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }

  .footer-logo:hover {
    transform: rotate(6deg) scale(1.05);
    box-shadow: 0 0 20px rgba(34, 211, 238, 0.7);
  }

  .brand-name {
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 1.5rem;
    background: var(--gradient-2);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin: 0;
  }

  .brand-description {
    color: #b0b0b0;
    max-width: 250px;
    line-height: 1.6;
  }

  /* Footer Links */
  .footer-links {
    display: flex;
    flex-direction: column;
    gap: 1rem;
  }

  .links-title {
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    font-size: 1.2rem;
    margin: 0 0 0.5rem;
    position: relative;
    display: inline-block;
  }

  .links-title::after {
    content: '';
    position: absolute;
    bottom: -5px;
    left: 0;
    width: 40px;
    height: 2px;
    background: var(--gradient-3);
    border-radius: 2px;
  }

  .links-list {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
  }

  .link-item {
    color: #b0b0b0;
    text-decoration: none;
    transition: color 0.3s ease, transform 0.3s ease;
    position: relative;
    display: inline-block;
  }

  .link-item::before {
    content: '';
    position: absolute;
    bottom: -2px;
    left: 0;
    width: 0;
    height: 1px;
    background: var(--aqua-accent);
    transition: width 0.3s ease;
  }

  .link-item:hover {
    color: var(--aqua-accent);
    transform: translateX(5px);
  }

  .link-item:hover::before {
    width: 100%;
  }

  /* Footer Contact */
  .footer-contact {
    display: flex;
    flex-direction: column;
    gap: 1rem;
  }

  .contact-title {
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    font-size: 1.2rem;
    margin: 0 0 0.5rem;
    position: relative;
    display: inline-block;
  }

  .contact-title::after {
    content: '';
    position: absolute;
    bottom: -5px;
    left: 0;
    width: 40px;
    height: 2px;
    background: var(--gradient-3);
    border-radius: 2px;
  }

  .contact-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    color: #b0b0b0;
  }

  .contact-item i {
    color: var(--aqua-accent);
    width: 20px;
    text-align: center;
  }

  /* Footer Newsletter */
  .footer-newsletter {
    display: flex;
    flex-direction: column;
    gap: 1rem;
  }

  .newsletter-title {
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    font-size: 1.2rem;
    margin: 0 0 0.5rem;
    position: relative;
    display: inline-block;
  }

  .newsletter-title::after {
    content: '';
    position: absolute;
    bottom: -5px;
    left: 0;
    width: 40px;
    height: 2px;
    background: var(--gradient-3);
    border-radius: 2px;
  }

  .newsletter-description {
    color: #b0b0b0;
    margin-bottom: 0.5rem;
  }

  .newsletter-form {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
  }

  .newsletter-input {
    padding: 0.75rem;
    border: 1px solid rgba(124, 58, 237, 0.3);
    border-radius: 8px;
    background: rgba(26, 31, 43, 0.5);
    color: #fff;
    font-family: 'Poppins', sans-serif;
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
  }

  .newsletter-input:focus {
    outline: none;
    border-color: var(--electric-blue);
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
  }

  .newsletter-btn {
    padding: 0.75rem;
    border: none;
    border-radius: 8px;
    background: var(--gradient-2);
    color: #fff;
    font-family: 'Poppins', sans-serif;
    font-weight: 500;
    cursor: pointer;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }

  .newsletter-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
  }

  /* Footer Bottom */
  .footer-bottom {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 2rem;
    border-top: 1px solid rgba(124, 58, 237, 0.2);
  }

  .copyright {
    color: #b0b0b0;
    font-size: 0.9rem;
  }

  /* Social Icons */
  .social-icons {
    display: flex;
    gap: 1rem;
  }

  .social-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    text-decoration: none;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
  }

  .social-icon::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    border-radius: 50%;
    background: var(--gradient-2);
    opacity: 0;
    transition: opacity 0.3s ease;
  }

  .social-icon i {
    position: relative;
    z-index: 1;
  }

  .social-icon:hover::before {
    opacity: 1;
  }

  .social-icon:hover {
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
  }

  /* Decorative Elements */
  .footer-decoration {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    pointer-events: none;
    overflow: hidden;
  }

  .decoration-circle {
    position: absolute;
    border-radius: 50%;
    background: var(--gradient-2);
    opacity: 0.1;
  }

  .circle-1 {
    width: 300px;
    height: 300px;
    top: -150px;
    right: -100px;
  }

  .circle-2 {
    width: 200px;
    height: 200px;
    bottom: -100px;
    left: 10%;
  }

  .circle-3 {
    width: 150px;
    height: 150px;
    top: 50%;
    left: -75px;
  }

  /* Responsive Design */
  @media (max-width: 768px) {
    .footer-content {
      grid-template-columns: 1fr;
      gap: 2rem;
    }
    
    .footer-bottom {
      flex-direction: column;
      gap: 1.5rem;
      text-align: center;
    }
    
    .social-icons {
      justify-content: center;
    }
  }
</style>