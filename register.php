<?php 
session_start();
include("database/db.php");

 $registrationSuccess = false; // Flag to check registration success
 $errorMessage = ""; // Variable to hold error messages

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone']; // Add phone to form processing
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role = 'student'; // By default, registration is for students   

    // Check if email already exists
    $emailCheckQuery = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $emailCheckQuery);

    // Handle file upload for user_img
    if (isset($_FILES['user_img']) && $_FILES['user_img']['error'] == 0) {
        $targetDir = "assets/users/";
        $targetFile = $targetDir . basename($_FILES["user_img"]["name"]);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Check if image file is a valid image type
        $check = getimagesize($_FILES["user_img"]["tmp_name"]);
        if ($check !== false) {
            // Move uploaded file to target directory
            if (move_uploaded_file($_FILES["user_img"]["tmp_name"], $targetFile)) {
                $user_img = $targetFile; 
            } else {
                $errorMessage = "Error uploading image.";
            }
        } else {
            $errorMessage = "File is not an image.";
        }
    } else {
        $user_img = null; // No image uploaded
    }

    // Only set error message if email already exists
    if (mysqli_num_rows($result) > 0) {
        $errorMessage = "Email already exists. Please use a different email.";
    } else {
        // Email does not exist, proceed with registration
        $query = "INSERT INTO users (name, email, phone, password, role, user_img) VALUES ('$name','$email', '$phone', '$password','$role','$user_img')";
        
        if (mysqli_query($conn, $query)) {
            $registrationSuccess = true; // Set success flag
        } else {
            $errorMessage = "Error: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Showbase - Register</title>
    
    <!-- Google Fonts - Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Lottie Animation -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.7.5/lottie.min.js"></script>
    
    <!-- Particles.js -->
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
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
            line-height: 1.5;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        /* Fullscreen particles */
        #particles-js {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 0;
        }

        /* Ultra Compact Form Container */
        .form-container {
            background: rgba(26, 31, 43, 0.8);
            backdrop-filter: blur(20px);
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(124, 58, 237, 0.2);
            position: relative;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            max-width: 320px;
            width: 100%;
            margin: 0 auto;
        }

        .form-container::before {
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
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .form-container:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.4);
        }

        .form-container:hover::before {
            opacity: 1;
        }

        /* Logo Section - Centered */
        .logo-section {
            text-align: center;
            margin-bottom: 1rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .logo {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            border: 2px solid var(--aqua-accent);
            box-shadow: 0 0 15px rgba(34, 211, 238, 0.5);
            margin-bottom: 0.75rem;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        .logo:hover {
            transform: rotate(8deg) scale(1.05);
            box-shadow: 0 0 20px rgba(34, 211, 238, 0.7);
        }

        .brand-name {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 1.2rem;
            background: var(--gradient-2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 0.25rem;
            text-align: center;
        }

        .tagline {
            color: #9CA3AF;
            font-size: 0.7rem;
            font-weight: 400;
            text-align: center;
        }

        /* Form Styles */
        .form-title {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 1rem;
            color: #fff;
            margin-bottom: 1rem;
            text-align: center;
        }

        .form-group {
            margin-bottom: 0.75rem;
            position: relative;
        }

        .form-label {
            display: block;
            margin-bottom: 0.25rem;
            font-weight: 500;
            color: #e0e0e0;
            font-size: 0.8rem;
        }

        .form-input {
            width: 100%;
            padding: 0.6rem 1rem 0.6rem 2rem;
            border: 2px solid rgba(124, 58, 237, 0.2);
            border-radius: 8px;
            background: rgba(26, 31, 43, 0.6);
            color: #fff;
            font-family: 'Poppins', sans-serif;
            font-size: 0.85rem;
            transition: all 0.3s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--electric-blue);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            background: rgba(26, 31, 43, 0.8);
        }

        .input-icon {
            position: absolute;
            left: 0.75rem;
            top: 1.6rem;
            color: #9CA3AF;
            transition: color 0.3s ease;
            font-size: 0.85rem;
        }

        .form-input:focus ~ .input-icon {
            color: var(--electric-blue);
        }

        /* File Input */
        .file-input-wrapper {
            position: relative;
            overflow: hidden;
            display: inline-block;
            width: 100%;
        }

        .file-input {
            position: absolute;
            left: -9999px;
        }

        .file-input-label {
            display: block;
            padding: 0.6rem 1rem;
            border: 2px solid rgba(124, 58, 237, 0.2);
            border-radius: 8px;
            background: rgba(26, 31, 43, 0.6);
            color: #e0e0e0;
            font-family: 'Poppins', sans-serif;
            font-size: 0.85rem;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
        }

        .file-input-label:hover {
            border-color: var(--electric-blue);
            background: rgba(26, 31, 43, 0.8);
        }

        .file-input-label i {
            margin-right: 0.4rem;
        }

        /* Button Styles */
        .btn {
            padding: 0.6rem 1rem;
            border-radius: 8px;
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 0.85rem;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: none;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
            position: relative;
            overflow: hidden;
            width: 100%;
            margin-bottom: 0.75rem;
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
            box-shadow: 0 3px 8px rgba(124, 58, 237, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(124, 58, 237, 0.4);
        }

        /* Password Toggle */
        .password-toggle {
            position: absolute;
            right: 0.75rem;
            top: 1.6rem;
            color: #9CA3AF;
            cursor: pointer;
            transition: color 0.3s ease;
            font-size: 0.85rem;
        }

        .password-toggle:hover {
            color: var(--electric-blue);
        }

        /* Form Footer */
        .form-footer {
            text-align: center;
            margin-top: 0.75rem;
            color: #9CA3AF;
            font-size: 0.8rem;
        }

        .form-footer a {
            color: var(--aqua-accent);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .form-footer a:hover {
            color: var(--electric-blue);
            text-decoration: underline;
        }

        /* Success Animation */
        .success-container {
            text-align: center;
            padding: 1.5rem;
        }

        .success-animation {
            width: 100px;
            height: 100px;
            margin: 0 auto 1rem;
        }

        .success-title {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 1.2rem;
            color: #fff;
            margin-bottom: 0.5rem;
        }

        .success-message {
            color: #9CA3AF;
            font-size: 0.85rem;
            margin-bottom: 1rem;
        }

        /* Password Strength Indicator */
        .password-strength {
            height: 3px;
            border-radius: 3px;
            margin-top: 0.25rem;
            background: rgba(124, 58, 237, 0.2);
            overflow: hidden;
        }

        .password-strength-bar {
            height: 100%;
            width: 0;
            transition: width 0.3s ease, background-color 0.3s ease;
        }

        .strength-weak {
            background-color: #EF4444;
            width: 33%;
        }

        .strength-medium {
            background-color: #F59E0B;
            width: 66%;
        }

        .strength-strong {
            background-color: #10B981;
            width: 100%;
        }

        /* Mobile-friendly SweetAlert sizing */
        .swal2-popup { 
            width: min(85vw, 300px) !important; 
            border-radius: 12px; 
        }
        
        @media (max-width:480px){
            .swal2-title{ font-size:16px }
            .swal2-html-container{ font-size:13px }
            .swal2-actions .swal2-styled{ padding:8px 14px; font-size:13px }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .form-container {
                padding: 1.25rem;
                margin: 0.75rem;
                max-width: 300px;
            }
            
            .brand-name {
                font-size: 1.1rem;
            }
            
            .form-title {
                font-size: 0.95rem;
            }
        }

        @media (max-width: 480px) {
            .form-container {
                padding: 1rem;
                margin: 0.5rem;
                max-width: 280px;
            }
            
            .logo {
                width: 45px;
                height: 45px;
            }
            
            .brand-name {
                font-size: 1rem;
            }
            
            .form-input {
                padding: 0.5rem 0.75rem 0.5rem 1.75rem;
                font-size: 0.8rem;
            }
            
            .input-icon {
                top: 1.4rem;
                left: 0.6rem;
                font-size: 0.8rem;
            }
            
            .password-toggle {
                top: 1.4rem;
                right: 0.6rem;
                font-size: 0.8rem;
            }
            
            .btn {
                padding: 0.5rem 0.75rem;
                font-size: 0.8rem;
            }
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center relative">
    <!-- Particles.js Background -->
    <div id="particles-js"></div>

    <?php if ($registrationSuccess): ?>
        <!-- Success Animation -->
        <div class="success-container">
            <div class="success-animation" id="success-animation"></div>
            <h1 class="success-title">Registration Successful!</h1>
            <p class="success-message">Your account has been created successfully. Redirecting to login...</p>
        </div>
    <?php else: ?>
        <!-- Registration Form -->
        <div class="form-container">
            <!-- Logo Section - Centered -->
            <div class="logo-section">
                <img src="https://saphotel.in/test/demo_files/admin/sri_logo.jpg" alt="Showbase Logo" class="logo">
               
            </div>

            <h2 class="form-title">Create Account</h2>
            
            <!-- Registration Form -->
            <form method="POST" class="space-y-2" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name" class="form-label">Full Name</label>
                    <input type="text" id="name" name="name" class="form-input" placeholder="Enter your full name" required>
                    <i class="fas fa-user input-icon"></i>
                </div>
                
                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" class="form-input" placeholder="Enter your email" required>
                    <i class="fas fa-envelope input-icon"></i>
                </div>
                
                <div class="form-group">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="tel" id="phone" name="phone" class="form-input" placeholder="Enter your phone number" required>
                    <i class="fas fa-phone input-icon"></i>
                </div>
                
                <div class="form-group">
                    <label for="user_img" class="form-label">Profile Image (Optional)</label>
                    <div class="file-input-wrapper">
                        <input type="file" id="user_img" name="user_img" class="file-input" accept="image/*">
                        <label for="user_img" class="file-input-label">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <span id="file-name">Choose a file</span>
                        </label>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" id="password" name="password" class="form-input" placeholder="Create a strong password" required>
                    <i class="fas fa-lock input-icon"></i>
                    <i class="fas fa-eye password-toggle" id="password-toggle"></i>
                    <div class="password-strength">
                        <div class="password-strength-bar" id="password-strength-bar"></div>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-user-plus"></i> Create Account
                </button>
            </form>

            <!-- Form Footer -->
            <div class="form-footer">
                <p>Already have an account? <a href="index.php">Sign In</a></p>
            </div>
        </div>
    <?php endif; ?>

    <script>
        // Particles.js configuration
        particlesJS("particles-js", {
            "particles": {
                "number": {
                    "value": 30,
                    "density": {
                        "enable": true,
                        "value_area": 600
                    }
                },
                "color": {
                    "value": "#ffffff"
                },
                "shape": {
                    "type": "circle",
                    "stroke": {
                        "width": 0,
                        "color": "#000000"
                    },
                    "polygon": {
                        "nb_sides": 5
                    }
                },
                "opacity": {
                    "value": 0.5,
                    "random": false,
                    "anim": {
                        "enable": false,
                        "speed": 1,
                        "opacity_min": 0.1,
                        "sync": false
                    }
                },
                "size": {
                    "value": 2,
                    "random": true,
                    "anim": {
                        "enable": false,
                        "speed": 40,
                        "size_min": 0.1,
                        "sync": false
                    }
                },
                "line_linked": {
                    "enable": true,
                    "distance": 80,
                    "color": "#ffffff",
                    "opacity": 0.3,
                    "width": 1
                },
                "move": {
                    "enable": true,
                    "speed": 3,
                    "direction": "none",
                    "random": false,
                    "straight": false,
                    "out_mode": "out",
                    "bounce": false,
                    "attract": {
                        "enable": false,
                        "rotateX": 600,
                        "rotateY": 1200
                    }
                }
            },
            "interactivity": {
                "detect_on": "canvas",
                "events": {
                    "onhover": {
                        "enable": true,
                        "mode": "repulse"
                    },
                    "onclick": {
                        "enable": true,
                        "mode": "push"
                    },
                    "resize": true
                },
                "modes": {
                    "grab": {
                        "distance": 200,
                        "line_linked": {
                            "opacity": 1
                        }
                    },
                    "bubble": {
                        "distance": 200,
                        "size": 15,
                        "duration": 2,
                        "opacity": 4,
                        "speed": 2
                    },
                    "repulse": {
                        "distance": 100,
                        "duration": 0.4
                    },
                    "push": {
                        "particles_nb": 2
                    },
                    "remove": {
                        "particles_nb": 1
                    }
                }
            },
            "retina_detect": true
        });

        <?php if ($registrationSuccess): ?>
            // Load success animation
            var animation = lottie.loadAnimation({
                container: document.getElementById('success-animation'),
                renderer: 'svg',
                loop: false,
                autoplay: true,
                path: 'https://assets5.lottiefiles.com/packages/lf20_1r2f0p3s.json' // Success animation JSON
            });

            // Redirect to login page after animation
            animation.addEventListener('complete', function() {
                setTimeout(function() {
                    window.location.href = 'index.php';
                }, 500);
            });
        <?php endif; ?>

        // File input label update
        document.getElementById('user_img').addEventListener('change', function() {
            const fileName = this.files[0] ? this.files[0].name : 'Choose a file';
            document.getElementById('file-name').textContent = fileName;
        });

        // Password toggle
        document.getElementById('password-toggle').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const icon = this;
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });

        // Password strength checker
        document.getElementById('password').addEventListener('input', function() {
            const password = this.value;
            const strengthBar = document.getElementById('password-strength-bar');
            
            // Reset classes
            strengthBar.className = 'password-strength-bar';
            
            if (password.length === 0) {
                strengthBar.style.width = '0';
                return;
            }
            
            // Check password strength
            let strength = 0;
            
            // Length check
            if (password.length >= 8) strength += 1;
            
            // Contains lowercase
            if (/[a-z]/.test(password)) strength += 1;
            
            // Contains uppercase
            if (/[A-Z]/.test(password)) strength += 1;
            
            // Contains number
            if (/[0-9]/.test(password)) strength += 1;
            
            // Contains special character
            if (/[^a-zA-Z0-9]/.test(password)) strength += 1;
            
            // Update UI based on strength
            if (strength <= 2) {
                strengthBar.classList.add('strength-weak');
            } else if (strength <= 4) {
                strengthBar.classList.add('strength-medium');
            } else {
                strengthBar.classList.add('strength-strong');
            }
        });
    </script>

    <?php if ($registrationSuccess): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Success toast
                Swal.fire({
                    icon: 'success',
                    title: 'Registration Successful!',
                    text: 'Your account has been created successfully. Redirecting to login...',
                    toast: true,
                    position: 'top',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true
                });
            });
        </script>
    <?php elseif (!empty($errorMessage)): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Registration Failed',
                    html: <?php echo json_encode($errorMessage); ?>, // safe encoding
                    confirmButtonText: 'OK',
                    allowOutsideClick: true,
                    allowEscapeKey: true
                });
            });
        </script>
    <?php endif; ?>
</body>
</html>