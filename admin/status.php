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

<!-- Include DataTables CSS and JS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<!-- Include SweetAlert CSS and JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    .table-bg { color: black; }
    .table-header { background-color: #2c2c2c; } /* Darker color for the header */
</style>

<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold text-center mb-4">Student Portfolios</h1>
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
            <tbody class="table-bg">
            <?php
            $portfolios = mysqli_query($conn, "SELECT portfolios.id, users.name, portfolios.resume, portfolios.status, portfolios.payment_status, templates.text FROM portfolios INNER JOIN users ON portfolios.user_id = users.id INNER JOIN templates ON portfolios.template_id = templates.id");
            while ($portfolio = mysqli_fetch_assoc($portfolios)) {
                echo '<tr id="row-' . $portfolio['id'] . '" class="hover:bg-gray-100 transition">';
                echo '<td class="border p-2">' . htmlspecialchars($portfolio['name']) . '</td>';
                echo '<td class="border p-2">' . htmlspecialchars($portfolio['text']) . '</td>';
                echo '<td class="border p-2">
                        <a href="https://saphotel.in/test/demo_files/assets/resume/' . urlencode($portfolio['resume']) . '" target="_blank" download class="text-blue-500">View Resume</a>
                      </td>';
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
                        <button class="delete-btn bg-red-500 text-white p-2 rounded shadow hover:bg-red-600 transition" data-id="' . $portfolio['id'] . '">Delete</button>
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
    $('#userTable').DataTable(); // Initialize DataTables

    // Handle status change
    $('.status-select, .payment-status-select').change(function() {
        var portfolioId = $(this).data('portfolio-id');
        var status = $(this).closest('tr').find('.status-select').val();
        var paymentStatus = $(this).closest('tr').find('.payment-status-select').val();

        $.ajax({
            url: '', // Same page to handle the update
            type: 'POST',
            data: {
                action: 'update',
                id: portfolioId,
                status: status,
                payment_status: paymentStatus
            },
            success: function(response) {
                Swal.fire('Success!', 'Portfolio updated successfully.', 'success');
            },
            error: function() {
                Swal.fire('Error!', 'An error occurred while updating the portfolio.', 'error');
            }
        });
    });

    // Handle delete action
    $('.delete-btn').click(function() {
        var portfolioId = $(this).data('id');
        var row = $('#row-' + portfolioId);

        Swal.fire({
            title: 'Are you sure?',
            text: 'This action cannot be undone!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '',
                    type: 'POST',
                    data: {
                        action: 'delete',
                        id: portfolioId
                    },
                    success: function(response) {
                        row.remove();
                        Swal.fire('Deleted!', 'The portfolio has been deleted.', 'success');
                    },
                    error: function() {
                        Swal.fire('Error!', 'An error occurred while deleting.', 'error');
                    }
                });
            }
        });
    });
});
</script>

<?php
// Handle AJAX requests for delete and update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['action'] === 'delete') {
        $id = intval($_POST['id']);
        mysqli_query($conn, "DELETE FROM portfolios WHERE id = $id");
        exit;
    } elseif ($_POST['action'] === 'update') {
        $id = intval($_POST['id']);
        $status = mysqli_real_escape_string($conn, $_POST['status']);
        $payment_status = mysqli_real_escape_string($conn, $_POST['payment_status']);
        mysqli_query($conn, "UPDATE portfolios SET status = '$status', payment_status = '$payment_status' WHERE id = $id");
        exit;
    }
}
?>
