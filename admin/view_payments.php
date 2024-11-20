<?php
session_start();
include("../database/db.php");

if ($_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
}

// Fetch all payment data with corresponding usernames
$portfolios = mysqli_query($conn, query: "
    SELECT portfolios.id, portfolios.amount, portfolios.proof_image, portfolios.payment_status, portfolios.created_at, users.name, users.email
    FROM portfolios 
    JOIN users ON portfolios.user_id = users.id
");

// Fetch only completed portfolios
$completed_portfolios = mysqli_query($conn, "
    SELECT portfolios.id, portfolios.amount, portfolios.proof_image, portfolios.payment_status, portfolios.created_at, users.name, users.email 
    FROM portfolios 
    JOIN users ON portfolios.user_id = users.id 
    WHERE portfolios.payment_status = 'completed'
");

include('../includes/header.php');
?>

<!-- Include DataTables CSS and JS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>


<style>
    .table-bg {
    
      color: black;
    }
    /* Adjust table header for better visibility */
    .table-header {
      background-color: #2c2c2c; /* Darker color for the header */
    }
</style>



<div class="container mx-auto p-10">
    <h1 class="text-2xl font-bold text-center">Payment Records</h1>
    <p class="text-center">Manage Payments</p><br>

    <!-- All portfolios Section -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table id="userTable" class="min-w-full display">
            <thead class="table-header text-white">
            <tr>
                <th class="px-4 py-2">ID</th>
                <th class="px-4 py-2">Username</th>
                <th class="px-4 py-2">Amount</th>
                <th class="px-4 py-2">Proof Image</th>
                <th class="px-4 py-2">Payment Status</th>
                <th class="px-4 py-2">Created At</th>
            </tr>
        </thead>
        <tbody class="table-bg">
            <?php
            while ($payment = mysqli_fetch_assoc($portfolios)) {
                echo '<tr class="border-b">';
                echo '<td class="px-4 py-2">' . htmlspecialchars($payment['id'] ?? '') . '</td>';
                echo '<td class="px-4 py-2">' . htmlspecialchars($payment['name'] ?? 'N/A') . '</td>';
                echo '<td class="px-4 py-2">' . htmlspecialchars($payment['amount'] ?? '0.00') . '</td>';
                echo '<td class="px-4 py-2">';
                if (!empty($payment['proof_image'])) {
                    echo '<img src="../assets/' . htmlspecialchars($payment['proof_image']) . '" class="w-26 h-20 cursor-pointer" onclick="showFullImage(this.src)" onerror="this.style.display=\'none\'">';
                } else {
                    echo 'No image';
                }
                echo '</td>';
                echo '<td class="px-4 py-2">' . htmlspecialchars($payment['payment_status'] ?? 'Unknown') . '</td>';
                echo '<td class="px-4 py-2">' . htmlspecialchars($payment['created_at'] ?? 'N/A') . '</td>';
                echo '</tr>';
            }
            ?>
        </tbody>
    </table>
</div><hr style="color:white">



    <!-- Completed portfolios Section -->
    <div class="mt-6">
        <h2 class="text-xl font-semibold text-center p-5">Completed payments List</h2><br>
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table id="userTable" class="min-w-full display">
            <thead class="table-header text-white">
                <tr>
                    <th class="px-4 py-2">ID</th>
                    <th class="px-4 py-2">Username</th>
                    <th class="px-4 py-2">Amount</th>
                    <th class="px-4 py-2">Proof Image</th>
                    <th class="px-4 py-2">Payment Status</th>
                    <th class="px-4 py-2">Created At</th>
                    <th class="px-4 py-2">Action</th>
                </tr>
            </thead>
            <tbody class="table-bg">
                <?php
                while ($completed_payment = mysqli_fetch_assoc($completed_portfolios)) {
                    echo '<tr class="border-b">';
                    echo '<td class="px-4 py-2">' . htmlspecialchars($completed_payment['id'] ?? '') . '</td>';
                    echo '<td class="px-4 py-2">' . htmlspecialchars($completed_payment['name'] ?? 'N/A') . '</td>';
                    echo '<td class="px-4 py-2">' . htmlspecialchars($completed_payment['amount'] ?? '0.00') . '</td>';
                    echo '<td class="px-4 py-2">';
                    if (!empty($payment['proof_image'])) {
                        echo '<img src="../assets/' . htmlspecialchars($payment['proof_image']) . '" class="w-16 h-16 cursor-pointer" onclick="showFullImage(this.src)" onerror="this.style.display=\'none\'">';
                    } else {
                        echo 'No image';
                    }
                    echo '</td>';
                    echo '<td class="px-4 py-2">' . htmlspecialchars($completed_payment['payment_status'] ?? 'Unknown') . '</td>';
                    echo '<td class="px-4 py-2">' . htmlspecialchars($completed_payment['created_at'] ?? 'N/A') . '</td>';
                    echo '<td class="px-4 py-2">';
                    // Add the Send Mail button
                    echo '<button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition duration-200" onclick="openModal(\'' . htmlspecialchars($completed_payment['email']) . '\', \'' . htmlspecialchars($completed_payment['name']) . '\')">Send Mail</button>';
                    echo '</td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
    </div>

    <!-- Modal for sending email -->
    <div id="sendMailModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center">
        <div class="bg-white rounded-lg shadow-lg p-6 w-1/3">
            <h3 class="text-lg font-semibold text-center  text-black rounded p-2 mb-4">Send Portfolio Email</h3>
            <form id="emailForm" action="mail" method="POST">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700" for="portfolio_link">Portfolio Link</label>
                    <input type="text" name="portfolio_link" id="portfolio_link" class="border border-gray-300 rounded w-full px-3 py-2 text-black" required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700" for="email">Email</label>
                    <input type="email" name="user_email" id="user_email" class="border border-gray-300 rounded w-full px-3 py-2 text-black" required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700" for="name">Username</label>
                    <input type="text" name="user_name" id="user_name" class="border border-gray-300 rounded w-full px-3 py-2 text-black" required>
                </div>
                <div class="mb-4 flex justify-between">
                    <button type="submit" name="send_email" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition duration-200">Send Email</button>
                    <button type="button" onclick="closeModal()" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition duration-200">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#portfoliosTable').DataTable(); // Initialize DataTables for all portfolios
    $('#completedportfoliosTable').DataTable(); // Initialize DataTables for completed portfolios
});

// Open the modal for sending mail
function openModal(email, name) {
    document.getElementById('user_email').value = email; 
    document.getElementById('user_name').value = name; 
    document.getElementById('sendMailModal').classList.remove('hidden');
}

// Close the modal
function closeModal() {
    document.getElementById('sendMailModal').classList.add('hidden');
}
</script>


<!-- Modal for full-size image -->
<div id="imageModal" class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center hidden">
    <span class="absolute top-4 right-4 text-white cursor-pointer" onclick="closeModal()">&times;</span>
    <img id="fullImage" class="max-w-6xl max-h-6xl object-contain p-4" src="" alt="Full Size Image">
</div>

<script>
$(document).ready(function() {
    $('#portfoliosTable').DataTable(); // Initialize DataTable
});

// Function to show full-size image
function showFullImage(src) {
    document.getElementById('fullImage').src = src;
    document.getElementById('imageModal').classList.remove('hidden');
}

// Function to close the modal
function closeModal() {
    document.getElementById('imageModal').classList.add('hidden');
}
</script>

<?php include('../includes/footer.php'); ?>
