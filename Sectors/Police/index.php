<?php
// TA:60:4
$page_title = "Police sector | GBV";
$current_page = "home";

require_once 'includes/global.inc.php';

// check to see if they're logged in
if (isset($_SESSION['logged_in'])) {
    
    // get the user object from the session
    $user = unserialize($_SESSION['user']);
    
if( !($userTools->isAdmin($user->user_group) &&  $user->sector === '3')){
        print " You do not have permission to access this page.";
        return;
    }
    
    // include "includes/Dash_header.php";include "includes/topbar.php"; //TA:60:1
    include "../../includes/Dash_header.php"; // TA:60:1
    include "../../includes/topbar.php"; // TA:60:1
    
    $counties = $db->selectAllOrdered("counties", "county_name");
    $indicators = $db->selectAllOrderedWhere("indicators", "indicator_id", " sector_id=3");
    $ranks = $db->selectAllOrderedWhere("ranks", "rank", " sector_id=3");
    
    ?>

<!-- TA:60:1 date picker libs -->
<link rel="stylesheet"
	href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

<script type="text/javascript">

var $RANK_AMOUNT = 5;

//format mm/dd/yyyy
// $(function() {
// 	$( "#date" ).datepicker();
// }).click(function(){
// $('.ui-datepicker-calendar').show();
// });

//format mm/yyyy
//format mm/yyyy
$(function() {
	$('#date').datepicker({
	     changeMonth: true,
	     changeYear: true,
	     dateFormat: 'mm/yy',
	     maxDate: new Date,//no future date entering
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
		  alert("Please select " + title)
      return false;
  }
  return true;
}

		  function validate(title, value){
			  if(value == undefined || value == ""){
				  alert("Please select " + title)
                  return false;
              }
              return true;
		  }

		  function clean_form(){
			  $( "#date" ).val("");
			  $( "#county" ).val("");
			  add_indicator22();
			  add_indicator23();
			  add_indicator24();
			  add_indicator25();
			  add_indicator27();
		  }
		  

               function enter_data(){

            	   var county_id = $( "#county" ).val();
                   var date = $( "#date" ).val();
                   
            	   if(validate("county", county_id) && validate("date", date)){
            			 
      				  var url= "";

        				//take indicator 27
      				   var indicator27 = "";
       				 
      				  for(var $i=0; $i<$RANK_AMOUNT; $i++){
      					  
        					  var male_rank = $('#indicator27').find( "#male_rank" + $i ).val();
       					  var male_aggregate = $('#indicator27').find( "#male_aggregate" + $i ).val();
       					  if(male_rank != ''){
                      		if(validate("aggregate in Indicator 5.2 section", male_aggregate)){
                           		if(indicator27 != ""){
                           			indicator27 += ";";
                           		}
                           		indicator27 += "Male," + male_rank + "," + male_aggregate;
                       		}else{
                           		return;
                       		}
                    		}

      					  var female_rank = $('#indicator27').find( "#female_rank" + $i ).val();
      					  var female_aggregate = $('#indicator27').find( "#female_aggregate" + $i ).val();
      					  if(female_rank != ''){
                      		if(validate("aggregate in Indicator 5.2 section", female_aggregate)){
                           		if(indicator27 != ""){
                           			indicator27 += ";";
                           		}
                           		indicator27 += "Female," + female_rank + "," + female_aggregate;
                       		}else{
                           		return;
                       		}
                   		}
      				  }
      				  if(indicator27 != ""){
      					  url += "&indicator27=" + indicator27;
      				  }

        				var other_indicators = ["22", "23", "24", "25"];
        				  for(var i=0; i<other_indicators.length; i++){
            				  var aggregate= $('#aggregate' + other_indicators[i]).val();
            				  if(aggregate != ''){
                				  
            					  url += "&indicator" + other_indicators[i] +"=" + aggregate;
            				  }
        				  }

        				


        				if(url != ""){
        					  url = "enter_data.php?mode=add_aggregates" + 
        		       	   		"&date=" + date +
        		       	   		"&county_id=" + county_id + url;
        				  }else{
        					  alert("Please enter data to forms.");
        					  return;
        				  }

        				// alert(url); //return;
        				  
        	            	 $.ajax({
                		  type:"post",
                		            url:url,     
                		  beforeSend: function(  ) {
                			  window.scrollTo(0, 0);
                			  document.getElementById("entry_form").style.visibility = "hidden";
                			  $("#progress_bar").html("<img src='../../UI/images/data_loading_animation.gif' width=300 height=200/>");
                		  }
                		})
                		  .done(function( data ) {
                			  $("#progress_bar").html("");
                			  if(data){
                				  alert(data);
                			  }else{
                				  alert("No any data were insirted into database.");
                			  }
                			  document.getElementById("entry_form").style.visibility = "visible";
                			  
                		  });

        	           clean_form();
            	   }

                   
               }

               function selectRank(sex, index){
      			  if($('#' + sex + '_rank' + index).val() == ""){
      				  $('#' + sex + '_aggregate' + index).val("");
      			  }
      			  $('#' + sex + '_aggregate' + index).prop('disabled', $('#' + sex + '_rank' + index).val() == "");
      		  }

      		  function add_indicator22(){
          		  $("#indicator22").html("<input type='text' onkeypress='return isNumberKey(event)' id='aggregate22' name='aggregate22' placeholder='Aggregate' class='gbvis_smallBoxInputs' title='Aggregate'>");  
      		  }

        		function add_indicator23(){
          		  $("#indicator23").html("<input type='text' onkeypress='return isNumberKey(event)' id='aggregate23' name='aggregate23' placeholder='Aggregate' class='gbvis_smallBoxInputs' title='Aggregate'>");  
      		  }

        		function add_indicator24(){
          		  $("#indicator24").html("<input type='text' onkeypress='return isNumberKey(event)' id='aggregate24' name='aggregate24' placeholder='Aggregate' class='gbvis_smallBoxInputs' title='Aggregate'>");  
      		  }

        		function add_indicator25(){
          		  $("#indicator25").html("<input type='text' onkeypress='return isNumberKey(event)' id='aggregate25' name='aggregate25' placeholder='Aggregate' class='gbvis_smallBoxInputs' title='Aggregate'>");  
      		  }

        		

        		function add_indicator27(){
            		var text = "";
        			for(var $i=0; $i<$RANK_AMOUNT; $i++){
          			   text += "Male &nbsp;&nbsp;"+
          			   "<select id='male_rank" + $i + "' class='gbvis_select' title='Select Rank' width='400px' onchange='selectRank(\"male\"," + $i + ")'>" +
    						"<option value=''>-- Select Rank --</option>" +
          			   <?php
            						echo "\"";
            						foreach ($ranks as $urows) {
            						   echo "<option value='" . $urows['0'] . "'>" . ucfirst($urows['1']) . "</option>";
            						}
            						echo "</select>\" + ";
            							    ?>
            				 "&nbsp;&nbsp;<input type='text' onkeypress='return isNumberKey(event)' id='male_aggregate" + $i + "' placeholder='Aggregate' class='gbvis_smallBoxInputs' title='Aggregate' disabled=disabled>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" +
             				"Female&nbsp;&nbsp;" +
             				"<select id='female_rank" + $i + "' class='gbvis_select' title='Select Rank' width='400px' onchange='selectRank(\"female\"," + $i + ")'>" +
    						"<option value=''>-- Select Rank --</option>" +
          			   <?php
            						echo "\"";
            						foreach ($ranks as $urows) {
            						   echo "<option value='" . $urows['0'] . "'>" . ucfirst($urows['1']) . "</option>";
            						}
            						echo "</select>\" + ";
            							    ?>
            				 "&nbsp;&nbsp;<input type='text' onkeypress='return isNumberKey(event)' id='female_aggregate" + $i + "' placeholder='Aggregate' class='gbvis_smallBoxInputs' title='Aggregate' disabled=disabled><div style='line-height:50%;'><br></div>";
              			   
          		   }
          		  $("#indicator27").html(text);  
      		  }

      		 
               

               function isNumberKey(e){
            	      if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            	                return false;
            	     }
                 }

    </script>

<div id="main-content_with_side_bar">

	<div id="content-body">
		<!--  <center>
			<h2 class="page-title">Welcome to the National Sexual Gender Violence
				Information System (GBVIS)</h2>
		</center>-->
		<!-- TA:60:1 -->
		<div class="profile-data" align="left">

			<!-- TA:60:1 START -->

			<div id='progress_bar' align='center'
				style="position: absolute; top: 250px; left: 200px;"></div>

			<div id="entry_form">

				<h2 class="page-title-section">Police sector data entry</h2>
				<table width="900px" border="0" cellspacing="5"
					style='font-family: Verdana, Geneva, sans-serif; font-size: 12px;'>

					<tr>
						<td colspan=4><select id="county" class="gbvis_select"
							width='400px' title="Select County">
								<option value="">-- Select County --</option>
  <?php
    foreach ($counties as $urows) {
        echo "<option value='" . $urows['0'] . "'>" . $urows['1'] . "</option>";
    }
    ?>
</select></td>
					</tr>
					<tr>
						<td><input type="text" id="date" name="date" placeholder="Date"
							class="gbvis_smallBoxInputs" title="Date"></td>
					</tr>
					
					<tr> <!-- 22: Number of police stations surveyed-->
						<td><b>Indicator 5.1.a Number of police stations surveyed</b><br>
							<div id='indicator22'></div> 
							 <script type='text/javascript'>add_indicator22()</script><br>
						</td>
					</tr>
					
					<tr> <!-- 23: Number of police stations that have a functional gender desk-->
						<td><b>Indicator 5.1.b Number of police stations that have a functional gender desk</b><br>
							<div id='indicator23'></div> 
							 <script type='text/javascript'>add_indicator23()</script><br>
						</td>
					</tr>
					
					<tr><!-- 27: Number of police who have been trained to respond and investigate cases of SGBV-->
						<td><b>Indicator 5.2 Number of police who have been trained to respond and investigate cases of SGBV</b><br>
							<div id='indicator27'></div> 
							 <script type='text/javascript'>add_indicator27()</script><br>
						</td>
					</tr>
					
					<tr><!-- 24: Number of SGBV cases reported to National police service (NPS)-->
						<td><b>Indicator 5.3 Number of SGBV cases reported to National Police Service (NPS)</b><br>
							<div id='indicator24'></div> 
							 <script type='text/javascript'>add_indicator24()</script><br>
						</td>
					</tr>
					
					<tr><!-- 25: Number of SGBV cases investigated by the National Police-->
						<td><b>Indicator 5.4 Number of SGBV cases investigated by the National Police Service</b><br>
							<div id='indicator25'></div> 
							 <script type='text/javascript'>add_indicator25()</script><br>
						</td>
					</tr>

					<tr>
						<td><button type="button" class="submit_button"
								onClick='enter_data();'>Enter</button></td>
					</tr>
				</table>
			</div>
			<br>


			<!-- TA:60:1 END -->




			<br clear="all"> <br clear="all"> <br clear="all"> <br clear="all">
			<!--&nbsp;Your MD5 encrypted password: <font color="white"><?php //echo $passwd; ?></font>-->


			<br clear="all"> <br clear="all"> <br clear="all"> <br clear="all"> <br
				clear="all"> <br clear="all">
		</div>
		<br clear="all">
		</center>
	</div>
</div>
<?php
    include "../../includes/footer.php";
} else {
    // Redirect user back to login page if there is no valid session created
    header("Location: ../../login.php");
}
?>