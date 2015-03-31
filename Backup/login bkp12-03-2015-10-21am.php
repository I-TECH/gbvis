<?php
//login.php

  $page_title = "Login| GBV";
    $current_page = "Login";
	
require_once 'includes/global.inc.php';

$error = "";
$username = "";
$password = "";

//check to see if they've submitted the login form
if(isset($_POST['submit-login'])) { 

	$username = $_POST['username'];
	$password = $_POST['password'];

	$userTools = new UserTools();
  
	
	if($userTools->login($username, $password)){ 
		//successful login, redirect them to a page
		
		if($userTools->health($user->sector)){
		
		header("Location: health.php");
		}
		else  if($userTools->judiciary($user->sector)) 
		{
		
		header("Location: judiciary.php");
		
		}
		else if($userTools->prosection($user->sector)) 
		{
		
		header("Location: prosecution.php");
		
		}
		else if($userTools->ngec($user->sector)) {
		
		   header("Location: dashboard.php");
		}
	}
	else{
		$error = "Incorrect username or password. Please try again.";
	}
}
include "includes/login_header.php";
?> 
<!-- Code Begins -->
<center>
<div class="login_wrapper">

<br clear="all">
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<div style="width:450px;float:left; color:red " align="left"><?php echo $error; ?></div><br clear="all">

<h2 align="center" style="margin-top:0px;">Users Login</h2><br />
<div class="labelsDiv">Username:</div>
<div class="inputsDiv"><input type="text" name="username" id="username" value="" class="textInputs"></div><br clear="all"><br clear="all">


<div class="labelsDiv">Password:</div>
<div class="inputsDiv"><input type="password" name="password" id="password" value="" class="textInputs"></div><br clear="all"><br clear="all">


<div class="labelsDiv">&nbsp;</div>
<div class="inputsDiv">
<input type="submit" name="submit-login" id="" value="Login" style="margin-right:50px; width:38%" class="login_button">
<input type="reset" name="reset" id="" value="Reset" style="width:38%" class="login_button">


</div>
</form>
<br clear="all"><br clear="all">
<div style="width:450px;float:left;" align="center"><a href="" style="text-decoration:none;" class="link">Forgot Password?</a></div><br clear="all">


</div>
</center>
<!-- Code Ends -->
<br clear="all">

<p style="margin-bottom:180px;">&nbsp;</p>
</center>
</body>
</html>