<?php 
//index.php
  $page_title = "Create Users | GBV";
    $current_page = "Create Users";
	


require_once 'includes/global.inc.php';
require_once('classes/dropdown.class.php');

if(isset($_SESSION['logged_in'])) {

//get the user object from the session
$user = unserialize($_SESSION['user']);

//initialize php variables used in the form
$lastname ="";
$username = "";
$password = "";
$user_group= "";
$password_confirm = "";
$email = "";
$error = "";
$NewUsersaved =false;

//check to see that the form has been submitted
if(isset($_POST['submit-form'])) { 

	//retrieve the $_POST variables
	$date_created=date("Y-m-d");
	$username = $_POST['username'];
	$firstname = $_POST['firstname'];
	$lastname = $_POST['lastname'];
	$user_group = $_POST['user_group'];
	$sector = $_POST['sector'];
	$password = $_POST['password'];
	$password_confirm = $_POST['password-confirm'];
	$email = $_POST['email'];
	$mobile_phone = $_POST['mobile_phone'];
	
	//initialize variables for form validation
	$success = true;
	$userTools = new UserTools();
	
	//validate that the form was filled out correctly
	//check to see if user name already exists
	if($userTools->checkUsernameExists($username))
	{
	    $error .= "That username is already taken.";
	    $success = false;
	}

	//check to see if passwords match
	if($password != $password_confirm) {
	    $error .= "Passwords do not match.";
	    
	    $success = false;
	}
       
	if($success){
	    //prep the data for saving in a new user object
	    $data['firstname'] = $firstname;
	    $data['lastname'] = $lastname;
	    $data['username'] = $username;
	    $data['user_group'] = $user_group;
	    $data['password'] = md5($password); //encrypt the password for storage
	    $data['email'] = $email;
	    $data['sector'] = $sector;
	    $data['join_date'] = $date_created;
	    $data['mobile_phon'] = $mobile_phone;
	
	    //create the new user object
	    $newUser = new User($data);
	
	    //save the new user to the database
	    $newUser->save(true);
	    echo "<script type='text/javascript'>alert('New user added successfully!')</script>";    
	}else{
	   echo "<script type='text/javascript'>alert('" . $error . "')</script>";
	}
      
}

 
	  include "includes/Dash_header.php"; // TA:60:1
	  include "includes/topbar.php"; // TA:60:1
?>

<script type="text/javascript">
function validate(){
	if(document.forms["form"]["firstname"].value == ''){
		alert("First Name is required.");
		return false;
	}
	if(document.forms["form"]["lastname"].value == ''){
		alert("Last Name is required.");
		return false;
	}
	if(document.forms["form"]["username"].value == ''){
		alert("User name is required.");
		return false;
	}
	var email = document.forms["form"]["email"].value;
	if(email == ''){
		alert("Email is required.");
		return false;
	}else{
		var atpos = email.indexOf("@");
	    var dotpos = email.lastIndexOf(".");
	    if (atpos<1 || dotpos<atpos+2 || dotpos+2>=email.length) {
	        alert("Not a valid e-mail address");
	        return false;
	    }
	}
	if(document.forms["form"]["password"].value == ''){
		alert("Password is required.");
		return false;
	}
	if(document.forms["form"]["password"].value != document.forms["form"]["password-confirm"].value){
		alert("Passwords do not match.");
		return false;
	}
	return true;
}

function isNumberKey(e){
    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
              return false;
   }
}
</script>

	  <div id="sidebar">
	  
	<div class="sidebar-nav">
	<?php
	  include "includes/sidebar.php"; 
	  
	  ?>
	</div> 
	  </div> 
	  <div id="main-content_with_side_bar">
	    
        <div id="content-body">
		
  <div class="profile-data" align="left">

  <form name="form" onsubmit="return validate();" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" >
<table width="700" style="">
   
<tr>
<td colspan="2" style="font:bold 21px arial; text-align:center; border-bottom:1px solid #eee; padding:5px 0 10px 0;">Add User</td></tr>
</tr>
<tr>
<td colspan="2" style="font:bold 21px arial; text-align:center; border-bottom:1px solid #eee; padding:5px 0 10px 0;"><p id="msgDsp" STYLE="color:#FF0000; font-size:14px; "></p>
</td></tr>
</tr>
<tr>
<td width="50%" class="table-td-input">First Name</td>
<td width="50%" class="table-td-input"><div id='t1'><input type="text" name="firstname" id="firstname" value="<?php echo $firstname; ?>" class=form_textbox_inputs></div></td>
</tr>
<tr>
<td width="50%" class="table-td-input">Last Name</td>
<td width="50%" class="table-td-input"><div id='t1'><input type="text" name="lastname" id="lastname" value="<?php echo $lastname; ?>" class=form_textbox_inputs></div></td>
</tr>
<tr>
<td width="50%" class="table-td-input">User name</td>
<td width="50%" class="table-td-input"><div id='t1'><input type="text" name="username" id="username" value="<?php echo $username; ?>" class=form_textbox_inputs></div></td>
</tr>
<tr>
<td width="50%" class="table-td-input">Email</td>
<td width="50%" class="table-td-input"><div id='t1'><input type="text" name="email" id="email" value="<?php echo $email; ?>" class=form_textbox_inputs></div></td>
</tr>
<tr>
<td width="50%" class="table-td-input">Mobile Phone No</td>
<td width="50%" class="table-td-input"><div id='t1'><input type="text" onkeypress='return isNumberKey(event)' name="mobile_phone" id="mobile_phone" value="<?php echo $mobile_phone; ?>" class=form_textbox_inputs></div></td>
</tr>
<tr>
<td width="50%" class="table-td-input">User group</td>
<?php


$ddl=new dropdown();

?>
<td width="50%" class="table-td-input"><div id='s2'><?php $ddl->dropdown('user_groups'); ?></div></td>
</tr>
<tr>
<td width="50%" class="table-td-input">Sectors</td>
<?php


$ddl=new dropdown();

?>
<td width="50%" class="table-td-input"><div id='s3'><?php $ddl->dropdown('sectors'); ?></div></td>
</tr>
<tr>
<td width="50%" class="table-td-input">Password</td>
<td width="50%" class="table-td-input"><div id='t1'><input type="password" name="password" id="password" value="<?php echo $password; ?>" class="form_textbox_inputs"></div></td>
</tr>
<tr>
<td width="50%" class="table-td-input">Confirm password</td>
<td width="50%" class="table-td-input"><div id='t1'><input type="password" name="password-confirm" id="password-confirm" value="<?php echo $password_confirm; ?>" class="form_textbox_inputs"></div></td>
</tr>
<tr>
<td class="table-td-label"></td>

<td width="50%" style=" padding:5px;">

<input type="submit" onClick="" value=Save name="submit-form" class="gbvis_general_button">
<input type="reset" name="Reset" id="" value="Reset" style="" class="gbvis_general_button">
</td>
</tr>
</table>
</form>


<br clear="all">
<br clear="all">
</div><br clear="all">

	    </div> 		
	  </div> 	
 <?php
 include "includes/footer.php"; 
	}
else
{
	//Redirect user back to login page if there is no valid session created
	header("Location: login.php");
}
?>