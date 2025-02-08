<?php

require_once __DIR__ . "/vendor/autoload.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

try {
    // Get form data
    $name = strip_tags(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $subject = strip_tags(trim($_POST["subject"]));
    $message = strip_tags(trim($_POST["message"]));

    $mail = new PHPMailer(true);

    // Debug settings
    $mail->SMTPDebug = 2;  // Enable verbose debug output
    $mail->Debugoutput = 'error_log';  // Write to error log

    // Server settings
    $mail->isSMTP();
    $mail->Host = 'smtp.sendgrid.net';
    $mail->SMTPAuth = true;
    $mail->Username = 'apikey';
    $mail->Password = 'YOUR-SENDGRID-API-KEY'; // Your actual API key
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // Format message nicely
    $htmlMessage = "
        <h2>New Contact Form Submission</h2>
        <p><strong>Name:</strong> {$name}</p>
        <p><strong>Email:</strong> {$email}</p>
        <p><strong>Subject:</strong> {$subject}</p>
        <p><strong>Message:</strong></p>
        <p>{$message}</p>
    ";

    // Recipients - use your verified sender
    $mail->setFrom('sam@hotwatersolutions.com', 'Hot Water Solutions');
    $mail->addAddress('sam@hotwatersolutions.com', 'Sam');
    $mail->addReplyTo($email, $name);

    // Content
    $mail->isHTML(true);
    $mail->Subject = "Website Contact: $subject";
    $mail->Body = $htmlMessage;
    $mail->AltBody = strip_tags($htmlMessage);

    if ($mail->send()) {
        http_response_code(200);
        echo "Thank you! Your message has been sent successfully.";
    } else {
        throw new Exception("Mailer Error: " . $mail->ErrorInfo);
    }

} catch (Exception $e) {
    error_log("Mail Error: " . $e->getMessage());
    http_response_code(500);
    echo "Message could not be sent. Please try again later.";
}

?>
