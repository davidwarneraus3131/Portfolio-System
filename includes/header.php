<?php
// Check if a session is already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="Teck Spiral - Your gateway to innovative tech solutions.">
<meta name="keywords" content="Tech, Solutions, Innovative, Teck Spiral">
<meta name="author" content="Teck Spiral">
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flaticon/3.0.1/font/flaticon.css">
<link rel="stylesheet" href="../css/styles.css">

<title>SRIDHAR'S-PORTFOLIO</title>

<!-- Favicon -->
<link rel="icon" href="https://saphotel.in/test/demo_files/admin/sri_logo.jpg" type="image/png">

<style>
  .heading{
    font-family: Georgia, serif;

  }
</style>

<!-- Header Navigation Bar -->
<nav class="bg-gradient-to-r from-black-900 to-gray-800 p-4 shadow-lg">
  <div class="container mx-auto flex justify-between items-center">
    <!-- Logo Section with Gradient Text Animation -->
    <a href="../index.php" class="flex items-center space-x-2">
      <img src="https://saphotel.in/test/demo_files/admin/sri_logo.jpg" alt="Logo" class="w-10 h-10 rounded-full transition-transform duration-300 hover:rotate-6"> <!-- Logo Image -->
      <span class="text-1xl font-extrabold gradient-text tracking-wide heading">TeckSpiral</span>
    </a>
    
    <!-- Navigation Links (Desktop) -->
    <ul class="hidden md:flex space-x-6">
      <?php
      if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
          echo '<li><a href="dashboard.php" class="nav-link">Dashboard</a></li>';
          echo '<li><a href="view_users.php" class="nav-link">Users List</a></li>';
          echo '<li><a href="templates.php" class="nav-link">All Templates</a></li>';
          echo '<li><a href="status.php" class="nav-link">Status</a></li>';
          echo '<li><a href="view_payments.php" class="nav-link">Payments</a></li>';
          echo '<li><a href="../logout.php" class="nav-link">Logout</a></li>';
      } else {
          echo '<li><a href="dashboard.php" class="nav-link"> Templates</a></li>';
          echo '<li><a href="my_templates.php" class="nav-link">My Templates</a></li>';
          echo '<li>
    <a href="ats_checker.php" class="nav-link-mobile relative group">
         Resume Check(ATS)<br> 
       <span class="absolute left-0 mt-1 w-64 px-3 py-2 text-xs text-white bg-gray-800 rounded shadow-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300">
            Upload & Analyze Your Resume for ATS Compatibility! Get instant feedback on formatting, keywords, and missing skills to boost your job success!
        </span>
    </a>
</li>';
          echo '<li><a href="contact.php" class="nav-link">Contact Us</a></li>';
          echo '<li><a href="../logout.php" class="nav-link">Logout</a></li>';
      }
      ?>
     
    </ul>

    <!-- User Image -->
    <!-- <?php if (isset($_SESSION['user_img'])): ?>
      <div class="relative">
        <img src="../<?php echo htmlspecialchars($_SESSION['user_img']); ?>" alt="User Profile" class="w-16 h-16 rounded-full border-2 border-green">
      </div>
    <?php endif; ?> -->

    <!-- Mobile Menu Icon -->
    <button id="menuToggle" class="md:hidden flex items-center text-white focus:outline-none">
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
      </svg>
    </button>
  </div>

  <!-- Mobile Navigation Menu -->
  <ul id="mobileMenu" class="hidden md:hidden flex flex-col mt-4 space-y-4 text-center bg-gray-900 p-4 rounded-lg">
    <?php
    if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
        echo '<li><a href="dashboard.php" class="nav-link-mobile">Dashboard</a></li>';
        echo '<li><a href="view_users.php" class="nav-link-mobile">Users List</a></li>';
        echo '<li><a href="templates.php" class="nav-link-mobile">All Templates</a></li>';
        echo '<li><a href="status.php" class="nav-link-mobile">Status</a></li>';
        echo '<li><a href="view_payments.php" class="nav-link-mobile">Payments</a></li>';
        echo '<li><a href="../logout.php" class="nav-link-mobile">Logout</a></li>';
    } else {
        echo '<li><a href="dashboard.php" class="nav-link-mobile">Templates</a></li>';
        echo '<li><a href="my_templates.php" class="nav-link-mobile">My Templates</a></li>';
        echo '<li>
    <a href="ats_checker.php" class="nav-link-mobile relative group">
        Resume Check(ATS) <br> 
        <span class="absolute left-0 mt-1 w-max px-2 py-1 text-xs text-white bg-gray-800 rounded opacity-0 group-hover:opacity-100 transition-opacity">
            Upload & Analyze Your Resume for ATS Compatibility!
        </span>
    </a>
</li>';
        echo '<li><a href="contact.php" class="nav-link-mobile">Contact Us</a></li>';
        echo '<li><a href="../logout.php" class="nav-link-mobile">Logout</a></li>';
    }
    ?>
   
  </ul>
</nav>

<style>
  /* Gradient Text Animation */
  .gradient-text {
    /* background: linear-gradient(90deg, #FF7A18, #AF002D 40%, #319197 100%); */
    background: linear-gradient(90deg, #FF7A18, #AF002D 40%, #FF7A18 100%);
    background-size: 200% 200%;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    animation: gradient-animation 4s ease infinite;
    font-size: 20px;
  }

  /* Animation Keyframes for Gradient Text */
  @keyframes gradient-animation {
    0% {
      background-position: 0% 50%;
    }
    50% {
      background-position: 100% 50%;
    }
    100% {
      background-position: 0% 50%;
    }
  }

  /* Nav Link Hover Effect (Desktop) */
  .nav-link {
    position: relative;
    font-size: 1rem;
    font-weight: 600;
    color: whitesmoke;
    transition: color 0.3s ease;
    text-transform: capitalize;
  }

  .nav-link:hover {
    color: #cbd5e0;
  }

  /* Animated Underline */
  .nav-link::after {
    content: '';
    position: absolute;
    width: 0;
    height: 2px;
    background-color: #fbbf24; /* Amber color underline */
    bottom: -2px;
    left: 0;
    transition: width 0.3s ease;
  }

  .nav-link:hover::after {
    width: 100%;
  }

  /* Mobile Nav Link Styling */
  .nav-link-mobile {
    font-size: 1rem;
    font-weight: 500;
    color: #ffffff;
    transition: color 0.3s ease;
  }

  .nav-link-mobile:hover {
    color: #fbbf24;
  }
</style>

<script>
  // Mobile Menu Toggle Script
  document.getElementById('menuToggle').addEventListener('click', function() {
    document.getElementById('mobileMenu').classList.toggle('hidden');
  });
</script>



<!-- live chat options  for students -->
 <!--Start of Tawk.to Script-->
 <?php
 // Check if the user is logged in
if(isset($_SESSION['user_id'])) { 
?>
    <script type="text/javascript">
        var Tawk_API = Tawk_API || {}, Tawk_LoadStart = new Date();
        (function() {
            var s1 = document.createElement("script"), s0 = document.getElementsByTagName("script")[0];
            s1.async = true;
            s1.src = 'https://embed.tawk.to/67ce7a57ec6c18190fe22067/1ilv8rpgl';
            s1.charset = 'UTF-8';
            s1.setAttribute('crossorigin', '*');
            s0.parentNode.insertBefore(s1, s0);
        })();
    </script>
<?php 
} 
?>
<!--End of Tawk.to Script-->
