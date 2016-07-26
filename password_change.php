<?php
//login.php

  $page_title = "Password change| GBV";
    $current_page = "Login";
	
require_once 'includes/global.inc.php';
$token = $_GET['token'];
$userTools = new UserTools();
$error = ($userTools->checkPasswordRecoveryTokenExists($token)) ? "" : "Invalid token" ;
//check to see if they've submitted the login form
if(isset($_POST['password_change'])) { 

	
	$new_password = $_POST['password'];
	$token = $_POST['token'];
	if($token == ""){
	    $error = "Invalid token";
	}else{
	    
	    if($userTools->checkPasswordRecoveryTokenExists($token)){
	    $userTools->update_user_password($token, $new_password);
	    header("Location: login.php");
	    }else{
	       $error = "Password change failed. The token may be expired";
	        
	    }
	}
}
include "includes/Dash_header.php"; //TA:60:1
?> 
<script type="text/javascript">
	function validate(){
		if($('#password').val() == ''){
		alert("Password is required.");
		return false;
	}
	if($('#password').val() != $('#password-confirm').val()){
		alert("Passwords do not match.");
		return false;
	}
	return true;
}
</script>
<!-- Code Begins -->
<center>
<div class="login_wrapper">

<br clear="all">
<div style="width:450px;float:left; color:red " align="left"><?php echo $error; ?></div>
<div style="width:450px;float:left; color:green " align="left"><?php echo $info; ?></div>
<?php if ($userTools->checkPasswordRecoveryTokenExists($token)) {
	# code...
?>
<form method="post" onsubmit="return validate();" action="<?php echo $_SERVER['PHP_SELF']; ?>">


<h4 style="margin-top:0px;">Please provide us with following information</h4><br />

<div class="labelsDiv">New Password:</div>
<div class="inputsDiv"><input type="password" name="password" id="password" value="" class="textInputs"></div><br clear="all"><br clear="all">
<div class="labelsDiv">Confirm Password:</div>
<div class="inputsDiv"><input type="password" name="password-confirm" id="password-confirm" value="" class="textInputs"></div><br clear="all"><br clear="all">
<input type="hidden" name="token" id="token" value="<?php echo $token; ?>" class="textInputs">
<div class="labelsDiv">&nbsp;</div>
<div class="inputsDiv">
<input type="submit" name="password_change" id="" value="Submit" style="margin-right:50px; width:38%" class="login_button">
<input type="reset" name="reset" id="" value="Reset" style="width:38%" class="login_button">


</div>
</form>
<?php } ?>
<br clear="all"><br clear="all">
 


</div>
</center>
<!-- Code Ends -->

<!-- TA:60:1 -->
<?php include "includes/footer.php";?>
 

</center>
</body>
</html>