<?php
//login.php

  $page_title = "Password request| GBV";
    $current_page = "Login";
	
require_once 'includes/global.inc.php';
include "Data_uploadandapproval/smtpmail/classes/class.phpmailer.php"; // include the class name
$msg = "";
$username = "";
$email = "";

//check to see if they've submitted the login form
if(isset($_POST['password_request'])) { 

	$username = $_POST['username'];
	$email = $_POST['email2'];
	
	if($username == "" || $email == ""){
		$msg = "<div class='alert alert-warning'>
     <button class='close' data-dismiss='alert'>&times;</button>
     Please provide username and email.
      </div>";
	}else{
	    $userTools = new UserTools();
	    $token = uniqid($email);
	    if($userTools->checkUsernameExists($username) && $userTools->checkEmailExists($email) && $userTools->set_reset_password_token($email, $username, $token)){
	    	
	        //successful redirect them to a page
	        	        
		$mail = new PHPMailer(); // create a new object
		$mail->IsSMTP(); // enable SMTP
		$mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
		$mail->SMTPAuth = true; // authentication enabled
		$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
		$mail->Host = "smtp.gmail.com";
		$mail->Port = 465; // or 587
		$mail->IsHTML(true);
		$mail->Username = "norbertglen7@gmail.com";
		$mail->Password = "ldirdkmehmfdatgw";
		$mail->SetFrom("sgbvis@ngeckenya.org");
		$mail->Subject = "KenyaSGBVIS Account Password Recovery";
		$mail->Body = "<b>Hi, You recently requested to change your KenyaSGBVIS account password. Please follow the following link to reset password. <br/><br/> <a href='http://localhost/KenyaGBV/password_change.php?token=".$token."'>Click here</a></b>";
		$mail->AddAddress("norbertglen7@gmail.com");
	if(!$mail->Send()){
		$msg = "<div class='alert alert-warning'>
     <button class='close' data-dismiss='alert'>&times;</button>
     ".$mail->ErrorInfo."
      </div>";
	}
	else{
		$msg = "<div class='alert alert-success'>
     <button class='close right' data-dismiss='alert'>&times;</button><br>
     We've sent an email to $email.
                    Please click on the password reset link in the email to generate new password. 
      </div>";
	}
	        //header("Location: index.php");
	    }else{
	       // header("Location: index.php");
	        $to = "norbertglen7@yahoo.com";
	        $subject = "Password Recovery Attempt";
	        $txt = "There has been a password recovery attempt by".$email;
	        $headers = "MIME-Version: 1.0" . "\r\n";
	        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
	        $headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";
	        $headers .= "From: <norbertglen7@yahoo.com>";
	         
	        mail($to,$subject,$txt,$headers);
	        
	        $msg = "<div class='alert alert-warning'>
     <button class='close right' data-dismiss='alert'>&times;</button>
     Incorrect username and email. Please try again.
      </div>";
	        
	    }
	}
}
include "includes/Dash_header.php"; //TA:60:1
?> 
<!-- Code Begins -->
<center>
<div class="login_wrapper">

<br clear="all">
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<div class="message"><?php echo $msg; ?></div>


<h4 style="margin-top:0px;">Please provide us with following information</h4><br />

<div class="labelsDiv">Username:</div>
<div class="inputsDiv"><input type="text" name="username" id="username" value="" class="textInputs"></div><br clear="all"><br clear="all">
<div class="labelsDiv">Email:</div>
<div class="inputsDiv"><input type="text" name="email2" id="email2" value="" class="textInputs"></div><br clear="all"><br clear="all">

<div class="labelsDiv">&nbsp;</div>
<div class="inputsDiv">
<input type="submit" name="password_request" id="" value="Submit" style="margin-right:50px; width:38%" class="login_button">
<input type="reset" name="reset" id="" value="Reset" style="width:38%" class="login_button">


</div>
</form>
<br clear="all"><br clear="all">
 


</div>
</center>
<!-- Code Ends -->

<!-- TA:60:1 -->
<?php include "includes/footer.php";?>
 

</center>
</body>
</html>
