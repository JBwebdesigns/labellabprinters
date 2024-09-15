<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize form inputs
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $name = filter_var(trim($_POST["name"]), FILTER_SANITIZE_STRING);
    $subject = filter_var(trim($_POST["subject"]), FILTER_SANITIZE_STRING);
    $message = filter_var(trim($_POST["message"]), FILTER_SANITIZE_STRING);

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format");
    }
    // Validate message
    if (empty($message)) {
        die("Message cannot be empty");
    }

    // Email details
    $to = "sales@labellabprinters.com"; // Replace with your email address
    $email_subject = "Contact Form Submission: $subject";
    $email_body = "You have received a new message from the contact form.\n\n";
    $email_body .= "Name: $name\n";
    $email_body .= "Email: $email\n";
    $email_body .= "Subject: $subject\n";
    $email_body .= "Message:\n$message\n";
    $headers = "From: $email\n";
    $headers .= "Reply-To: $email";

    // Send the email
    if (mail($to, $email_subject, $email_body, $headers)) {
        echo "Thank you for your message. It has been sent.";
    } else {
        echo "Sorry, something went wrong. Please try again later.";
    }
} else {
    // Not a POST request
    echo "Invalid request";
}
?>
