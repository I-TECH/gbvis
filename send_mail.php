<?php


  $page_title = "Send Email | GBV";
    $current_page = "DSend Email";
	
require 'PHPMailer/PHPMailerAutoload.php';

$mail = new PHPMailer;

$mail->isSMTP(); 
$mail->Host = 'smtp.gmail.com'; 
$mail->Mailer = "smtp";
$mail->SMTPAuth = true;
$mail->Username = 'benardkkoech@gmail.com';
$mail->Password = '3271koech';
$mail->SMTPSecure = 'ssl';
$mail->Port = 25;  

$mail->From = 'benardkkoech@gmail.com';
$mail->FromName = 'Koech';
$mail->addAddress('benardkkoech@gmail.com');

$mail->isHTML(true);

$mail->Subject = 'Test Mail Subject!';
$mail->Body    = 'This is SMTP Email Test';

if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
 } else {
    echo 'Message has been sent';
}
?>
