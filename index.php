<?php
session_start();
include("database/db.php");

$message = ""; // Variable to hold the message for SweetAlert


if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
  $email = $_POST['email'];
  $password = $_POST['password'];

  // Query to select the user based on the email and check for inactive status
  $result = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
  $user = mysqli_fetch_assoc($result);

  // Check if user exists and password is correct
  if ($user) {
      if ($user['status'] == 'inactive') {
          // User is inactive, unauthorized error
          $message = "You are unauthorized to log in!";
          $message_type = "unauthorized";
      } elseif (password_verify($password, $user['password'])) {
          // Credentials are correct, proceed with login
          $_SESSION['user_id'] = $user['id'];
          $_SESSION['role'] = $user['role'];
          $_SESSION['name'] = $user['name'];
          $_SESSION['email'] = $user['email'];
          $_SESSION['user_img'] = $user['user_img']; // Store user image in session

          // Set success message
          $message = "Login successful! Redirecting...";
          $message_type = "success";

          echo "<script>
                  setTimeout(function() {
                      window.location.href = '" . ($user['role'] == 'admin' ? "admin/dashboard.php" : "student/dashboard.php") . "';
                  }, 2000); // Redirect after 2 seconds
                </script>";
      } else {
          // Incorrect password
          $message = "Invalid credentials!";
          $message_type = "error";
      }
  } else {
      // User not found
      $message = "Invalid credentials!";
      $message_type = "error";
  }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Teck Spiral - Login</title>
    
  <!-- Favicon -->
  <link rel="icon" href="https://teckspiral.com/moores/storage/app/public/shop/2024-06-02-665c438ca5bb6.webp" type="image/png">
  <script src="https://cdn.tailwindcss.com"></script> <!-- Import Tailwind CSS -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- SweetAlert2 CDN -->
  
  <style>
    /* Background image with gradient overlay */
    .bg-login {
      background-image: url('assets/images/login.jpg');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      position: relative;
    }

    /* Dark gradient overlay */
    .bg-overlay {
      background: linear-gradient(to right, rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.5));
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: 1;
    }

    /* Animations for form elements */
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(30px); }
      to { opacity: 0.9; transform: translateY(0); }
    }

    .fade-in {
      animation: fadeIn 1s ease-in-out;
    }

    .input-effect {
      transition: box-shadow 0.3s ease, transform 0.3s ease;
    }

    .input-effect:hover {
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      transform: translateY(-3px);
    }

    .button-effect {
      background: linear-gradient(to right, #3b5757, #020d1b);
      transition: background 0.3s ease-in-out;
    }
    .button-effect:hover {
      background: linear-gradient(to right, #020d1b, #3b5757);
    }

    /* Error message style */
    .error-message {
      background-color: red;
      color: white;
      padding: 10px;
      border-radius: 5px;
      margin-top: 10px;
      display: none; /* Initially hidden */
    }
  </style>
</head>
<body class="bg-login h-screen flex items-center justify-center">

  <!-- Dark overlay for the background image -->
  <div class="bg-overlay"></div>

  <!-- Login Form Container -->
  <div class="relative z-10 bg-white bg-opacity-90 shadow-xl rounded-lg p-10 max-w-lg w-full fade-in">
    <h1 class="text-4xl font-extrabold text-gray-800 mb-8 text-center">Login</h1>

    <!-- Login Form -->
    <form method="POST" class="space-y-6">
      <div>
        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
        <input type="email" id="email" name="email" placeholder="Enter your email"
               class="w-full px-4 py-3 mt-2 border border-gray-300 rounded-lg shadow-sm input-effect focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required>
      </div>

      <div>
        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
        <input type="password" id="password" name="password" placeholder="Enter your password"
               class="w-full px-4 py-3 mt-2 border border-gray-300 rounded-lg shadow-sm input-effect focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required>
      </div>

      <!-- Submit Button -->
      <div>
        <button type="submit"
                class="w-full text-white font-bold py-3 px-6 rounded-lg shadow-lg button-effect focus:outline-none focus:ring-4 focus:ring-indigo-500">
          Login
        </button>
      </div>
      
      <!-- Registration Link -->
      <div class="text-center mt-4">
        <p class="text-sm text-gray-600">
          Don't have an account? <a href="register.php" class="text-indigo-600 underline">Register</a>
        </p>
      </div>
      
      <!-- Error Message Display -->
      <?php if (!empty($message)): ?>
        <div class="error-message" id="errorMessage">
          <?php echo $message; ?>
        </div>
      <?php endif; ?>

    </form>
  </div>

  <script>
  <?php if (!empty($message)): ?>
    Swal.fire({
      icon: '<?php echo $message_type === "success" ? "success" : "error"; ?>',
      title: '<?php echo $message_type === "success" ? "Success!" : "Oops..."; ?>',
      text: '<?php echo $message; ?>',
      confirmButtonColor: '#3b5757',
    });
  <?php endif; ?>
</script>
</body>
</html>
