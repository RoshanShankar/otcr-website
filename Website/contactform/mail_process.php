<?php
$myemail = '';
$name = $_POST['name'];
$email_address = $_POST['email'];
$message = $_POST['message'];
$to = $myemail;
$email_subject = "From ".$name. "; Email: ".$email_address;
$email_body = "$message";
mail($to,$email_subject,$email_body);
ob_start();
echo '
<script type="text/javascript">
alert("Email sent! We will get back to you as soon as possible.");
window.location = "http://otcr.illinois.edu/";
</script>';
ob_end_flush();
exit;
?>
