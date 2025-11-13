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
<!-- Include Poppins Font -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
<!-- Include Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    :root {
        --dark-navy: #0B0F19;
        --deep-gray: #1A1F2B;
        --neon-purple: #7C3AED;
        --electric-blue: #3B82F6;
        --aqua-accent: #22D3EE;
    }
    
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    
    body {
        background: linear-gradient(135deg, var(--dark-navy) 0%, var(--deep-gray) 100%);
        font-family: 'Poppins', sans-serif;
        color: #fff;
        min-height: 100vh;
        padding: 20px 0;
    }
    
    .container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 20px;
    }
    
    .dashboard-header {
        text-align: center;
        margin-bottom: 40px;
        position: relative;
    }
    
    .dashboard-header h1 {
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        font-size: 2.5rem;
        margin-bottom: 10px;
        background: linear-gradient(90deg, var(--neon-purple), var(--electric-blue));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        text-shadow: 0 0 20px rgba(124, 58, 237, 0.5);
        animation: glow 2s ease-in-out infinite alternate;
    }
    
    @keyframes glow {
        from { filter: drop-shadow(0 0 10px rgba(124, 58, 237, 0.5)); }
        to { filter: drop-shadow(0 0 20px rgba(59, 130, 246, 0.8)); }
    }
    
    .dashboard-header p {
        font-family: 'Poppins', sans-serif;
        font-weight: 500;
        color: rgba(255, 255, 255, 0.7);
        font-size: 1.1rem;
    }
    
    .stats-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }
    
    .stat-card {
        background: rgba(26, 31, 43, 0.7);
        backdrop-filter: blur(10px);
        border-radius: 15px;
        padding: 20px;
        border: 1px solid rgba(124, 58, 237, 0.3);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, var(--neon-purple), var(--electric-blue));
        animation: gradient-shift 3s ease infinite;
    }
    
    @keyframes gradient-shift {
        0%, 100% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 40px rgba(124, 58, 237, 0.2);
    }
    
    .stat-card h3 {
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        font-size: 1.1rem;
        margin-bottom: 10px;
        color: var(--aqua-accent);
    }
    
    .stat-card .value {
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        font-size: 2rem;
        color: #fff;
    }
    
    .table-container {
        background: rgba(26, 31, 43, 0.7);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        padding: 25px;
        border: 1px solid rgba(124, 58, 237, 0.3);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }
    
    .table-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }
    
    .table-header h2 {
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        font-size: 1.5rem;
        color: #fff;
    }
    
    .search-box {
        position: relative;
        width: 300px;
    }
    
    .search-box input {
        width: 100%;
        padding: 10px 40px 10px 15px;
        border-radius: 50px;
        border: 1px solid rgba(124, 58, 237, 0.3);
        background: rgba(11, 15, 25, 0.7);
        color: #fff;
        font-family: 'Poppins', sans-serif;
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }
    
    .search-box input:focus {
        outline: none;
        border-color: var(--neon-purple);
        box-shadow: 0 0 10px rgba(124, 58, 237, 0.5);
    }
    
    .search-box i {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--aqua-accent);
    }
    
    .dataTables_wrapper {
        padding: 0;
    }
    
    .dataTables_filter {
        display: none;
    }
    
    .dataTables_length {
        margin-bottom: 15px;
    }
    
    .dataTables_length select {
        background: rgba(11, 15, 25, 0.7);
        color: #fff;
        border: 1px solid rgba(124, 58, 237, 0.3);
        border-radius: 5px;
        padding: 5px 10px;
        font-family: 'Poppins', sans-serif;
    }
    
    .dataTables_length label {
        color: #fff;
        font-family: 'Poppins', sans-serif;
        font-weight: 500;
    }
    
    .dataTables_info {
        color: rgba(255, 255, 255, 0.7);
        font-family: 'Poppins', sans-serif;
        font-size: 0.9rem;
        margin-top: 15px;
    }
    
    .dataTables_paginate {
        margin-top: 15px;
    }
    
    .dataTables_paginate .paginate_button {
        background: rgba(11, 15, 25, 0.7);
        color: #fff;
        border: 1px solid rgba(124, 58, 237, 0.3);
        border-radius: 5px;
        padding: 5px 10px;
        margin: 0 3px;
        font-family: 'Poppins', sans-serif;
        transition: all 0.3s ease;
    }
    
    .dataTables_paginate .paginate_button.current {
        background: var(--neon-purple);
        border-color: var(--neon-purple);
    }
    
    .dataTables_paginate .paginate_button:hover {
        background: var(--electric-blue);
        border-color: var(--electric-blue);
    }
    
    #userTable {
        width: 100% !important;
        border-collapse: separate;
        border-spacing: 0 10px;
    }
    
    #userTable thead th {
        background: rgba(11, 15, 25, 0.7);
        color: var(--aqua-accent);
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        padding: 15px;
        text-align: left;
        border: none;
        position: relative;
    }
    
    #userTable thead th:first-child {
        border-radius: 10px 0 0 10px;
    }
    
    #userTable thead th:last-child {
        border-radius: 0 10px 10px 0;
    }
    
    #userTable tbody tr {
        background: rgba(11, 15, 25, 0.5);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }
    
    #userTable tbody tr:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(124, 58, 237, 0.2);
    }
    
    #userTable tbody td {
        padding: 15px;
        color: #fff;
        font-family: 'Poppins', sans-serif;
        font-weight: 400;
        border: none;
        vertical-align: middle;
    }
    
    #userTable tbody td:first-child {
        border-radius: 10px 0 0 10px;
        font-weight: 500;
    }
    
    #userTable tbody td:last-child {
        border-radius: 0 10px 10px 0;
    }
    
    .status-select, .payment-status-select {
        background: rgba(11, 15, 25, 0.7);
        color: #fff;
        border: 1px solid rgba(124, 58, 237, 0.3);
        border-radius: 50px;
        padding: 8px 15px;
        font-family: 'Poppins', sans-serif;
        font-size: 0.85rem;
        cursor: pointer;
        transition: all 0.3s ease;
        width: 100%;
    }
    
    .status-select:focus, .payment-status-select:focus {
        outline: none;
        border-color: var(--neon-purple);
        box-shadow: 0 0 10px rgba(124, 58, 237, 0.5);
    }
    
    .action-buttons {
        display: flex;
        gap: 10px;
    }
    
    .view-btn, .delete-btn {
        padding: 8px 15px;
        border-radius: 50px;
        border: none;
        font-family: 'Poppins', sans-serif;
        font-weight: 500;
        font-size: 0.85rem;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 5px;
    }
    
    .view-btn {
        background: linear-gradient(90deg, var(--electric-blue), var(--aqua-accent));
        color: #fff;
    }
    
    .view-btn:hover {
        box-shadow: 0 5px 15px rgba(59, 130, 246, 0.4);
        transform: translateY(-2px);
    }
    
    .delete-btn {
        background: linear-gradient(90deg, #f43f5e, #ef4444);
        color: #fff;
    }
    
    .delete-btn:hover {
        box-shadow: 0 5px 15px rgba(244, 63, 94, 0.4);
        transform: translateY(-2px);
    }
    
    .resume-link {
        color: var(--aqua-accent);
        text-decoration: none;
        font-family: 'Poppins', sans-serif;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 5px;
        transition: all 0.3s ease;
    }
    
    .resume-link:hover {
        color: var(--electric-blue);
        text-shadow: 0 0 10px rgba(34, 211, 238, 0.5);
    }
    
    .status-badge {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 50px;
        font-family: 'Poppins', sans-serif;
        font-weight: 500;
        font-size: 0.8rem;
        text-transform: uppercase;
    }
    
    .status-pending {
        background: rgba(251, 191, 36, 0.2);
        color: #fbbf24;
        border: 1px solid rgba(251, 191, 36, 0.3);
    }
    
    .status-in-progress {
        background: rgba(59, 130, 246, 0.2);
        color: #3b82f6;
        border: 1px solid rgba(59, 130, 246, 0.3);
    }
    
    .status-review {
        background: rgba(168, 85, 247, 0.2);
        color: #a855f7;
        border: 1px solid rgba(168, 85, 247, 0.3);
    }
    
    .status-completed {
        background: rgba(34, 197, 94, 0.2);
        color: #22c55e;
        border: 1px solid rgba(34, 197, 94, 0.3);
    }
    
    .status-rejected {
        background: rgba(239, 68, 68, 0.2);
        color: #ef4444;
        border: 1px solid rgba(239, 68, 68, 0.3);
    }
    
    .payment-pending {
        background: rgba(251, 191, 36, 0.2);
        color: #fbbf24;
        border: 1px solid rgba(251, 191, 36, 0.3);
    }
    
    .payment-completed {
        background: rgba(34, 197, 94, 0.2);
        color: #22c55e;
        border: 1px solid rgba(34, 197, 94, 0.3);
    }
    
    .payment-failed {
        background: rgba(239, 68, 68, 0.2);
        color: #ef4444;
        border: 1px solid rgba(239, 68, 68, 0.3);
    }
    
    .payment-verify {
        background: rgba(34, 211, 238, 0.2);
        color: #22d3ee;
        border: 1px solid rgba(34, 211, 238, 0.3);
    }
    
    .floating-shapes {
        position: fixed;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        z-index: -1;
        overflow: hidden;
    }
    
    .shape {
        position: absolute;
        border-radius: 50%;
        filter: blur(40px);
        opacity: 0.1;
        animation: float 20s infinite ease-in-out;
    }
    
    .shape-1 {
        width: 300px;
        height: 300px;
        background: var(--neon-purple);
        top: -100px;
        right: -100px;
    }
    
    .shape-2 {
        width: 200px;
        height: 200px;
        background: var(--electric-blue);
        bottom: -50px;
        left: -50px;
        animation-delay: 5s;
    }
    
    .shape-3 {
        width: 150px;
        height: 150px;
        background: var(--aqua-accent);
        top: 50%;
        left: 50%;
        animation-delay: 10s;
    }
    
    @keyframes float {
        0%, 100% { transform: translate(0, 0) rotate(0deg); }
        33% { transform: translate(30px, -30px) rotate(120deg); }
        66% { transform: translate(-20px, 20px) rotate(240deg); }
    }
    
    /* Mobile Responsive */
    @media (max-width: 768px) {
        .dashboard-header h1 {
            font-size: 2rem;
        }
        
        .stats-container {
            grid-template-columns: 1fr;
        }
        
        .table-header {
            flex-direction: column;
            gap: 15px;
            align-items: flex-start;
        }
        
        .search-box {
            width: 100%;
        }
        
        .table-container {
            padding: 15px;
            overflow-x: auto;
        }
        
        #userTable {
            font-size: 0.85rem;
        }
        
        #userTable thead th, #userTable tbody td {
            padding: 10px;
        }
        
        .action-buttons {
            flex-direction: column;
        }
        
        .view-btn, .delete-btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<div class="floating-shapes">
    <div class="shape shape-1"></div>
    <div class="shape shape-2"></div>
    <div class="shape shape-3"></div>
</div>

<div class="container">
    <div class="dashboard-header">
        <h1>Student Portfolios</h1>
        <p>Manage and review all student portfolio submissions</p>
    </div>
    
    <div class="stats-container">
        <div class="stat-card">
            <h3>Total Portfolios</h3>
            <div class="value"><?php echo mysqli_num_rows(mysqli_query($conn, "SELECT id FROM portfolios")); ?></div>
        </div>
        <div class="stat-card">
            <h3>Pending Review</h3>
            <div class="value"><?php echo mysqli_num_rows(mysqli_query($conn, "SELECT id FROM portfolios WHERE status='pending' OR status='review'")); ?></div>
        </div>
        <div class="stat-card">
            <h3>In Progress</h3>
            <div class="value"><?php echo mysqli_num_rows(mysqli_query($conn, "SELECT id FROM portfolios WHERE status='in progress'")); ?></div>
        </div>
        <div class="stat-card">
            <h3>Completed</h3>
            <div class="value"><?php echo mysqli_num_rows(mysqli_query($conn, "SELECT id FROM portfolios WHERE status='completed'")); ?></div>
        </div>
    </div>
    
    <div class="table-container">
        <div class="table-header">
            <h2>Portfolio Submissions</h2>
            <div class="search-box">
                <input type="text" id="tableSearch" placeholder="Search portfolios...">
                <i class="fas fa-search"></i>
            </div>
        </div>
        
        <table id="userTable" class="display">
            <thead>
                <tr>
                    <th>Student</th>
                    <th>Template</th>
                    <th>Resume</th>
                    <th>Status</th>
                    <th>Payment Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $portfolios = mysqli_query($conn, "SELECT portfolios.id, users.name, portfolios.resume, portfolios.status, portfolios.payment_status, templates.text FROM portfolios INNER JOIN users ON portfolios.user_id = users.id INNER JOIN templates ON portfolios.template_id = templates.id");
            while ($portfolio = mysqli_fetch_assoc($portfolios)) {
                echo '<tr id="row-' . $portfolio['id'] . '">';
                echo '<td>' . htmlspecialchars($portfolio['name']) . '</td>';
                echo '<td>' . htmlspecialchars($portfolio['text']) . '</td>';
                echo '<td>
                        <a href="https://saphotel.in/test/demo_files/assets/resume/' . urlencode($portfolio['resume']) . '" target="_blank" download class="resume-link">
                            <i class="fas fa-file-pdf"></i> View Resume
                        </a>
                      </td>';
                echo '<td>
                        <select data-portfolio-id="' . $portfolio['id'] . '" class="status-select">
                            <option value="pending" ' . ($portfolio['status'] == 'pending' ? 'selected' : '') . '>Pending</option>
                            <option value="in progress" ' . ($portfolio['status'] == 'in progress' ? 'selected' : '') . '>In Progress</option>
                            <option value="review" ' . ($portfolio['status'] == 'review' ? 'selected' : '') . '>Review</option>
                            <option value="completed" ' . ($portfolio['status'] == 'completed' ? 'selected' : '') . '>Completed</option>
                            <option value="rejected" ' . ($portfolio['status'] == 'rejected' ? 'selected' : '') . '>Rejected</option>
                        </select>
                      </td>';
                echo '<td>
                        <select data-portfolio-id="' . $portfolio['id'] . '" class="payment-status-select">
                            <option value="pending" ' . ($portfolio['payment_status'] == 'pending' ? 'selected' : '') . '>Pending</option>
                            <option value="completed" ' . ($portfolio['payment_status'] == 'completed' ? 'selected' : '') . '>Completed</option>
                            <option value="failed" ' . ($portfolio['payment_status'] == 'failed' ? 'selected' : '') . '>Failed</option>
                            <option value="verify" ' . ($portfolio['payment_status'] == 'verify' ? 'selected' : '') . '>Verify</option>
                        </select>
                      </td>';
                echo '<td>
                        <div class="action-buttons">
                            <a href="view_portfolio.php?id=' . $portfolio['id'] . '" class="view-btn">
                                <i class="fas fa-eye"></i> View
                            </a>
                            <button class="delete-btn" data-id="' . $portfolio['id'] . '">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </div>
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
    var table = $('#userTable').DataTable({
        "pageLength": 10,
        "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
        "dom": '<"top"lf>rt<"bottom"ip><"clear">',
        "language": {
            "search": "",
            "lengthMenu": "Show _MENU_ entries",
            "info": "Showing _START_ to _END_ of _TOTAL_ portfolios",
            "paginate": {
                "first": "First",
                "last": "Last",
                "next": "Next",
                "previous": "Previous"
            }
        }
    });
    
    // Custom search functionality
    $('#tableSearch').on('keyup', function() {
        table.search(this.value).draw();
    });
    
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
                Swal.fire({
                    title: 'Success!',
                    text: 'Portfolio updated successfully.',
                    icon: 'success',
                    confirmButtonColor: '#7C3AED',
                    background: '#1A1F2B',
                    color: '#fff'
                });
            },
            error: function() {
                Swal.fire({
                    title: 'Error!',
                    text: 'An error occurred while updating the portfolio.',
                    icon: 'error',
                    confirmButtonColor: '#7C3AED',
                    background: '#1A1F2B',
                    color: '#fff'
                });
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
            confirmButtonColor: '#7C3AED',
            cancelButtonColor: '#3B82F6',
            confirmButtonText: 'Yes, delete it!',
            background: '#1A1F2B',
            color: '#fff'
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
                        Swal.fire({
                            title: 'Deleted!',
                            text: 'The portfolio has been deleted.',
                            icon: 'success',
                            confirmButtonColor: '#7C3AED',
                            background: '#1A1F2B',
                            color: '#fff'
                        });
                    },
                    error: function() {
                        Swal.fire({
                            title: 'Error!',
                            text: 'An error occurred while deleting.',
                            icon: 'error',
                            confirmButtonColor: '#7C3AED',
                            background: '#1A1F2B',
                            color: '#fff'
                        });
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