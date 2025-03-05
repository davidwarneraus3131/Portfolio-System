<?php
session_start(); // Start session at the top

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

// Include necessary files
include('../includes/header.php');
include("../database/db.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

  <!-- PHP Database Connection and Data Fetching -->
  <?php



    // Fetch total users
    $totalUsers = $conn->query("SELECT COUNT(*) as count FROM users")->fetch_assoc()['count'];

    // Fetch total completed templates
    $completedTemplates = $conn->query("SELECT COUNT(*) as count FROM portfolios WHERE status = 'completed'")->fetch_assoc()['count'];

    // Calculate total revenue
    $totalRevenue = $conn->query("SELECT SUM(amount) as total FROM portfolios")->fetch_assoc()['total'];

    // Count pending projects
    $pendingProjects = $conn->query("SELECT COUNT(*) as count FROM portfolios WHERE status = 'pending' OR status = 'review'")->fetch_assoc()['count'];

    // Total templates
    $totalTemplates = $conn->query("SELECT COUNT(*) as count FROM templates")->fetch_assoc()['count'];
  ?>

  <!-- Dashboard Container -->
  <div class="container mx-auto px-4 py-6">
    
    <!-- Dashboard Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

      <!-- Total Users Card -->
      <div class="bg-white shadow-lg p-6 rounded-lg flex items-center">
        <a href="view_users.php" class="text-blue-500 text-5xl mr-4"><i class="fas fa-users"></i></a>
        <div>
          <h3 class="text-gray-700 text-lg font-semibold mb-2">Total Users</h3>
          <p class="text-4xl font-bold text-blue-500"><?= $totalUsers ?></p>
        </div>
      </div>

      <!-- Total Template Completions Card -->
      <div class="bg-white shadow-lg p-6 rounded-lg flex items-center">
        <a href="status.php" class="text-green-500 text-5xl mr-4"><i class="fas fa-check-circle"></i></a>
        <div>
          <h3 class="text-gray-700 text-lg font-semibold mb-2">Total Template Completions</h3>
          <p class="text-4xl font-bold text-green-500"><?= $completedTemplates ?></p>
        </div>
      </div>

      <!-- Total Revenue Card -->
      <!-- Total Revenue Card -->
<div class="bg-white shadow-lg p-6 rounded-lg flex items-center">
    <a href="view_payments.php" class="text-yellow-500 text-5xl mr-4"><i class="fa-solid fa-indian-rupee-sign"></i></a>
    <div>
        <h3 class="text-gray-700 text-lg font-semibold mb-2">Total Revenue</h3>
        <p class="text-4xl font-bold text-yellow-500">
            ₹<?= $totalRevenue !== null ? number_format($totalRevenue, 2) : '0.00' ?>
        </p>
    </div>
</div>


      <!-- Pending Template Projects Card -->
      <div class="bg-white shadow-lg p-6 rounded-lg flex items-center">
        <a href="status.php" class="text-red-500 text-5xl mr-4"><i class="fas fa-exclamation-circle"></i></a>
        <div>
          <h3 class="text-gray-700 text-lg font-semibold mb-2">Pending Template Projects</h3>
          <p class="text-4xl font-bold text-red-500"><?= $pendingProjects ?></p>
        </div>
      </div>

      <!-- Total Templates Card -->
      <div class="bg-white shadow-lg p-6 rounded-lg flex items-center">
        <a href="templates.php" class="text-purple-500 text-5xl mr-4"><i class="fas fa-folder-open"></i></a>
        <div>
          <h3 class="text-gray-700 text-lg font-semibold mb-2">Total Templates</h3>
          <p class="text-4xl font-bold text-purple-500"><?= $totalTemplates ?></p>
        </div>
      </div>
      
    </div>
    

 
    
  </div>

 
</body>
</html>

<?php include('../includes/footer.php'); ?>
