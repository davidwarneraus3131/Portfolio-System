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
    <!-- Include Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Include DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
</head>

<style>
    /* Add custom background gradient and box-shadow styles */
    .gradient-bg {
      background: linear-gradient(to right, #3b5757, #020d1b);
      color: white;
    }
    .hover-shadow {
      transition: box-shadow 0.3s ease;
    }
    .hover-shadow:hover {
      box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.6);
    }
    /* Table Gradient Background */
    .table-bg {
      background: linear-gradient(to right, #3b5757, #020d1b);
      color: black;
    }
    /* Adjust table header for better visibility */
    .table-header {
      background-color: #2c2c2c; /* Darker color for the header */
    }
</style>

<body class="gradient-bg">

<div class="container mx-auto mt-8">
    <h2 class="text-2xl font-semibold mb-6">User List</h2>
    <!-- Add User Button -->
    <div class="flex justify-end mb-4">
        <a href="add_user.php" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-blue-600 hover-shadow">
            Add User
        </a>
    </div>

    <!-- User Table Container -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table id="userTable" class="min-w-full display">
            <thead class="table-header text-white">
                <tr>
                    <th class="py-3 px-4 text-left">ID</th>
                    <th class="py-3 px-4 text-left">Name</th>
                    <th class="py-3 px-4 text-left">Email</th>
                    <th class="py-3 px-4 text-left">Phone</th>
                    <th class="py-3 px-4 text-left">User Image</th>
                    
                    <th class="py-3 px-4 text-left">Status</th>
                    <th class="py-3 px-4 text-left">Actions</th>
                </tr>
            </thead>
            <tbody class="table-bg">
                <?php while ($user = mysqli_fetch_assoc($users)) { ?>
                    <tr class="border-b hover:bg-gray-100">
                        <td class="py-3 px-4"><?php echo $user['id']; ?></td>
                        <td class="py-3 px-4"><?php echo htmlspecialchars($user['name'] ?? 'N/A'); ?></td>
                        <td class="py-3 px-4"><?php echo htmlspecialchars($user['email'] ?? 'N/A'); ?></td>
                        <td class="py-3 px-4"><?php echo htmlspecialchars($user['phone'] ?? 'N/A'); ?></td>
                        <td class="py-3 px-4"><img src="../assets/<?php echo htmlspecialchars($user['user_img'] ?? 'default.jpg'); ?>" class="w-16 h-16 rounded"></td>
                       
                        <td class="py-3 px-4"><?php echo htmlspecialchars(ucfirst($user['status'] ?? 'N/A')); ?></td>
                        <td class="py-3 px-4">
                            <form action="" method="POST" class="inline">
                                <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                <!-- Activate/Deactivate buttons -->
                                <?php if ($user['status'] === 'inactive') { ?>
                                    <button type="submit" name="action" value="activate" class="bg-green-500 text-white px-4 py-1 rounded hover:bg-green-600">Activate</button>
                                <?php } else { ?>
                                    <button type="submit" name="action" value="deactivate" class="bg-red-500 text-white px-4 py-1 rounded hover:bg-red-600">Deactivate</button>
                                <?php } ?>
                                <!-- View Button -->
                                <button type="button" onclick="viewUser(<?php echo $user['id']; ?>)" class="bg-blue-500 text-white px-4 py-1 rounded hover:bg-blue-600 ml-2">View</button>
                                <!-- Edit Button -->
                                <a href="edit_user.php?id=<?php echo $user['id']; ?>" class="bg-blue-500 text-white px-4 py-1 rounded hover:bg-blue-600 ml-2">Edit</a>
                                <!-- Delete Button -->
                                <button type="button" class="bg-red-700 text-white px-4 py-1 rounded hover:bg-red-800 ml-2" onclick="confirmDelete(<?php echo $user['id']; ?>)">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<!-- User Details Modal -->
<div id="userModal" class="fixed inset-0 flex items-center justify-center z-50 hidden bg-gray-900 bg-opacity-50">
    <div class="bg-white rounded-lg p-6 max-w-lg w-full">
        <h3 class="text-lg font-semibold mb-4">User Details</h3>
        <div id="userDetails"></div>
        <button onclick="closeModal()" class="mt-4 px-4 py-2 bg-gray-500 text-white rounded">Close</button>
    </div>
</div>

<!-- Include jQuery and DataTables JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script>
    // Initialize DataTables
    $(document).ready(function() {
        $('#userTable').DataTable();
    });

    // Function to view user details
    function viewUser(userId) {
        $.ajax({
            url: 'fetch_user.php', // Create a new file to fetch user details
            type: 'GET',
            data: { id: userId },
            success: function(data) {
                $('#userDetails').html(data);
                $('#userModal').removeClass('hidden'); // Show the modal
            }
        });
    }

    // Function to close the modal
    function closeModal() {
        $('#userModal').addClass('hidden'); // Hide the modal
    }

    // SweetAlert2 for delete confirmation
    function confirmDelete(userId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
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
</script>

</body>
</html>
