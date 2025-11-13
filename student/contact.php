<?php include('../includes/header.php'); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    
    <!-- Google Fonts - Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
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

        /* Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--gradient-1);
            color: #e0e0e0;
            line-height: 1.6;
            padding-top: 80px; /* Space for fixed header */
        }

        /* Page Header */
        .page-header {
            padding: 4rem 0 2rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .page-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('https://images.unsplash.com/photo-1516321318423-f06f85e504b3?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80') center/cover;
            opacity: 0.2;
            z-index: -1;
        }

        .page-header h1 {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 2.5rem;
            margin-bottom: 1rem;
            background: var(--gradient-2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            position: relative;
            display: inline-block;
        }

        .page-header h1::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 3px;
            background: var(--gradient-3);
            border-radius: 3px;
        }

        .page-header p {
            font-family: 'Poppins', sans-serif;
            font-weight: 400;
            font-size: 1.1rem;
            max-width: 600px;
            margin: 0 auto;
            color: #b0b0b0;
        }

        /* Container */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        /* Contact Section */
        .contact-section {
            padding: 4rem 0;
            display: flex;
            flex-wrap: wrap;
            gap: 3rem;
        }

        .contact-form-container, .contact-info-container {
            flex: 1;
            min-width: 300px;
        }

        .section-title {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 1.8rem;
            margin-bottom: 1.5rem;
            color: #fff;
            position: relative;
            display: inline-block;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 0;
            width: 60px;
            height: 3px;
            background: var(--gradient-3);
            border-radius: 3px;
        }

        .section-description {
            color: #b0b0b0;
            margin-bottom: 2rem;
        }

        /* Contact Form */
        .contact-form {
            background: rgba(26, 31, 43, 0.7);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(124, 58, 237, 0.2);
            position: relative;
            overflow: hidden;
        }

        .contact-form::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            border-radius: 16px;
            padding: 2px;
            background: var(--gradient-border);
            mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            mask-composite: exclude;
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            z-index: -1;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
            font-size: 1rem;
            margin-bottom: 0.5rem;
            color: #fff;
        }

        .form-input, .form-textarea {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid rgba(124, 58, 237, 0.3);
            border-radius: 8px;
            background: rgba(26, 31, 43, 0.5);
            color: #fff;
            font-family: 'Poppins', sans-serif;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .form-input:focus, .form-textarea:focus {
            outline: none;
            border-color: var(--electric-blue);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
        }

        .form-textarea {
            resize: vertical;
            min-height: 120px;
        }

        .form-button {
            width: 100%;
            padding: 0.875rem;
            border: none;
            border-radius: 8px;
            background: var(--gradient-2);
            color: #fff;
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
            font-size: 1rem;
            cursor: pointer;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .form-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        /* Contact Info */
        .contact-info {
            background: rgba(26, 31, 43, 0.7);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(124, 58, 237, 0.2);
            position: relative;
            overflow: hidden;
        }

        .contact-info::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            border-radius: 16px;
            padding: 2px;
            background: var(--gradient-border);
            mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            mask-composite: exclude;
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            z-index: -1;
        }

        .contact-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 1.5rem;
        }

        .contact-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: rgba(26, 31, 43, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            border: 1px solid rgba(124, 58, 237, 0.3);
            transition: all 0.3s ease;
        }

        .contact-icon i {
            font-size: 1.2rem;
            color: var(--aqua-accent);
        }

        .contact-item:hover .contact-icon {
            background: var(--gradient-2);
            border-color: transparent;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        .contact-item:hover .contact-icon i {
            color: #fff;
        }

        .contact-details h4 {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 1.1rem;
            margin-bottom: 0.25rem;
            color: #fff;
        }

        .contact-details p {
            color: #b0b0b0;
        }

        /* Map Section */
        .map-section {
            padding: 4rem 0;
        }

        .map-container {
            background: rgba(26, 31, 43, 0.7);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(124, 58, 237, 0.2);
            position: relative;
            overflow: hidden;
        }

        .map-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            border-radius: 16px;
            padding: 2px;
            background: var(--gradient-border);
            mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            mask-composite: exclude;
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            z-index: -1;
        }

        .map-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .map-header h2 {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 1.8rem;
            margin-bottom: 0.5rem;
            color: #fff;
        }

        .map-header p {
            color: #b0b0b0;
        }

        .map-frame {
            width: 100%;
            height: 400px;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid rgba(124, 58, 237, 0.3);
        }

        .map-frame iframe {
            width: 100%;
            height: 100%;
            border: none;
        }

        /* Decorative Elements */
        .decoration-circle {
            position: absolute;
            border-radius: 50%;
            background: var(--gradient-2);
            opacity: 0.1;
            z-index: -1;
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

        /* Responsive Design */
        @media (max-width: 768px) {
            .page-header h1 {
                font-size: 2rem;
            }
            
            .contact-section {
                flex-direction: column;
                gap: 2rem;
            }
            
            .map-frame {
                height: 300px;
            }
        }
    </style>
</head>
<body>
    <!-- Page Header -->
    <div class="page-header">
        <div class="container">
            <h1>Get in Touch with Us</h1>
            <p>We'd love to hear from you! Feel free to reach out with any questions or inquiries. (Update Your Portfolio Details)</p>
        </div>
        <div class="decoration-circle circle-1"></div>
        <div class="decoration-circle circle-2"></div>
    </div>

    <!-- Contact Section -->
    <section class="container">
        <div class="contact-section">
            <!-- Contact Form -->
            <div class="contact-form-container">
                <h2 class="section-title">Send Us a Message</h2>
                <p class="section-description">Fill out the form below and we'll get back to you as soon as possible.</p>
                
                <form action="submit_contact.php" method="POST" class="contact-form">
                    <div class="form-group">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" id="name" name="name" class="form-input" value="<?php echo htmlspecialchars($_SESSION['name']) ?? ""; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" id="email" name="email" class="form-input" value="<?php echo htmlspecialchars($_SESSION['email']) ?? ""; ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="message" class="form-label">Your Message</label>
                        <textarea id="message" name="message" class="form-textarea" required></textarea>
                    </div>
                    
                    <button type="submit" class="form-button">Send Message</button>
                </form>
            </div>

            <!-- Contact Information -->
            <div class="contact-info-container">
                <h2 class="section-title">Contact Information</h2>
                <p class="section-description">Our team is here to answer any questions you may have.</p>
                
                <div class="contact-info">
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="contact-details">
                            <h4>Location</h4>
                            <p>Chennai, Tamil Nadu</p>
                        </div>
                    </div>
                    
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="contact-details">
                            <h4>Working Hours</h4>
                            <p>Monday - Friday: 9:00 AM - 5:00 PM</p>
                        </div>
                    </div>
                    
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="contact-details">
                            <h4>Email</h4>
                            <p>potterharry623016@gmail.com</p>
                        </div>
                    </div>
                    
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="contact-details">
                            <h4>Phone</h4>
                            <p>+91 6369752557</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <section class="container">
        <div class="map-section">
            <div class="map-container">
                <div class="map-header">
                    <h2>Visit Our Office</h2>
                    <p>Find us on the map below and stop by our office for a chat!</p>
                </div>
                <div class="map-frame">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3898.8076142704894!2d80.12117771482096!3d12.922904890886401!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3a52f73f78b84963%3A0x7aef1f7f8d7ed540!2sTambaram%2C%20Chennai%2C%20Tamil%20Nadu!5e0!3m2!1sen!2sin!4v1614001450930!5m2!1sen!2sin"
                        width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
        </div>
    </section>

</body>
</html>
<?php include('../includes/footer.php'); ?>