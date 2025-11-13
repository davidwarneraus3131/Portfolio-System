<?php
session_start(); // Start session at the top

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

// Include necessary files
include('../includes/header.php');
include("../database/db.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    
    <!-- Google Fonts: Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
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
            background: var(--dark-navy);
            color: #fff;
            min-height: 100vh;
            padding: 15px;
            position: relative;
            overflow-x: hidden;
        }
        
        .bg-gradient {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 25% 25%, rgba(124, 58, 237, 0.1) 0%, transparent 40%),
                radial-gradient(circle at 75% 75%, rgba(59, 130, 246, 0.1) 0%, transparent 40%);
            z-index: -1;
        }
        
        .dashboard-container {
            max-width: 1200px;
            margin: 0 auto;
            animation: fadeIn 0.5s ease-out;
        }
        
        .dashboard-header {
            text-align: center;
            margin-bottom: 24px;
        }
        
        .icon-wrapper {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, var(--neon-purple), var(--electric-blue));
            border-radius: 12px;
            margin-bottom: 12px;
            box-shadow: 0 4px 12px rgba(124, 58, 237, 0.3);
        }
        
        .icon-wrapper i {
            font-size: 1.5rem;
            color: white;
        }
        
        h1 {
            font-weight: 600;
            font-size: 1.8rem;
            background: linear-gradient(90deg, var(--neon-purple), var(--electric-blue));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            margin-bottom: 6px;
        }
        
        .subtitle {
            font-size: 0.9rem;
            color: #9ca3af;
            font-weight: 400;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }
        
        .stat-card {
            background: linear-gradient(145deg, rgba(26, 31, 43, 0.95), rgba(11, 15, 25, 0.95));
            border-radius: 12px;
            padding: 16px;
            box-shadow: 
                0 8px 20px rgba(0, 0, 0, 0.4),
                0 0 0 1px rgba(124, 58, 237, 0.2);
            position: relative;
            overflow: hidden;
            backdrop-filter: blur(8px);
            display: flex;
            align-items: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 
                0 12px 24px rgba(0, 0, 0, 0.5),
                0 0 0 1px rgba(124, 58, 237, 0.3);
        }
        
        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--neon-purple), var(--electric-blue), var(--aqua-accent));
        }
        
        .stat-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 50px;
            height: 50px;
            border-radius: 10px;
            margin-right: 16px;
            flex-shrink: 0;
        }
        
        .stat-icon.blue {
            background: rgba(59, 130, 246, 0.2);
            color: var(--electric-blue);
        }
        
        .stat-icon.green {
            background: rgba(34, 197, 94, 0.2);
            color: #22c55e;
        }
        
        .stat-icon.yellow {
            background: rgba(250, 204, 21, 0.2);
            color: #facc15;
        }
        
        .stat-icon.red {
            background: rgba(239, 68, 68, 0.2);
            color: #ef4444;
        }
        
        .stat-icon.purple {
            background: rgba(124, 58, 237, 0.2);
            color: var(--neon-purple);
        }
        
        .stat-icon i {
            font-size: 1.5rem;
        }
        
        .stat-content {
            flex: 1;
        }
        
        .stat-title {
            font-size: 0.85rem;
            color: #9ca3af;
            margin-bottom: 4px;
            font-weight: 500;
        }
        
        .stat-value {
            font-size: 1.8rem;
            font-weight: 600;
            line-height: 1;
        }
        
        .stat-value.blue {
            color: var(--electric-blue);
        }
        
        .stat-value.green {
            color: #22c55e;
        }
        
        .stat-value.yellow {
            color: #facc15;
        }
        
        .stat-value.red {
            color: #ef4444;
        }
        
        .stat-value.purple {
            color: var(--neon-purple);
        }
        
        .progress-indicator {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
            gap: 6px;
        }
        
        .dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: rgba(124, 58, 237, 0.3);
            transition: all 0.3s ease;
        }
        
        .dot.active {
            background: var(--electric-blue);
            box-shadow: 0 0 10px rgba(59, 130, 246, 0.5);
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            h1 {
                font-size: 1.5rem;
            }
        }
        
        @media (max-width: 480px) {
            .stat-card {
                padding: 14px;
            }
            
            .stat-icon {
                width: 40px;
                height: 40px;
                margin-right: 12px;
            }
            
            .stat-icon i {
                font-size: 1.2rem;
            }
            
            .stat-value {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="bg-gradient"></div>
    
    <div class="dashboard-container">
        <div class="dashboard-header">
            <div class="icon-wrapper">
                <i class="fas fa-chart-line"></i>
            </div>
            <h1>Admin Dashboard</h1>
            <p class="subtitle">Monitor your platform performance</p>
        </div>
        
        <div class="progress-indicator">
            <div class="dot active"></div>
            <div class="dot"></div>
            <div class="dot"></div>
        </div>
        
        <?php
            // Fetch total users
            $totalUsers = $conn->query("SELECT COUNT(*) as count FROM users")->fetch_assoc()['count'];

            // Fetch total completed templates
            $completedTemplates = $conn->query("SELECT COUNT(*) as count FROM portfolios WHERE status = 'completed'")->fetch_assoc()['count'];

            // Calculate total revenue
            $totalRevenue = $conn->query("SELECT SUM(amount) as total FROM portfolios")->fetch_assoc()['total'];

            // Count pending projects
            $pendingProjects = $conn->query("SELECT COUNT(*) as count FROM portfolios WHERE status = 'pending' OR status = 'review'")->fetch_assoc()['count'];

            // Total templates
            $totalTemplates = $conn->query("SELECT COUNT(*) as count FROM templates")->fetch_assoc()['count'];
        ?>
        
        <div class="stats-grid">
            <!-- Total Users Card -->
            <a href="view_users.php" class="stat-link">
                <div class="stat-card">
                    <div class="stat-icon blue">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-title">Total Users</div>
                        <div class="stat-value blue"><?= $totalUsers ?></div>
                    </div>
                </div>
            </a>

            <!-- Total Template Completions Card -->
            <a href="status.php" class="stat-link">
                <div class="stat-card">
                    <div class="stat-icon green">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-title">Template Completions</div>
                        <div class="stat-value green"><?= $completedTemplates ?></div>
                    </div>
                </div>
            </a>

            <!-- Total Revenue Card -->
            <a href="view_payments.php" class="stat-link">
                <div class="stat-card">
                    <div class="stat-icon yellow">
                        <i class="fa-solid fa-indian-rupee-sign"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-title">Total Revenue</div>
                        <div class="stat-value yellow">₹<?= $totalRevenue !== null ? number_format($totalRevenue, 2) : '0.00' ?></div>
                    </div>
                </div>
            </a>

            <!-- Pending Template Projects Card -->
            <a href="status.php" class="stat-link">
                <div class="stat-card">
                    <div class="stat-icon red">
                        <i class="fas fa-exclamation-circle"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-title">Pending Projects</div>
                        <div class="stat-value red"><?= $pendingProjects ?></div>
                    </div>
                </div>
            </a>

            <!-- Total Templates Card -->
            <a href="templates.php" class="stat-link">
                <div class="stat-card">
                    <div class="stat-icon purple">
                        <i class="fas fa-folder-open"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-title">Total Templates</div>
                        <div class="stat-value purple"><?= $totalTemplates ?></div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <script>
        // Animate progress dots
        let currentDot = 0;
        const dots = document.querySelectorAll('.dot');
        
        setInterval(() => {
            dots.forEach(dot => dot.classList.remove('active'));
            currentDot = (currentDot + 1) % dots.length;
            dots[currentDot].classList.add('active');
        }, 2000);
    </script>
</body>
</html>

<?php include('../includes/footer.php'); ?>