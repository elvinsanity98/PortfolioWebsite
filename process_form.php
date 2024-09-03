<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Load Composer's autoloader

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = strip_tags(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $message = trim($_POST["message"]);

    // Check if the form fields are empty
    if (empty($name) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo "Please fill out all the fields.";
        exit;
    }

    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host       = 'smtp-relay.brevo.com';                     // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = '7b656a002@smtp-brevo.com';               // SMTP username
        $mail->Password   = 'COaQbEfNAmkMd9Ij';                  // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
        $mail->Port       = 587;                                    // TCP port to connect to

        // Recipients
        $mail->setFrom('7b656a002@smtp-brevo.com', 'Your Name');
        $mail->addAddress('kaeltheinvoker121@gmail.com', 'Recipient Name'); // Add a recipient

        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'New Contact Form Submission';
        $mail->Body    = "You have received a new message from your website contact form.<br><br>" .
                         "Name: $name<br>" .
                         "Email: $email<br><br>" .
                         "Message:<br>$message";
        $mail->AltBody = "You have received a new message from your website contact form.\n\n" .
                         "Name: $name\n" .
                         "Email: $email\n\n" .
                         "Message:\n$message";

        $mail->send();
        echo 'Your message was sent, thank you!';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
} else {
    echo 'There was a problem with your submission. Please try again.';
}
?>
