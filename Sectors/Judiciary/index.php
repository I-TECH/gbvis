<?php
// TA:60:4
$page_title = "Judiciary sector | GBV ";
$current_page = "home";

require_once 'includes/global.inc.php';

// check to see if they're logged in
if (isset($_SESSION['logged_in'])) {
    
    // get the user object from the session
    $user = unserialize($_SESSION['user']);
    
if( !($userTools->isAdmin($user->user_group) &&  $user->sector === '1')){
        print " You do not have permission to access this page.";
        return;
    }
    
    // include "includes/Dash_header.php";include "includes/topbar.php"; //TA:60:1
    include "../../includes/Dash_header.php"; // TA:60:1
    include "../../includes/topbar.php"; // TA:60:1
    
    $counties = $db->selectAllOrdered("counties", "county_name");
    $indicators = $db->selectAllOrderedWhere("indicators", "indicator", " sector_id=1");
    $cadres_male = $db->selectAllOrderedWhere("cadres", "cadre", " sector_id=1 and gender like 'male%'");
    $cadres_female = $db->selectAllOrderedWhere("cadres", "cadre", " sector_id=1 and gender like '%,female'");
    
    ?>
    
    <!-- TA:60:1 date picker libs -->
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css"> 
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

<script type="text/javascript">

var $CADRE_AMOUNT = 5;

//format mm/dd/yyyy
//$(function() {
//	$( "#date" ).datepicker();
//}).click(function(){
//$('.ui-datepicker-calendar').show();
//});;

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
			  add_indicator7();
			  add_indicator8();
			  add_indicator9();
			  add_indicator10();
			  add_indicator28();
		  }
		  

               function enter_data(){

            	   var county_id = $( "#county" ).val();
                   var date = $( "#date" ).val();
                   
            	   if(validate("county", county_id) && validate("date", date)){
            			 
      				  var url= "";


        				//take indicator 28
    				   var indicator28 = "";
     				 
    				  for(var $i=0; $i<$CADRE_AMOUNT; $i++){
    					  
      					  var male_cadre = $('#indicator28').find( "#male_cadre" + $i ).val();
     					  var male_aggregate = $('#indicator28').find( "#male_aggregate" + $i ).val();
     					  if(male_cadre != ''){
                    		if(validate("aggregate in Indicator 7.1 section", male_aggregate)){
                         		if(indicator28 != ""){
                         			indicator28 += ";";
                         		}
                         		indicator28 += "Male," + male_cadre + "," + male_aggregate;
                     		}else{
                         		return;
                     		}
                  		}

    					  var female_cadre = $('#indicator28').find( "#female_cadre" + $i ).val();
    					  var female_aggregate = $('#indicator28').find( "#female_aggregate" + $i ).val();
    					  if(female_cadre != ''){
                    		if(validate("aggregate in Indicator 7.1 section", female_aggregate)){
                         		if(indicator28 != ""){
                         			indicator28 += ";";
                         		}
                         		indicator28 += "Female," + female_cadre + "," + female_aggregate;
                     		}else{
                         		return;
                     		}
                 		}
    				  }
    				  if(indicator28 != ""){
    					  url += "&indicator28=" + indicator28;
    				  }

    				  var other_indicators = ["7", "8", "9", "10"];
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

    				// alert(url); return;

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
                			  clean_form();
                		  });
                   }
               }

               function isNumberKey(e){
          	      if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
          	                return false;
          	     }
               }

               function add_indicator7(){
            		  $("#indicator7").html("<input type='text' onkeypress='return isNumberKey(event)' id='aggregate7' name='aggregate7' placeholder='Aggregate' class='gbvis_smallBoxInputs' title='Aggregate'>");  
        		  }

               function add_indicator8(){
          		  $("#indicator8").html("<input type='text' onkeypress='return isNumberKey(event)' id='aggregate8' name='aggregate8' placeholder='Aggregate' class='gbvis_smallBoxInputs' title='Aggregate'>");  
      		  }

               function add_indicator9(){
          		  $("#indicator9").html("<input type='text' onkeypress='return isNumberKey(event)' id='aggregate9' name='aggregate9' placeholder='Aggregate' class='gbvis_smallBoxInputs' title='Aggregate'>");  
      		  }

               function add_indicator10(){
          		  $("#indicator10").html("<input type='text' onkeypress='return isNumberKey(event)' id='aggregate10' name='aggregate10' placeholder='Aggregate' class='gbvis_smallBoxInputs' title='Aggregate'>");  
      		  }

               function add_indicator28(){
              		var text = "";
          			for(var $i=0; $i<$CADRE_AMOUNT; $i++){
            			   text += "Male &nbsp;&nbsp;"+
            			   "<select id='male_cadre" + $i + "' class='gbvis_select' title='Select Cadre' width='400px' onchange='selectCadre(\"male\"," + $i + ")'>" +
      						"<option value=''>-- Select Cadre --</option>" +
            			   <?php
              						echo "\"";
              						foreach ($cadres_male as $urows) {
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
              						foreach ($cadres_female as $urows) {
              						   echo "<option value='" . $urows['0'] . "'>" . ucfirst($urows['1']) . "</option>";
              						}
              						echo "</select>\" + ";
              							    ?>
              				 "&nbsp;&nbsp;<input type='text' onkeypress='return isNumberKey(event)' id='female_aggregate" + $i + "' placeholder='Aggregate' class='gbvis_smallBoxInputs' title='Aggregate' disabled=disabled><div style='line-height:50%;'><br></div>";
                			   
            		   }
            		  $("#indicator28").html(text);  
        		  }

               function selectCadre(sex, index){
        			  if($('#' + sex + '_cadre' + index).val() == ""){
        				  $('#' + sex + '_aggregate' + index).val("");
        			  }
        			  $('#' + sex + '_aggregate' + index).prop('disabled', $('#' + sex + '_cadre' + index).val() == "");
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

			<div id='progress_bar' align='center'style="position: absolute; top: 250px; left: 200px;"></div>
			
			<div id="entry_form">

			<h2 class="page-title-section">Judiciary sector data entry</h2>
			<table width="900px" border="0" cellspacing="5"
				style='font-family: Verdana, Geneva, sans-serif; font-size: 12px;'>
				
				<tr>
					<td colspan=4><select id="county" class="gbvis_select"
						width='400px' title="Select County" >
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
                <tr><td>
                
                <!-- 28: Number of judges/magistrates trained in SGBV-->
                <b>Indicator 7.1 Number of judges/magistrates trained in SGVB</b><br><div id='indicator28'></div> <script type='text/javascript'>add_indicator28()</script><br>
                
                <!-- 7: Number of prosecuted SGBV cases-->
                <b>Indicator 7.2.a Number of prosecuted SGBV cases </b><br><div id='indicator7'></div> <script type='text/javascript'>add_indicator7()</script><br>
                
                 <!-- 8: Number of prosecuted SGBV cases withdrawn-->
                <b>Indicator 7.2.b Number of cases withdrawn </b><br><div id='indicator8'></div> <script type='text/javascript'>add_indicator8()</script><br>
                
                 <!-- 9: Number of prosecuted SGBV  cases that resulted in a  conviction-->
                <b>Indicator 7.3 Number of cases convicted </b><br><div id='indicator9'></div> <script type='text/javascript'>add_indicator9()</script><br>
                
                 <!-- 10: Average time to conclude a SGBV case-->
                <b>Indicator 7.4 Average time to conclude case (months)</b><br><div id='indicator10'></div> <script type='text/javascript'>add_indicator10()</script><br>
							 
                </td></tr>

				

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