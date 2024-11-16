<?php
session_start();
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../vendor/autoload.php';
    $sender_name      = $_REQUEST['sender_name'];
    $recipient_email  = $_REQUEST['recipient_email'];
    $subject          = $_REQUEST['subject'];
    $body             = $_REQUEST['body'];
    $attechment_img   = $_REQUEST['attachment_img'];

    if(empty($sender_name)                             ||
        empty($recipient_email)                        ||
    !filter_var($recipient_email,FILTER_VALIDATE_EMAIL)||
    empty($subject)                                    ||
    empty($body)){
        http_response_code(400);
        echo "<span style='color:blue;'> Bad Resqust -Please Fill All Fields.</span> <br/>";
        return false;
    }

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'awadppp389@gmail.com';                     //SMTP username
    $mail->Password   = '';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('mr.hatab055@info.com', $sender_name);
    $mail->addAddress($recipient_email);
    


   

    //Content
    $mail->isHTML(false);                                  //Set email format to HTML
    $mail->Subject = $subject;
    $mail->Body    = $body;
    $mail->AltBody = $body;

    $mail->send();
    // set Success Massage in Session 
    $_SESSION['success_message'] = "\"<span style='font-weight:bold; text-decroition:underline;'>$sender_name</span>\" , your mail has been successfully to \"<span style='font-weight:bold; text-decroition:underline;'>$recipient_email</span>\"";
    header("Location: http://localhost:8080/index.php#contact");
    exit;
} catch (Exception $e) {
    $_SESSION['error_message'] = "\"<span style='font-weight:bold; text-decroition:underline;'>$sender_name</span>\" , your mail hasn't been successfully to \"<span style='font-weight:bold; text-decroition:underline;'>$recipient_email</span>\"";
    header("Location: http://localhost:8080/index.php#contact");
exit;
}