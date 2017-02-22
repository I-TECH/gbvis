<?php 
//add_Indicato.php
  $page_title = "Add Indicator | GBV";
    $current_page = "Add Indicator";
	

require_once 'includes/global.inc.php';
require_once('classes/dropdown.class.php');

if(isset($_SESSION['logged_in'])) {

//get the user object from the session
$user = unserialize($_SESSION['user']);
$sector=$user->sector;
//initialize php variables used in the form

$msg = "";
$id = "";
$sector = "";
$indicator_name= "";
$description = "";
$date_recorded = "";


//check to see that the form has been submitted
if(isset($_POST['submit-form'])) { 

	//retrieve the $_POST variables
	$date_recorded = date("Y-m-d");
	$indicator_name  =$_POST['indicator_name'];
	$sector  = $_POST['sector'];
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
		 $data['sector_id'] = $sector;
		  $data['date_recorded'] = $date_recorded;
		 
	
	    //create the new indicator object
	    $Jud_indicators = new DB ($data);
	
	    //save the new user group to the database
	    
		$data = array(
				"indicator_id" => "'$id'",
				"indicator" => "'$indicator_name'",
				"sector_id" => "'$sector'",
				"date_recorded"=> "'$date_recorded'"
				
		);
	    $id = $db->insert($data, 'indicators');
	  
	   $msg .= "Record added successfully <br/> \n\r";
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
	
	      
 <table class="forms-table" width="700" style="">
<div><?php echo  $msg; ?></div>
  <form action="#tab3" method="post" enctype="multipart/form-data">

<tr>
<td colspan="2" style="font:bold 21px arial; text-align:center; border-bottom:1px solid #eee; padding:5px 0 10px 0;">Add Indicators</td></tr>
</tr>
<tr>
<td width="50%" class="table-td-input">Sector</td>
<?php

$ddl=new dropdown();

?>
<td width="50%" class="table-td-input"><div id='s2'><?php $ddl->dropdown('sectors'); ?></div></td>
</tr>
<tr>
<td width="50%" class="table-td-input">Indicator</td>
<td width="50%" class="table-td-input"><textarea type="text" name="indicator_name" id="indicator_name" style="height:50px;" class="form_textbox_inputs" required></textarea></td>
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
	header("Location: login.php");
}
?>