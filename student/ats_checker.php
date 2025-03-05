<?php
session_start();
include("../database/db.php");

if ($_SESSION['role'] !== 'student') {
    header("Location: ../index.php");
    exit;
}

include('../includes/header.php');
?>


<div style="display: grid;place-items: center;height: 100vh;">
<div class="bg-white shadow-xl rounded-lg p-8 max-w-lg w-full text-center">
    <h2 class="text-3xl font-bold text-gray-800">📄 ATS Resume Checker</h2>
    <p class="text-gray-600 mt-2">Upload your resume and check its ATS compatibility</p>

    <form action="upload_resume" method="post" enctype="multipart/form-data" class="mt-6 space-y-4">
        
        <!-- Job Role Selection -->
        <label for="role" class="block font-semibold text-gray-700">Select Job Role:</label>
        <select name="role" required class="w-full p-2 border rounded-lg shadow-sm focus:ring focus:ring-blue-300">
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

        <!-- Resume Upload -->
        <label for="resume" class="block font-semibold text-gray-700">Upload Resume (PDF/DOCX):</label>
        <div class="relative border-dashed border-2 border-gray-300 p-6 rounded-lg cursor-pointer hover:border-blue-500 transition">
            <input type="file" name="resume" id="resume" accept=".pdf, .docx" class="absolute inset-0 opacity-0 cursor-pointer w-full h-full">
            <span id="fileLabel" class="text-gray-500">Drag & Drop or Click to Upload</span>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="w-full bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-800 transition font-semibold">
            🚀 Check Resume
        </button>
    </form>
</div>
</div>

<script>
    // Show file name after selection
    document.getElementById("resume").addEventListener("change", function(event) {
        let fileName = event.target.files[0] ? event.target.files[0].name : "Drag & Drop or Click to Upload";
        document.getElementById("fileLabel").innerText = fileName;
    });

    // SweetAlert Confirmation after submit
    document.querySelector("form").addEventListener("submit", function(event) {
        event.preventDefault(); 
        Swal.fire({
            title: "Uploading...",
            text: "Please wait while we analyze your resume.",
            icon: "info",
            showConfirmButton: false,
            timer: 2000
        }).then(() => {
            event.target.submit();
        });
    });
</script>

</body>
</html>
