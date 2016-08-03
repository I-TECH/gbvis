<?php 
//register.php
  $page_title = "Add indicators| GBV";
    $current_page = "Add indicators";

require_once 'includes/global.inc.php';


if(isset($_SESSION['logged_in'])) {

//get the user object from the session
$user = unserialize($_SESSION['user']);
$sector=$user->sector;
//initialize php variables used in the form
$Logged_user =$user->username;
$user_sector_name = $user->sector;
$user_email=$user->email;
$Logged_user_group =$user->user_group;
$msg = "";
$indicator_id = "";
$sector = "";
$indicator= "";
$description = "";
$date_recorded = "";
$Added='';
 $id="";

//check to see that the form has been submitted
if(isset($_POST['submit-form'])) { 

	//retrieve the $_POST variables
	$date_recorded = date("Y-m-d");
	$indicator_name  = $_POST['indicator_name'];
	//initialize variables for form validation
	$success = true;
	$db = new DB();
	 
	 //validate that the form was filled out correctly
	//check to see if user name already exists
	
	if($success)
	{
	    //prep the data for saving in a new user object
	    $data['indicator_id'] = $id;
		 $data['indicator'] = $indicator_name;
		 $data['sector_id'] = $user_sector_name;
		  $data['date_recorded'] = $date_recorded;
		 
	
	    //create the new indicator object
	    $Jud_indicators = new DB ($data);
	
	    //save the new user group to the database
	    
		$data = array(
				"indicator_id" => "'$id'",
				"indicator" => "'$indicator_name'",
				"sector_id" => "'$user_sector_name'",
				"date_recorded"=> "'$date_recorded'"
				
		);
	    $id = $db->insert($data, 'indicators');
	  
	   $Added = true;
	}

}

//If the form wasn't submitted, or didn't validate
//then we show the registration form again

include "includes/Dash_header.php";include "includes/topbar.php"; //TA:60:1 
?>
	  <div id="sidebar">
	  <center><h3 style="text-size:18px;   font-family: TStar-Bol"></h3></center>
	<div class="sidebar-nav">
	<?php
	  include "includes/sidebar.php"; 
	  ?>
	</div> 
	  </div> 
	  <div id="main-content_with_side_bar">
	    <div id="bread-crumbs">
	      <!--breadcrumbs-->
	    </div>
        <div id="content-body">
		<h3 class="page-title">Add Indicator</h3>
	       
    <div class="profile-data" align="left">
	<?php echo ($msg != "") ? $msg : ""; ?>
	      
 <table class="forms-table" width="700" style="">

  <form action="#tab3" method="post" enctype="multipart/form-data">

<tr>
<td colspan="2" style="font:bold 21px arial; text-align:center; border-bottom:1px solid #eee; padding:5px 0 10px 0;">Add Indicators</td></tr>
</tr>
<tr>
<td width="50%" colspan="2" class="table-td-label"><center>New Indicator</center></td></tr>
<tr>
<td width="40%" class="table-td-label">Enter New Indicator</td>
<td width="60%" class="table-td-input"><textarea type="text" name="indicator_name" id="indicator_name" style="height:50px;" class="form_textbox_inputs"></textarea></td>
</tr>
<tr>
<td class="table-td-label"></td>
<td width="50%" style=" padding:5px;"><input type="submit" name="submit-form" value="SAVE" class="gbvis_general_button" /></td>
</tr>
</form>

</table>
<br clear="all">
<hr size="1" color="#CCCCCC">
<br clear="all"><br clear="all"><br clear="all">
<?php
 if($Added){
echo "<script type='text/javascript'>alert('Record Added successfully!')</script>";
}
?>
</div>
<br clear="all">
</div> 		
</div> 	
 <?php
 include "includes/footer.php"; 
	}
else
{
	//Redirect user back to login page if there is no valid session created
	header("Location: ../../login.php");
}
?>