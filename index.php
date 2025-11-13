<?php
session_start();
include("database/db.php");

 $message = ""; // Variable to hold message for SweetAlert

if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
  $email = $_POST['email'];
  $password = $_POST['password'];

  // Query to select user based on email
  $result = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
  $user = mysqli_fetch_assoc($result);

  // Check if user exists and password is correct
  if ($user) {
      if ($user['status'] == 'inactive') {
          // User is inactive, unauthorized error
          $message = "You are unauthorized to log in!";
          $message_type = "unauthorized";
      } elseif (password_verify($password, $user['password'])) {
          // Credentials are correct, proceed with login
          $_SESSION['user_id'] = $user['id'];
          $_SESSION['role'] = $user['role'];
          $_SESSION['name'] = $user['name'];
          $_SESSION['email'] = $user['email'];
          $_SESSION['user_img'] = $user['user_img']; // Store user image in session

          // Set success message
          $message = "Login successful! Redirecting...";
          $message_type = "success";

          echo "<script>
                  setTimeout(function() {
                      window.location.href = '" . ($user['role'] == 'admin' ? "admin/dashboard.php" : "student/dashboard.php") . "';
                  }, 2000); // Redirect after 2 seconds
                </script>";
      } else {
          // Incorrect password
          $message = "Invalid credentials!";
          $message_type = "error";
      }
  } else {
      // User not found
      $message = "Invalid credentials!";
      $message_type = "error";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teck Spiral - Login</title>
    
    <!-- Google Fonts - Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
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
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        /* Background with animated particles */
        .bg-login {
            position: relative;
            width: 100%;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .bg-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
        }

        .bg-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to right, rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.5));
            z-index: 0;
        }

        /* Particles */
        .particles-container {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 1;
        }

        .particle {
            position: absolute;
            background: var(--aqua-accent);
            border-radius: 50%;
            opacity: 0.3;
            animation: float 15s infinite ease-in-out;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); opacity: 0; }
            10% { opacity: 0.4; }
            90% { opacity: 0.4; }
            50% { transform: translateY(-100vh) rotate(360deg); }
        }

        /* Login Form Container */
        .login-container {
            background: rgba(26, 31, 43, 0.8);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 2.5rem;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(124, 58, 237, 0.2);
            position: relative;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            max-width: 450px;
            width: 100%;
            z-index: 10;
        }

        .login-container::before {
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

        .login-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 25px 70px rgba(0, 0, 0, 0.4);
        }

        .login-container:hover::before {
            opacity: 1;
        }

        /* Logo Section */
        .logo-section {
            text-align: center;
            margin-bottom: 2rem;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .logo {
            width: 70px;
            height: 70px;
            border-radius: 16px;
            border: 2px solid var(--aqua-accent);
            box-shadow: 0 0 20px rgba(34, 211, 238, 0.5);
            margin-bottom: 1rem;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .logo:hover {
            transform: rotate(8deg) scale(1.05);
            box-shadow: 0 0 30px rgba(34, 211, 238, 0.7);
        }

        .brand-name {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 1.8rem;
            background: var(--gradient-2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 0.5rem;
        }

        /* Form Styles */
        .form-title {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 1.5rem;
            color: #fff;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .form-group {
            margin-bottom: 1.5rem;
            position: relative;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #e0e0e0;
            font-size: 0.9rem;
        }

        .form-input {
            width: 100%;
            padding: 0.875rem 1rem 0.875rem 3rem;
            border: 2px solid rgba(124, 58, 237, 0.2);
            border-radius: 12px;
            background: rgba(26, 31, 43, 0.6);
            color: #fff;
            font-family: 'Poppins', sans-serif;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--electric-blue);
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
            background: rgba(26, 31, 43, 0.8);
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 2.75rem;
            color: #9CA3AF;
            transition: color 0.3s ease;
            font-size: 1rem;
        }

        .form-input:focus ~ .input-icon {
            color: var(--electric-blue);
        }

        /* Button Styles */
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
            width: 100%;
            margin-bottom: 1.5rem;
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

        /* Form Footer */
        .form-footer {
            text-align: center;
            margin-top: 1.5rem;
            color: #9CA3AF;
            font-size: 0.9rem;
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

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .login-container {
                padding: 2rem;
                margin: 1rem;
                max-width: 400px;
            }
            
            .brand-name {
                font-size: 1.5rem;
            }
            
            .form-title {
                font-size: 1.3rem;
            }
        }

        @media (max-width: 480px) {
            .login-container {
                padding: 1.5rem;
                margin: 0.5rem;
                max-width: 350px;
            }
            
            .logo {
                width: 60px;
                height: 60px;
            }
            
            .brand-name {
                font-size: 1.3rem;
            }
            
            .form-input {
                padding: 0.75rem 1rem 0.75rem 2.5rem;
                font-size: 0.9rem;
            }
            
            .input-icon {
                top: 2.5rem;
                left: 0.75rem;
                font-size: 0.9rem;
            }
            
            .btn {
                padding: 0.75rem 1.25rem;
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <!-- Background with animated particles -->
    <div class="bg-login">
        <!-- <img src="https://images.unsplash.com/photo-1603835125302-6a7f2a0376a?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fGVufDB8fHx8fGVufDB8fHx8fGVufDB8fHx8fGVufDB8fHx8&auto=format&fit=crop&w=1470&q=80" alt="Background" class="bg-image"> -->
        <div class="bg-overlay"></div>
        
        <!-- Animated particles -->
        <div class="particles-container" id="particles-container"></div>
        
        <!-- Login Form Container -->
        <div class="login-container">
            <!-- Logo Section -->
            <div class="logo-section">
                <img src="https://saphotel.in/test/demo_files/admin/sri_logo.jpg" alt="Showbase Logo" class="logo">
              
            </div>

            <h2 class="form-title">Welcome Back</h2>
            
            <!-- Login Form -->
            <form method="POST" class="space-y-6">
                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" id="email" name="email" class="form-input" placeholder="Enter your email" required>
                    <i class="fas fa-envelope input-icon"></i>
                </div>
                
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" id="password" name="password" class="form-input" placeholder="Enter your password" required>
                    <i class="fas fa-lock input-icon"></i>
                </div>
                
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-sign-in-alt"></i> Sign In
                </button>
            </form>

            <!-- Form Footer -->
            <div class="form-footer">
                <p>Don't have an account? <a href="register.php">Register</a></p>
            </div>
        </div>
    </div>

    <script>
        // Create floating particles
        function createParticles() {
            const particlesContainer = document.getElementById('particles-container');
            const particleCount = 50;
            
            for (let i = 0; i < particleCount; i++) {
                const particle = document.createElement('div');
                particle.classList.add('particle');
                
                // Random size
                const size = Math.random() * 5 + 2;
                particle.style.width = `${size}px`;
                particle.style.height = `${size}px`;
                
                // Random position
                const posX = Math.random() * 100;
                const posY = Math.random() * 100;
                particle.style.left = `${posX}%`;
                particle.style.top = `${posY}%`;
                
                // Random animation delay
                particle.style.animationDelay = `${Math.random() * 5}s`;
                
                particlesContainer.appendChild(particle);
            }
        }

        // Initialize particles
        createParticles();

        <?php if (!empty($message)): ?>
            document.addEventListener('DOMContentLoaded', function() {
                const messageType = '<?php echo $message_type; ?>';
                const messageText = '<?php echo $message; ?>';
                
                if (messageType === 'success') {
                    // Show success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: messageText,
                        confirmButtonColor: '#10B981',
                        background: 'rgba(26, 31, 43, 0.9)',
                        color: '#e0e0e0',
                        timer: 2000,
                        timerProgressBar: true,
                        didOpen: () => {
                            // Redirect after SweetAlert opens
                            setTimeout(() => {
                                window.location.href = '<?php echo ($user['role'] ?? 'student') == 'admin' ? "admin/dashboard.php" : "student/dashboard.php"; ?>';
                            }, 1800);
                        }
                    });
                } else if (messageType === 'unauthorized') {
                    // Show unauthorized error
                    Swal.fire({
                        icon: 'error',
                        title: 'Access Denied',
                        text: messageText,
                        confirmButtonColor: '#EF4444',
                        background: 'rgba(26, 31, 43, 0.9)',
                        color: '#e0e0e0'
                    });
                } else {
                    // Show general error
                    Swal.fire({
                        icon: 'error',
                        title: 'Login Failed',
                        text: messageText,
                        confirmButtonColor: '#EF4444',
                        background: 'rgba(26, 31, 43, 0.9)',
                        color: '#e0e0e0'
                    });
                }
            });
        <?php endif; ?>
    </script>
</body>
</html>