<?php
// Check if a session is already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Teck Spiral - Your gateway to innovative tech solutions.">
    <meta name="keywords" content="Tech, Solutions, Innovative, Teck Spiral">
    <meta name="author" content="Teck Spiral">
    
    <!-- Google Fonts - Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/styles.css">
    
    <title>SRIDHAR'S-PORTFOLIO</title>

    <!-- Favicon -->
    <link rel="icon" href="https://saphotel.in/test/demo_files/admin/sri_logo.jpg" type="image/png">
    
    <style>
        :root {
            --dark-navy: #0B0F19;
            --deep-gray: #1A1F2B;
            --neon-purple: #7C3AED;
            --electric-blue: #3B82F6;
            --aqua-accent: #22D3EE;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--dark-navy);
            color: #fff;
            padding-bottom: 70px; /* Space for bottom nav */
        }
        
        /* Navigation Styles */
        .navbar {
            background: linear-gradient(135deg, rgba(11, 15, 25, 0.9) 0%, rgba(26, 31, 43, 0.9) 100%);
            backdrop-filter: blur(10px);
            padding: 1rem 0;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 999;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            border-bottom: 1px solid rgba(34, 211, 238, 0.2);
        }
        
        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .logo-container {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
            position: relative;
        }
        
        .logo {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            border: 2px solid var(--aqua-accent);
            box-shadow: 0 0 15px rgba(34, 211, 238, 0.5);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .logo:hover {
            transform: rotate(6deg) scale(1.05);
            box-shadow: 0 0 20px rgba(34, 211, 238, 0.7);
        }
        
        .logo-text {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 1.5rem;
            background: linear-gradient(90deg, var(--neon-purple), var(--electric-blue), var(--aqua-accent));
            background-size: 200% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: gradient-shift 3s ease infinite;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        @keyframes gradient-shift {
            0% { background-position: 0% center; }
            50% { background-position: 100% center; }
            100% { background-position: 0% center; }
        }
        
        .nav-menu {
            display: flex;
            list-style: none;
            gap: 2rem;
        }
        
        .nav-item {
            position: relative;
        }
        
        .nav-link {
            color: #fff;
            font-weight: 500;
            font-size: 1rem;
            text-decoration: none;
            padding: 0.5rem 0;
            position: relative;
            transition: color 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--neon-purple), var(--electric-blue));
            transition: width 0.3s ease;
        }
        
        .nav-link:hover {
            color: var(--aqua-accent);
        }
        
        .nav-link:hover::after {
            width: 100%;
        }
        
        .nav-link-tooltip {
            position: absolute;
            top: calc(100% + 10px);
            left: 50%;
            transform: translateX(-50%);
            background-color: rgba(26, 31, 43, 0.95);
            color: #fff;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            font-size: 0.8rem;
            white-space: normal;
            max-width: 250px;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s ease, top 0.3s ease;
            z-index: 10;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(34, 211, 238, 0.3);
            text-align: center;
            line-height: 1.4;
        }
        
        .nav-link-tooltip::before {
            content: '';
            position: absolute;
            top: -8px;
            left: 50%;
            transform: translateX(-50%);
            border-left: 8px solid transparent;
            border-right: 8px solid transparent;
            border-bottom: 8px solid rgba(26, 31, 43, 0.95);
        }
        
        .nav-item:hover .nav-link-tooltip {
            opacity: 1;
            visibility: visible;
            top: calc(100% + 15px);
        }
        
        /* Bottom Navigation Bar */
        .bottom-nav {
            display: none;
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            background: linear-gradient(135deg, rgba(11, 15, 25, 0.95) 0%, rgba(26, 31, 43, 0.95) 100%);
            backdrop-filter: blur(10px);
            border-top: 1px solid rgba(34, 211, 238, 0.2);
            z-index: 1000;
            box-shadow: 0 -5px 15px rgba(0, 0, 0, 0.3);
        }
        
        .bottom-nav-container {
            display: flex;
            justify-content: space-around;
            align-items: center;
            padding: 0.5rem 0;
        }
        
        .bottom-nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 0.5rem;
            text-decoration: none;
            color: #fff;
            position: relative;
            transition: all 0.3s ease;
            width: 20%;
        }
        
        .bottom-nav-item.active {
            color: var(--aqua-accent);
        }
        
        .bottom-nav-item:hover {
            color: var(--aqua-accent);
            transform: translateY(-2px);
        }
        
        .bottom-nav-icon {
            position: relative;
            margin-bottom: 0.25rem;
            font-size: 1.2rem;
        }
        
        .bottom-nav-label {
            font-size: 0.7rem;
            font-weight: 500;
            text-align: center;
        }
        
        .bottom-nav-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #ff4757;
            color: white;
            font-size: 0.5rem;
            padding: 2px 4px;
            border-radius: 4px;
            text-transform: uppercase;
            font-weight: 600;
            letter-spacing: 0.5px;
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .nav-menu {
                display: none;
            }
            
            .bottom-nav {
                display: block;
            }
            
            .nav-link-tooltip {
                max-width: 200px;
                font-size: 0.75rem;
            }
        }
        
        /* Glow effect for active/hover states */
        .glow {
            box-shadow: 0 0 15px rgba(124, 58, 237, 0.5);
        }
    </style>
</head>
<body>
    <!-- Header Navigation Bar -->
    <nav class="navbar">
        <div class="nav-container">
            <!-- Logo Section -->
            <a href="../index.php" class="logo-container">
                <img src="https://saphotel.in/test/demo_files/admin/sri_logo.jpg" alt="Logo" class="logo">
                <span class="logo-text">ShowBase</span>
            </a>
            
            <!-- Desktop Navigation Menu -->
            <ul class="nav-menu">
                <?php
                if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
                    echo '<li class="nav-item"><a href="dashboard.php" class="nav-link">Dashboard</a></li>';
                    echo '<li class="nav-item"><a href="view_users.php" class="nav-link">Users List</a></li>';
                    echo '<li class="nav-item"><a href="templates.php" class="nav-link">All Templates</a></li>';
                    echo '<li class="nav-item"><a href="status.php" class="nav-link">Status</a></li>';
                    echo '<li class="nav-item"><a href="view_payments.php" class="nav-link">Payments</a></li>';
                    echo '<li class="nav-item"><a href="../logout.php" class="nav-link">Logout</a></li>';
                } else {
                    echo '<li class="nav-item"><a href="dashboard.php" class="nav-link">Templates</a></li>';
                    echo '<li class="nav-item"><a href="my_templates.php" class="nav-link">My Templates</a></li>';
                    echo '<li class="nav-item">
                        <a href="ats_checker.php" class="nav-link">Resume Check(ATS)</a>
                        <div class="nav-link-tooltip">
                            Upload & Analyze Your Resume for ATS Compatibility! Get instant feedback on formatting, keywords, and missing skills to boost your job success!
                        </div>
                    </li>';
                    echo '<li class="nav-item"><a href="contact.php" class="nav-link">Contact Us</a></li>';
                    echo '<li class="nav-item"><a href="../logout.php" class="nav-link">Logout</a></li>';
                }
                ?>
            </ul>
        </div>
    </nav>
    
    <!-- Bottom Navigation Bar -->
    <div class="bottom-nav">
        <div class="bottom-nav-container">
            <?php
            if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
                echo '<a href="dashboard.php" class="bottom-nav-item">
                    <div class="bottom-nav-icon">
                        <i class="fas fa-tachometer-alt"></i>
                    </div>
                    <span class="bottom-nav-label">Dashboard</span>
                </a>';
                echo '<a href="view_users.php" class="bottom-nav-item">
                    <div class="bottom-nav-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <span class="bottom-nav-label">Users</span>
                </a>';
                echo '<a href="templates.php" class="bottom-nav-item">
                    <div class="bottom-nav-icon">
                        <i class="fas fa-layer-group"></i>
                    </div>
                    <span class="bottom-nav-label">Templates</span>
                </a>';
                echo '<a href="status.php" class="bottom-nav-item">
                    <div class="bottom-nav-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <span class="bottom-nav-label">Status</span>
                </a>';
                echo '<a href="view_payments.php" class="bottom-nav-item">
                    <div class="bottom-nav-icon">
                        <i class="fas fa-credit-card"></i>
                    </div>
                    <span class="bottom-nav-label">Payments</span>
                </a>';
            } else {
                echo '<a href="dashboard.php" class="bottom-nav-item">
                    <div class="bottom-nav-icon">
                        <i class="fas fa-search"></i>
                    </div>
                    <span class="bottom-nav-label">Search</span>
                </a>';
                echo '<a href="my_templates.php" class="bottom-nav-item">
                    <div class="bottom-nav-icon">
                        <i class="fas fa-lightbulb"></i>
                    </div>
                    <span class="bottom-nav-label">Suggestions</span>
                </a>';
                echo '<a href="ats_checker.php" class="bottom-nav-item">
                    <div class="bottom-nav-icon">
                        <i class="fas fa-file-alt"></i>
                        <span class="bottom-nav-badge">NEW</span>
                    </div>
                    <span class="bottom-nav-label">ATS Check</span>
                </a>';
                echo '<a href="contact.php" class="bottom-nav-item">
                    <div class="bottom-nav-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <span class="bottom-nav-label">Contact</span>
                </a>';
                echo '<a href="../logout.php" class="bottom-nav-item">
                    <div class="bottom-nav-icon">
                        <i class="fas fa-sign-out-alt"></i>
                    </div>
                    <span class="bottom-nav-label">Logout</span>
                </a>';
            }
            ?>
        </div>
    </div>

    <script>
        // Set active state for bottom nav based on current page
        document.addEventListener('DOMContentLoaded', function() {
            const currentPath = window.location.pathname;
            const bottomNavItems = document.querySelectorAll('.bottom-nav-item');
            
            bottomNavItems.forEach(item => {
                const href = item.getAttribute('href');
                if (currentPath.includes(href) || (href === 'dashboard.php' && currentPath.endsWith('/'))) {
                    item.classList.add('active');
                }
            });
        });
    </script>

    <!-- Live chat options for students -->
    <!--Start of Tawk.to Script-->
    <?php
    // Check if user is logged in
    if(isset($_SESSION['user_id'])) { 
    ?>
        <script type="text/javascript">
            var Tawk_API = Tawk_API || {}, Tawk_LoadStart = new Date();
            (function() {
                var s1 = document.createElement("script"), s0 = document.getElementsByTagName("script")[0];
                s1.async = true;
                s1.src = 'https://embed.tawk.to/67ce7a57ec6c18190fe22067/1ilv8rpgl';
                s1.charset = 'UTF-8';
                s1.setAttribute('crossorigin', '*');
                s0.parentNode.insertBefore(s1, s0);
            })();
        </script>
    <?php 
    } 
    ?>
    <!--End of Tawk.to Script-->
</body>
</html>