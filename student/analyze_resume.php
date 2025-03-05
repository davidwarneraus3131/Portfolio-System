<?php
session_start();
require '../vendor/autoload.php'; // Required for PDF & DOCX parsing

use Smalot\PdfParser\Parser;
use PhpOffice\PhpWord\IOFactory;

// Ensure resume and role are set
if (!isset($_SESSION['uploaded_resume'], $_SESSION['selected_role'])) {
    die("No file uploaded or role selected.");
}

$filePath = $_SESSION['uploaded_resume'];
$selectedRole = $_SESSION['selected_role'];
$ext = pathinfo($filePath, PATHINFO_EXTENSION);
$resumeText = "";

// Extract text from PDF
if ($ext === "pdf") {
    $parser = new Parser();
    $pdf = $parser->parseFile($filePath);
    $resumeText = strtolower($pdf->getText()); // Convert text to lowercase for better matching
}

// Extract text from DOCX
if ($ext === "docx") {
    $phpWord = IOFactory::load($filePath);
    foreach ($phpWord->getSections() as $section) {
        foreach ($section->getElements() as $element) {
            if (method_exists($element, 'getText')) {
                $resumeText .= strtolower($element->getText()) . " "; // Convert to lowercase
            }
        }
    }
}

// Function to fetch job skills based on role (API or Fallback)
function fetchJobSkills($role) {
    $apiKey = "155ca28d11msh866ff53efc39559p1c4afajsnc7bfd3fb38df";
    
    $url = "https://jsearch.p.rapidapi.com/search?query=" . urlencode($role) . "&num_pages=1";

    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            "X-RapidAPI-Host: jsearch.p.rapidapi.com",
            "X-RapidAPI-Key: $apiKey"
        ]
    ]);

    $response = curl_exec($curl);
    curl_close($curl);

    $data = json_decode($response, true);
    
    if (!empty($data['data'][0]['job_highlights']['Qualifications'])) {
        return array_map('strtolower', $data['data'][0]['job_highlights']['Qualifications']); // Convert to lowercase
    }

    // Fallback skills based on predefined roles
    $roleSkills = [
        "Java Developer" => ["Java", "Spring Boot", "Microservices", "REST API", "SQL", "OOP"],
        "SQL Developer" => ["SQL", "Stored Procedures", "Triggers", "Indexing", "Database Optimization"],
        "Business Analyst" => ["Data Analysis", "Requirement Gathering", "Stakeholder Management", "Agile", "JIRA"],
        "PHP Developer" => ["PHP", "Laravel", "CodeIgniter", "MySQL", "JavaScript", "OOP"],
        "WordPress Developer" => ["WordPress", "PHP", "HTML", "CSS", "JavaScript", "SEO"],
        "Tester" => ["Manual Testing", "Automation Testing", "Selenium", "Bug Reporting", "Test Cases"],
    ];

    return $roleSkills[$role] ?? ["Communication", "Problem Solving", "Adaptability"]; // Default skills if role not found
}

// Fetch job skills based on role
$jobSkills = fetchJobSkills($selectedRole);

// Compare Resume with Job Skills
$foundSkills = array_filter($jobSkills, function($skill) use ($resumeText) {
    return stripos($resumeText, $skill) !== false;
});

// Find missing skills
$missingSkills = array_diff($jobSkills, $foundSkills);

// Store results in session
$_SESSION['ats_score'] = count($foundSkills) / count($jobSkills) * 100;
$_SESSION['missing_skills'] = $missingSkills;

header("Location: resume_result.php");
exit();
?>
