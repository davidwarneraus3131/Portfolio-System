<?php
ob_start();
include('../includes/header.php');
include("../database/db.php");

// Fetch current portfolio data
if (isset($_GET['template_id'])) {
    $template_id = intval($_GET['template_id']); // Ensure it's an integer

    // Prepare and execute the query
    $query = "SELECT * FROM portfolios WHERE template_id = $template_id";
    $result = mysqli_query($conn, $query);
    
    if (!$result || mysqli_num_rows($result) == 0) {
        echo "<script>
            Swal.fire('Error', 'No portfolio found!', 'error').then(function() {
                window.location.href = 'my_templates.php';
            });
        </script>";
        exit();
    }

    $portfolio = mysqli_fetch_assoc($result);
} else {
    header('Location: my_templates.php');
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $projects = mysqli_real_escape_string($conn, $_POST['projects']);
    $work_experience = mysqli_real_escape_string($conn, $_POST['work_experience']);
    $school_info = mysqli_real_escape_string($conn, $_POST['school_info']);
    $college_info = mysqli_real_escape_string($conn, $_POST['college_info']);
    $skill_description = mysqli_real_escape_string($conn, $_POST['skill_description']);
    $key_skills = mysqli_real_escape_string($conn, $_POST['key_skills']);
    $skills = mysqli_real_escape_string($conn, $_POST['skills']);

    // Photo and resume handling
    $photo = $_FILES['photo']['name'] ? $_FILES['photo']['name'] : $portfolio['photo'];
    $resume = $_FILES['resume']['name'] ? $_FILES['resume']['name'] : $portfolio['resume'];

    // Save uploaded files (assuming you have an "assets/pay_proof" directory)
    if ($_FILES['photo']['name']) {
        move_uploaded_file($_FILES['photo']['tmp_name'], "../assets/pay_proof/" . $photo);
    }
    if ($_FILES['resume']['name']) {
        move_uploaded_file($_FILES['resume']['tmp_name'], "../assets/pay_proof/" . $resume);
    }

    // Update query
    $update_query = "UPDATE portfolios SET name='$name', email='$email', projects='$projects', work_experience='$work_experience', school_info='$school_info', college_info='$college_info', skill_description='$skill_description', key_skills='$key_skills', skills='$skills', photo='$photo', resume='$resume' WHERE template_id=$template_id";

    if (mysqli_query($conn, $update_query)) {
        echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'Updated Successfully',
                showConfirmButton: false,
                timer: 1500
            }).then(function() {
                window.location.href = 'my_templates.php';
            });
        </script>";
    } else {
        echo "<script>
            Swal.fire('Error', 'Something went wrong!', 'error');
        </script>";
    }
}
?>

<div class="container mx-auto p-6">
    <h2 class="text-2xl font-bold mb-4 text-center">Update Portfolio Details</h2>
    
    <form method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-lg space-y-4">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-bold mb-2 text-black">Name</label>
                <input type="text" name="name" class="w-full border border-gray-300 rounded p-2 text-black" value="<?= htmlspecialchars($portfolio['name'] ?? '') ?>" >
            </div>
            <div>
                <label class="block text-sm font-bold mb-2 text-black">Email</label>
                <input type="email" name="email" class="w-full border border-gray-300 rounded p-2 text-black" value="<?= htmlspecialchars($portfolio['email'] ?? '') ?>" >
            </div>
            <div>
                <label class="block text-sm font-bold mb-2 text-black">Projects</label>
                <input type="text" name="projects" class="w-full border border-gray-300 rounded p-2 text-black" value="<?= htmlspecialchars($portfolio['projects'] ?? '') ?>" >
            </div>
            <div>
                <label class="block text-sm font-bold mb-2 text-black">Work Experience</label>
                <input type="text" name="work_experience" class="w-full border border-gray-300 rounded p-2 text-black" value="<?= htmlspecialchars($portfolio['work_experience'] ?? '') ?>" >
            </div>
            <div>
                <label class="block text-sm font-bold mb-2 text-black">School Info</label>
                <input type="text" name="school_info" class="w-full border border-gray-300 rounded p-2 text-black" value="<?= htmlspecialchars($portfolio['school_info'] ?? '') ?>" >
            </div>
            <div>
                <label class="block text-sm font-bold mb-2 text-black">College Info</label>
                <input type="text" name="college_info" class="w-full border border-gray-300 rounded p-2 text-black" value="<?= htmlspecialchars($portfolio['college_info'] ?? '') ?>" >
            </div>
            <div>
                <label class="block text-sm font-bold mb-2 text-black">Skill Description</label>
                <textarea name="skill_description" class="w-full border border-gray-300 rounded p-2 text-black" ><?= htmlspecialchars($portfolio['skill_description'] ?? '') ?></textarea>
            </div>
            <div>
                <label class="block text-sm font-bold mb-2 text-black">Key Skills</label>
                <input type="text" name="key_skills" class="w-full border border-gray-300 rounded p-2 text-black" value="<?= htmlspecialchars($portfolio['key_skills'] ?? '') ?>" >
            </div>
        </div>

        <div>
            <label class="block text-sm font-bold mb-2 text-black">Skills</label>
            <input type="text" name="skills" class="w-full border border-gray-300 rounded p-2 text-black" value="<?= htmlspecialchars($portfolio['skills'] ?? '') ?>" >
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-bold mb-2 text-black">Photo</label>
                <input type="file" name="photo" class="w-full border border-gray-300 rounded p-2 text-black">
                <p class="text-sm mt-1">Current Photo: <?= htmlspecialchars($portfolio['photo'] ?? '') ?></p>
            </div>
            <div>
                <label class="block text-sm font-bold mb-2 text-black">Resume</label>
                <input type="file" name="resume" class="w-full border border-gray-300 rounded p-2 text-black">
                <p class="text-sm mt-1">Current Resume: <?= htmlspecialchars($portfolio['resume'] ?? '') ?></p>
            </div>
        </div>

        <div class="flex justify-between items-center mt-6">
            <a href="my_templates.php" class="shine-button">Back</a>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 shine-button">Update Portfolio</button>
            <div id="lottie-animation" class="h-16 w-16"></div>
        </div>
    </form>
</div>

<style>
    .shine-button {
        position: relative;
        background-color: #4241a9;
        color: rgb(251 251 251 / 40%);
        padding: 8px 20px;
        border-radius: 5px;
        text-decoration: none;
        overflow: hidden;
        transition: background-color 0.3s;
    }

    .shine-button:hover {
        background-color: #e0e0e0;
        color: #000000;
    }

    .shine-button::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 200%;
        height: 100%;
        background: rgba(255, 255, 255, 0.4);
        transform: skewX(-45deg);
        transition: all 0.7s ease;
    }

    .shine-button:hover::before {
        left: 100%;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.7.4/lottie.min.js"></script>
<script>
    // Lottie animation
    var animation = lottie.loadAnimation({
        container: document.getElementById('lottie-animation'),
        renderer: 'svg',
        loop: true,
        autoplay: true,
        path: 'https://assets10.lottiefiles.com/packages/lf20_V9t630.json' // Example Lottie animation link
    });
</script>

<?php include('../includes/footer.php');?>
<?php
// Flush output buffer
ob_end_flush();
?>
