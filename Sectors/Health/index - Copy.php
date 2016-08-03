<?php
// TA:60:4
$page_title = "Health sector | GBV";
$current_page = "home";

require_once 'includes/global.inc.php';

// check to see if they're logged in
if (isset($_SESSION['logged_in'])) {
    
    // get the user object from the session
    $user = unserialize($_SESSION['user']);
    
    if( !($userTools->isSuperAdmin($user->user_group) || ($userTools->isAdmin($user->user_group) &&  $userTools->health($user->sector)))){
        print " You do not have permission to access this page.";
        return;
    }
    
    // include "includes/Dash_header.php";include "includes/topbar.php"; //TA:60:1
    include "../../includes/Dash_header.php"; // TA:60:1
    include "../../includes/topbar.php"; // TA:60:1
    
    $counties = $db->selectAllOrdered("counties", "county_name");
    $indicators = $db->selectAllOrderedWhere("indicators", "indicator", " sector_id=2");
    $ownerships = $db->selectAllOrderedWhere("ownerships", "ownership", " sector_id=2");
    $cadres = $db->selectAllOrderedWhere("cadres", "cadre", " sector_id=2");
    
    ?>

<!-- TA:60:1 date picker libs -->
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css"> 
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>


<script type="text/javascript">

    var $OWNERSHIP_AMOUNT = 5;
    var $CADRE_AMOUNT = 5;


    $(function() {
		$( "#date" ).datepicker();
	}).click(function(){
	    $('.ui-datepicker-calendar').show();
	});;

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
			  $("#extra").html("");
			  $( "#county" ).val("");
			  $( "#date" ).val("");
			  $( "#male_0-11_amount" ).val("0");
              $( "#male_12-17_amount" ).val("0");
              $( "#male_18-49_amount" ).val("0");
              $( "#male_50_amount" ).val("0");
              $( "#female_0-11_amount" ).val("0");
              $( "#female_12-17_amount" ).val("0");
              $( "#female_18-49_amount" ).val("0");
              $( "#female_50_amount" ).val("0");
              $('#my-input-id').prop('disabled', false); 
              $('#all_aggregates').prop('disabled', true); 
              $( "#all_aggregates" ).val("0");
		  }

		  function selectOwnership(index){
			  if($('#ownership' + index).val() == ""){
				  $('#aggregate' + index).val("");
			  }
			  $('#aggregate' + index).prop('disabled', $('#ownership' + index).val() == "");
		  }

		  function selectSex(index){
			  if($('#sex' + index).val() == ""){
				  $('#cadre' + index).val("");
			  }
			  $('#cadre' + index).prop('disabled', $('#sex' + index).val() == "");
			  selectCadre(index);
		  }

		  function selectCadre(index){
			  if($('#cadre' + index).val() == ""){
				  $('#aggregate' + index).val("");
			  }
			  $('#aggregate' + index).prop('disabled', $('#cadre' + index).val() == "");
		  }
		  

               function enter_data(){

                   var indicator_id = $( "#indicator_id" ).val();
                   var county_id = $( "#county" ).val();
                   var date = $( "#date" ).val();
                   var all_aggregates = $( "#all_aggregates" ).val();

                    var male_0_11_amount = $( "#male_0-11_amount" ).val();
                   var male_12_17_amount = $( "#male_12-17_amount" ).val();
                   var male_18_49_amount = $( "#male_18-49_amount" ).val();
                   var male_50_amount = $( "#male_50_amount" ).val();
                   var female_0_11_amount = $( "#female_0-11_amount" ).val();
                   var female_12_17_amount = $( "#female_12-17_amount" ).val();
                   var female_18_49_amount = $( "#female_18-49_amount" ).val();
                   var female_50_amount = $( "#female_50_amount" ).val(); 

                   if(validate("report", indicator_id) && validate("county", county_id) && validate("date", date)){

                 	  var url= "enter_data.php?mode=add_aggregates" + 
                 	   		"&date=" + date +
                 	   		"&county_id=" + county_id +
                     	   	"&indicator_id=" + indicator_id;

                  	 if(indicator_id == '1'){
                      	 var ownerships = "";
                       	var aggregates = "";
                   		for(var $i=0; $i<$OWNERSHIP_AMOUNT; $i++){
                       		if(!isEmpty($( "#ownership" + $i ).val())){
                           		if(validate("aggregate", $( "#aggregate"+ $i ).val())){
                               		if(ownerships != ""){
                               			ownerships += ",";
                               		}
                           			ownerships += $(  "#ownership" + $i ).val();
                           			if(aggregates != ""){
                           				aggregates += ",";
                               		}
                           			aggregates += $(  "#aggregate" + $i ).val();
                           		}else{
                               		return;
                           		}
                       		}
                   		}
                      	 if(validate("ownership", ownerships) && validate("aggregate", aggregates)){
                       	    url = url + "&ownership_ids=" + ownerships + "&aggregates=" + aggregates;
                      	 }else{
                          	 return;
                      	 }
                     }else if(indicator_id == '2'){
                         //url format: [gender,cadre,aggregate;gender,cadre,aggregate;...]
                    	 var cadres = "";
                    	 for(var $i=0; $i<$CADRE_AMOUNT; $i++){
                    		 if(!isEmpty($( "#sex" + $i ).val())){
                    			 if(validate("cadre", $( "#cadre"+ $i ).val()) && validate("aggregate", $( "#aggregate"+ $i ).val())){
                    				 if(cadres != ""){
                    					 cadres += ";";
                             		}
                    				 cadres += $( "#sex"+ $i ).val() + "," + $( "#cadre"+ $i ).val() + "," + $( "#aggregate"+ $i ).val()
                        		 }else{
                            		 return;
                        		 }
                    		 }
                    	 }
                         if(validate("sex, cadre, aggregate", cadres)){
                       	  url = url + "&cadres=" + cadres;
                         }else{
                             return;
                         }
                     }else if(indicator_id == '3' || indicator_id == '4' || indicator_id == '5' || indicator_id == '6' || indicator_id == '11'){
                      if($( "#all_aggregates" ).val() == '0'){
                  	    alert("Please enter any aggregate value in the table.");
                        return;
                        }
                    	 url = url +  
                    	 "&female_0_11_amount=" + female_0_11_amount +
                    	 "&female_12_17_amount=" + female_12_17_amount +
                    	 "&female_18_49_amount=" + female_18_49_amount +
                    	 "&female_50_amount=" + female_50_amount;
                    	 if(indicator_id != '6'){
                        	 url = url +  "&male_0_11_amount=" + male_0_11_amount +
                        	 "&male_12_17_amount=" + male_12_17_amount +
                        	 "&male_18_49_amount=" + male_18_49_amount +
                        	 "&male_50_amount=" + male_50_amount;
                    	 }
                     }else{
                         return;
                     }

                  //  alert(url);
                  	 $.ajax({
                		  type:"post",
                		            url:url,     
                		  beforeSend: function(  ) {
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
                			  $( "#indicator_id" ).val("");
                			  clean_form();
                		  });
                   }
               }

               function calculate_total(){
            	   var indicator_id = $( "#indicator_id" ).val();
            	   var total =  parseInt($( "#female_0-11_amount" ).val(), 10) +
            	   parseInt($( "#female_12-17_amount" ).val(), 10) +
            	   parseInt($( "#female_18-49_amount" ).val(), 10) +
            	   parseInt($( "#female_50_amount" ).val(), 10); 
            	   if(indicator_id != '6'){
            		   total = total + parseInt($( "#male_0-11_amount" ).val(), 10) +
                	   parseInt($( "#male_12-17_amount" ).val(), 10) +
                	   parseInt($( "#male_18-49_amount" ).val(), 10) +
                	   parseInt($( "#male_50_amount" ).val(), 10);
            	   }
            	   $( "#all_aggregates" ).val(total); 
               }

               function select_indicator(){
            	   clean_form();
            	   var indicator_id = $( "#indicator_id" ).val();
            	   $("#extra").html("");
                   if(indicator_id == '11' || indicator_id == '3' || indicator_id == '4' || indicator_id == '5' || indicator_id == '6'){
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
							"title='Amount' onchange='calculate_total();'></td>" +
						"<td align='right' width='10px' style='padding: 5px 5px 5px 5px;'>Male&nbsp;&nbsp;" +
						"<input type='text' onkeypress='return isNumberKey(event)' id='male_12-17_amount' name='male_12-17_amount' value='0' class='gbvis_smallBoxInputs'" +
							"title='Amount' onchange='calculate_total();'></td>" +
						"<td align='right' width='10px' style='padding: 5px 5px 5px 5px;'>Male&nbsp;&nbsp;" +
						"<input type='text' onkeypress='return isNumberKey(event)' id='male_18-49_amount' name='male_18-49_amount' value='0' class='gbvis_smallBoxInputs'" +
							"title='Amount' onchange='calculate_total();'></td>" +
						"<td align='right' width='10px' style='padding: 5px 5px 5px 5px;'>Male&nbsp;&nbsp;" +
						"<input type='text' id='male_50_amount' name='male_50_amount' onkeypress='return isNumberKey(event)' value='0' class='gbvis_smallBoxInputs' title='Amount' onchange='calculate_total();'></td></tr>";
						}
					text = text + "<tr style='border: 1px solid gray;'><td align='right' style='padding: 5px 5px 5px 5px;'>Female&nbsp;&nbsp;<input " +
							"type='text' onkeypress='return isNumberKey(event)' id='female_0-11_amount' name='female_0-11_amount' value='0' class='gbvis_smallBoxInputs' title='Amount' onchange='calculate_total();'></td>" +
        	   "<td align='right' style='padding: 5px 5px 5px 5px;'>Female&nbsp;&nbsp;<input type='text' onkeypress='return isNumberKey(event)' id='female_12-17_amount' name='female_12-17_amount' value='0'" +
				"class='gbvis_smallBoxInputs' title='Amount' onchange='calculate_total();'></td>" +
			"<td align='right' style='padding: 5px 5px 5px 5px;'>Female&nbsp;&nbsp;<input " +
				"type='text' onkeypress='return isNumberKey(event)' id='female_18-49_amount'" +
				"name='female_18-49_amount' value='0' class='gbvis_smallBoxInputs' title='Amount' onchange='calculate_total();'> </td>" +
			"<td align='right' style='padding: 5px 5px 5px 5px;'>Female&nbsp;&nbsp;<input type='text' onkeypress='return isNumberKey(event)' id='female_50_amount'" +
				"name='female_50_amount' value='0' class='gbvis_smallBoxInputs' title='Amount' onchange='calculate_total();'>" +
			"</td></tr></table><div style='line-height:50%;'><br></div>" +
				"Grand total: <input type='text' id='all_aggregates' name='all_aggregates' placeholder='Grand Total' class='gbvis_smallBoxInputs' title='Grand Total' value='0' disabled='disabled'>";
                	   $("#extra").html(text);
                   }else if(indicator_id == '1'){
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
            	    "&nbsp;&nbsp;<input type='text' onkeypress='return isNumberKey(event)' id='aggregate" + $i + "'' placeholder='Aggregate' class='gbvis_smallBoxInputs' title='Aggregate' disabled=disabled><div style='line-height:50%;'><br></div>";
                       }
                	   $("#extra").html(text);
                   }else if(indicator_id == '2'){
                	   var text = "";
                	   for(var $i=0; $i<$CADRE_AMOUNT; $i++){
                		   text += "<select id='sex" + $i + "' class='gbvis_select' title='Select Sex' width='400px' onchange='selectSex(" + $i + ")'>" +
     						"<option value=''>-- Select Sex --</option>" +
    						"<option value='Male'>Male</option>" +
    						"<option value='Female'>Female</option></select>&nbsp;&nbsp;" + 
    						"<select id='cadre" + $i + "' class='gbvis_select' title='Select Cadre' width='400px' disabled=disabled onchange='selectCadre(" + $i + ")'>" +
      						"<option value=''>-- Select Cadre --</option>" + 
      						<?php
      						echo "\"";
      						foreach ($cadres as $urows) {
      						    echo "<option value='" . $urows['0'] . "'>" . ucfirst($urows['1']) . "</option>";
      						}
      						echo "</select>\" + ";
      							    ?> 
              	    "&nbsp;&nbsp;<input type='text' onkeypress='return isNumberKey(event)' id='aggregate" + $i + "' placeholder='Aggregate' class='gbvis_smallBoxInputs' title='Aggregate' disabled=disabled><div style='line-height:50%;'><br></div>";
                	   }
                	   $("#extra").html(text);
                       }
               }

               function isNumberKey(e){
          	      if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
          	                return false;
          	     }
               }


    </script>

<div id="main-content_with_side_bar">

	<div id="content-body">
		<center>
			<h2 class="page-title">Welcome to the National Sexual Gender Violence
				Information System (GBVIS)</h2>
		</center>
		<!-- TA:60:1 -->
		<div class="profile-data" align="left">

			<!-- TA:60:1 START -->

			<div id='progress_bar' align='center'style="position: absolute; top: 250px; left: 200px;"></div>
			
			<div id="entry_form">

			<h2 class="page-title-section">Health sector data entry</h2>
			<table width="800px" border="0" cellspacing="5"
				style='font-family: Verdana, Geneva, sans-serif; font-size: 12px;'>
				<tr>
					<td><select id="indicator_id" name="indicator_id"
						class="gbvis_select" title="Select Indicator" width='400px' onchange='select_indicator();'>
							<option value="">-- Select Indicator --</option>
											<?php
    foreach ($indicators as $urows) {
        echo "<option value='" . $urows['2'] . "'>" . ucfirst($urows['3']) . "</option>";
    }
    ?>
									</select></td>
				</tr>
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
					<td><div id='extra'></div>
						
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