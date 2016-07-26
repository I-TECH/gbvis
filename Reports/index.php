<?php
//TA:60:3
$page_title = "Reports | GBV";
$current_page = "home";

require_once 'includes/global.inc.php';

// check to see if they're logged in
if (isset ( $_SESSION ['logged_in'] )) {
	
	// get the user object from the session
	$user = unserialize ( $_SESSION ['user'] );
	
	// include "includes/header.php";
	include "../includes/Dash_header.php"; // TA:60:1
	include "../includes/topbar.php"; // TA:60:1
	                                  
	// TA:60:1
	//$db = new DB ();
	$counties = $db->selectAllOrdered ( "counties",  "county_name");
	$sectors = $db->selectAllOrdered ( "sectors", "sector");
	$indicators = $db->selectAllOrdered( "indicators", "indicator");
	
	?>
<!-- TA:60:1 <div id="sidebar">
	 
	 <div class="sidebar-nav">
	<?php
	// include "../includes/sidebar.php";
	?>
	</div> 
	  </div> -->
<!-- TA:60:1 date picker libs -->
<link rel="stylesheet"
	href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script> <!-- for calrendar picker -->
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script> <!-- for calrendar picker -->

<!-- libs for report charts and tables -->
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript" src="../UI/js/jspdf.js"></script>
<script type="text/javascript" src="../UI/js/FileSaver.js"></script>
<script type="text/javascript" src="../UI/js/zlib.js"></script>
<script type="text/javascript" src="../UI/js/png.js"></script>
<script type="text/javascript" src="../UI/js/addimage.js"></script>
<script type="text/javascript" src="../UI/js/png_support.js"></script>
<script type="text/javascript" src="../UI/js/jspdf.debug.js"></script>
<script type="text/javascript" src="../UI/js/jspdf.plugin.autotable.js"></script>
<script type="text/javascript" src="../UI/js/jspdf.min.js"></script>
<!--  -->



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
					  //alert(from_date_new + ">" + to_date_new);
					  alert("'From Date' must be less than 'To Date'.");
					  return false;
				  }
				  return true;
			  }else{
				  return false;
			  }
		  }

		  function getReportTypesList(){
			  var sel_sector_id = $( "#sector_type_id :selected" ).val(); 
			  $("#report_id option").remove();
			  $('#report_id').append($("<option></option>").attr("value","").text("-- Select Report --"));
			  if($('#sector_type_id').val() == 1){
				  $('#report_id').append($("<option></option>").attr("value","1").text("Number of judges/magistrates trained in SGVB"));
				  $('#report_id').append($("<option></option>").attr("value","2").text("Proportion of prosecuted SGBV cases withdrawn"));
				  $('#report_id').append($("<option></option>").attr("value","3").text("Proportion of prosecuted SGBV cases that resulted in a conviction"));
				  $('#report_id').append($("<option></option>").attr("value","4").text("Average time to conclude a SGBV case"));
			  }else if($('#sector_type_id').val() == 2){
				  $('#report_id').append($("<option></option>").attr("value","1").text("Proportion of health facilities providing comprehensive clinical management services for survivors of sexual violence"));
				  $('#report_id').append($("<option></option>").attr("value","2").text("Number of service providers trained on management of SGBV survivors"));
				  $('#report_id').append($("<option></option>").attr("value","3").text("Number of cases of SGBV reported to health facilities"));
				  $('#report_id').append($("<option></option>").attr("value","4").text("Proportion of eligible sexual violence survivors initiated on post ‐exposure prophylaxis for HIV"));
				  $('#report_id').append($("<option></option>").attr("value","5").text("Proportion of sexual violence survivors who have completed post ‐exposure prophylaxis"));
				  $('#report_id').append($("<option></option>").attr("value","6").text("Proportion of sexual violence survivors who received comprehensive care"));
			  }else if($('#sector_type_id').val() == 3){
				  $('#report_id').append($("<option></option>").attr("value","1").text("Proportion of police stations that have a functional gender desk"));
				  $('#report_id').append($("<option></option>").attr("value","2").text("Number of police who have been trained to respond and investigate cases of SGBV"));
				  $('#report_id').append($("<option></option>").attr("value","3").text("Number of cases reported to National Police Service (NPS)"));
				  $('#report_id').append($("<option></option>").attr("value","4").text("Proportion of SGBV cases investigated by the National Police Service"));
			  }else if($('#sector_type_id').val() == 4){
				  $('#report_id').append($("<option></option>").attr("value","1").text("Number of prosecutors who have been trained in SGBV using SGBV prosecutor's manual"));
				  $('#report_id').append($("<option></option>").attr("value","2").text("Proportion of SGBV cases that were prosecuted by law"));
			  }else if($('#sector_type_id').val() == 5){
				  $('#report_id').append($("<option></option>").attr("value","1").text("Number of teachers or MoE staff trained in SGBV"));
				  $('#report_id').append($("<option></option>").attr("value","2").text("Percent of schools implementing life skills curriculum that teaches students on what to do in case of violation"));
				  $('#report_id').append($("<option></option>").attr("value","3").text("Proportion of children who possess life skills - who know what to do in case of violation at home/school"));
				  $('#report_id').append($("<option></option>").attr("value","4").text("Proportion of children who have indicated via self reports that they have violated at home/school in the last 12 months"));
			  }
		  }


               function get_report(){

                   var sector_type_id = $( "#sector_type_id" ).val();
                   var report_id = $( "#report_id" ).val();
                   var report_name = document.getElementById('report_id').options[document.getElementById('report_id').selectedIndex].text;
                   var county_id = $( "#county" ).val();
                   var from_date = $( "#fromdate" ).val();
                   var to_date = $( "#todate" ).val();

                  if(validate("sector", sector_type_id) && validate("report", report_id) && validateDates(from_date, to_date)){

//                     //get data from *aggregates table 
//                     if($sector_type_id === 0){
//                         $aggregates_table = "";
//                     }else if($sector_type_id === 1){
//                         $aggregates_table = "judiciary_aggregates";
//                     }else if($sector_type_id === 2){
//                         $aggregates_table = "health_aggregates";
//                     }else if($sector_type_id === 3){
//                         $aggregates_table = "police_aggregates";
//                     }else if($sector_type_id === 4){
//                         $aggregates_table = "procecution_aggregates";
//                     }else if($sector_type_id === 5){
//                         $aggregates_table = "education_aggregates";
//                     }else if($sector_type_id === 6){
//                         $aggregates_table = "";
//                     }else if($sector_type_id === 7){
//                         $aggregates_table = "community_aggregates";
//                     }

                	  var url;
                	  if(sector_type_id == 1){ //Judiciary sector
                		    url = "report_by_judiciary_sector.php?sector_type_id=" + sector_type_id + 
                 	   		"&fromdate=" + from_date +
                     	   	"&todate=" + to_date +
                 	   		"&county_id=" + county_id +
                     	   	"&report_name=" + encodeURI(report_name) + 
                     	   	"&report_id=" + report_id;
            		    }else if(sector_type_id == 2){ //Health sector
                		    url = "report_by_health_sector.php?sector_type_id=" + sector_type_id + 
                 	   		"&fromdate=" + from_date +
                     	   	"&todate=" + to_date +
                 	   		"&county_id=" + county_id +
                     	   	"&report_name=" + encodeURI(report_name) + 
                     	   	"&report_id=" + report_id;
            		    }else if(sector_type_id == 3){ //Police sector
                		    url = "report_by_police_sector.php?sector_type_id=" + sector_type_id + 
                 	   		"&fromdate=" + from_date +
                     	   	"&todate=" + to_date +
                 	   		"&county_id=" + county_id +
                     	   	"&report_name=" + encodeURI(report_name) + 
                     	   	"&report_id=" + report_id;
            		    }else if(sector_type_id == 4){ //Prosecution sector
                		    url = "report_by_prosecution_sector.php?sector_type_id=" + sector_type_id + 
                 	   		"&fromdate=" + from_date +
                     	   	"&todate=" + to_date +
                 	   		"&county_id=" + county_id +
                     	   	"&report_name=" + encodeURI(report_name) + 
                     	   	"&report_id=" + report_id;
            		    }else if(sector_type_id == 5){ //Education sector
                		    url = "report_by_education_sector.php?sector_type_id=" + sector_type_id + 
                 	   		"&fromdate=" + from_date +
                     	   	"&todate=" + to_date +
                 	   		"&county_id=" + county_id +
                     	   	"&report_name=" + encodeURI(report_name) + 
                     	   	"&report_id=" + report_id;
            		    }else{
                		    return;
            		    }

                	   $('#report').load(url, function( response, status, xhr ) {
                 	   	  if ( status == "error" ) {
                	   	    var msg = "Sorry but there was an error: ";
                	   	    $( "#error" ).html( msg + xhr.status + " " + xhr.statusText );
                	   	  }
                	   	});
  	              	  
                  }
               }

               //TEST
               function get_reportTest(){

            	   var url = "report_by_health_sector.php?sector_type_id=2&fromdate=06/2015&todate=12/2015&county_id=all&indicator_id=3";
              	  $('#report').load(url, function( response, status, xhr ) {
               	   	  if ( status == "error" ) {
              	   	    var msg = "Sorry but there was an error: ";
              	   	    $( "#error" ).html( msg + xhr.status + " " + xhr.statusText );
              	   	  }
              	   	});
               }
    </script>

<div id="main-content">

	<div id="content-body">
		<!--  <center>
			<h2 class="page-title">Welcome to the National Sexual Gender Violence
				Information System (GBVIS)</h2>
		</center>-->
		<!-- TA:60:1 -->

		<div class="profile-data" align="left">

			<!-- TA:60:1 START -->
			<table border=0>
				<tr>
					<td valign='top' width='290px'>
						<div class="profile-data" align="left">

							<br clear="all">
							<table width="30%" border="0" align="left" cellspacing="5"
								class="table-hover">
								<tr>
									<td><select id="sector_type_id" name="sector_type_id" class="gbvis_select" title="Sector" onchange="getReportTypesList();">
											<option value="">-- Select Sector --</option>
											<?php
	foreach ( $sectors as $urows ) {
	    $disable = " disabled ";
	    print "+" . $urows ['0'] . "=";
	    if($urows ['0'] === '1' || $urows ['0'] === '2' || $urows ['0'] === '3' || $urows ['0'] === '4' || $urows ['0'] === '5'){
	        $disable = "";
	    }    
		echo "<option value='" . $urows ['0'] . "' " . $disable . " >" . ucfirst($urows ['1']) . "</option>";
	}
	?>
									</select></td>
								</tr>
								<tr>
									<td><select id="report_id" name="report_id" class="gbvis_select" title="Select Report">
									<option selected="selected">Select sector first</option>
									</select></td>
								</tr>
								<tr>
									<td><input type="text" id="fromdate" name="fromdate"
										placeholder="From Date" class="gbvis_smallBoxInputs"
										title="From Date"> <input type="text" id="todate"
										name="todate" placeholder="To Date"
										class="gbvis_smallBoxInputs" title="To Date"></td>
								</tr>
								<tr>
									<td><select id="county" class="gbvis_select"
										title="Select County">
										<option value="all">Kenya Total</option>
										<option value="across">All Counties</option>
											
  <?php
	foreach ( $counties as $urows ) {
		echo "<option value='" . $urows ['0'] . "'>" . $urows ['1'] . "</option>";
	}
	?>
</select></td>
								</tr>
								<tr>
									<td><button type="button" class="submit_button"
											onClick='get_report();'>Generate</button></td>
								</tr>
							</table>
						</div>
					</td>
					<td>
						<div id='report'></div>
					
					</td>
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
 include "../includes/footer.php"; 
	}
else
{
	//Redirect user back to login page if there is no valid session created
	header("Location: ../login.php");
}
?>