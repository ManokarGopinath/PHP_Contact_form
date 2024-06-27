<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'C:\xampp\htdocs/PHPMailer/PHPMailer/src/Exception.php';
require 'C:\xampp\htdocs/PHPMailer/PHPMailer/src/PHPMailer.php';
require 'C:\xampp\htdocs/PHPMailer/PHPMailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    if (isset($_FILES["attachment"]) && $_FILES["attachment"]["error"] == 0) {
        $file_tmp = $_FILES["attachment"]["tmp_name"];
        $file_name = $_FILES["attachment"]["name"];
        $file_type = $_FILES["attachment"]["type"];

        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'kbjagadeesan@gmail.com';
            $mail->Password = 'your app  password';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            // Recipients
            $mail->setFrom($email, $name);
            $mail->addAddress('kbjagadeesan@gmail.com', 'pentavenue');

            // Attachments
            $mail->addAttachment($file_tmp, $file_name);

            // Content
            $mail->isHTML(true);
            $mail->Subject = "New Inquiry from $name";
            $mail->Body = nl2br("Name: $name\nEmail: $email\n\nMessage:\n$message\n");

            $mail->send();
            echo "Thank you! Your message has been sent.";
        } catch (Exception $e) {
            echo "Oops! Something went wrong and we couldn't send your message. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "Please fill in all fields and attach a file.";
    }
} else {
    echo "Invalid request.";
}
?>
