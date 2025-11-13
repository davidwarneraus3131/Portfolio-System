<?php
// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You - Showbase</title>
    
    <!-- Google Fonts - Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- AOS Animation Library -->
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    
    <!-- Favicon -->
    <link rel="icon" href="https://saphotel.in/test/demo_files/admin/sri_logo.jpg" type="image/png">

    <style>
        /* CSS Variables for Premium Color Palette */
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
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }

        /* Animated Background */
        .animated-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            background: linear-gradient(45deg, #0B0F19, #1A1F2B, #0B0F19, #1A1F2B);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 100% 100%; }
        }

        /* Floating Elements */
        .floating-element {
            position: absolute;
            border-radius: 50%;
            background: rgba(124, 58, 237, 0.1);
            animation: float 6s ease-in-out infinite;
            z-index: 1;
        }

        @keyframes float {
            0% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
            100% { transform: translateY(0) rotate(0deg); }
        }

        /* Container */
        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 2rem;
            position: relative;
            z-index: 1;
        }

        /* Thank You Container */
        .thank-you-container {
            background: rgba(26, 31, 43, 0.8);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 3rem;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(124, 58, 237, 0.2);
            position: relative;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            text-align: center;
        }

        .thank-you-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            border-radius: 24px;
            padding: 2px;
            background: var(--gradient-border);
            mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            mask-composite: exclude;
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            z-index: -1;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .thank-you-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.4);
        }

        .thank-you-container:hover::before {
            opacity: 1;
        }

        /* Success Message */
        .success-message {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 2.5rem;
            color: #fff;
            margin-bottom: 2rem;
            text-align: center;
            background: var(--gradient-2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            padding: 1rem 2rem;
            border-radius: 12px;
            display: inline-block;
            position: relative;
        }

        .success-message::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            border-radius: 12px;
            padding: 2px;
            background: var(--gradient-3);
            mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            mask-composite: exclude;
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            z-index: -1;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .success-message:hover::after {
            opacity: 1;
        }

        /* Subtitle */
        .subtitle {
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
            font-size: 1.2rem;
            color: #e0e0e0;
            text-align: center;
            margin-bottom: 1rem;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 1.5rem;
            margin-top: 2rem;
        }

        .btn {
            padding: 0.875rem 1.5rem;
            border-radius: 12px;
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: none;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            position: relative;
            overflow: hidden;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.7s ease;
        }

        .btn:hover::before {
            left: 100%;
        }

        .btn-primary {
            background: var(--gradient-2);
            color: white;
            box-shadow: 0 4px 15px rgba(124, 58, 237, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(124, 58, 237, 0.4);
        }

        .btn-secondary {
            background: transparent;
            color: var(--aqua-accent);
            border: 2px solid var(--aqua-accent);
        }

        .btn-secondary:hover {
            background: rgba(34, 211, 238, 0.1);
            transform: translateY(-2px);
        }

        /* Animated Checkmark */
        .checkmark {
            width: 80px;
            height: 80px;
            margin: 0 auto 2rem;
            border-radius: 50%;
            display: block;
            stroke-width: 4px;
            stroke: var(--aqua-accent);
            stroke-miterlimit: 10;
            box-shadow: inset 0px 0px 0px var(--gradient-3);
            animation: checkmark-draw 0.5s ease-in-out forwards;
        }

        @keyframes checkmark-draw {
            0% { stroke-dasharray: 100 100; stroke-dashoffset: 100; }
            50% { stroke-dasharray: 100 100; stroke-dashoffset: 0; }
            100% { stroke-dasharray: 0 100; stroke-dashoffset: -100; }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .thank-you-container {
                padding: 2rem;
            }
            
            .success-message {
                font-size: 2rem;
            }
            
            .subtitle {
                font-size: 1.1rem;
            }
        }

        @media (max-width: 480px) {
            .thank-you-container {
                padding: 1.5rem;
            }
            
            .success-message {
                font-size: 1.5rem;
                padding: 0.75rem 1.5rem;
            }
            
            .btn {
                padding: 0.75rem 1.25rem;
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <!-- Animated Background -->
    <div class="animated-bg"></div>
    
    <!-- Floating Elements -->
    <div class="floating-element" style="top: 10%; left: 10%;"></div>
    <div class="floating-element" style="top: 20%; left: 20%; animation-delay: 0.5s;"></div>
    <div class="floating-element" style="top: 30%; right: 15%; animation-delay: 1s;"></div>
    <div class="floating-element" style="bottom: 20%; left: 5%; animation-delay: 1.5s;"></div>
    <div class="floating-element" style="bottom: 10%; right: 10%; animation-delay: 2s;"></div>

    <div class="container">
        <!-- Thank You Container -->
        <div class="thank-you-container" data-aos="fade-up">
            <!-- Success Message -->
            <div class="success-message">
                <svg class="checkmark" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M5 12l5 5l10 10-7 7 12l-10 10 10-10 10-7 12z"></path>
                </svg>
                <h2>Thank You!</h2>
                <p class="subtitle">Your message has been sent successfully. We'll get back to you soon!</p>
            </div>
            
            <!-- Action Buttons -->
            <div class="action-buttons" data-aos="fade-up" data-aos-delay="200">
                <a href="contact.php" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i>
                    Back to Contact
                </a>
                
                <a href="../index.php" class="btn btn-primary">
                    <i class="fas fa-home"></i>
                    Home
                </a>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script>
        // Initialize AOS
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true,
            mirror: true,
            offset: 100
        });
    </script>
</body>
</html>