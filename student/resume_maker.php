<?php
session_start();
include("../database/db.php");

if ($_SESSION['role'] !== 'student') {
    header("Location: ../index.php");
    exit;
}

include('../includes/header.php'); ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/5.3.0/fabric.min.js"></script>
   
</head>
<body>
    <h1>Drag & Drop Resume Builder</h1>
    
    <canvas id="resumeCanvas" width="800" height="1000" style="border:1px solid #ccc;"></canvas>

    <button id="addText">Add Text</button>
    <button id="uploadImage">Upload Image</button>
    <input type="file" id="imageInput" style="display: none;">
    <button id="saveResume">Save Resume</button>
    <button id="downloadPDF">Download as PDF</button>

    <script src="script.js"></script>
</body>
</html>
