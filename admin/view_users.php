<?php
ob_start();

// Include the database connection file
include('../database/db.php');
include('../includes/header.php');

// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Fetch users from the database
 $users = mysqli_query($conn, "SELECT id, name, email, phone, user_img, github_password, github_id, created_at, status FROM users");

// Handle activation/deactivation and delete
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['user_id'];
    $action = $_POST['action'];

    if ($action === 'activate') {
        mysqli_query($conn, "UPDATE users SET status = 'active' WHERE id = $userId");
    } elseif ($action === 'deactivate') {
        mysqli_query($conn, "UPDATE users SET status = 'inactive' WHERE id = $userId");
    } elseif ($action === 'delete') {
        // Handle user deletion
        mysqli_query($conn, "DELETE FROM users WHERE id = $userId");
    }

    header("Location: view_users.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Users</title>
    
    <!-- Google Fonts: Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
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
            font-family: 'Poppins', sans-serif;
            background: var(--dark-navy);
            color: #fff;
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }
        
        .bg-gradient {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 20% 20%, rgba(124, 58, 237, 0.08) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(59, 130, 246, 0.08) 0%, transparent 50%);
            z-index: -1;
        }
        
        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
            animation: fadeIn 0.5s ease-out;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 20px;
        }
        
        .header-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .icon-wrapper {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, var(--neon-purple), var(--electric-blue));
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(124, 58, 237, 0.3);
        }
        
        .icon-wrapper i {
            font-size: 1.3rem;
            color: white;
        }
        
        h2 {
            font-weight: 600;
            font-size: 1.8rem;
            background: linear-gradient(90deg, var(--neon-purple), var(--electric-blue));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        
        .btn {
            padding: 10px 20px;
            background: linear-gradient(90deg, var(--neon-purple), var(--electric-blue));
            color: white;
            border: none;
            border-radius: 10px;
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }
        
        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }
        
        .btn:hover::before {
            left: 100%;
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(124, 58, 237, 0.3);
        }
        
        .table-wrapper {
            background: linear-gradient(145deg, rgba(26, 31, 43, 0.95), rgba(11, 15, 25, 0.95));
            border-radius: 16px;
            padding: 20px;
            box-shadow: 
                0 10px 30px rgba(0, 0, 0, 0.4),
                0 0 0 1px rgba(124, 58, 237, 0.2);
            position: relative;
            overflow: hidden;
            backdrop-filter: blur(10px);
        }
        
        .table-wrapper::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--neon-purple), var(--electric-blue), var(--aqua-accent));
        }
        
        .table-controls {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 15px;
        }
        
        .search-box {
            position: relative;
            flex: 1;
            max-width: 300px;
        }
        
        .search-box input {
            width: 100%;
            padding: 10px 15px 10px 40px;
            background: rgba(26, 31, 43, 0.6);
            border: 1px solid rgba(124, 58, 237, 0.2);
            border-radius: 10px;
            color: #fff;
            font-family: 'Poppins', sans-serif;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }
        
        .search-box input:focus {
            outline: none;
            border-color: var(--electric-blue);
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.15);
        }
        
        .search-box i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
        }
        
        .entries-select {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .entries-select select {
            padding: 8px 12px;
            background: rgba(26, 31, 43, 0.6);
            border: 1px solid rgba(124, 58, 237, 0.2);
            border-radius: 8px;
            color: #fff;
            font-family: 'Poppins', sans-serif;
            font-size: 0.9rem;
            cursor: pointer;
        }
        
        .users-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            overflow: hidden;
        }
        
        .users-table thead th {
            background: rgba(26, 31, 43, 0.7);
            padding: 15px 12px;
            text-align: left;
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--aqua-accent);
            border-bottom: 2px solid rgba(124, 58, 237, 0.3);
            white-space: nowrap;
        }
        
        .users-table tbody tr {
            transition: all 0.3s ease;
            border-bottom: 1px solid rgba(124, 58, 237, 0.1);
        }
        
        .users-table tbody tr:hover {
            background: rgba(59, 130, 246, 0.08);
        }
        
        .users-table tbody td {
            padding: 15px 12px;
            font-size: 0.9rem;
            vertical-align: middle;
        }
        
        .user-img {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid rgba(124, 58, 237, 0.3);
            display: block;
        }
        
        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
            text-transform: capitalize;
        }
        
        .status-active {
            background: rgba(34, 197, 94, 0.2);
            color: #22c55e;
            border: 1px solid rgba(34, 197, 94, 0.3);
        }
        
        .status-inactive {
            background: rgba(239, 68, 68, 0.2);
            color: #ef4444;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }
        
        .actions-container {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }
        
        .action-btn {
            padding: 8px 12px;
            border-radius: 8px;
            font-size: 0.8rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
            color: white;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            white-space: nowrap;
        }
        
        .btn-activate {
            background: linear-gradient(135deg, #22c55e, #16a34a);
        }
        
        .btn-activate:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(34, 197, 94, 0.3);
        }
        
        .btn-deactivate {
            background: linear-gradient(135deg, #ef4444, #dc2626);
        }
        
        .btn-deactivate:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        }
        
        .btn-view {
            background: linear-gradient(135deg, var(--electric-blue), #2563eb);
        }
        
        .btn-view:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }
        
        .btn-edit {
            background: linear-gradient(135deg, var(--aqua-accent), #06b6d4);
        }
        
        .btn-edit:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(34, 211, 238, 0.3);
        }
        
        .btn-delete {
            background: linear-gradient(135deg, #dc2626, #991b1b);
        }
        
        .btn-delete:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
        }
        
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
            gap: 10px;
        }
        
        .pagination button {
            padding: 8px 12px;
            background: rgba(26, 31, 43, 0.6);
            border: 1px solid rgba(124, 58, 237, 0.2);
            border-radius: 8px;
            color: #fff;
            font-family: 'Poppins', sans-serif;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .pagination button:hover {
            background: var(--electric-blue);
            border-color: var(--electric-blue);
        }
        
        .pagination button.active {
            background: var(--neon-purple);
            border-color: var(--neon-purple);
        }
        
        .pagination-info {
            color: #9ca3af;
            font-size: 0.9rem;
        }
        
        /* Modal Styling */
        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            padding: 20px;
        }
        
        .modal.active {
            opacity: 1;
            visibility: visible;
        }
        
        .modal-content {
            background: linear-gradient(145deg, rgba(26, 31, 43, 0.98), rgba(11, 15, 25, 0.98));
            border-radius: 16px;
            padding: 25px;
            max-width: 600px;
            width: 100%;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 
                0 20px 40px rgba(0, 0, 0, 0.6),
                0 0 0 1px rgba(124, 58, 237, 0.3);
            transform: translateY(20px);
            transition: all 0.3s ease;
        }
        
        .modal.active .modal-content {
            transform: translateY(0);
        }
        
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid rgba(124, 58, 237, 0.2);
        }
        
        .modal-title {
            font-weight: 600;
            font-size: 1.4rem;
            background: linear-gradient(90deg, var(--neon-purple), var(--electric-blue));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        
        .close-btn {
            background: transparent;
            border: none;
            color: #9ca3af;
            font-size: 1.5rem;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .close-btn:hover {
            color: #fff;
            background: rgba(124, 58, 237, 0.2);
        }
        
        .user-detail-row {
            display: flex;
            margin-bottom: 15px;
            gap: 15px;
        }
        
        .user-detail-label {
            flex: 0 0 120px;
            font-weight: 500;
            color: var(--aqua-accent);
            font-size: 0.9rem;
        }
        
        .user-detail-value {
            flex: 1;
            color: #fff;
            font-size: 0.9rem;
        }
        
        .user-detail-img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid rgba(124, 58, 237, 0.3);
            margin: 0 auto 20px;
            display: block;
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Responsive Design */
        @media (max-width: 1024px) {
            .container {
                padding: 15px;
            }
            
            .table-controls {
                flex-direction: column;
                align-items: stretch;
            }
            
            .search-box {
                max-width: 100%;
            }
        }
        
        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                align-items: stretch;
                text-align: center;
            }
            
            .header-left {
                justify-content: center;
            }
            
            h2 {
                font-size: 1.5rem;
            }
            
            .table-wrapper {
                padding: 15px;
                overflow-x: auto;
            }
            
            .users-table {
                min-width: 700px;
            }
            
            .users-table thead th,
            .users-table tbody td {
                padding: 12px 8px;
                font-size: 0.85rem;
            }
            
            .actions-container {
                flex-direction: column;
                gap: 5px;
            }
            
            .action-btn {
                font-size: 0.75rem;
                padding: 6px 10px;
                justify-content: center;
            }
            
            .pagination {
                flex-wrap: wrap;
                gap: 5px;
            }
            
            .user-detail-row {
                flex-direction: column;
                gap: 5px;
            }
            
            .user-detail-label {
                flex: none;
            }
        }
        
        @media (max-width: 480px) {
            .container {
                padding: 10px;
            }
            
            .btn {
                padding: 8px 16px;
                font-size: 0.85rem;
            }
            
            .modal-content {
                padding: 20px;
            }
            
            .modal-title {
                font-size: 1.2rem;
            }
        }
    </style>
</head>
<body>
    <div class="bg-gradient"></div>
    
    <div class="container">
        <div class="header">
            <div class="header-left">
                <div class="icon-wrapper">
                    <i class="fas fa-users"></i>
                </div>
                <h2>User Management</h2>
            </div>
            <a href="add_user.php" class="btn">
                <i class="fas fa-plus"></i> Add User
            </a>
        </div>
        
        <div class="table-wrapper">
            <div class="table-controls">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" id="searchInput" placeholder="Search users...">
                </div>
                <div class="entries-select">
                    <label for="entriesSelect">Show:</label>
                    <select id="entriesSelect">
                        <option value="10">10 entries</option>
                        <option value="25">25 entries</option>
                        <option value="50">50 entries</option>
                        <option value="100">100 entries</option>
                    </select>
                </div>
            </div>
            
            <div style="overflow-x: auto;">
                <table class="users-table" id="usersTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Image</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($user = mysqli_fetch_assoc($users)) { ?>
                            <tr>
                                <td><?php echo $user['id']; ?></td>
                                <td><?php echo htmlspecialchars($user['name'] ?? 'N/A'); ?></td>
                                <td><?php echo htmlspecialchars($user['email'] ?? 'N/A'); ?></td>
                                <td><?php echo htmlspecialchars($user['phone'] ?? 'N/A'); ?></td>
                                <td><img src="../assets/<?php echo htmlspecialchars($user['user_img'] ?? 'default.jpg'); ?>" class="user-img" alt="User Image"></td>
                                <td>
                                    <span class="status-badge status-<?php echo $user['status']; ?>">
                                        <?php echo htmlspecialchars(ucfirst($user['status'] ?? 'N/A')); ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="actions-container">
                                        <?php if ($user['status'] === 'inactive') { ?>
                                            <form action="" method="POST" style="display: inline;">
                                                <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                                <button type="submit" name="action" value="activate" class="action-btn btn-activate">
                                                    <i class="fas fa-check"></i> Activate
                                                </button>
                                            </form>
                                        <?php } else { ?>
                                            <form action="" method="POST" style="display: inline;">
                                                <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                                <button type="submit" name="action" value="deactivate" class="action-btn btn-deactivate">
                                                    <i class="fas fa-pause"></i> Deactivate
                                                </button>
                                            </form>
                                        <?php } ?>
                                        
                                        <button type="button" onclick="viewUser(<?php echo $user['id']; ?>)" class="action-btn btn-view">
                                            <i class="fas fa-eye"></i> View
                                        </button>
                                        
                                        <a href="edit_user.php?id=<?php echo $user['id']; ?>" class="action-btn btn-edit">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        
                                        <button type="button" class="action-btn btn-delete" onclick="confirmDelete(<?php echo $user['id']; ?>)">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            
            <div class="pagination">
                <button onclick="changePage(-1)">Previous</button>
                <span class="pagination-info">Showing 1 to 10 of 50 entries</span>
                <button onclick="changePage(1)">Next</button>
            </div>
        </div>
    </div>
    
    <!-- User Details Modal -->
    <div id="userModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">User Details</h3>
                <button class="close-btn" onclick="closeModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div id="userDetails"></div>
        </div>
    </div>

    <script>
        // Search functionality
        document.getElementById('searchInput').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('#usersTable tbody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });
        
        // Entries per page
        document.getElementById('entriesSelect').addEventListener('change', function() {
            // Implement entries per page logic here
            console.log('Entries per page:', this.value);
        });
        
        // Pagination
        function changePage(direction) {
            // Implement pagination logic here
            console.log('Change page:', direction);
        }
        
        // Function to view user details
        function viewUser(userId) {
            // Create mock user details for demo
            const userDetails = `
                <img src="../assets/default.jpg" class="user-detail-img" alt="User Image">
                <div class="user-detail-row">
                    <div class="user-detail-label">User ID:</div>
                    <div class="user-detail-value">#${userId}</div>
                </div>
                <div class="user-detail-row">
                    <div class="user-detail-label">Name:</div>
                    <div class="user-detail-value">John Doe</div>
                </div>
                <div class="user-detail-row">
                    <div class="user-detail-label">Email:</div>
                    <div class="user-detail-value">john.doe@example.com</div>
                </div>
                <div class="user-detail-row">
                    <div class="user-detail-label">Phone:</div>
                    <div class="user-detail-value">+1 234 567 8900</div>
                </div>
                <div class="user-detail-row">
                    <div class="user-detail-label">Status:</div>
                    <div class="user-detail-value">
                        <span class="status-badge status-active">Active</span>
                    </div>
                </div>
                <div class="user-detail-row">
                    <div class="user-detail-label">Created:</div>
                    <div class="user-detail-value">2024-01-15</div>
                </div>
            `;
            
            document.getElementById('userDetails').innerHTML = userDetails;
            document.getElementById('userModal').classList.add('active');
        }

        // Function to close the modal
        function closeModal() {
            document.getElementById('userModal').classList.remove('active');
        }

        // SweetAlert2 for delete confirmation
        function confirmDelete(userId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#7C3AED',
                cancelButtonColor: '#3B82F6',
                confirmButtonText: 'Yes, delete it!',
                background: 'var(--deep-gray)',
                color: '#fff'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '';
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'user_id';
                    input.value = userId;
                    form.appendChild(input);
                    const actionInput = document.createElement('input');
                    actionInput.type = 'hidden';
                    actionInput.name = 'action';
                    actionInput.value = 'delete';
                    form.appendChild(actionInput);
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }
        
        // Close modal when clicking outside
        document.getElementById('userModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
        
        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal();
            }
        });
    </script>
</body>
</html>
<?php include('../includes/footer.php'); ?>