<?php
include('../database/db.php');
?>
<style>
    .modal-content {
    background-color: white;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding: 20px;
}

h3 {
    font-size: 1.5rem;
    color: black;
}

strong {
    color: black;
}

.mb-2 {
    margin-bottom: 0.5rem;
}

.mb-4 {
    margin-bottom: 1rem;
}

.rounded-full {
    border-radius: 50%;
}

</style>
<?php 
if (isset($_GET['id'])) {
    $userId = intval($_GET['id']);
    $result = mysqli_query($conn, "SELECT * FROM users WHERE id = $userId");
    $user = mysqli_fetch_assoc($result);

    if ($user) {
        // Start the modal content
        echo "<div class='modal-content p-6 bg-white rounded-lg shadow-lg text-black'>";

        // User ID
        echo "<h3 class='text-center text-xl font-semibold mb-4'>User Details</h3>";
        echo "<div class='mb-2'><strong>ID:</strong> " . htmlspecialchars($user['id'] ?? 'N/A') . "</div>";
        
        // User Role
        echo "<div class='mb-2'><strong>Role:</strong> " . htmlspecialchars($user['role'] ?? 'N/A') . "</div>";

        // User Name
        echo "<div class='mb-2'><strong>Name:</strong> " . htmlspecialchars($user['name'] ?? 'N/A') . "</div>";

        // User Email
        echo "<div class='mb-2'><strong>Email:</strong> " . htmlspecialchars($user['email'] ?? 'N/A') . "</div>";

        // User Phone
        echo "<div class='mb-2'><strong>Phone:</strong> " . htmlspecialchars($user['phone'] ?? 'N/A') . "</div>";

        // User GitHub ID
        echo "<div class='mb-2'><strong>GitHub ID:</strong> " . htmlspecialchars($user['github_id'] ?? 'N/A') . "</div>";

        // User GitHub Password
        echo "<div class='mb-2'><strong>GitHub Password:</strong> " . htmlspecialchars($user['github_password'] ?? 'N/A') . "</div>";

        // User Image
        echo "<div class='mb-4 text-center'><strong>User Image:</strong><br>";
        echo "<img src='../assets/" . htmlspecialchars($user['user_img'] ?? 'default.jpg') . "' class='w-32 h-32 rounded-full mx-auto' alt='User Image'></div>";

        // User Creation Date
        echo "<div class='mb-2'><strong>Created At:</strong> " . date('Y-m-d', strtotime($user['created_at'])) . "</div>";

        // User Status
        echo "<div class='mb-2'><strong>Status:</strong> " . htmlspecialchars(ucfirst($user['status'] ?? 'N/A')) . "</div>";

        // Close modal content
        echo "</div>";
    } else {
        echo "<div class='text-center text-black'>User not found.</div>";
    }
} else {
    echo "<div class='text-center text-black'>No user ID provided.</div>";
}
?>
