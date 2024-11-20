<?php 
session_start();
include("database/db.php");

$registrationSuccess = false; // Flag to check registration success
$errorMessage = ""; // Variable to hold error messages

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone']; // Add phone to form processing
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role = 'student'; // By default, registration is for students
    $githubid=$_POST['githubid'];
    $githubpassword=$_POST['githubpassword'];

    // Check if the email already exists
    $emailCheckQuery = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $emailCheckQuery);

    // Handle file upload for user_img
if (isset($_FILES['user_img']) && $_FILES['user_img']['error'] == 0) {
  $targetDir = "assets/users/";
  $targetFile = $targetDir . basename($_FILES["user_img"]["name"]);
  $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

  // Check if image file is a valid image type
  $check = getimagesize($_FILES["user_img"]["tmp_name"]);
  if ($check !== false) {
      // Move the uploaded file to the target directory
      if (move_uploaded_file($_FILES["user_img"]["tmp_name"], $targetFile)) {
          $user_img = $targetFile; 
      } else {
          $errorMessage = "Error uploading the image.";
      }
  } else {
      $errorMessage = "File is not an image.";
  }
} else {
  $user_img = null; // No image uploaded
}

    // Only set the error message if the email already exists
    if (mysqli_num_rows($result) > 0) {
        $errorMessage = "Email already exists. Please use a different email.";
    } else {
        // Email does not exist, proceed with registration
        $query = "INSERT INTO users (name, email, phone, password, role,github_id,github_password,user_img) VALUES ('$name', '$email', '$phone', '$password','$role','$githubid','$githubpassword','$user_img')";
        
        if (mysqli_query($conn, $query)) {
            $registrationSuccess = true; // Set success flag
        } else {
            $errorMessage = "Error: " . mysqli_error($conn);
        }
    }
}


?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>TeckSpiral - Register</title>
  <link rel="icon" href="https://teckspiral.com/moores/storage/app/public/shop/2024-06-02-665c438ca5bb6.webp" type="image/png">
  <script src="https://cdn.tailwindcss.com"></script> <!-- Tailwind CSS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.7.5/lottie.min.js"></script> <!-- Lottie Animation -->
  <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script> <!-- Particles.js -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- Font Awesome -->

  <style>
    /* Background gradient for the whole page */
    .bg-gradient {
      background: linear-gradient(to right, #3b5757, #020d1b);
      position: relative; /* Position for particle effect */
      overflow: hidden; /* Prevent overflow from particles */
      
    }
    .button-gradient {
      background: linear-gradient(to right, #3b5757, #020d1b);
    }
   

    /* Animations for form elements */
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(30px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .fade-in {
      animation: fadeIn 1s ease-in-out;
    }

    /* Input focus effects */
    .input-effect {
      transition: box-shadow 0.3s ease, transform 0.3s ease;
    }

    .input-effect:hover {
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      transform: translateY(-3px);
    }

    /* Button hover effects */
    .button-effect {
      transition: background-position 0.4s ease, box-shadow 0.3s ease;
      background-size: 200% 200%;
      background-position: left;
    }

    .button-effect:hover {
      background-position: right;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    }

    /* Center the Lottie animation */
    .lottie-container {
      width: 600px;
      margin: 0 auto;
    }

    /* Fullscreen particles */
    #particles-js {
      position: absolute;
      width: 100%;
      height: 100%;
      top: 0;
      left: 0;
      z-index: 0; /* Behind other content */
    }
  </style>
</head>
<body class="bg-gradient min-h-screen flex items-center justify-center relative">

  <!-- Particles.js Background -->
  <div id="particles-js"></div>

  <?php if ($registrationSuccess): ?>
    <!-- Lottie animation for success -->
    <div class="lottie-container mb-8 z-10">
      <div id="lottie-animation"></div>
      <script>
        var animation = lottie.loadAnimation({
          container: document.getElementById('lottie-animation'),
          renderer: 'svg',
          loop: false,
          autoplay: true,
          path: 'assets/animations/success-animation.json' // Lottie animation JSON file
        });

        // Redirect to index.php after animation finishes
        animation.addEventListener('complete', function() {
          setTimeout(function() {
            window.location.href = 'index.php'; // Redirect to index.php
          }, 1000); // Delay before redirecting (1 second)
        });
      </script>
    </div>
    
    <h1 class="text-4xl font-extrabold text-white mb-8 text-center z-10">Registration Successful!</h1>
    <p class="text-center text-white z-10">You will be redirected shortly...</p>
  <?php else: ?>
    <!-- Registration Form Container -->
    <div class="relative z-10 bg-white bg-opacity-90 shadow-xl rounded-lg p-10 max-w-lg w-full fade-in">
      <h1 class="text-4xl font-extrabold text-gray-800 mb-8 text-center">Register</h1>
      
      <!-- Show error message if the registration attempt fails -->
      <?php if ($errorMessage): ?>
        <div class="bg-red-500 text-white text-center p-2 rounded mb-4">
          <?php echo $errorMessage; ?>
        </div>
      <?php endif; ?>

      <!-- Registration Form -->
      <form method="POST" class="space-y-3" enctype="multipart/form-data">
  <div>
    <label for="name" class="block text-xs font-medium text-gray-700">Name</label>
    <input type="text" id="name" name="name" placeholder="Enter your name"
           class="w-full px-2 py-1 mt-1 text-sm border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required>
  </div>

  <div>
    <label for="email" class="block text-xs font-medium text-gray-700">Email</label>
    <input type="email" id="email" name="email" placeholder="Enter your email"
           class="w-full px-2 py-1 mt-1 text-sm border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required>
  </div>

  <div>
    <label for="phone" class="block text-xs font-medium text-gray-700">Phone</label>
    <input type="tel" id="phone" name="phone" placeholder="Enter your phone number"
           class="w-full px-2 py-1 mt-1 text-sm border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required>
  </div>

  <div>
    <label for="user_img" class="block text-xs font-medium text-gray-700">Upload Profile Image</label>
    <input type="file" id="user_img" name="user_img"
           class="w-full px-2 py-1 mt-1 text-sm border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
  </div>

  <div>
    <label for="githubid" class="block text-xs font-medium text-gray-700">GitHub ID</label>
    <input type="text" id="githubid" name="githubid" placeholder="Enter your GitHub ID"
           class="w-full px-2 py-1 mt-1 text-sm border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
  </div>

  <div>
    <label for="githubpassword" class="block text-xs font-medium text-gray-700">GitHub Password</label>
    <div class="relative">
      <input type="password" id="githubpassword" name="githubpassword" placeholder="Enter your GitHub Password"
             class="w-full px-2 py-1 mt-1 text-sm border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
      <button type="button" onclick="togglePassword('githubpassword', 'githubEyeIcon')" class="absolute inset-y-0 right-0 flex items-center pr-3">
        <i class="fas fa-eye" id="githubEyeIcon"></i>
      </button>
    </div>
  </div>

  <div>
    <label for="password" class="block text-xs font-medium text-gray-700">Password</label>
    <div class="relative">
      <input type="password" id="password" name="password" placeholder="Enter your password"
             class="w-full px-2 py-1 mt-1 text-sm border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required>
      <button type="button" onclick="togglePassword('password', 'eyeIcon')" class="absolute inset-y-0 right-0 flex items-center pr-3">
        <i class="fas fa-eye" id="eyeIcon"></i>
      </button>
    </div>
  </div>

  <div>
    <button type="submit"
            class="w-full button-gradient text-white font-bold py-2 px-4 rounded-md shadow-lg transition ease-in-out duration-300 
                   bg-blue-500 hover:bg-blue-600 hover:shadow-xl transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-400">
      Register
    </button>
  </div>

  <div class="mt-2 flex justify-between">
    <a href="https://github.com/signup" class="text-blue-600 underline text-xs">Create a GitHub Account</a>
    <a href="index.php" class="text-blue-600 underline text-xs">Already have an account? Log in</a>
  </div>
</form>


    </div>
  <?php endif; ?>

  <script>




    // Particles.js configuration
    particlesJS("particles-js", {
      "particles": {
        "number": {
          "value": 80,
          "density": {
            "enable": true,
            "value_area": 800
          }
        },
        "color": {
          "value": "#ffffff"
        },
        "shape": {
          "type": "circle",
          "stroke": {
            "width": 0,
            "color": "#000000"
          },
          "polygon": {
            "nb_sides": 5
          },
          "image": {
            "src": "img/github.svg",
            "width": 100,
            "height": 100
          }
        },
        "opacity": {
          "value": 0.5,
          "random": false,
          "anim": {
            "enable": false,
            "speed": 1,
            "opacity_min": 0.1,
            "sync": false
          }
        },
        "size": {
          "value": 3,
          "random": true,
          "anim": {
            "enable": false,
            "speed": 40,
            "size_min": 0.1,
            "sync": false
          }
        },
        "line_linked": {
          "enable": true,
          "distance": 150,
          "color": "#ffffff",
          "opacity": 0.4,
          "width": 1
        },
        "move": {
          "enable": true,
          "speed": 6,
          "direction": "none",
          "random": false,
          "straight": false,
          "out_mode": "out",
          "bounce": false,
          "attract": {
            "enable": false,
            "rotateX": 600,
            "rotateY": 1200
          }
        }
      },
      "interactivity": {
        "detect_on": "canvas",
        "events": {
          "onhover": {
            "enable": true,
            "mode": "repulse"
          },
          "onclick": {
            "enable": true,
            "mode": "push"
          },
          "resize": true
        },
        "modes": {
          "grab": {
            "distance": 400,
            "line_linked": {
              "opacity": 1
            }
          },
          "bubble": {
            "distance": 400,
            "size": 40,
            "duration": 2,
            "opacity": 8,
            "speed": 3
          },
          "repulse": {
            "distance": 200,
            "duration": 0.4
          },
          "push": {
            "particles_nb": 4
          },
          "remove": {
            "particles_nb": 2
          }
        }
      },
      "retina_detect": true
    });
  </script>
   <script>
    function togglePassword(inputId) {
      const passwordInput = document.getElementById(inputId);
      const eyeIcon = inputId === 'password' ? document.getElementById('eyeIcon') : document.getElementById('githubEyeIcon');
      
      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeIcon.classList.remove('fa-eye');
        eyeIcon.classList.add('fa-eye-slash');
      } else {
        passwordInput.type = 'password';
        eyeIcon.classList.remove('fa-eye-slash');
        eyeIcon.classList.add('fa-eye');
      }
    }

    particlesJS.load('particles-js', 'assets/particles.json', function() {
      console.log('particles.js loaded - callback');
    });
  </script>
</body>
</html>


