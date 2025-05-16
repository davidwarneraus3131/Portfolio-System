<?php
session_start();
include("../database/db.php");

if ($_SESSION['role'] !== 'student') {
    header("Location: ../index.php");
    exit;
}

include('../includes/header.php');

$data = json_decode(file_get_contents("php://input"), true);
$resume_data = $data['data'];

$stmt = $conn->prepare("INSERT INTO resumes (resume_data) VALUES (?)");
$stmt->bind_param("s", $resume_data);

if ($stmt->execute()) {
    echo "Resume saved successfully!";
} else {
    echo "Error: " . $stmt->error;
}
?>



