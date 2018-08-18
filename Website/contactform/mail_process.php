<?php
$myemail = 'rishabh3@illinois.edu';
$name = $_POST['name'];
$email_address = $_POST['email'];
$message = $_POST['message'];
$to = $myemail;
$email_subject = "From ".$name. "; Email: ".$email_address;
$email_body = "$message";
$mailheader = "From: $email_address \r\n";
mail($to, $email_subject, $message, $mailheader) or die("Error!");
echo "Thank You!" . " -" . "<a href='index.html' style='text-decoration:none;color:#ff0099;'> Return Home</a>";?>
