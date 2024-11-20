<?php
session_start();

include('../database/db.php');
if ($_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

// Initialize success and error variables
$success = '';
$error = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role = $_POST['role'];
    $phone = $_POST['phone'];
    $github_id = $_POST['github_id'];
    $github_password = $_POST['github_password'];

    // Handle file upload for user_img
    $user_img = null;
    if (isset($_FILES['user_img']) && $_FILES['user_img']['error'] == UPLOAD_ERR_OK) {
        $target_dir = "../assets/users/";
        $user_img = basename($_FILES["user_img"]["name"]);
        move_uploaded_file($_FILES["user_img"]["tmp_name"], $target_dir . $user_img);
    }

    // Check if email already exists
    $emailCheck = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");

    if (mysqli_num_rows($emailCheck) > 0) {
        $error = "Email already exists!";
    } else {
        // Insert user into the database
        $query = "INSERT INTO users (name, email, password, role, phone, user_img, github_id, github_password) 
                  VALUES ('$name', '$email', '$password', '$role', '$phone', '$user_img', '$github_id', '$github_password')";
        if (mysqli_query($conn, $query)) {
            $success = "User added successfully!";
        } else {
            $error = "Error: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/styles.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md mx-auto bg-white p-8 border border-gray-300 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold mb-6 text-center">Add New User</h2>

        <form method="POST" action="" enctype="multipart/form-data">
            <!-- Name -->
            <div class="mb-4">
                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name</label>
                <input type="text" name="name" id="name" placeholder="Enter name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                <input type="email" name="email" id="email" placeholder="Enter email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                <input type="password" name="password" id="password" placeholder="Enter password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>

            <!-- Phone -->
            <div class="mb-4">
                <label for="phone" class="block text-gray-700 text-sm font-bold mb-2">Phone</label>
                <input type="text" name="phone" id="phone" placeholder="Enter phone number" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>

            <!-- User Image -->
            <div class="mb-4">
                <label for="user_img" class="block text-gray-700 text-sm font-bold mb-2">User Image</label>
                <input type="file" name="user_img" id="user_img" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>

            <!-- GitHub ID -->
            <div class="mb-4">
                <label for="github_id" class="block text-gray-700 text-sm font-bold mb-2">GitHub ID</label>
                <input type="text" name="github_id" id="github_id" placeholder="Enter GitHub ID" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>

            <!-- GitHub Password -->
            <div class="mb-4">
                <label for="github_password" class="block text-gray-700 text-sm font-bold mb-2">GitHub Password</label>
                <input type="password" name="github_password" id="github_password" placeholder="Enter GitHub Password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>

            <!-- Role -->
            <div class="mb-4">
                <label for="role" class="block text-gray-700 text-sm font-bold mb-2">Role</label>
                <select name="role" id="role" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    <option value="student">Student</option>
                    <option value="admin">Admin</option>
                </select>
            </div>

            <!-- Submit Button -->
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Add User
                </button>
                <a href="view_users.php" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                    Cancel
                </a>
            </div>
        </form>
    </div>

    <script>
        // Show success or error message using SweetAlert
        <?php if (!empty($success)) : ?>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '<?php echo addslashes($success); ?>',
                confirmButtonText: 'OK'
            }).then(() => {
                // Redirect to view_users.php after closing the alert
                window.location.href = 'view_users.php';
            });
        <?php elseif (!empty($error)) : ?>
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
