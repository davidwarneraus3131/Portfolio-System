<?php
session_start();
include("../database/db.php");

if ($_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

// Check if data is sent via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = intval($_POST['id']);
    $status = $_POST['status'];
    $payment_status = $_POST['payment_status'];

    // Update the database
    $stmt = $conn->prepare("UPDATE portfolios SET status = ?, payment_status = ? WHERE id = ?");
    $stmt->bind_param("ssi", $status, $payment_status, $id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }

    $stmt->close();
}

$conn->close();
?>
