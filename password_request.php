<?php
//login.php

  $page_title = "Password request| GBV";
    $current_page = "Login";
	
require_once 'includes/global.inc.php';

$error = "";
$username = "";
$email = "";

//check to see if they've submitted the login form
if(isset($_POST['password_request'])) { 

	$username = $_POST['username'];
	$email = $_POST['email2'];
	
	if($username == "" || $email == ""){
	    $error = "Please provide username and email.";
	}else{
	    $userTools = new UserTools();
	    if($userTools->checkUsernameExists($username) && $userTools->checkEmailExists($email)){
	        //successful redirect them to a page
	        header("Location: index.php");
	        $to = "tamara7@uw.edu";
	        $subject = "Test";
	        $txt = "Test!";
	        $headers = "From: tamara7@uw.edu"; 
	        
	        mail($to,$subject,$txt,$headers);
	    }else{
	       // header("Location: index.php");
	        $to = "tamara7@uw.edu";
	        $subject = "Test";
	        $txt = "Test!";
	        $headers = "MIME-Version: 1.0" . "\r\n";
	        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
	        $headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";
	        $headers .= "From: <tamara7@uw.edu>";
	         
	        mail($to,$subject,$txt,$headers);
	        
	        $error = "Incorrect username and email. Please try again.";
	        
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
<div style="width:450px;float:left; color:red " align="left"><?php echo $error; ?></div><br clear="all">


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