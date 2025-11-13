<?php
session_start();
include("../database/db.php");

if ($_SESSION['role'] !== 'student') {
    header("Location: ../index.php");
    exit;
}

include('../includes/header.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ATS Resume Checker</title>
    
    <!-- Google Fonts: Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
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
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 10px;
            position: relative;
            overflow: hidden;
        }
        
        .bg-gradient {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 25% 25%, rgba(124, 58, 237, 0.1) 0%, transparent 40%),
                radial-gradient(circle at 75% 75%, rgba(59, 130, 246, 0.1) 0%, transparent 40%);
            z-index: -1;
        }
        
        .main-wrapper {
            width: 100%;
            max-width: 320px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        .card {
            background: linear-gradient(145deg, rgba(26, 31, 43, 0.95), rgba(11, 15, 25, 0.95));
            border-radius: 12px;
            padding: 16px;
            box-shadow: 
                0 8px 20px rgba(0, 0, 0, 0.4),
                0 0 0 1px rgba(124, 58, 237, 0.2);
            position: relative;
            overflow: hidden;
            backdrop-filter: blur(8px);
            width: 100%;
        }
        
        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--neon-purple), var(--electric-blue), var(--aqua-accent));
        }
        
        .header {
            text-align: center;
            margin-bottom: 12px;
        }
        
        .icon-wrapper {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, var(--neon-purple), var(--electric-blue));
            border-radius: 8px;
            margin-bottom: 8px;
            box-shadow: 0 3px 8px rgba(124, 58, 237, 0.25);
        }
        
        .icon-wrapper i {
            font-size: 1rem;
            color: white;
        }
        
        h2 {
            font-weight: 600;
            font-size: 1rem;
            background: linear-gradient(90deg, var(--neon-purple), var(--electric-blue));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            margin-bottom: 2px;
        }
        
        .subtitle {
            font-size: 0.7rem;
            color: #9ca3af;
            font-weight: 400;
        }
        
        .stats-row {
            display: flex;
            justify-content: space-around;
            margin-bottom: 12px;
            padding: 8px;
            background: rgba(26, 31, 43, 0.5);
            border-radius: 6px;
            border: 1px solid rgba(124, 58, 237, 0.1);
        }
        
        .stat-item {
            text-align: center;
        }
        
        .stat-value {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--electric-blue);
        }
        
        .stat-label {
            font-size: 0.6rem;
            color: #9ca3af;
            margin-top: 1px;
        }
        
        .form-group {
            margin-bottom: 10px;
        }
        
        label {
            display: block;
            margin-bottom: 4px;
            font-weight: 500;
            font-size: 0.75rem;
            color: var(--aqua-accent);
        }
        
        select, .file-upload {
            width: 100%;
            padding: 8px 10px;
            background: rgba(26, 31, 43, 0.6);
            border: 1px solid rgba(124, 58, 237, 0.2);
            border-radius: 6px;
            color: #fff;
            font-family: 'Poppins', sans-serif;
            font-size: 0.8rem;
            transition: all 0.3s ease;
        }
        
        select {
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%237C3AED' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 8px center;
            background-size: 14px;
            padding-right: 28px;
        }
        
        select:focus, .file-upload:focus-within {
            outline: none;
            border-color: var(--electric-blue);
            box-shadow: 0 0 0 1px rgba(59, 130, 246, 0.15);
        }
        
        select option {
            background: var(--deep-gray);
            color: #fff;
        }
        
        .file-upload {
            position: relative;
            border: 1px dashed rgba(124, 58, 237, 0.3);
            cursor: pointer;
            text-align: center;
            padding: 10px 8px;
            transition: all 0.3s ease;
            min-height: 50px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        
        .file-upload:hover {
            border-color: var(--electric-blue);
            background: rgba(59, 130, 246, 0.08);
        }
        
        .file-upload input[type="file"] {
            position: absolute;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }
        
        .file-upload i {
            font-size: 1rem;
            color: var(--electric-blue);
            margin-bottom: 2px;
        }
        
        .file-upload span {
            font-size: 0.7rem;
            color: #9ca3af;
        }
        
        .btn {
            width: 100%;
            padding: 8px;
            background: linear-gradient(90deg, var(--neon-purple), var(--electric-blue));
            color: white;
            border: none;
            border-radius: 6px;
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 0.8rem;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            margin-top: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .btn i {
            margin-right: 6px;
            font-size: 0.75rem;
        }
        
        .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(124, 58, 237, 0.3);
        }
        
        .progress-dots {
            display: flex;
            justify-content: center;
            margin-bottom: 10px;
            gap: 4px;
        }
        
        .dot {
            width: 5px;
            height: 5px;
            border-radius: 50%;
            background: rgba(124, 58, 237, 0.3);
            transition: all 0.3s ease;
        }
        
        .dot.active {
            background: var(--electric-blue);
            box-shadow: 0 0 6px rgba(59, 130, 246, 0.5);
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(5px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .main-wrapper {
            animation: fadeIn 0.5s ease-out;
        }
        
        @media (max-width: 340px) {
            .main-wrapper {
                max-width: 100%;
            }
            
            .card {
                padding: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="bg-gradient"></div>
    
    <div class="main-wrapper">
        <div class="card">
            <div class="header">
                <div class="icon-wrapper">
                    <i class="fas fa-file-alt"></i>
                </div>
                <h2>ATS Resume Checker</h2>
                <p class="subtitle">Upload your resume for instant analysis</p>
            </div>
            
            <div class="progress-dots">
                <div class="dot active"></div>
                <div class="dot"></div>
                <div class="dot"></div>
            </div>
            
            <div class="stats-row">
                <div class="stat-item">
                    <div class="stat-value">98%</div>
                    <div class="stat-label">Accuracy</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value">50+</div>
                    <div class="stat-label">Roles</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value">2s</div>
                    <div class="stat-label">Analysis</div>
                </div>
            </div>

            <form action="upload_resume" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="role">Job Role</label>
                    <select name="role" required>
                        <option value="" disabled selected>Select role</option>
                        <option value="Web Developer">💻 Web Developer</option>
                        <option value="Java Developer">☕ Java Developer</option>
                        <option value="PHP Developer">🐘 PHP Developer</option>
                        <option value="WordPress Developer">🌐 WordPress Developer</option>
                        <option value="SQL Developer">📊 SQL Developer</option>
                        <option value="Data Analyst">📈 Data Analyst</option>
                        <option value="Marketing Manager">📢 Marketing Manager</option>
                        <option value="Graphic Designer">🎨 Graphic Designer</option>
                        <option value="UI/UX Designer">🖌️ UI/UX Designer</option>
                        <option value="Business Analyst">📑 Business Analyst</option>
                        <option value="Software Tester">🛠️ Software Tester</option>
                        <option value="Photographer">📷 Photographer</option>
                        <option value="Content Writer">📝 Content Writer</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="resume">Resume File</label>
                    <div class="file-upload">
                        <input type="file" name="resume" id="resume" accept=".pdf, .docx">
                        <i class="fas fa-cloud-upload-alt"></i>
                        <span id="fileLabel">Choose file or drag here</span>
                    </div>
                </div>

                <button type="submit" class="btn">
                    <i class="fas fa-bolt"></i> Analyze Resume
                </button>
            </form>
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
        
        // File name display
        document.getElementById("resume").addEventListener("change", function(event) {
            let fileName = event.target.files[0] ? event.target.files[0].name : "Choose file or drag here";
            document.getElementById("fileLabel").innerText = fileName.length > 15 ? 
                fileName.substring(0, 15) + '...' : fileName;
        });

        // Form submission with SweetAlert
        document.querySelector("form").addEventListener("submit", function(event) {
            event.preventDefault(); 
            
            Swal.fire({
                title: "Analyzing Resume",
                html: "Checking ATS compatibility...",
                icon: "info",
                showConfirmButton: false,
                background: 'var(--deep-gray)',
                color: '#fff',
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            setTimeout(() => {
                event.target.submit();
            }, 2000);
        });
    </script>
</body>
</html>
