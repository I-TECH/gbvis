<?php
//TA:60:4
$page_title = "Enter Data | GBV";
$current_page = "home";

require_once 'includes/global.inc.php';

// check to see if they're logged in
if (isset ( $_SESSION ['logged_in'] )) {
	
	// get the user object from the session
	$user = unserialize ( $_SESSION ['user'] );
	
	if( !($userTools->isAdmin($user->user_group))){
	    print " You do not have permission to access this page.";
	    return;
	}
	
	// include "includes/Dash_header.php";include "includes/topbar.php"; //TA:60:1
	include "includes/Dash_header.php"; // TA:60:1
	include "includes/topbar.php"; // TA:60:1
	                                  
	// TA:60:1
	//$db = new DB ();
	
	$sectors = $db->selectAllOrdered ( "sectors", "sector");
	
	?>
	
	<script type="text/javascript">

	function validate(title, value){
		  if(value == undefined || value == ""){
          alert("Please select " + title);
          return false;
      }
      return true;
	  }

	function enter_data(){
		var sector_type_id = $( "#sector_type_id" ).val();
		var data_entry_type = $( "#data_entry_type" ).val();

       if(validate("sector", sector_type_id)){
           if(data_entry_type == 'data_entry_manul'){
        	   if(sector_type_id == '1'){
               	     window.location.href = "Sectors/Judiciary";    
        	   }else if(sector_type_id == '2'){
                   window.location.href = "Sectors/Health";
               }else if(sector_type_id == '3'){
                   window.location.href = "Sectors/Police";
               }else if(sector_type_id == '4'){
                   window.location.href = "Sectors/Prosecution";
               }else if(sector_type_id == '5'){
                   window.location.href = "Sectors/Education";
               }else{
                   alert("You cannot be redirected to selected sector.");
               }
           }else if(data_entry_type == 'data_entry_excel'){
        	   if(sector_type_id == '1'){
           	     window.location.href = "Sectors/Judiciary/import_excel.php";    
    	   }else if(sector_type_id == '2'){
               window.location.href = "Sectors/Health/import_excel.php";
           }else if(sector_type_id == '3'){
               window.location.href = "Sectors/Police/import_excel.php";
           }else if(sector_type_id == '4'){
               window.location.href = "Sectors/Prosecution/import_excel.php";
           }else if(sector_type_id == '5'){
               window.location.href = "Sectors/Education/import_excel.php";
           }else{
               alert("You cannot be redirected to selected sector.");
           }
           }else{
        	   alert("You cannot be redirected to selected data entry type.");
           }
    	   
       }
	}
	</script>
<!-- TA:60:1 <div id="sidebar">
	 
	 <div class="sidebar-nav">
	<?php
	// include "../includes/sidebar.php";
	?>
	</div> 
	  </div> -->



<div id="main-content_with_side_bar">

	<div id="content-body">
		<!--  <center>
			<h2 class="page-title">Welcome to the National Sexual Gender Violence
				Information System (GBVIS)</h2>
		</center>-->
		<!-- TA:60:1 -->

		<div class="profile-data" align="left">

			<!-- TA:60:1 START -->
		

							<br clear="all">
							<table width="30%" border="0" align="left" cellspacing="10">
								<tr>
									<td><select id="sector_type_id" name="sector_type_id" class="gbvis_select" title="Select Sector" onchange="getReportTypesList();">
											<?php
											
	foreach ( $sectors as $urows ) {
	    $disable = " disabled ";
	    if($userTools->isAdmin($user->user_group) && $urows ['0'] === $user->sector){
	        $disable = "";
	    }  
	    if(!$disable) {
		  echo "<option value='" . $urows ['0'] . "' " . $disable . " >" . ucfirst($urows ['1']) . "</option>";
	    }
	}
	?>
									</select></td>
								</tr>
								
								<tr>
									<td><br><select id="data_entry_type" name="data_entry_type" class="gbvis_select" title="Select Sector" onchange="getReportTypesList();">
											<option value="data_entry_manul" selected>Manual data entry</option>
											<option value="data_entry_excel">Excel upload</option>
									</select></td>
								</tr>
								
								
								<tr>
									<td><br><button type="button" class="submit_button"
											onClick='enter_data();'>Enter data</button></td>
								</tr>
							</table>
						

			<!-- TA:60:1 END -->


			<!-- TA:60:1 <a href="stardard_reports.php" style="float:left; width:25%; height:100px;  margin-right:15px; text-decoration:none;" title="Standard Reports" >
				 <p>Standard Reports</p>  <p><img src="images/reports.jpeg" height="70" /></p>
				</a>
				<a href="analytical_reports.php" style="float:left; width:25%; height:100px;  margin-right:15px; text-decoration:none;" >
				  <p>Analytical Reports</p><p><img src="images/analytical.jpeg" height="70" title="Analytical Reports" /></p> 
				</a>-->

			<br clear="all"> <br clear="all">
			<br clear="all">
			<br clear="all">
			<!--&nbsp;Your MD5 encrypted password: <font color="white"><?php //echo $passwd; ?></font>-->


			<br clear="all">
			<br clear="all">
			<br clear="all"> <br clear="all">
			<br clear="all">
			<br clear="all">
		</div>
		<br clear="all">
		</center>
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