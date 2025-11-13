<?php
ob_start();
session_start();
include("../database/db.php");
if ($_SESSION['role'] !== 'student') {
    header("Location: ../index.php");
}
include('../includes/header.php');
 $template_id = $_GET['id'];
 $user_id = $_SESSION['user_id'];

// Fetch template details
 $template_result = mysqli_query($conn, "SELECT * FROM templates WHERE id='$template_id'");
 $template = mysqli_fetch_assoc($template_result);

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $projects = $_POST['projects'];
    $work_experience = $_POST['work_experience'];
    $school_info = $_POST['school_info'];
    $college_info = $_POST['college_info'];
    $skill_description = $_POST['skill_description'];
    $key_skills = $_POST['key_skills'];

    // Upload files (photo and resume)
    $photo = $_FILES['photo']['name'];
    $resume = $_FILES['resume']['name'];
    move_uploaded_file($_FILES['photo']['tmp_name'], "../assets/users/$photo");
    move_uploaded_file($_FILES['resume']['tmp_name'], "../assets/resume/$resume");

    // Insert into portfolios
    $query = "INSERT INTO portfolios (user_id, template_id, name, email, projects, work_experience, school_info, college_info, skill_description, key_skills, photo, resume, status)
              VALUES ('$user_id', '$template_id', '$name', '$email', '$projects', '$work_experience', '$school_info', '$college_info', '$skill_description', '$key_skills', '$photo', '$resume', 'pending')";

    if (mysqli_query($conn, $query)) {
        // Set success message
        $_SESSION['success'] = 'Data inserted successfully!';
        header("Location: " . $_SERVER['PHP_SELF'] . "?id=" . $template_id); // Redirect to the same page with success message
        exit();
    }
}

// Check if a success message exists
 $success_message = isset($_SESSION['success']) ? $_SESSION['success'] : '';
unset($_SESSION['success']); // Clear the message after showing it
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio Template Selection</title>
    
    <!-- Google Fonts: Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Include SweetAlert CSS and JS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
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
            background-color: var(--dark-navy);
            color: #fff;
            min-height: 100vh;
            padding: 20px;
            position: relative;
            overflow-x: hidden;
        }
        
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 20% 30%, rgba(124, 58, 237, 0.2) 0%, transparent 50%),
                radial-gradient(circle at 80% 70%, rgba(59, 130, 246, 0.2) 0%, transparent 50%);
            z-index: -1;
        }
        
        .container {
            max-width: 900px;
            margin: 0 auto;
            animation: fadeInUp 0.8s ease-out;
        }
        
        .card {
            background: linear-gradient(135deg, rgba(26, 31, 43, 0.9), rgba(11, 15, 25, 0.9));
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(124, 58, 237, 0.3);
            position: relative;
            overflow: hidden;
            backdrop-filter: blur(10px);
        }
        
        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--neon-purple), var(--electric-blue), var(--aqua-accent));
            animation: gradient 3s ease infinite;
        }
        
        @keyframes gradient {
            0%, 100% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
        }
        
        h1 {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 2rem;
            margin-bottom: 20px;
            background: linear-gradient(90deg, var(--neon-purple), var(--electric-blue));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            text-align: center;
        }
        
        .template-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 15px;
        }
        
        .price {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 1.2rem;
            position: relative;
            display: inline-block;
        }
        
        .original-price {
            color: #999;
            text-decoration: line-through;
            margin-right: 15px;
        }
        
        .current-price {
            color: var(--aqua-accent);
            text-shadow: 0 0 10px rgba(34, 211, 238, 0.5);
        }
        
        .template-image {
            width: 100%;
            height: 300px;
            object-fit: cover;
            border-radius: 15px;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(34, 211, 238, 0.3);
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-row {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }
        
        .form-row .form-group {
            flex: 1;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--aqua-accent);
        }
        
        input, textarea {
            width: 100%;
            padding: 15px;
            background: rgba(26, 31, 43, 0.7);
            border: 1px solid rgba(124, 58, 237, 0.3);
            border-radius: 10px;
            color: #fff;
            font-family: 'Poppins', sans-serif;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        
        input:focus, textarea:focus {
            outline: none;
            border-color: var(--electric-blue);
            box-shadow: 0 0 10px rgba(59, 130, 246, 0.3);
        }
        
        textarea {
            min-height: 120px;
            resize: vertical;
        }
        
        .file-input {
            position: relative;
            overflow: hidden;
            display: inline-block;
            width: 100%;
        }
        
        .file-input input[type=file] {
            position: absolute;
            left: -9999px;
        }
        
        .file-input label {
            display: block;
            padding: 15px;
            background: rgba(26, 31, 43, 0.7);
            border: 1px solid rgba(124, 58, 237, 0.3);
            border-radius: 10px;
            cursor: pointer;
            text-align: center;
            transition: all 0.3s ease;
        }
        
        .file-input label:hover {
            background: rgba(124, 58, 237, 0.2);
            border-color: var(--electric-blue);
        }
        
        .file-input label i {
            margin-right: 10px;
            color: var(--electric-blue);
        }
        
        .btn {
            display: inline-block;
            padding: 15px 30px;
            background: linear-gradient(90deg, var(--neon-purple), var(--electric-blue));
            color: white;
            border: none;
            border-radius: 50px;
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
            width: 100%;
            margin-top: 20px;
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
            transition: left 0.5s;
        }
        
        .btn:hover::before {
            left: 100%;
        }
        
        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(124, 58, 237, 0.3);
        }
        
        .progress-bar {
            height: 5px;
            background: rgba(26, 31, 43, 0.7);
            border-radius: 5px;
            margin-bottom: 30px;
            overflow: hidden;
        }
        
        .progress {
            height: 100%;
            background: linear-gradient(90deg, var(--neon-purple), var(--electric-blue), var(--aqua-accent));
            width: 75%;
            border-radius: 5px;
            animation: progress 2s ease-out;
        }
        
        @keyframes progress {
            from {
                width: 0;
            }
        }
        
        .toggle-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        
        .toggle {
            position: relative;
            width: 60px;
            height: 30px;
            background: rgba(26, 31, 43, 0.7);
            border-radius: 30px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .toggle::after {
            content: '';
            position: absolute;
            top: 3px;
            left: 3px;
            width: 24px;
            height: 24px;
            background: #fff;
            border-radius: 50%;
            transition: all 0.3s ease;
        }
        
        .toggle.active {
            background: var(--electric-blue);
        }
        
        .toggle.active::after {
            transform: translateX(30px);
        }
        
        .floating-shapes {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: -1;
            overflow: hidden;
        }
        
        .shape {
            position: absolute;
            opacity: 0.1;
            animation: float 20s infinite linear;
        }
        
        .shape:nth-child(1) {
            width: 80px;
            height: 80px;
            background: var(--neon-purple);
            border-radius: 50%;
            top: 20%;
            left: 10%;
            animation-duration: 25s;
        }
        
        .shape:nth-child(2) {
            width: 120px;
            height: 120px;
            background: var(--electric-blue);
            border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
            top: 60%;
            right: 10%;
            animation-duration: 30s;
            animation-direction: reverse;
        }
        
        .shape:nth-child(3) {
            width: 100px;
            height: 100px;
            background: var(--aqua-accent);
            border-radius: 50%;
            bottom: 20%;
            left: 30%;
            animation-duration: 35s;
        }
        
        @keyframes float {
            0% {
                transform: translateY(0) rotate(0deg);
            }
            50% {
                transform: translateY(-20px) rotate(180deg);
            }
            100% {
                transform: translateY(0) rotate(360deg);
            }
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @media (max-width: 768px) {
            .form-row {
                flex-direction: column;
                gap: 0;
            }
            
            .template-info {
                flex-direction: column;
                text-align: center;
            }
            
            h1 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="floating-shapes">
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
    </div>
    
    <div class="container">
        <div class="card">
            <h1>Select Template: <?php echo $template['text']; ?></h1>
            
            <div class="progress-bar">
                <div class="progress"></div>
            </div>
            
            <div class="template-info">
                <div>
                    <span class="price original-price">Original Price: ₹<?php echo $template['actual_price']; ?></span>
                    <span class="price current-price">Price: ₹<?php echo $template['price']; ?></span>
                </div>
            </div>
            
            <img src="../assets/<?php echo $template['template_image']; ?>" class="template-image" alt="Template Preview">
            
            <form method="POST" enctype="multipart/form-data">
                <div class="form-row">
                    <div class="form-group">
                        <label for="name">Your Name</label>
                        <input type="text" id="name" name="name" placeholder="John Doe" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Your Email</label>
                        <input type="email" id="email" name="email" placeholder="john@example.com" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="projects">Your Projects</label>
                        <input type="text" id="projects" name="projects" placeholder="Project 1, Project 2">
                    </div>
                    <div class="form-group">
                        <label for="work_experience">Work Experience</label>
                        <input type="text" id="work_experience" name="work_experience" placeholder="Company Name, Position">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="school_info">School Info with Year</label>
                        <input type="text" id="school_info" name="school_info" placeholder="School Name, Year">
                    </div>
                    <div class="form-group">
                        <label for="college_info">College Info with Year</label>
                        <input type="text" id="college_info" name="college_info" placeholder="College Name, Year">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="skill_description">Describe Your Skills</label>
                    <textarea id="skill_description" name="skill_description" placeholder="Brief description of your skills and expertise"></textarea>
                </div>
                
                <div class="form-group">
                    <label for="key_skills">Key Skills</label>
                    <input type="text" id="key_skills" name="key_skills" placeholder="HTML, CSS, JavaScript, etc.">
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Upload Your Photo</label>
                        <div class="file-input">
                            <input type="file" id="photo" name="photo" accept="image/*">
                            <label for="photo">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <span id="photo-label">Choose a file</span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Upload Your Resume (PDF)</label>
                        <div class="file-input">
                            <input type="file" id="resume" name="resume" accept=".pdf">
                            <label for="resume">
                                <i class="fas fa-file-pdf"></i>
                                <span id="resume-label">Choose a file</span>
                            </label>
                        </div>
                    </div>
                </div>
                
                <button type="submit" class="btn">Submit Portfolio</button>
            </form>
        </div>
    </div>

    <script>
        // File input label update
        document.getElementById('photo').addEventListener('change', function() {
            const fileName = this.files[0]?.name || 'Choose a file';
            document.getElementById('photo-label').textContent = fileName;
        });
        
        document.getElementById('resume').addEventListener('change', function() {
            const fileName = this.files[0]?.name || 'Choose a file';
            document.getElementById('resume-label').textContent = fileName;
        });
        
        // Show SweetAlert success message
        <?php if ($success_message): ?>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '<?php echo $success_message; ?>',
                confirmButtonText: 'OK',
                background: 'var(--deep-gray)',
                color: '#fff',
                confirmButtonColor: 'var(--electric-blue)'
            });
        <?php endif; ?>
    </script>
</body>
</html>
<?php include('../includes/footer.php'); ?>
<?php
// Flush output buffer
ob_end_flush();
?>