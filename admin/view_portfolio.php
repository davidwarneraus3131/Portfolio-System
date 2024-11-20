<?php
session_start();
include("../database/db.php");

if ($_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
}

$portfolio_id = $_GET['id'];
$portfolio = mysqli_fetch_assoc(mysqli_query($conn, "
    SELECT portfolios.*, templates.template_name, users.name AS student_name 
    FROM portfolios 
    INNER JOIN templates ON portfolios.template_id = templates.id 
    INNER JOIN users ON portfolios.user_id = users.id 
    WHERE portfolios.id='$portfolio_id'
"));

include('../includes/header.php');
?>

<div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold mb-8 text-center">View Portfolio</h1>

    <div class="bg-white shadow-lg rounded-lg p-6 text-black">
        <h2 class="text-2xl font-semibold mb-4 text-center"><?php echo htmlspecialchars($portfolio['student_name'] ?? 'N/A'); ?>'s Portfolio</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <p class="font-medium"><strong>Template:</strong> <?php echo htmlspecialchars($portfolio['template_name'] ?? 'N/A'); ?></p>
                <p class="font-medium"><strong>Status:</strong> <?php echo htmlspecialchars($portfolio['status'] ?? 'N/A'); ?></p>
                <p class="font-medium"><strong>Payment Status:</strong> <?php echo htmlspecialchars($portfolio['payment_status'] ?? 'N/A'); ?></p>
                <p class="font-medium"><strong>Skills:</strong> <?php echo htmlspecialchars($portfolio['skills'] ?? 'N/A'); ?></p>
                <p class="font-medium"><strong>Username:</strong> <?php echo htmlspecialchars($portfolio['username'] ?? 'N/A'); ?></p>
                <p class="font-medium"><strong>Created At:</strong> <?php echo date('Y-m-d', strtotime($portfolio['created_at'] ?? 'now')); ?></p>
            </div>
            <div>
                <p class="font-medium"><strong>User ID:</strong> <?php echo htmlspecialchars($portfolio['user_id'] ?? 'N/A'); ?></p>
                <p class="font-medium"><strong>Template ID:</strong> <?php echo htmlspecialchars($portfolio['template_id'] ?? 'N/A'); ?></p>
                <p class="font-medium"><strong>Projects:</strong> <?php echo htmlspecialchars($portfolio['projects'] ?? 'N/A'); ?></p>
                <p class="font-medium"><strong>Work Experience:</strong> <?php echo htmlspecialchars($portfolio['work_experience'] ?? 'N/A'); ?></p>
                <p class="font-medium"><strong>School Info:</strong> <?php echo htmlspecialchars($portfolio['school_info'] ?? 'N/A'); ?></p>
                <p class="font-medium"><strong>College Info:</strong> <?php echo htmlspecialchars($portfolio['college_info'] ?? 'N/A'); ?></p>
            </div>
        </div>

        <div class="mt-8">
            <h3 class="text-xl font-semibold mb-4">Additional Information</h3>
            <p class="font-medium"><strong>Skill Description:</strong> <?php echo htmlspecialchars($portfolio['skill_description'] ?? 'N/A'); ?></p>
            <p class="font-medium"><strong>Key Skills:</strong> <?php echo htmlspecialchars($portfolio['key_skills'] ?? 'N/A'); ?></p>

            <div class="mt-4">
                <strong>Resume:</strong>
                <a href="../assets/resume/<?php echo htmlspecialchars($portfolio['resume'] ?? ''); ?>" target="_blank" class="text-blue-500 underline">Download Resume</a>
            </div>

            <div class="mt-4">
                <strong>Photo:</strong>
                <img src="../assets/users/<?php echo htmlspecialchars($portfolio['photo'] ?? 'default.jpg'); ?>" alt="User Photo" class="w-32 h-32 rounded-full my-2 mx-auto">
            </div>

            <div class="mt-4">
                <strong>Proof Image:</strong>
                <img src="../assets/pay_proof/<?php echo htmlspecialchars($portfolio['proof_image'] ?? 'default.jpg'); ?>" alt="Proof Image" class="w-60 h-60 rounded my-2 mx-auto">
            </div>

            <p class="font-medium"><strong>Amount:</strong> <?php echo htmlspecialchars($portfolio['amount'] ?? 'N/A'); ?></p>
            <p class="font-medium"><strong>Sender UPI ID:</strong> <?php echo htmlspecialchars($portfolio['sender_UPI_id'] ?? 'N/A'); ?></p>
            <p class="font-medium"><strong>Receiver UPI ID:</strong> <?php echo htmlspecialchars($portfolio['receiver_UPI_id'] ?? 'N/A'); ?></p>
        </div>
    </div>
</div>

<?php include('../includes/footer.php'); ?>
