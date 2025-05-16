<?php
session_start();
include("../database/db.php");

if ($_SESSION['role'] !== 'student') {
    header("Location: ../index.php");
    exit;
}

include('../includes/header.php');
?>




<?php
require '../vendor/autoload.php';
use Mpdf\Mpdf;


// Fetch the latest resume
$result = $conn->query("SELECT resume_data FROM resumes ORDER BY id DESC LIMIT 1");
$row = $result->fetch_assoc();
$resume_data = json_decode($row['resume_data'], true);

$mpdf = new Mpdf();
$html = "<h1>Your Resume</h1>";

foreach ($resume_data['objects'] as $obj) {
    if ($obj['type'] == 'textbox') {
        $html .= "<p style='font-size:{$obj['fontSize']}px;'>{$obj['text']}</p>";
    }
}

$mpdf->WriteHTML($html);
$mpdf->Output("resume.pdf", "D");
?>
