<?php 

if(isset($_POST['submit-form'])) { 

	//retrieve the $_POST variables
	$date_created=date("Y-m-d");
	$aggregate = $_POST['aggregates'];
	$aggregate_id = $_POST['aggregate_id'];
	

	//initialize variables for form validation
	$success = true;
	$db = new DB();
	
	
	if($success)
	{
	    //prep the data for saving in a new user object
	    $data['aggregate'] = $aggregate;
	    //$data['created'] = $date_created;
	
	    //create the new user object
	    $newUsergroup = new DB ($data);
	
	    //save the new user group to the database
	    
		$data = array(
		"aggregate" => "'$aggregate'",
				//"created" => "'$date_created'"
		);
	    $id = $db->update($data, "judiciary_aggregates","id = $aggregate_id");
	  
	   $msg .= "Group Added successfully <br/> \n\r";
	}

}
//check to see that the form has been submitted

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
		<h3 class="page-title">Edit Aggregates</h3>
	       <hr size="1" color="#CCCCCC">
    <div class="profile-data" align="left">
	<?php echo ($msg != "") ? $msg : ""; ?>
	      
 <table class="forms-table" width="700" style="">
  <form  name="myForm">
  

<tr>
<td colspan="2" style="font:bold 21px arial; text-align:center; border-bottom:1px solid #eee; padding:5px 0 10px 0;">Edit Aggregates</td></tr>
</tr>
<tr>
<td colspan="2" style="font:bold 21px arial; text-align:center; border-bottom:1px solid #eee; padding:5px 0 10px 0;"><p id="msgDsp" STYLE="color:#FF0000; font-size:14px; "></p>
</td></tr>
</tr>
<tr>
<td width="50%" class="table-td-input">Counties</td>
<td width="50%" class="table-td-input"><div id='s1'><input type=text name=aggregates value="<?php echo $county_name ?>" readonly class=form_textbox_inputs></div></td>
</tr>
<tr>
<td width="50%" class="table-td-input">Survey Period</td>
<td width="50%" class="table-td-input"><div id='s2'><input type=text name=survey  value="<?php echo $survey ?>" readonly class=form_textbox_inputs></div></td>
</tr>
<tr>
<td width="50%" class="table-td-input">Indicator</td>

<td width="50%" class="table-td-input"><div id='s3'><div id='t1'><input type=text name=indicator value="<?php echo $indicator ?>"  readonly class=form_textbox_inputs></div></td>
</tr>
<tr>
<td width="50%" class="table-td-input">Aggregates</td>
<td width="50%" class="table-td-input"><div id='t1'><input type=text name=aggregates value="<?php echo $aggregates ?>" class=form_textbox_inputs></div></td>
</tr>
<tr>
<td class="table-td-label"></td>

<td width="50%" style=" padding:5px;"><input type=submit name="submit-form" value=Update class=gbvis_general_button></td>
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
	header("Location: ../login.php");
}
?>