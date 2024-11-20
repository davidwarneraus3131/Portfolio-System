<?php
// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Include necessary files for email sending (PHPMailer, etc.)
// For this example, we will use the mail() function, but you may want to use PHPMailer or similar for more features.

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize input data
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $message = trim($_POST['message']);

    $errors = [];

    // Basic validation
    if (empty($name)) {
        $errors[] = "Name is required.";
    }
    if (empty($email)) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }
    if (empty($message)) {
        $errors[] = "Message is required.";
    }

    // If there are no errors, proceed to send email
    if (empty($errors)) {
        $to = "potterharry623016@gmail.com"; // Replace with your email address
        $subject = "New Contact Form Submission from $name";
        $body = "You have received a new message from the contact form(Students).\n\n".
                "Name: $name\n".
                "Email: $email\n".
                "Message:\n$message\n";
        $headers = "From: $name <$email>\r\n";
        $headers .= "Reply-To: $email\r\n";

        // Send email
        if (mail($to, $subject, $body, $headers)) {
            // Redirect to a thank you page or show a success message
            header("Location: thank_you.php");
            exit();
        } else {
            $errors[] = "There was an error sending your message. Please try again later.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Contact Submission</title>
</head>

<style>
    body {
            font-family: 'Arial', sans-serif; /* Professional font style */
    scroll-behavior: smooth; /* Smooth scrolling effect */
    margin: 0; /* Remove default margin */
    padding: 0; /* Remove default padding */
    background-image: linear-gradient(to right, #3b5757, #020d1b); /* Gradient from blue-900 to gray-800 */
    padding: 1rem; /* Equivalent to p-4 in Tailwind (1rem = 16px) */
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Shadow equivalent to shadow-lg */
    color:rgb(193 193 193);
        }
</style>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-6 rounded-lg shadow-lg max-w-lg w-full">
        <h2 class="text-2xl font-bold mb-4">Contact Form Submission</h2>
        
        <?php if (!empty($errors)): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Oops!</strong>
                <ul class="mt-2">
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php else: ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Success!</strong> Your message has been sent.
            </div>
        <?php endif; ?>
        
        <a href="contact.php" class="text-blue-500 hover:text-blue-700">Return to Contact Page</a>
    </div>
</body>
</html>
