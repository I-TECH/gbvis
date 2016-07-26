<?php 
//index.php
  $page_title = "Add Group | GBV";
    $current_page = "Add Group";
	


require_once 'includes/global.inc.php';


if(isset($_SESSION['logged_in'])) {

//get the user object from the session
$user = unserialize($_SESSION['user']);

//initialize php variables used in the form
$group_name = "";
$description = "";
$date_created = "";
$error = "";


//check to see that the form has been submitted
if(isset($_POST['submit-form'])) { 

	//retrieve the $_POST variables
	$date_created=date("Y-m-d");
	$group_name = $_POST['group_name'];
	$description = $_POST['description'];

	//initialize variables for form validation
	$success = true;
	$db = new DB();
	 
	 //validate that the form was filled out correctly
	//check to see if user name already exists
	
	if($success)
	{
	    //prep the data for saving in a new user object
	    $data['group_name'] = $group_name;
		 $data['description'] = $description;
		 $data['created'] = $date_created;
	
	    //create the new user object
	    $newUsergroup = new DB ($data);
	
	    //save the new user group to the database
	    
		$data = array(
				"group_name" => "'$group_name'",
				"description" => "'$description'",
				"created" => "'$date_created'"
		);
	    $id = $db->insert($data, 'user_groups');
	  
	   $error .= "Group Added successfully <br/> \n\r";
	}

}

//If the form wasn't submitted, or didn't validate
//then we show the registration form again

include "includes/header.php"; 
?>
	  <div id="sidebar">
	  <center><h3 style="text-size:18px;   font-family: TStar-Bol"></h3></center>
	<div class="sidebar-nav">
	<?php
	  include "includes/sidebar.php"; 
	  ?>
	</div> 
	  </div> 
	  <div id="main-content">
	    <div id="bread-crumbs">
	      <!--breadcrumbs-->
	    </div>
        <div id="content-body">
 <div class="profile-data" align="left">
	<?php echo ($error != "") ? $error : ""; ?>

	<h3 class="page-title">Add users Groups<h3>
	      
 <table class="forms-table" width="700" style="">
   <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<tr>
<td colspan="2" style="font:bold 21px arial; text-align:center; border-bottom:1px solid #eee; padding:5px 0 10px 0;">View User Group</td></tr>
</tr>
<tr>
<td colspan="2" style="font:bold 21px arial; text-align:center; border-bottom:1px solid #eee; padding:5px 0 10px 0;"><p id="msgDsp" STYLE="color:#FF0000; font-size:14px; "></p>
</td></tr>
</tr>
<tr>
<td width="50%" class="table-td-input">Group  Name</td>
<td width="50%" class="table-td-input"><div id='t1'><input type="text" name="group_name" id="lastname" value="<?php echo $group_name; ?>" readonly class=form_textbox_inputs></div></td>
</tr>
<tr>
<td width="50%" class="table-td-input">Description</td>
<td width="50%" class="table-td-input"><div id='t1'><input type="text" name="description" id="lastname" value="<?php echo $description; ?>" readonly  class=form_textbox_inputs></div></td>
</tr>
<tr>
<td class="table-td-label"></td>

<td width="50%" style=" padding:5px;">

<input type="submit" onClick="" value=Save name="submit-form" class="gbvis_general_button">
<input type="reset" name="Reset" id="" value="Reset" style="" class="gbvis_general_button">
</td>
</tr>
</form>
</table>
<br clear="all">
<hr size="1" color="#CCCCCC">

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