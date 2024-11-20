<?php
ob_start();
session_start();
include("../database/db.php");
if ($_SESSION['role'] !== 'student') {
    header("Location: ../index.php");
}
include('../includes/header.php');
$template_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

// Fetch template details
$template_result = mysqli_query($conn, "SELECT * FROM templates WHERE id='$template_id'");
$template = mysqli_fetch_assoc($template_result);

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $projects = $_POST['projects'];
    $work_experience = $_POST['work_experience'];
    $school_info = $_POST['school_info'];
    $college_info = $_POST['college_info'];
    $skill_description = $_POST['skill_description'];
    $key_skills = $_POST['key_skills'];

    // Upload files (photo and resume)
    $photo = $_FILES['photo']['name'];
    $resume = $_FILES['resume']['name'];
    move_uploaded_file($_FILES['photo']['tmp_name'], "../assets/users/$photo");
    move_uploaded_file($_FILES['resume']['tmp_name'], "../assets/resume/$resume");

    // Insert into portfolios
    $query = "INSERT INTO portfolios (user_id, template_id, name, email, projects, work_experience, school_info, college_info, skill_description, key_skills, photo, resume, status)
              VALUES ('$user_id', '$template_id', '$name', '$email', '$projects', '$work_experience', '$school_info', '$college_info', '$skill_description', '$key_skills', '$photo', '$resume', 'pending')";

    if (mysqli_query($conn, $query)) {
        // Set success message
        $_SESSION['success'] = 'Data inserted successfully!';
        header("Location: " . $_SERVER['PHP_SELF'] . "?id=" . $template_id); // Redirect to the same page with success message
        exit();
    }
}

// Check if a success message exists
$success_message = isset($_SESSION['success']) ? $_SESSION['success'] : '';
unset($_SESSION['success']); // Clear the message after showing it
?>

<!DOCTYPE html>
<html>
<head>
  <link href="../assets/css/style.css" rel="stylesheet">
  <!-- Include SweetAlert CSS and JS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<div class="bg-white shadow-md rounded-lg overflow-hidden p-16 bg-gray-300">
<h1 class="text-2xl font-bold text-center p-1 text-black underline">Select Template: <?php echo $template['text']; ?></h1>

<div class="flex justify-between items-center p-1 text-black">
    <h1 class="text-2xl font-bold line-through">Original Price: ₹<?php echo $template['actual_price']; ?></h1>
    <h1 class="text-2xl font-bold overline">Price: ₹<?php echo $template['price']; ?></h1>
</div>

<img src="../assets/<?php echo $template['template_image']; ?>" class="w-full h-64 object-cover mt-2 mb-4">


    <form method="POST" enctype="multipart/form-data" class="space-y-4">
        <div class="grid grid-cols-2 gap-4">
            <input type="text" name="name" placeholder="Your Name" class="p-2 border border-gray-300 w-full rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blue-300 text-black">
            <input type="email" name="email" placeholder="Your Email" class="p-2 border border-gray-300 w-full rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blue-300 text-black">
        </div>

        <div class="grid grid-cols-2 gap-4">
            <input type="text" name="projects" placeholder="Your Projects" class="p-2 border border-gray-300 w-full rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blue-300 text-black">
            <input type="text" name="work_experience" placeholder="Work Experience" class="p-2 border border-gray-300 w-full rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blue-300 text-black">
        </div>

        <div class="grid grid-cols-2 gap-4">
            <input type="text" name="school_info" placeholder="School Info with Year" class="p-2 border border-gray-300 w-full rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blue-300 text-black">
            <input type="text" name="college_info" placeholder="College Info with Year" class="p-2 border border-gray-300 w-full rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blue-300 text-black">
        </div>

        <textarea name="skill_description" placeholder="Describe Your Skills" class="p-2 border border-gray-300 w-full rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blue-300 text-black"></textarea>

        <input type="text" name="key_skills" placeholder="Key Skills (e.g. HTML, CSS, JavaScript)" class="p-2 border border-gray-300 w-full rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blue-300 text-black">

        <label class="block">
            <span class="text-gray-700">Upload Your Photo</span>
            <input type="file" name="photo" class="block w-full text-sm text-gray-500 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none">
        </label>

        <label class="block">
            <span class="text-gray-700">Upload Your Resume (PDF)</span>
            <input type="file" name="resume" class="block w-full text-sm text-gray-500 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none">
        </label>

        <button type="submit" class="bg-blue-500 text-white p-2 mt-2 rounded-md w-full shadow hover:bg-blue-600 transition duration-200">Submit</button>
    </form>
</div>

<script>
    // Show SweetAlert success message
    <?php if ($success_message): ?>
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '<?php echo $success_message; ?>',
            
            confirmButtonText: 'OK'
        });
    <?php endif; ?>
</script>

</body>
</html>
<?php include('../includes/footer.php'); ?>
<?php
// Flush output buffer
ob_end_flush();
?>
