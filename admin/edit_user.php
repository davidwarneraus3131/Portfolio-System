<?php
ob_start();
include('../database/db.php');
include('../includes/header.php');

// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if user ID is passed
if (isset($_GET['id'])) {
    $userId = $_GET['id'];
    $query = "SELECT * FROM users WHERE id = $userId";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);
} else {
    header('Location: view_users.php');
    exit();
}

// Handle form submission
$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $status = $_POST['status'];
    $phone = $_POST['phone'];
    $githubId = $_POST['github_id'];
    $githubPassword = $_POST['github_password'];
    $userImage = $_FILES['user_img'];

    // Image upload logic
    $imagePath = '';
    if ($userImage['name']) {
        $targetDir = "../assets/users";
        $imagePath = $targetDir . basename($userImage["name"]);
        move_uploaded_file($userImage["tmp_name"], $imagePath);
    } else {
        $imagePath = $user['user_img']; // Retain old image if none uploaded
    }

    // Update user in the database
    $query = "UPDATE users SET name = '$name', email = '$email', status = '$status', phone = '$phone', github_id = '$githubId', github_password = '$githubPassword', user_img = '$imagePath' WHERE id = $userId";
    if (mysqli_query($conn, $query)) {
        // Set success message and redirect
        header("Location: edit_user.php?id=$userId&success=" . urlencode("User updated successfully!"));
        exit();
    } else {
        $error = "Error updating user: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/styles.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- SweetAlert CDN -->
    <title>Edit User</title>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-8">
        <div class="max-w-lg mx-auto bg-white p-6 rounded-lg shadow-lg">
            <h2 class="text-2xl font-bold text-center mb-6">Edit User</h2>

            <?php if ($error): ?>
                <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>
            
            <form action="" method="POST" enctype="multipart/form-data">
    <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2">Name</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($user['name'] ?? '', ENT_QUOTES); ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
    </div>

    <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2">Email</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($user['email'] ?? '', ENT_QUOTES); ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
    </div>

    <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2">Phone</label>
        <input type="text" name="phone" value="<?php echo htmlspecialchars($user['phone'] ?? '', ENT_QUOTES); ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
    </div>

    <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2">GitHub ID</label>
        <input type="text" name="github_id" value="<?php echo htmlspecialchars($user['github_id'] ?? '', ENT_QUOTES); ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
    </div>

    <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2">GitHub Password</label>
        <input type="password" name="github_password" value="<?php echo htmlspecialchars($user['github_password'] ?? '', ENT_QUOTES); ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
    </div>

    <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2">User Image</label>
        <input type="file" name="user_img" accept="image/*" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
    </div>

    <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2">Status</label>
        <select name="status" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            <option value="active" <?php if (isset($user['status']) && $user['status'] === 'active') echo 'selected'; ?>>Active</option>
            <option value="inactive" <?php if (isset($user['status']) && $user['status'] === 'inactive') echo 'selected'; ?>>Inactive</option>
        </select>
    </div>

    <div class="flex items-center justify-between">
        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
            Update User
        </button>
        <a href="view_users.php" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
            Cancel
        </a>
    </div>
</form>

        </div>
    </div>

    <script>
        // Check for success message in the URL
        const urlParams = new URLSearchParams(window.location.search);
        const successMessage = urlParams.get('success');

        // Show success message if it exists
        if (successMessage) {
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: successMessage,
                confirmButtonText: 'OK'
            }).then(() => {
                // Redirect to view_users.php after alert is closed
                window.location.href = 'view_users.php';
            });
        }

        // Check for error message in the PHP error variable
        <?php if (!empty($error)): ?>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '<?php echo addslashes($error); ?>',
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
