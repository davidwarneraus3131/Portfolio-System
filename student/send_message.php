<?php
session_start();
include("../database/db.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['message']) && !empty(trim($_POST['message']))) {
        $user_id = $_SESSION['user_id'] ?? 0; // Fallback if session is not set
        $message = trim($_POST['message']);
        
        $query = "INSERT INTO chat_messages (user_id, message, sent_by) VALUES ($user_id, '$message', 'user')";
        if (mysqli_query($conn, $query)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to send message.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Message cannot be empty.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
