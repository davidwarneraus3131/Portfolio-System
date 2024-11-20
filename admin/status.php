<!-- Include DataTables CSS and JS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<!-- Include SweetAlert CSS and JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php
session_start();
include("../database/db.php");

if ($_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
}

include('../includes/header.php');
?>

<style>
    .table-bg {
    
      color: black;
    }
    /* Adjust table header for better visibility */
    .table-header {
      background-color: #2c2c2c; /* Darker color for the header */
    }
</style>

<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold text-center mb-4 ">Student Portfolios</h1>
    <!-- Student Portfolios -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table id="userTable" class="min-w-full display">
            <thead class="table-header text-white">
                <tr>
                    <th class="border p-2">Student</th>
                    <th class="border p-2">Template</th>
                    <th class="border p-2">Resume</th>
                    <th class="border p-2">Status</th>
                    <th class="border p-2">Payment Status</th>
                    <th class="border p-2">Actions</th>
                </tr>
            </thead>
            <tbody class="table-bg ">
            <?php
            $portfolios = mysqli_query($conn, "SELECT portfolios.id, users.name, portfolios.resume, portfolios.status, portfolios.payment_status, templates.text FROM portfolios INNER JOIN users ON portfolios.user_id = users.id INNER JOIN templates ON portfolios.template_id = templates.id");
            while ($portfolio = mysqli_fetch_assoc($portfolios)) {
                echo '<tr class="hover:bg-gray-100 transition">';
                echo '<td class="border p-2">' . htmlspecialchars($portfolio['name']) . '</td>';
                echo '<td class="border p-2">' . htmlspecialchars($portfolio['text']) . '</td>';
                echo '<td class="border p-2"><a href="../assets/resume/' . htmlspecialchars($portfolio['resume']) . '" target="_blank" class="text-blue-500">View Resume</a></td>';
                echo '<td class="border p-2">
                        <select data-portfolio-id="' . $portfolio['id'] . '" class="status-select border border-gray-300 p-2 rounded">
                            <option value="pending" ' . ($portfolio['status'] == 'pending' ? 'selected' : '') . '>Pending</option>
                            <option value="in progress" ' . ($portfolio['status'] == 'in progress' ? 'selected' : '') . '>In Progress</option>
                            <option value="review" ' . ($portfolio['status'] == 'review' ? 'selected' : '') . '>Review</option>
                            <option value="completed" ' . ($portfolio['status'] == 'completed' ? 'selected' : '') . '>Completed</option>
                            <option value="rejected" ' . ($portfolio['status'] == 'rejected' ? 'selected' : '') . '>Rejected</option>
                        </select>
                      </td>';
                echo '<td class="border p-2">
                        <select data-portfolio-id="' . $portfolio['id'] . '" class="payment-status-select bg-white border border-gray-300 p-2 rounded">
                            <option value="pending" ' . ($portfolio['payment_status'] == 'pending' ? 'selected' : '') . '>Pending</option>
                            <option value="completed" ' . ($portfolio['payment_status'] == 'completed' ? 'selected' : '') . '>Completed</option>
                            <option value="failed" ' . ($portfolio['payment_status'] == 'failed' ? 'selected' : '') . '>Failed</option>
                            <option value="verify" ' . ($portfolio['payment_status'] == 'verify' ? 'selected' : '') . '>Verify</option>
                        </select>
                      </td>';
                echo '<td class="border p-2">
                        <a href="view_portfolio.php?id=' . $portfolio['id'] . '" class="bg-green-500 text-white p-2 rounded shadow hover:bg-green-600 transition">View</a>
                      </td>';
                echo '</tr>';
            }
            ?>
            </tbody>
        </table>
    </div>
</div>

<script>
$(document).ready(function() {
    // Initialize DataTables
    $('#portfoliosTable').DataTable();

    // Handle status change
    $('.status-select, .payment-status-select').change(function() {
        var portfolioId = $(this).data('portfolio-id');
        var status = $(this).closest('tr').find('.status-select').val();
        var paymentStatus = $(this).closest('tr').find('.payment-status-select').val();

        // AJAX request to update status
        $.ajax({
            url: 'update_portfolio', // Your PHP script to handle the update
            type: 'POST',
            data: {
                id: portfolioId,
                status: status,
                payment_status: paymentStatus
            },
            success: function(response) {
                // Show success message
                Swal.fire({
                    title: 'Success!',
                    text: 'Portfolio updated successfully.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            },
            error: function() {
                // Show error message
                Swal.fire({
                    title: 'Error!',
                    text: 'An error occurred while updating the portfolio.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        });
    });
});
</script>
