<?php 
//register.php
  $page_title = "Register  | GBV";
    $current_page = "Register";
	
require_once 'includes/global.inc.php';

//initialize php variables used in the form
$firstname = "";
$lastname = "";
$username = "";
$password = "";
$user_group= "";
$password_confirm = "";
$email = "";
$mobile_phone= "";
$sector = "";
$error = "";

//check to see that the form has been submitted
if(isset($_POST['submit-form'])) { 

	//retrieve the $_POST variables
	$username = $_POST['username'];
	$firstname = $_POST['firstname'];
	$lastname = $_POST['lastname'];
	$password = $_POST['password'];
	$password_confirm = $_POST['password-confirm'];
	$email = $_POST['email'];
	$mobile_phone = $_POST['mobile_phone'];
	$sector =8;
	$user_group =3;

	//initialize variables for form validation
	$success = true;
	$userTools = new UserTools();
	
	//validate that the form was filled out correctly
	//check to see if user name already exists
	if($userTools->checkUsernameExists($username))
	{
	    $error .= "That username is already taken.<br/> \n\r";
	    $success = false;
	}

	//check to see if passwords match
	if($password != $password_confirm) {
	    $error .= "Passwords do not match.<br/> \n\r";
	    $success = false;
	}

	if($success)
	{
	    //prep the data for saving in a new user object
		$data['firstname'] = $firstname;
		$data['lastname'] = $lastname;
	        $data['username'] = $username;
	        $data['password'] = md5($password); //encrypt the password for storage
	        $data['email'] = $email;
		$data['mobile_phone'] = $mobile_phone;
		$data['user_group'] = $user_group;
		$data['sector'] = $sector;
	
	    //create the new user object
	    $newUser = new User($data);
	
	    //save the new user to the database
	    $newUser->save(true);
	
	    //log them in
	    $userTools->login($username, $password);
	
	    //redirect them to a welcome page
	    header("Location: welcome.php");
	    
	}

}

//include "includes/login_header.php";
//If the form wasn't submitted, or didn't validate
//then we show the registration form again
include "includes/Dash_header.php"; //TA:60:1
include "includes/topbar.php"; //TA:60:1
?>
	  <center>
<div class="login_wrapper">

<br clear="all">
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<?php
if($error != "")
{
    echo $error."<br/>";
}
?>
<h2 align="center" style="margin-top:0px;">Create Account</h2><br />

<div class="labelsDiv">Your Name:</div>
<div class="inputsDiv">
First Name<input type="text" name="firstname" id="firstname" value="<?php echo $firstname;  ?>" required class="textInputs">
Last Name<input type="text" name="lastname" id="lastname" value="<?php echo $lastname; ?>" required class="textInputs"> 
</div><br clear="all"><br clear="all">

<div class="labelsDiv">Username:</div>
<div class="inputsDiv"><input type="text" name="username" id="username" value="<?php echo $username; ?>" required class="textInputs"></div><br clear="all"><br clear="all">

<div class="labelsDiv">Password:</div>
<div class="inputsDiv"><input type="password" name="password" id="password" value="<?php echo $password; ?>" required class="textInputs"></div><br clear="all"><br clear="all">

<div class="labelsDiv">Confirm Password:</div>
<div class="inputsDiv"><input type="password" name="password-confirm" id="password" value="<?php echo $password_confirm; ?>" required class="textInputs"></div><br clear="all"><br clear="all">

<div class="labelsDiv">Email:</div>
<div class="inputsDiv"><input type="email" name="email" id="email" value="<?php echo $email; ?>" required class="textInputs"></div><br clear="all"><br clear="all">

<div class="labelsDiv">Mobile Phone:</div>
<div class="inputsDiv"><input type="number" name="mobile_phone" id="mobile_phone" value="<?php echo $mobile_phone; ?>" required class="textInputs"></div><br clear="all"><br clear="all">


<div class="labelsDiv">&nbsp;</div>
<div class="inputsDiv">
<input type="submit" name="submit-form" id="" value="Create" style="margin-right:50px; width:38%" class="login_button">
<input type="reset" name="reset" id="" value="Reset" style="width:38%" class="login_button">


</div>
</form>
<br clear="all"><br clear="all">
<div style="width:450px;float:left;" align="center"><a href="login.php" style="text-decoration:none;" class="link">Back To Login</a></div><br clear="all">
<br clear="all"><br clear="all">
</div>
</center>
<!-- Code Ends -->
<br clear="all">

<p style="margin-bottom:180px;">&nbsp;</p>
</center>

<?php
 include "includes/footer.php"; 
 ?>
</body>
</html>