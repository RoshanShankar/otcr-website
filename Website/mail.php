<?php
$name = $_POST['name'];
$email = $_POST['email'];
$message = $_POST['message'];
$recipient = "rishabh3@illinois.edu";
$subject = $_POST['subject'];
$mailheader = "From: $email \r\n";
mail($recipient, $subject, $message, $mailheader) or die("Error!");
ob_start();
    echo '
    <script type="text/javascript">
    alert("Thank you for your message, we will get back to you as quickly as possible!");
    window.location = "http://otcr.illinois.edu/";
    </script>';
    ob_end_flush();
?>
