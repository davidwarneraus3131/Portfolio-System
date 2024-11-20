<?php
session_start();
include("../database/db.php");

$user_id = $_SESSION['user_id'];

// Retrieve messages
$query = "SELECT * FROM chat_messages WHERE user_id = $user_id ORDER BY created_at ASC";
$result = mysqli_query($conn, $query);

$messages = [];
while ($row = mysqli_fetch_assoc($result)) {
    $messages[] = $row;
}

// Return messages as JSON
echo json_encode($messages);
?>
