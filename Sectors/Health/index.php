<?php
// TA:60:4
$page_title = "Health sector | GBV";
$current_page = "home";

require_once 'includes/global.inc.php';

// check to see if they're logged in
if (isset($_SESSION['logged_in'])) {
    
    // get the user object from the session
    $user = unserialize($_SESSION['user']);
    
if( !($userTools->isAdmin($user->user_group) &&  $user->sector === '2')){
        print " You do not have permission to access this page.";
        return;
    }
    
    // include "includes/Dash_header.php";include "includes/topbar.php"; //TA:60:1
    include "../../includes/Dash_header.php"; // TA:60:1
    include "../../includes/topbar.php"; // TA:60:1
    
    $counties = $db->selectAllOrdered("counties", "county_name");
    $indicators = $db->selectAllOrderedWhere("indicators", "indicator_id", " sector_id=2");
    $ownerships = $db->selectAllOrderedWhere("ownerships", "ownership", " sector_id=2");
    $cadres = $db->selectAllOrderedWhere("cadres", "cadre", " sector_id=2");
    
    ?>

<!-- TA:60:1 date picker libs -->
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css"> 
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>


<script type="text/javascript">

    var $OWNERSHIP_AMOUNT = 10;
    var $CADRE_AMOUNT = 5;

// format mm/dd/yyyy
//     $(function() {
// 		$( "#date" ).datepicker();
// 	}).click(function(){
// 	    $('.ui-datepicker-calendar').show();
// 	});;

    //format mm/yyyy
    $(function() {
    	$('#date').datepicker({
    	     changeMonth: true,
    	     changeYear: true,
    	     dateFormat: 'mm/yy',
    	     showButtonPanel: true,
    	     maxDate: new Date,//no future date entering

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

		  function isEmpty(value){
			  if(value == undefined || value == ""){
				  return true;
			  }
			  return false;
		  }

		  function aggregateValidate(title, value){
				   if(value < '0'){
					   alert(title + " value must be number more than 0.");
					   return false;
				   }else if(value > '0'){
				    var all_aggregates = $( "#all_aggregates" ).val();
				    $( "#all_aggregates" ).val($( "#all_aggregates" ).val() + 1);
				   }
              return true;
		  }

		  function clean_form(){
			  $( "#county" ).val("");
			  $( "#date" ).val("");
			  $('#indicator37').val("");

			  add_indicator_age_sex(3);
			  add_indicator_age_sex(38);
			  add_indicator_age_sex(4);
			  add_indicator_age_sex(5);
			  add_indicator_age_sex(6);
			  add_indicator_age_sex(11);
			  add_indicator_age_sex(39);
			  
			 
		  }

		  function selectOwnership(index){
			  if($('#ownership' + index).val() == ""){
				  $('#aggregate' + index).val("");
			  }
			  $('#aggregate' + index).prop('disabled', $('#ownership' + index).val() == "");
		  }

		  
		  function selectCadre(sex, index){
			  if($('#' + sex + '_cadre' + index).val() == ""){
				  $('#' + sex + '_aggregate' + index).val("");
			  }
			  $('#' + sex + '_aggregate' + index).prop('disabled', $('#' + sex + '_cadre' + index).val() == "");
		  }

		  function enter_data(){
			  var county_id = $( "#county" ).val();
              var date = $( "#date" ).val();
			  if(validate("county", county_id) && validate("date", date)){
			 
				  var url= "";

				  //take indicator 1
				   var indicator1 = "";
				  for(var $i=0; $i<$OWNERSHIP_AMOUNT; $i++){
					  var ownership = $('#indicator1').find( "#ownership" + $i ).val();
					  var aggregate = $('#indicator1').find( "#aggregate" + $i ).val();
					  if(!isEmpty(ownership)){
                  		if(validate("aggregate in Indicator 1 section", aggregate)){
                       		if(indicator1 != ""){
                       			indicator1 += ";";
                       		}
                       		indicator1 += ownership + "," + aggregate;
                   		}else{
                       		return;
                   		}
               		}
				  }
				  if(indicator1 != ""){
					  url += "&indicator1=" + indicator1;
				  }

					//take indicator 37
				   var indicator37 = $('#indicator37').val();
				  if(indicator37 != ""){
					  url += "&indicator37=" + indicator37;
				  }

					//take indicator 2
				   var indicator2 = "";
				  for(var $i=0; $i<$OWNERSHIP_AMOUNT; $i++){
					  
					  var male_cadre = $('#indicator2').find( "#male_cadre" + $i ).val();
					  var male_aggregate = $('#indicator2').find( "#male_aggregate" + $i ).val();
					  if(!isEmpty(male_cadre)){
                		if(validate("aggregate in Indicator 2 section", male_aggregate)){
                     		if(indicator2 != ""){
                     			indicator2 += ";";
                     		}
                     		indicator2 += "Male," + male_cadre + "," + male_aggregate;
                 		}else{
                     		return;
                 		}
             		}

					  var female_cadre = $('#indicator2').find( "#female_cadre" + $i ).val();
					  var female_aggregate = $('#indicator2').find( "#female_aggregate" + $i ).val();
					  if(!isEmpty(female_cadre)){
                		if(validate("aggregate in Indicator 2 section", female_aggregate)){
                     		if(indicator2 != ""){
                     			indicator2 += ";";
                     		}
                     		indicator2 += "Female," + female_cadre + "," + female_aggregate;
                 		}else{
                     		return;
                 		}
             		}
				  }
				  if(indicator2 != ""){
					  url += "&indicator2=" + indicator2;
				  }

					//take other indicators
				  var other_indicators = ["3", "4", "5", "6", "11", "38", "39"];
				  for(var i=0; i<other_indicators.length; i++){
					  
					  var indicator = "female_0_11," + $('#indicator' + other_indicators[i]).find( "#female_0-11_amount").val() + ";" +
	                     	 "female_12_17," + $('#indicator' + other_indicators[i]).find( "#female_12-17_amount").val() + ";" +
	                     	 "female_18_49," + $('#indicator' + other_indicators[i]).find( "#female_18-49_amount").val() + ";" +
	                     	 "female_50," + $('#indicator' + other_indicators[i]).find( "#female_50_amount").val();
					  if(other_indicators[i] != '6'){
						  indicator += ";male_0_11," + $('#indicator' + other_indicators[i]).find( "#male_0-11_amount").val() + ";" +
	                         	 "male_12_17," + $('#indicator' + other_indicators[i]).find( "#male_12-17_amount").val() + ";" +
	                         	 "male_18_49," +$('#indicator' + other_indicators[i]).find( "#male_18-49_amount").val() + ";" +
	                         	 "male_50," + $('#indicator' + other_indicators[i]).find( "#male_50_amount").val();
					  }

					  if(indicator != ""){
						  url += "&indicator" + other_indicators[i] +"=" + indicator;
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

				//  alert(url); return;
				  
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
		  

               function calculate_total(id){
                
            	   var total =  parseInt($('#indicator' + id).find( "#female_0-11_amount" ).val(), 10) +
            	   parseInt($('#indicator' + id).find( "#female_12-17_amount" ).val(), 10) +
            	   parseInt($('#indicator' + id).find( "#female_18-49_amount" ).val(), 10) +
            	   parseInt($('#indicator' + id).find( "#female_50_amount" ).val(), 10); 
            	   if(id != '6'){
            		   total = total + parseInt($('#indicator' + id).find( "#male_0-11_amount" ).val(), 10) +
                	   parseInt($('#indicator' + id).find( "#male_12-17_amount" ).val(), 10) +
                	   parseInt($('#indicator' + id).find( "#male_18-49_amount" ).val(), 10) +
                	   parseInt($('#indicator' + id).find( "#male_50_amount" ).val(), 10);
            	   }
            	  
            	   $('#indicator' + id).find( "#all_aggregates").val(total);
               }

               function add_indicator1(){
            	   $("#indicator1").html("");
            	   var text = "";
                   for(var $i=0; $i<$OWNERSHIP_AMOUNT; $i++){
                       text += "<select id='ownership" + $i + "' class='gbvis_select' title='Select Ownership' width='400px' onchange='selectOwnership(" + $i + ")'>" +
 						"<option value=''>-- Select Ownership --</option>" + 
  						<?php
  						echo "\"";
  						foreach ($ownerships as $urows) {
  						    echo "<option value='" . $urows['0'] . "'>" . ucfirst($urows['1']) . "</option>";
  						}
  						echo "</select>\" + ";
  							    ?>
        	    "&nbsp;&nbsp;<input type='text' onkeypress='return isNumberKey(event)' id='aggregate" + $i + "'' placeholder='Aggregate' class='gbvis_smallBoxInputs' title='Aggregate' disabled=disabled>";
        	    if(($i%2)!=0){
        	    	text += "<div style='line-height:50%;'><br></div>";
        	    }else{
        	    	text += "&nbsp;&nbsp;&nbsp;&nbsp;";
        	    }    
                }
//                    alert(text);
            	   $("#indicator1").append(text);
               }

               function add_indicator2(){
            	   $("#indicator2").html("");
            	   var text = "";
            	   for(var $i=0; $i<$CADRE_AMOUNT; $i++){
            		   text += "Male &nbsp;&nbsp;" + 
						"<select id='male_cadre" + $i + "' class='gbvis_select' title='Select Cadre' width='400px' onchange='selectCadre(\"male\", " + $i + ")'>" +
  						"<option value=''>-- Select Cadre --</option>" + 
  						<?php
  						echo "\"";
  						foreach ($cadres as $urows) {
  						    echo "<option value='" . $urows['0'] . "'>" . ucfirst($urows['1']) . "</option>";
  						}
  						echo "</select>\" + ";
  							    ?> 
          	    "&nbsp;&nbsp;<input type='text' onkeypress='return isNumberKey(event)' id='male_aggregate" + $i + "' placeholder='Aggregate' class='gbvis_smallBoxInputs' title='Aggregate' disabled=disabled>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" +
          	    "Female&nbsp;&nbsp;" +
            	  "<select id='female_cadre" + $i + "' class='gbvis_select' title='Select Cadre' width='400px' onchange='selectCadre(\"female\"," + $i + ")'>" +
					"<option value=''>-- Select Cadre --</option>" + 
					<?php
					echo "\"";
					foreach ($cadres as $urows) {
					    echo "<option value='" . $urows['0'] . "'>" . ucfirst($urows['1']) . "</option>";
					}
					echo "</select>\" + ";
						    ?> 
  	    "&nbsp;&nbsp;<input type='text' onkeypress='return isNumberKey(event)' id='female_aggregate" + $i + "' placeholder='Aggregate' class='gbvis_smallBoxInputs' title='Aggregate' disabled=disabled>" +
          	    "<div style='line-height:50%;'><br></div>";
            	   } 
            	   $("#indicator2").append(text);
               }

               function add_indicator_age_sex(indicator_id){
            	   $("#indicator" + indicator_id).html("");
            	   var text = "<table border=1 style='border-collapse: collapse; border: 1px solid gray;'>" +
					"<tr style='border: 1px solid gray; background-color: #D8D8D8;'>" +
					"<th align='center' width='160px'>0-11 years</th>" +
					"<th align='center' width='160px'>12-17 years</th>" +
					"<th align='center' width='160px'>18-49 years</th>" +
					"<th align='center' width='160px'>50+ years</th></tr>";
					if(indicator_id != '6'){
						text = text + "<tr style='border: 1px solid gray;'>" +
					"<td align='right' width='10px' style='padding: 5px 5px 5px 5px;'>Male&nbsp;&nbsp;" +
					"<input type='text' onkeypress='return isNumberKey(event)' id='male_0-11_amount' name='male_0-11_amount' value='0' class='gbvis_smallBoxInputs'" +
						"title='Amount' onchange='calculate_total(" + indicator_id + ");'></td>" +
					"<td align='right' width='10px' style='padding: 5px 5px 5px 5px;'>Male&nbsp;&nbsp;" +
					"<input type='text' onkeypress='return isNumberKey(event)' id='male_12-17_amount' name='male_12-17_amount' value='0' class='gbvis_smallBoxInputs'" +
						"title='Amount' onchange='calculate_total(" + indicator_id + ");'></td>" +
					"<td align='right' width='10px' style='padding: 5px 5px 5px 5px;'>Male&nbsp;&nbsp;" +
					"<input type='text' onkeypress='return isNumberKey(event)' id='male_18-49_amount' name='male_18-49_amount' value='0' class='gbvis_smallBoxInputs'" +
						"title='Amount' onchange='calculate_total(" + indicator_id + ");'></td>" +
					"<td align='right' width='10px' style='padding: 5px 5px 5px 5px;'>Male&nbsp;&nbsp;" +
					"<input type='text' id='male_50_amount' name='male_50_amount' onkeypress='return isNumberKey(event)' value='0' class='gbvis_smallBoxInputs' title='Amount' onchange='calculate_total(" + indicator_id + ");'></td></tr>";
					}
				text = text + "<tr style='border: 1px solid gray;'><td align='right' style='padding: 5px 5px 5px 5px;'>Female&nbsp;&nbsp;<input " +
						"type='text' onkeypress='return isNumberKey(event)' id='female_0-11_amount' name='female_0-11_amount' value='0' class='gbvis_smallBoxInputs' title='Amount' onchange='calculate_total(" + indicator_id + ");'></td>" +
  	   "<td align='right' style='padding: 5px 5px 5px 5px;'>Female&nbsp;&nbsp;<input type='text' onkeypress='return isNumberKey(event)' id='female_12-17_amount' name='female_12-17_amount' value='0'" +
			"class='gbvis_smallBoxInputs' title='Amount' onchange='calculate_total(" + indicator_id + ");'></td>" +
		"<td align='right' style='padding: 5px 5px 5px 5px;'>Female&nbsp;&nbsp;<input " +
			"type='text' onkeypress='return isNumberKey(event)' id='female_18-49_amount'" +
			"name='female_18-49_amount' value='0' class='gbvis_smallBoxInputs' title='Amount' onchange='calculate_total(" + indicator_id + ");'> </td>" +
		"<td align='right' style='padding: 5px 5px 5px 5px;'>Female&nbsp;&nbsp;<input type='text' onkeypress='return isNumberKey(event)' id='female_50_amount'" +
			"name='female_50_amount' value='0' class='gbvis_smallBoxInputs' title='Amount' onchange='calculate_total(" + indicator_id + ");'>" +
		"</td></tr></table><div style='line-height:50%;'><br></div>" +
			"Grand total: <input type='text' id='all_aggregates' name='all_aggregates' placeholder='Grand Total' class='gbvis_smallBoxInputs' title='Grand Total' value='0' disabled='disabled'><br>";
          	   $("#indicator" + indicator_id).append(text);
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
			<h2 class="page-title">Welcome to the National Sexual Gender Violence Information System (GBVIS)</h2>
		</center>-->
		<!-- TA:60:1 -->
		<div class="profile-data" align="left">

			<!-- TA:60:1 START -->

			<div id='progress_bar' align='center'style="position: absolute; top: 250px; left: 200px;"></div>
			
			<div id="entry_form">

			<h2 class="page-title-section">Health sector data entry</h2>
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
					<td><input type="text" id="date" name="date" placeholder="Date" class="gbvis_smallBoxInputs" title="Date"></td>
				</tr>

				<tr>
					<td>
					
					<b>Indicator 4.1.a Total number of health facilities surveyed</b><br>	
					<input type='text' id='indicator37' onkeypress='return isNumberKey(event)' id='aggregate37' placeholder='Aggregate' class='gbvis_smallBoxInputs' title='Aggregate' >
					<div style='line-height:50%;'></div><br>
                    
                    <b> Indicator 4.1.b Number of health facilities providing comprehensive clinical management services for survivors of sexual violence</b>
                    <div id='indicator1'></div><script type='text/javascript'>add_indicator1();</script><br>
                    <b>Indicator 4.2 Number of service providers trained on management of SGBV survivors</b><br><div id='indicator2'></div> <script type='text/javascript'>add_indicator2();</script> <br>
                    <!-- Number of rape survivors-->
                    <b>Indicator 4.3.a Number of rape survivors</b><br><div id='indicator3'></div><script type='text/javascript'>add_indicator_age_sex(3);</script><br>
                    <!-- Number presenting within 72 hours-->
                    <b>Indicator 4.3.b Number presenting within 72 hours</b><br><div id='indicator38'></div><script type='text/javascript'>add_indicator_age_sex(38);</script><br>
                    <!--Number initiated PEP-->
                     <b>Indicator 4.4 Number initiated PEP </b><br><div id='indicator4'></div> <script type='text/javascript'>add_indicator_age_sex(4);</script><br>
                     <!--Number completed PEP-->
                     <b>Indicator 4.5 Number completed PEP </b><br><div id='indicator11'></div> <script type='text/javascript'>add_indicator_age_sex(11);</script><br>
                     <!--Number given STI treatment-->
                     <b>Indicator 4.6.a Number given STI treatment</b><br><div id='indicator5'></div> <script type='text/javascript'>add_indicator_age_sex(5);</script><br>
                     <!--Number given Emergency Contraceptive Pill-->
                     <b>Indicator 4.6.b Number given Emergency Contraceptive Pill</b><br> <div id='indicator6'></div> <script type='text/javascript'>add_indicator_age_sex(6);</script><br>
                     <!--Number completed trauma counseling-->
                     <b>Indicator 4.6.c Number completed trauma counseling</b><br> <div id='indicator39'></div> <script type='text/javascript'>add_indicator_age_sex(39);</script><br>
                     
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


			<!-- TA:60:1 <a href="stardard_reports.php" style="float:left; width:25%; height:100px;  margin-right:15px; text-decoration:none;" title="Standard Reports" >
				 <p>Standard Reports</p>  <p><img src="images/reports.jpeg" height="70" /></p>
				</a>
				<a href="analytical_reports.php" style="float:left; width:25%; height:100px;  margin-right:15px; text-decoration:none;" >
				  <p>Analytical Reports</p><p><img src="images/analytical.jpeg" height="70" title="Analytical Reports" /></p> 
				</a>-->

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