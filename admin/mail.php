<?php
ob_start(); // Start output buffering
session_start();
include("../database/db.php");

if ($_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit(); 
}

// Include PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

// Initialize messages
$success_message = ""; 
$error_message = "";

// Check if the form for sending email has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['send_email'])) {
    
    $portfolio_link = $_POST['portfolio_link'] ?? '';
    $user_email = $_POST['user_email'] ?? ''; 
    $username = $_POST['user_name'] ?? '';

    // Create the email message
    $message = "
    <html>
    <head>
        <style>
            body {font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f6f6f6;}
            .container {max-width: 600px; margin: auto; background: #ffffff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);}
            h2 {color: #333;}
            p {color: #555;}
            .footer {margin-top: 20px; font-size: 12px; color: #aaa;}
            .logo {margin-bottom: 20px; text-align: center;}
        </style>
    </head>
    <body>
    <div class='container'>
        <div class='logo'>
            <img src='https://teckspiral.com/moores/storage/app/public/shop/2024-06-02-665c438ca5bb6.webp' alt='Showbase' style='width: 150px;'>
        </div>
        <h2>🌟 Your Portfolio is Ready! 🌟</h2>
        <p>Dear $username,</p>
        <p>We are delighted to inform you that your portfolio has been successfully completed. 😊</p>
        <p>We invite you to review your work using the link below:</p>
        <p><a href='$portfolio_link' style='color: #1d4ed8; font-weight: bold;'>View Your Portfolio</a></p>
        <p>Thank you for trusting us with your project! If you have any questions or need further assistance, feel free to reach out.</p>
        <p>Best regards,<br>Showbase</p>
    </div>
    </body>
    </html>";

    $mail = new PHPMailer;

    try {
        // Configure the mail server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'tls';

        $mail->Username = 'potterharry623017@gmail.com'; // Replace with your email
        $mail->Password = 'tdat jrtw ngkz rjvm'; // Replace with your password or app password

        $mail->setFrom('potterharry623017@gmail.com', 'Portfolio Status');
        $mail->addAddress($user_email);

        // Set the email content
        $mail->isHTML(true);
        $mail->Subject = 'Your Portfolio is Ready!';
        $mail->Body = $message;

        // Send the email
        if ($mail->send()) {
            echo "<script>
                    alert('Success! Your email has been sent successfully! 😊');
                    setTimeout(function() {
                        window.location.href = 'view_payments.php';
                    }, 2000); // Redirect after 2 seconds
                  </script>";
            exit();
        } else {
            $error_message = "Failed to send email.";
            echo "<script>
                    alert('Error! $error_message ❌');
                    setTimeout(function() {
                        window.location.href = 'view_payments.php';
                    }, 2000);
                  </script>";
        }
    } catch (Exception $e) {
        $error_message = "Mailer Error: {$mail->ErrorInfo}";
        echo "<script>
                alert('Error! $error_message ❌');
                setTimeout(function() {
                    window.location.href = 'view_payments.php';
                }, 2000);
              </script>";
    }
}
?>
