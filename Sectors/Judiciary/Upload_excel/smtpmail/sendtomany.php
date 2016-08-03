<?php
include 'library.php'; // include the library file
include "classes/class.phpmailer.php"; // include the class name
$mail	= new PHPMailer; // call the class 
$mail->IsSMTP(); 
$mail->Host = SMTP_HOST; //Hostname of the mail server
$mail->Port = SMTP_PORT; //Port of the SMTP like to be 25, 80, 465 or 587
$mail->SMTPAuth = true; //Whether to use SMTP authentication
$mail->Username = SMTP_UNAME; //Username for SMTP authentication any valid email created in your domain
$mail->Password = SMTP_PWORD;
$mail->AddReplyTo("info@ardech.co.ke", "koech"); //reply-to address
$mail->SetFrom("info@ardech.co.ke", "Gbv System"); //From address of the mail
// put your while loop here like below,
$mail->Subject = "Your SMTP Mail"; //Subject od your mail
$recipients = array(
   'benardkkoech@gmail.com' => 'Benard',
   'info@hostnow.co.ke' => 'Koech'
);
foreach($recipients as $email => $name){
	// it will display the emails of all users in their Mailbox 'To' area. Simple multiple mail.
	$mail->AddAddress($email, $name); //To address who will receive this email
	$mail->msgHTML(file_get_contents('smtpmail/contents.html'), dirname(__FILE__)); //Put your body of the message you can place html code here
	$mail->AddAttachment('smtpmail/images/logo.jpg'); //Attach a file here if any or comment this line,  
	$send = $mail->Send(); //Send the mails
	// if you want to does not show other users email addresses like newsletter, daily, weekly, subscription emails means use the below line to clear previous email address
	$mail->ClearAddresses();
}
	if($send){
		echo '<center><h3 style="color:#009933;">Mail sent successfully</h3></center>';
	}
	else{
		echo '<center><h3 style="color:#FF3300;">Mail error: </h3></center>'.$mail->ErrorInfo;
	}
?>