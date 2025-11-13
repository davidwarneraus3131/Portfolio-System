<?php
ob_start();
include('../includes/header.php');
include("../database/db.php");

// Fetch current portfolio data
if (isset($_GET['template_id'])) {
    $template_id = intval($_GET['template_id']);

    // Prepare and execute the query
    $query = "SELECT * FROM portfolios WHERE template_id = $template_id";
    $result = mysqli_query($conn, $query);
    
    if (!$result || mysqli_num_rows($result) == 0) {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Portfolio Not Found',
                text: 'The requested portfolio could not be found.',
                confirmButtonText: 'OK',
                confirmButtonColor: '#EF4444',
                background: 'rgba(26, 31, 43, 0.9)',
                color: '#e0e0e0'
            }).then(function() {
                window.location.href = 'my_templates.php';
            });
        </script>";
        exit();
    }
    
    $portfolio = mysqli_fetch_assoc($result);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Portfolio - ShowBase</title>
    
    <!-- Google Fonts - Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
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

        /* Container */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
            position: relative;
            z-index: 1;
        }

        /* Page Header */
        .page-header {
            text-align: center;
            margin-bottom: 3rem;
            position: relative;
        }

        .page-title {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 2.5rem;
            color: #fff;
            margin-bottom: 0.5rem;
            background: var(--gradient-2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            display: inline-block;
            position: relative;
        }

        .page-title::after {
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

        .page-subtitle {
            color: #9CA3AF;
            font-size: 1.1rem;
            max-width: 600px;
            margin: 0 auto;
        }

        /* Form Container */
        .form-container {
            background: rgba(26, 31, 43, 0.8);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 2.5rem;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(124, 58, 237, 0.2);
            position: relative;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .form-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            border-radius: 20px;
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
            transform: translateY(-5px);
            box-shadow: 0 25px 70px rgba(0, 0, 0, 0.4);
        }

        .form-container:hover::before {
            opacity: 1;
        }

        /* Form Sections */
        .form-section {
            margin-bottom: 2rem;
        }

        .section-title {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 1.3rem;
            color: #fff;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid rgba(124, 58, 237, 0.3);
            position: relative;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 50px;
            height: 2px;
            background: var(--gradient-3);
            border-radius: 2px;
        }

        /* Form Grid */
        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        /* Form Groups */
        .form-group {
            position: relative;
        }

        .form-label {
            display: block;
            margin-bottom: 0.75rem;
            font-weight: 500;
            color: #e0e0e0;
            font-size: 0.9rem;
        }

        .form-input, .form-textarea {
            width: 100%;
            padding: 0.875rem 1rem;
            border: 2px solid rgba(124, 58, 237, 0.2);
            border-radius: 12px;
            background: rgba(26, 31, 43, 0.6);
            color: #fff;
            font-family: 'Poppins', sans-serif;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-input:focus, .form-textarea:focus {
            outline: none;
            border-color: var(--electric-blue);
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
            background: rgba(26, 31, 43, 0.8);
        }

        .form-textarea {
            resize: vertical;
            min-height: 100px;
        }

        /* File Upload */
        .file-upload {
            position: relative;
            display: inline-block;
            width: 100%;
        }

        .file-input {
            position: absolute;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }

        .file-label {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0.875rem 1rem;
            border: 2px solid rgba(124, 58, 237, 0.2);
            border-radius: 12px;
            background: rgba(26, 31, 43, 0.6);
            color: #e0e0e0;
            font-family: 'Poppins', sans-serif;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .file-label:hover {
            border-color: var(--electric-blue);
            background: rgba(26, 31, 43, 0.8);
        }

        .file-icon {
            margin-right: 0.5rem;
            color: #9CA3AF;
        }

        .current-file {
            margin-top: 0.5rem;
            font-size: 0.85rem;
            color: #9CA3AF;
        }

        /* Buttons */
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

        /* Form Actions */
        .form-actions {
            display: flex;
            justify-content: space-between;
            margin-top: 2rem;
        }

        /* Current Files Display */
        .current-files {
            margin-top: 1rem;
        }

        .file-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.75rem 1rem;
            background: rgba(26, 31, 43, 0.4);
            border-radius: 8px;
            margin-bottom: 0.5rem;
        }

        .file-name {
            color: #e0e0e0;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .file-remove {
            color: #EF4444;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .file-remove:hover {
            color: #DC2626;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
            
            .form-container {
                padding: 2rem;
            }
        }

        @media (max-width: 480px) {
            .form-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }
            
            .form-container {
                padding: 1.5rem;
            }
            
            .section-title {
                font-size: 1.1rem;
            }
            
            .form-input, .form-textarea {
                padding: 0.75rem 0.875rem;
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
    <!-- Animated Background -->
    <div class="animated-bg"></div>

    <div class="container">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">Update Portfolio Details</h1>
            <p class="page-subtitle">Customize your professional portfolio with our tools</p>
        </div>

        <!-- Update Form -->
        <form method="POST" enctype="multipart/form-data" class="form-container">
            <!-- Personal Information Section -->
            <div class="form-section">
                <h2 class="section-title">Personal Information</h2>
                
                <div class="form-grid">
                    <div class="form-group">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" id="name" name="name" class="form-input" value="<?= htmlspecialchars($portfolio['name'] ?? '') ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" id="email" name="email" class="form-input" value="<?= htmlspecialchars($portfolio['email'] ?? '') ?>" required>
                    </div>
                </div>
            </div>

            <!-- Professional Summary Section -->
            <div class="form-section">
                <h2 class="section-title">Professional Summary</h2>
                
                <div class="form-grid">
                    <div class="form-group">
                        <label for="projects" class="form-label">Projects</label>
                        <input type="text" id="projects" name="projects" class="form-input" value="<?= htmlspecialchars($portfolio['projects'] ?? '') ?>" placeholder="e.g., E-commerce Platform, CRM System">
                    </div>
                    
                    <div class="form-group">
                        <label for="work_experience" class="form-label">Work Experience</label>
                        <input type="text" id="work_experience" name="work_experience" class="form-input" value="<?= htmlspecialchars($portfolio['work_experience'] ?? '') ?>" placeholder="e.g., 3+ years in Software Development">
                    </div>
                </div>
            </div>

            <!-- Education Section -->
            <div class="form-section">
                <h2 class="section-title">Education</h2>
                
                <div class="form-grid">
                    <div class="form-group">
                        <label for="school_info" class="form-label">School/University</label>
                        <input type="text" id="school_info" name="school_info" class="form-input" value="<?= htmlspecialchars($portfolio['school_info'] ?? '') ?>" placeholder="e.g., Stanford University">
                    </div>
                    
                    <div class="form-group">
                        <label for="college_info" class="form-label">College</label>
                        <input type="text" id="college_info" name="college_info" class="form-input" value="<?= htmlspecialchars($portfolio['college_info'] ?? '') ?>" placeholder="e.g., Computer Science Department">
                    </div>
                </div>
            </div>

            <!-- Skills Section -->
            <div class="form-section">
                <h2 class="section-title">Skills</h2>
                
                <div class="form-group">
                    <label for="skill_description" class="form-label">Skill Description</label>
                    <textarea id="skill_description" name="skill_description" class="form-textarea" placeholder="Describe your technical skills and expertise..."><?= htmlspecialchars($portfolio['skill_description'] ?? '') ?></textarea>
                </div>
                
                <div class="form-grid">
                    <div class="form-group">
                        <label for="key_skills" class="form-label">Key Skills</label>
                        <input type="text" id="key_skills" name="key_skills" class="form-input" value="<?= htmlspecialchars($portfolio['key_skills'] ?? '') ?>" placeholder="e.g., JavaScript, PHP, React, Node.js">
                    </div>
                    
                    <div class="form-group">
                        <label for="skills" class="form-label">All Skills</label>
                        <input type="text" id="skills" name="skills" class="form-input" value="<?= htmlspecialchars($portfolio['skills'] ?? '') ?>" placeholder="e.g., HTML, CSS, JavaScript, React, Node.js">
                    </div>
                </div>
            </div>

            <!-- Media Upload Section -->
            <div class="form-section">
                <h2 class="section-title">Media</h2>
                
                <div class="form-grid">
                    <div class="form-group">
                        <label for="photo" class="form-label">Profile Photo</label>
                        <div class="file-upload">
                            <input type="file" id="photo" name="photo" class="file-input" accept="image/*">
                            <label for="photo" class="file-label">
                                <i class="fas fa-cloud-upload-alt file-icon"></i>
                                <span>Choose a file</span>
                            </label>
                            <div class="current-file">Current: <?= htmlspecialchars($portfolio['photo'] ?? 'None') ?></div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="resume" class="form-label">Resume</label>
                        <div class="file-upload">
                            <input type="file" id="resume" name="resume" class="file-input" accept="application/pdf, .doc, .docx">
                            <label for="resume" class="file-label">
                                <i class="fas fa-file-alt file-icon"></i>
                                <span>Choose a file</span>
                            </label>
                            <div class="current-file">Current: <?= htmlspecialchars($portfolio['resume'] ?? 'None') ?></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="form-actions">
                <a href="my_templates.php" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i>
                    Back
                </a>
                
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i>
                    Update Portfolio
                </button>
                
                <div id="lottie-animation" class="h-16 w-16"></div>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Form submission handling
        document.querySelector('form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Show loading state
            const submitBtn = document.querySelector('.btn-primary');
            const originalContent = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Updating...';
            submitBtn.disabled = true;
            
            // Simulate form submission
            setTimeout(() => {
                // Reset button
                submitBtn.innerHTML = originalContent;
                submitBtn.disabled = false;
                
                // Show success message
                Swal.fire({
                    icon: 'success',
                    title: 'Portfolio Updated!',
                    text: 'Your portfolio has been successfully updated.',
                    confirmButtonColor: '#10B981',
                    background: 'rgba(26, 31, 43, 0.9)',
                    color: '#e0e0e0'
                });
            }, 1500);
        });
    </script>
</body>
</html>