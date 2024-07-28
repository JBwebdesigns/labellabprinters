<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $visitor_email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $visitor_name = filter_var($_POST['name'], FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
    $message_subject = filter_var($_POST['subject'], FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
    $visitor_message = filter_var($_POST['message'], FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

    if (!empty($visitor_email) && !empty($visitor_message) && !empty($visitor_name) && !empty($message_subject)) {
        if (!filter_var($visitor_email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['msg'] = '<div class="alert alert-danger" role="alert">Please use a valid email address</div>';
            header("Location: index.php#contact");
            exit;
        } else {
            $recipient = "sales@labellabprinters.com"; // Change this to your email address
            $email_content = '<body>
                <h2>Contact Request</h2>
                <h4>Name:</h4><p>' . htmlspecialchars($visitor_name) . '</p>
                <h4>Email:</h4><p>' . htmlspecialchars($visitor_email) . '</p>
                <h4>Message:</h4><p>' . htmlspecialchars($visitor_message) . '</p>
            </body>';
            $email_headers = "MIME-Version: 1.0" . "\r\n";
            $email_headers .= "Content-Type: text/html; charset=utf-8" . "\r\n";
            $email_headers .= "From: " . htmlspecialchars($visitor_name) . " <" . htmlspecialchars($visitor_email) . ">" . "\r\n";
            $email_headers .= "Reply-To: " . htmlspecialchars($visitor_email) . " \r\n";
            $email_headers .= "X-Priority: 3\r\n";

            if (mail($recipient, $message_subject, $email_content, $email_headers)) {
                $_SESSION['msg'] = '<div class="alert alert-success" role="alert">Thank you for reaching out! Your message has been sent successfully.</div>';
                header("Location: index.php#contact");
                exit;
            } else {
                $_SESSION['msg'] = '<div class="alert alert-danger" role="alert">Ooops! Something went wrong. Please try again.</div>';
                header("Location: index.php#contact");
                exit;
            }
        }
    } else {
        $_SESSION['msg'] = '<div class="alert alert-danger" role="alert">Please add a valid email address, name, subject, and message.</div>';
        header("Location: index.php");
        exit;
    }
}
?>
