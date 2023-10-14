<?php
if (isset($_POST['submit'])) {
$name = $_POST['name'];
$subject = $_POST['subject'];
$email = $_POST['Email'];
$message = $_POST['message'];

$mailto = "103068001@student.swin.edu.au";
$headers = "From: ".$email;


mail($mailto, $subject, $message, $headers);

echo"Message Sent!";
//header("location: dashboard.php?mailsent");
}


?>
