<?php
//TA:60:4
$page_title = "Export Data | GBV";
$current_page = "home";

require_once 'includes/global.inc.php';

// check to see if they're logged in
if (isset ( $_SESSION ['logged_in'] )) {
	
	// get the user object from the session
	$user = unserialize ( $_SESSION ['user'] );
	
// 	if( !($userTools->isAdmin($user->user_group))){
// 	    print " You do not have permission to access this page.";
// 	    return;
// 	}
	
	// include "includes/Dash_header.php";include "includes/topbar.php"; //TA:60:1
	include "includes/Dash_header.php"; // TA:60:1
	include "includes/topbar.php"; // TA:60:1
	                                  
	// TA:60:1
	//$db = new DB ();
	
	$sectors = $db->selectAllOrdered ( "sectors", "sector");
	
	?>
	
	<!-- TA:60:1 date picker libs -->
<link rel="stylesheet"
	href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script> <!-- for calrendar picker -->
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script> <!-- for calrendar picker -->
	
	<script type="text/javascript">

	$(function() {
		$('#fromdate').datepicker({
		     changeMonth: true,
		     changeYear: true,
		     dateFormat: 'mm/yy',
		     showButtonPanel: true,

		     onClose: function() {
		        var iMonth = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
		        var iYear = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
		        $(this).datepicker('setDate', new Date(iYear, iMonth, 1));
		     },

		     beforeShow: function() {
		       if ((selDate = $(this).val()).length > 0) 
		       {
		          iYear = selDate.substring(selDate.length - 4, selDate.length);
		          iMonth = jQuery.inArray(selDate.substring(0, selDate.length - 5), 
		                   $(this).datepicker('option', 'monthNames'));
		          $(this).datepicker('option', 'defaultDate', new Date(iYear, iMonth, 1));
		          $(this).datepicker('setDate', new Date(iYear, iMonth, 1));
		       }
		    }
		  });

	  });

	$(function() {
		$('#todate').datepicker({
		     changeMonth: true,
		     changeYear: true,
		     dateFormat: 'mm/yy',
		     showButtonPanel: true,

		     onClose: function() {
		        var iMonth = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
		        var iYear = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
		        $(this).datepicker('setDate', new Date(iYear, iMonth, 1));
		     },

		     beforeShow: function() {
		       if ((selDate = $(this).val()).length > 0) 
		       {
		          iYear = selDate.substring(selDate.length - 4, selDate.length);
		          iMonth = jQuery.inArray(selDate.substring(0, selDate.length - 5), 
		                   $(this).datepicker('option', 'monthNames'));
		          $(this).datepicker('option', 'defaultDate', new Date(iYear, iMonth, 1));
		          $(this).datepicker('setDate', new Date(iYear, iMonth, 1));
		       }
		    }
		  });
	  });

	function validate(title, value){
		  if(value == undefined || value == ""){
          alert("Please select " + title);
          return false;
      }
      return true;
	  }

	function validateDates(from_date, to_date){
		  if(validate("From Date", from_date) && validate("To Date", to_date)){
			  var from_date_arr = from_date.split("/");
			  var to_date_arr = to_date.split("/");
			  var from_date_new = from_date_arr[1] + from_date_arr[0];
			  var to_date_new = to_date_arr[1] + to_date_arr[0];
			  if(from_date_new > to_date_new){
				  alert(from_date_new + ">" + to_date_new);
				  alert("'From Date' must be less than 'To Date'.");
				  return false;
			  }
			  return true;
		  }else{
			  return false;
		  }
	  }

	function export_data(){
		var sector_type_id = $( "#sector_type_id" ).val();
		var indicator = $( "#indicator" ).val();
		 var from_date = $( "#fromdate" ).val();
         var to_date = $( "#todate" ).val();

       if(validate("sector", sector_type_id) && validate("indicator", indicator) && validateDates(from_date, to_date)){   
        	   if(sector_type_id == '1'){
           	     window.location.href = "Sectors/Judiciary/export_data.php?mode=export_csv&indicator=" + indicator + "&start_date=" + from_date + "&end_date=" + to_date;    
    	   }else if(sector_type_id == '2'){
               window.location.href = "Sectors/Health/export_data.php?mode=export_csv&indicator=" + indicator + "&start_date=" + from_date + "&end_date=" + to_date;
           }else if(sector_type_id == '3'){
               window.location.href = "Sectors/Police/export_data.php?mode=export_csv&indicator=" + indicator + "&start_date=" + from_date + "&end_date=" + to_date;
           }else if(sector_type_id == '4'){
               window.location.href = "Sectors/Prosecution/export_data.php?mode=export_csv&indicator=" + indicator + "&start_date=" + from_date + "&end_date=" + to_date;
           }else if(sector_type_id == '5'){
               window.location.href = "Sectors/Education/export_data.php?mode=export_csv&indicator=" + indicator + "&start_date=" + from_date + "&end_date=" + to_date;
           }else{
               alert("You cannot be redirected to selected sector.");
           }
          
    	   
       }
	}

	function getReportTypesList(){
		  var sel_sector_id = $( "#sector_type_id :selected" ).val(); 
		  $("#indicator option").remove();
		  $('#indicator').append($("<option></option>").attr("value","").text("-- Select Indicator --"));
		  if($('#sector_type_id').val() == 1){
			  $('#indicator').append($("<option></option>").attr("value","7.1-7.4").text("Indicators 7.1-7.4"));
		}else if($('#sector_type_id').val() == 2){
			$('#indicator').append($("<option></option>").attr("value","4.1").text("Indicator 4.1"));
			$('#indicator').append($("<option></option>").attr("value","4.2").text("Indicator 4.2"));
			$('#indicator').append($("<option></option>").attr("value","4.3-4.6").text("Indicators 4.3-4.6"));
		}else if($('#sector_type_id').val() == 3){
			$('#indicator').append($("<option></option>").attr("value","5.1,5.3,5.4").text("Indicators 5.1, 5.3, 5.4"));
			 $('#indicator').append($("<option></option>").attr("value","5.2").text("Indicator 5.2"));
		}else if($('#sector_type_id').val() == 4){
			 $('#indicator').append($("<option></option>").attr("value","6.1").text("Indicator 6.1"));
			 $('#indicator').append($("<option></option>").attr("value","6.2").text("Indicator 6.2"));
		}else if($('#sector_type_id').val() == 5){
			$('#indicator').append($("<option></option>").attr("value","8.1-8.3").text("Indicators 8.1-8.3"));
			 $('#indicator').append($("<option></option>").attr("value","8.4").text("Indicator 8.4"));
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
											//if($userTools->isSuperAdmin($user->user_group)){
											    echo "<option value='0'>-- Select Sector --</option>";
											//}
	foreach ( $sectors as $urows ) {
	    $disable = " disabled ";
	    if($userTools->isSuperAdmin($user->user_group) || ($userTools->isAdmin($user->user_group) && $urows ['0'] === $user->sector)){
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
									<td><br>
									<select id="indicator" name="indicator" class="gbvis_select" title="Select Indicator" placeholder="Select sector first">
									<option value=''>Select sector first</option>
									</select>
									</td>
								</tr>
								
								<tr>
									<td><br><input type="text" id="fromdate" name="fromdate"
										placeholder="From Date" class="gbvis_smallBoxInputs"
										title="From Date"> <input type="text" id="todate"
										name="todate" placeholder="To Date"
										class="gbvis_smallBoxInputs" title="To Date"></td>
								</tr>
								
								
								<tr>
									<td><br><button type="button" class="submit_button"
											onClick='export_data();'>Export data</button></td>
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