<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES['resume']) && $_FILES['resume']['error'] == 0) {
        $file = $_FILES['resume'];
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        
        if (!in_array($ext, ['pdf', 'docx'])) {
            die("Invalid file type. Only PDF and DOCX allowed.");
        }

        $uploadDir = "../assets/resume_checker/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $filePath = $uploadDir . basename($file['name']);
        move_uploaded_file($file['tmp_name'], $filePath);

        $_SESSION['uploaded_resume'] = $filePath;
        $_SESSION['selected_role'] = $_POST['role']; 

        header("Location: analyze_resume.php");
        exit();
    } else {
        die("Error uploading file.");
    }
}
?>
