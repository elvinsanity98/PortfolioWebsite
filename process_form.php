<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
require 'vendor/phpmailer/phpmailer/src/Exception.php';
require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/phpmailer/src/SMTP.php'

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp-relay.brevo.com'; // Set the SMTP server to send through
        $mail->SMTPAuth   = true;
        $mail->Username   = '7b656a001@smtp-brevo.com'; // SMTP username
        $mail->Password   = 'qOYsCTMNJDn1fgjH'; // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Recipients
        $mail->setFrom($email, $name); // Use the sender's name and email
        $mail->addAddress('7b656a001@smtp-brevo.com'); // Add a recipient

        // Content
        $mail->isHTML(true); 
        $mail->Subject = 'New Contact Form Submission';
        $mail->Body    = "<p><strong>Name:</strong> {$name}</p>
                          <p><strong>Email:</strong> {$email}</p>
                          <p><strong>Message:</strong><br>{$message}</p>";
        $mail->AltBody = "Name: {$name}\nEmail: {$email}\nMessage: {$message}";

        $mail->send();
        echo "<script>
                document.getElementById('form-message-success').style.display = 'block';
              </script>";
    } catch (Exception $e) {
        echo "<script>
                document.getElementById('form-message-warning').innerHTML = 'Message could not be sent. Mailer Error: {$mail->ErrorInfo}';
                document.getElementById('form-message-warning').style.display = 'block';
              </script>";
    } catch (\Exception $e) {
        echo "<script>
                document.getElementById('form-message-warning').innerHTML = 'Something went wrong: {$e->getMessage()}';
                document.getElementById('form-message-warning').style.display = 'block';
              </script>";
    }
}
?>
