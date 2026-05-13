<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "error";
    exit;
}

$name    = trim($_POST['name'] ?? '');
$email   = trim($_POST['email'] ?? '');
$subject = trim($_POST['subject'] ?? 'New message from your website');
$message = trim($_POST['message'] ?? '');

if ($name === '' || $email === '' || $message === '') {
    echo "error";
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "invalid_email";
    exit;
}

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'jerminmercado1@gmail.com';
    $mail->Password   = 'ejpd naet shcu joyw';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    $mail->setFrom('jerminmercado1@gmail.com', 'Portfolio Contact Form');
    $mail->addAddress('jerminmercado1@gmail.com');
    $mail->addReplyTo($email, $name);

    $safeName = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
    $safeEmail = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');
    $safeMessage = nl2br(htmlspecialchars($message, ENT_QUOTES, 'UTF-8'));

    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body = "
        <h3>New Portfolio Message</h3>
        <p><strong>From:</strong> {$safeName}</p>
        <p><strong>Email:</strong> {$safeEmail}</p>
        <hr>
        <p>{$safeMessage}</p>
    ";

    $mail->AltBody = "From: $name\nEmail: $email\n\n$message";

    $mail->send();

    echo "success";
    exit;

} catch (Exception $e) {
    echo "error";
    exit;
}
?>