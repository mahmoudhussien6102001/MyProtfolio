<?php
session_start();
// Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require '../vendor/autoload.php';

// Retrieve form data
$sender_name = $_REQUEST['sender_name'];
$recipient_email = $_REQUEST['recipient_email'];
$subject = $_REQUEST['subject'];
$body = $_REQUEST['body'];
$attachment_img = $_REQUEST['attachment_img'];

// Validate the inputs
if (empty($sender_name) || 
    empty($recipient_email) || 
    !filter_var($recipient_email, FILTER_VALIDATE_EMAIL) || 
    empty($subject) || 
    empty($body)) {
    http_response_code(400);
    echo "<span style='color:blue;'>Bad Request - Please Fill All Fields.</span><br/>";
    return false;
}

// Create an instance of PHPMailer
$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;  // Enable verbose debug output
    $mail->isSMTP();  // Send using SMTP
    $mail->Host = 'sandbox.smtp.mailtrap.io';  // Set the SMTP server to send through
    $mail->SMTPAuth = true;  // Enable SMTP authentication
    $mail->Username = '688d13e29f9831';  // SMTP username
    $mail->Password = '********231e';  // SMTP password (replace this with your actual password securely)
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;  // Enable implicit TLS encryption
    $mail->Port =2525 ;  // TCP port to connect to

    // Recipients
    $mail->setFrom('awadppp389@gmail.com', $sender_name);
    $mail->addAddress($recipient_email);  // Add recipient

    // Optional: Handle attachment if provided
    if (!empty($attachment_img)) {
        $mail->addAttachment($attachment_img);  // Attach file if provided
    }

    // Content
    $mail->isHTML(false);  // Set email format to plain text
    $mail->Subject = $subject;
    $mail->Body = $body;
    $mail->AltBody = $body;

    // Send the email
    $mail->send();

    // Set success message in session
    $_SESSION['success_message'] = "\"$sender_name\", your mail has been successfully sent to \"$recipient_email\"";
    header("Location: http://localhost:8080/index.php#contact");
    exit;
} catch (Exception $e) {
    // Set error message in session
    $_SESSION['error_message'] = "\"$sender_name\", your mail hasn't been successfully sent to \"$recipient_email\"";
    header("Location: http://localhost:8080/index.php#contact");
    exit;
}
?>
