<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer autoloader and your email configuration
require 'vendor/autoload.php'; // Update the path as needed

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get recipient email and username from the form
    $recipientEmail = $_POST['email'];
    $username = $_POST['username'];
    $fullname = $_POST['fullname'];
    $password = $_POST['password'];

    try {
        // Create a new PHPMailer instance
        require 'PHPMailer.php';
        require 'Exception.php';
        require 'SMTP.php';

        $mail = new PHPMailer();
        // Send an email to the user with a link to reset their password using PHPMailer

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Your SMTP server address
        $mail->SMTPAuth = true;
        $mail->Username = 'your-email@example.com'; // Your email address
        $mail->Password = 'your-email-password'; // Your email password
        $mail->Username = 'maryammohiyuddin123@gmail.com';
        $mail->Password = 'psbmwqolhvzubrbt

                        ';
        $mail->setFrom('your-email@example.com', 'Your Name');
        $mail->addAddress($recipientEmail); // Recipient's email address
        $mail->Subject = 'Student registration';
        $mail->Body = "Here are your credentials for $fullname : Username: $username and password: $password";


        // Send the email
        $mail->send();
        echo "<script>alert('Email has been sent successfully');</script>";
        echo "<script>setTimeout(function(){ window.location = 'view_student_credentials.php'; });</script>"; // Redirect after 3 seconds
    } catch (Exception $e) {
        $errorMessage = "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>