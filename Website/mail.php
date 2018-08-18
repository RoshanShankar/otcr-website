<?php
$name = $_POST['name'];
$email = $_POST['email'];
$message = $_POST['message'];
$recipient = "rishabh3@illinois.edu";
$subject = $_POST['subject']
$mailheader = "From: $email \r\n";
mail($recipient, $subject, $message, $mailheader) or die("Error!");
echo "Thank You!" . " -" . "<a href='form.html' style='text-decoration:none;color:#ff0099;'> Return Home</a>";
?>
