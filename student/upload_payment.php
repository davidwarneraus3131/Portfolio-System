<?php
session_start();
include("../database/db.php");
if ($_SESSION['role'] !== 'student') {
  header("Location: ../index.php");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $amount = $_POST['amount'];
    
    // Handle file upload
    $target_dir = "../assets/images/payments/";
    $target_file = $target_dir . basename($_FILES["proof_image"]["name"]);
    move_uploaded_file($_FILES["proof_image"]["tmp_name"], $target_file);
    
    // Insert payment into the database
    $query = "INSERT INTO payments (user_id, amount, proof_image) VALUES ('$user_id', '$amount', '$target_file')";
    mysqli_query($conn, $query);
    
    // Update portfolio payment status
    mysqli_query($conn, "UPDATE portfolios SET payment_status = 'pending' WHERE user_id = '$user_id'");

    header("Location: dashboard.php");
}
?>

<!DOCTYPE html>
<html>
<head>
  <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body>
  <div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold">Upload Payment Proof</h1>
    <form method="POST" enctype="multipart/form-data">
      <input type="number" name="amount" placeholder="Payment Amount" class="p-2 border w-full mt-2" required>
      <input type="file" name="proof_image" class="p-2 border w-full mt-2" required>
      <button type="submit" class="bg-blue-500 text-white p-2 mt-4">Submit Payment Proof</button>
    </form>
  </div>
</body>
</html>
