<?php
// TA:60:4
$page_title = "Education sector | GBV ";
$current_page = "home";

require_once 'includes/global.inc.php';

// check to see if they're logged in
if (isset($_SESSION['logged_in'])) {
    
    // get the user object from the session
    $user = unserialize($_SESSION['user']);
    
if( !($userTools->isAdmin($user->user_group) &&  $user->sector === '5')){
        print " You do not have permission to access this page.";
        return;
    }
    
    // include "includes/Dash_header.php";include "includes/topbar.php"; //TA:60:1
    include "../../includes/Dash_header.php"; // TA:60:1
    include "../../includes/topbar.php"; // TA:60:1
    
    $counties = $db->selectAllOrdered("counties", "county_name");
    $indicators = $db->selectAllOrderedWhere("indicators", "indicator", " sector_id=5");
    $ownership = $db->selectAllOrderedWhere("ownerships", "ownership", " sector_id=5");
    $violence_types = $db->selectAllOrderedWhere("violence_types", "violence_type", " sector_id=5");
    $identity_of_perpetrators = $db->selectAllOrderedWhere("identity_of_perpetrator", "identity", " sector_id=5");
    $place_of_victimizations = $db->selectAllOrderedWhere("place_of_victimization", "place", " sector_id=5");
    
    ?>

<!-- TA:60:1 date picker libs -->
<link rel="stylesheet"
	href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

<script type="text/javascript">

$OWNERSHIP_AMOUNT = 2;
$AGGREGATE_AMOUNT = 1;

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

		  function clean_form(){
			  $( "#date" ).val("");
			  $( "#county" ).val("");
			  add_indicator29_30(29);
			  add_indicator29_30(30);
			  add_indicator31_32_33_36(31);
			  add_indicator31_32_33_36(32);
			  add_indicator31_32_33_36(33);
			  add_indicator31_32_33_36(36);
			  add_indicator34();
		  }

		  function get_data_from_form(indicator_id){
			  var indicator = "";
			  for(var $i=0; $i<$OWNERSHIP_AMOUNT; $i++){
	  				var male_aggregate = $('#' + indicator_id + '_male_aggregate_' + $i ).val();
	  				if(male_aggregate != '' && male_aggregate != undefined){
	  					if(indicator != ""){
	  						indicator += ";";
	                 		}
	  					indicator += "male," + male_aggregate;
	                 		}

	  				var female_aggregate = $('#' + indicator_id + '_female_aggregate_' + $i).val();
	  				if(female_aggregate != ''  && female_aggregate != undefined){
	  					if(indicator != ""){
	  						indicator += ";";
	                 		}
	  					indicator += "female," + female_aggregate;
	                 		}
				     }
			     return indicator;
		  }
		  

               function enter_data(){

            	   var county_id = $( "#county" ).val();
                   var date = $( "#date" ).val();

                   
            	   if(validate("county", county_id) && validate("date", date)){
            			 
      				  var url= "";

        				//take indicator 29
        				var indicator29 = "";
        				for(var $i=0; $i<$OWNERSHIP_AMOUNT; $i++){
            				var ownership = $('#29_ownership_' + $i ).val();
            				var aggregate = $('#29_aggregate_' + $i ).val();
            				if(ownership != ''){
                				if(validate("aggregate in Indicator 'Number of schools implementing life skills'", aggregate)){
                               		if(indicator29 != ""){
                               			indicator29 += ";";
                               		}
                               		indicator29 += ownership + "," + aggregate;
                           		}else{
                               		return;
                           		}
                           		}
        			     }
        				if(indicator29 != ""){
      					  url += "&indicator29=" + indicator29;
      				  }

        				//take indicator 30
        				var indicator30 = "";
        				for(var $i=0; $i<$OWNERSHIP_AMOUNT; $i++){
        					var ownership = $('#30_ownership_' + $i ).val();
            				var aggregate = $('#30_aggregate_' + $i ).val();
            				if(ownership != ''){
                				if(validate("aggregate in Indicator 'Total number of schools surveyed for implementing life skills curriculum'", aggregate)){
                               		if(indicator30 != ""){
                               			indicator30 += ";";
                               		}
                               		indicator30 += ownership + "," + aggregate;
                           		}else{
                               		return;
                           		}
                           		}
        			     }
        				if(indicator30 != ""){
      					  url += "&indicator30=" + indicator30;
      				  }

        				//take indicator 36
        				var indicator36 = get_data_from_form(36);
        				if(indicator36 != ""){
      					  url += "&indicator36=" + indicator36;
      				  	}
        				//take indicator 33
        				var indicator33 = get_data_from_form(33);
        				if(indicator33 != ""){
      					  url += "&indicator33=" + indicator33;
      				  	}

        				//take indicator 32
        				var indicator32 = get_data_from_form(32);
        				if(indicator32 != ""){
      					  url += "&indicator32=" + indicator32;
      				  	}

        				//take indicator 31
        				var indicator31 = get_data_from_form(31);
        				if(indicator31 != ""){
      					  url += "&indicator31=" + indicator31;
      				  	}

        				//take indicator 34
        				var indicator34 = "";

        				var female_violence_type1 = $('#female_violence_type1').val();
        				var female_identity_of_perpetrators1 = $('#female_identity_of_perpetrators1').val();
        				var female_place_of_victimizations1 = $('#female_place_of_victimizations1').val();
        				var female_aggregate1 = $('#female_aggregate1').val().trim();
        				if(female_violence_type1 != "" && female_identity_of_perpetrators1 != "" && female_place_of_victimizations1 != ""){
            				if(female_aggregate1 == "" || female_aggregate1 == "0"){
                				alert("Aggregate for Female section is empty.");
                				return;
            				}else{
                				if(indicator34 != ""){
                					indicator34 += ";";
                				}
            					indicator34 += "female,<18 Yrs," + female_violence_type1 + "," + female_identity_of_perpetrators1 + "," + female_place_of_victimizations1 + "," + female_aggregate1;
            				}
        				}
        				var female_violence_type2 = $('#female_violence_type2').val();
        				var female_identity_of_perpetrators2 = $('#female_identity_of_perpetrators2').val();
        				var female_place_of_victimizations2 = $('#female_place_of_victimizations2').val();
        				var female_aggregate2 = $('#female_aggregate2').val().trim();
        				if(female_violence_type2 != "" && female_identity_of_perpetrators2 != "" && female_place_of_victimizations2 != ""){
            				if(female_aggregate2 == "" || female_aggregate2 == "0"){
                				alert("Aggregate for Female section is empty.");
                				return;
            				}else{
            					if(indicator34 != ""){
                					indicator34 += ";";
                				}
            					indicator34 += "female,<18 Yrs," + female_violence_type2 + "," + female_identity_of_perpetrators2 + "," + female_place_of_victimizations2 + "," + female_aggregate2;
            				}
        				}
        				
        				var male_violence_type1 = $('#male_violence_type1').val();
        				var male_identity_of_perpetrators1 = $('#male_identity_of_perpetrators1').val();
        				var male_place_of_victimizations1 = $('#male_place_of_victimizations1').val();
        				var male_aggregate1 = $('#male_aggregate1').val().trim();
        				if(male_violence_type1 != "" && male_identity_of_perpetrators1 != "" && male_place_of_victimizations1 != ""){
            				if(male_aggregate1 == "" || male_aggregate1 == "0"){
                				alert("Aggregate for Male section is empty.");
                				return;
            				}else{
            					if(indicator34 != ""){
                					indicator34 += ";";
                				}
            					indicator34 += "male,<18 Yrs," + male_violence_type1 + "," + male_identity_of_perpetrators1 + "," + male_place_of_victimizations1 + "," + male_aggregate1;
            				}
        				}
        				var male_violence_type2 = $('#male_violence_type2').val();
        				var male_identity_of_perpetrators2 = $('#male_identity_of_perpetrators2').val();
        				var male_place_of_victimizations2 = $('#male_place_of_victimizations2').val();
        				var male_aggregate2 = $('#male_aggregate2').val().trim();
        				if(male_violence_type2 != "" && male_identity_of_perpetrators2 != "" && male_place_of_victimizations2 != ""){
            				if(male_aggregate2 == "" || male_aggregate2 == "0"){
                				alert("Aggregate for Male section is empty.");
                				return;
            				}else{
            					if(indicator34 != ""){
                					indicator34 += ";";
                				}
            					indicator34 += "male,<18 Yrs," + male_violence_type2 + "," + male_identity_of_perpetrators2 + "," + male_place_of_victimizations2 + "," + male_aggregate2;
            				}
        				}
        				//>18 years old
        				var female_violence_type1_more18 = $('#female_violence_type1_more18').val();
        				var female_identity_of_perpetrators1_more18 = $('#female_identity_of_perpetrators1_more18').val();
        				var female_place_of_victimizations1_more18 = $('#female_place_of_victimizations1_more18').val();
        				var female_aggregate1_more18 = $('#female_aggregate1_more18').val().trim();
        				if(female_violence_type1_more18 != "" && female_identity_of_perpetrators1_more18 != "" && female_place_of_victimizations1_more18 != ""){
            				if(female_aggregate1_more18 == "" || female_aggregate1_more18 == "0"){
                				alert("Aggregate for Female section is empty.");
                				return;
            				}else{
                				if(indicator34 != ""){
                					indicator34 += ";";
                				}
            					indicator34 += "female,>18 Yrs," + female_violence_type1_more18 + "," + female_identity_of_perpetrators1_more18 + "," + female_place_of_victimizations1_more18 + "," + female_aggregate1_more18;
            				}
        				}
        				var female_violence_type2_more18 = $('#female_violence_type2_more18').val();
        				var female_identity_of_perpetrators2_more18 = $('#female_identity_of_perpetrators2_more18').val();
        				var female_place_of_victimizations2_more18 = $('#female_place_of_victimizations2_more18').val();
        				var female_aggregate2_more18 = $('#female_aggregate2_more18').val().trim();
        				if(female_violence_type2_more18 != "" && female_identity_of_perpetrators2_more18 != "" && female_place_of_victimizations2_more18 != ""){
            				if(female_aggregate2_more18 == "" || female_aggregate2_more18 == "0"){
                				alert("Aggregate for Female section is empty.");
                				return;
            				}else{
            					if(indicator34 != ""){
                					indicator34 += ";";
                				}
            					indicator34 += "female,>18 Yrs," + female_violence_type2_more18 + "," + female_identity_of_perpetrators2_more18 + "," + female_place_of_victimizations2_more18 + "," + female_aggregate2_more18;
            				}
        				}
        				
        				var male_violence_type1_more18 = $('#male_violence_type1_more18').val();
        				var male_identity_of_perpetrators1_more18 = $('#male_identity_of_perpetrators1_more18').val();
        				var male_place_of_victimizations1_more18 = $('#male_place_of_victimizations1_more18').val();
        				var male_aggregate1_more18 = $('#male_aggregate1_more18').val().trim();
        				if(male_violence_type1_more18 != "" && male_identity_of_perpetrators1_more18 != "" && male_place_of_victimizations1_more18 != ""){
            				if(male_aggregate1_more18 == "" || male_aggregate1_more18 == "0"){
                				alert("Aggregate for Male section is empty.");
                				return;
            				}else{
            					if(indicator34 != ""){
                					indicator34 += ";";
                				}
            					indicator34 += "male,>18 Yrs," + male_violence_type1_more18 + "," + male_identity_of_perpetrators1_more18 + "," + male_place_of_victimizations1_more18 + "," + male_aggregate1_more18;
            				}
        				}
        				var male_violence_type2_more18 = $('#male_violence_type2_more18').val();
        				var male_identity_of_perpetrators2_more18 = $('#male_identity_of_perpetrators2_more18').val();
        				var male_place_of_victimizations2_more18 = $('#male_place_of_victimizations2_more18').val();
        				var male_aggregate2_more18 = $('#male_aggregate2_more18').val().trim();
        				if(male_violence_type2_more18 != "" && male_identity_of_perpetrators2_more18 != "" && male_place_of_victimizations2_more18 != ""){
            				if(male_aggregate2_more18 == "" || male_aggregate2_more18 == "0"){
                				alert("Aggregate for Male section is empty.");
                				return;
            				}else{
            					if(indicator34 != ""){
                					indicator34 += ";";
                				}
            					indicator34 += "male,>18 Yrs," + male_violence_type2_more18 + "," + male_identity_of_perpetrators2_more18 + "," + male_place_of_victimizations2_more18 + "," + male_aggregate2_more18;
            				}
        				}
        				
        				
        				if(indicator34 != ""){
      					  url += "&indicator34=" + indicator34;
      				  }

        				//alert(url); //return;
        				  

        				if(url != ""){
        					  url = "enter_data.php?mode=add_aggregates" + 
        		       	   		"&date=" + date +
        		       	   		"&county_id=" + county_id + url;
        				  }else{
        					  alert("Please enter data to forms.");
        					  return;
        				  }

        				
        				
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


               function add_indicator29_30(indicator_id){
              		var text = "";
          			for(var $i=0; $i<$OWNERSHIP_AMOUNT; $i++){
            			   text += "<select id='" + indicator_id + "_ownership_" + $i + "' class='gbvis_select' title='Ownership' width='400px' onchange='selectOption(\"" + indicator_id + "_ownership_" + $i + "\",\"" + indicator_id + "_aggregate_" + $i + "\")'>" +
      						"<option value=''>-- Select Ownership --</option>" +
            			   <?php
              						echo "\"";
              						foreach ($ownership as $urows) {
              						   echo "<option value='" . $urows['0'] . "'>" . ucfirst($urows['1']) . "</option>";
              						}
              						echo "</select>\" + ";
              							    ?>
              				 "&nbsp;&nbsp;<input type='text' onkeypress='return isNumberKey(event)' id='" + indicator_id + "_aggregate_" + $i + "' placeholder='Aggregate' class='gbvis_smallBoxInputs' title='Aggregate' disabled=disabled><div style='line-height:50%;'><br></div>";
                			   
            		   }
            		  $("#indicator" + indicator_id).html(text);  
        		  }

               function add_indicator31_32_33_36(indicator_id){
              		var text = "";
          			for(var $i=0; $i<$AGGREGATE_AMOUNT; $i++){
                			   text += "Male &nbsp;&nbsp;<input type='text' onkeypress='return isNumberKey(event)' id='" + indicator_id + "_male_aggregate_" + $i + "' placeholder='Aggregate' class='gbvis_smallBoxInputs' title='Aggregate'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" +
                   				"Female&nbsp;&nbsp;<input type='text' onkeypress='return isNumberKey(event)' id='" + indicator_id + "_female_aggregate_" + $i + "' placeholder='Aggregate' class='gbvis_smallBoxInputs' title='Aggregate'><div style='line-height:50%;'><br></div>";   
                		   }
          				$("#indicator" + indicator_id).html(text);   
        		  }

               function add_indicator34(){
              		var text = "";
              		//<18 years old
          			text += "<table border=1 style='border-collapse: collapse; border: 1px solid gray;'><tr style='border: 1px solid gray; background-color: #D8D8D8;'><td colspan=2 align='center'><b><18 Yrs<br>Male</b></td><td colspan=2 align='center'><b><18 Yrs<br>Female</b></td></tr>";
          			text += "<tr>";
          			
              		text += "<td style='padding: 5px 5px 5px 5px;'>";
              		text += add_option_violence_type("male_violence_type1",  "Violence Type", "male_aggregate1", "male_identity_of_perpetrators1", "male_place_of_victimizations1");
              		text += add_option_place_of_victimizations("male_place_of_victimizations1",  "Place of Victimizations", "male_aggregate1", "male_violence_type1", "male_identity_of_perpetrators1");
              		text += add_option_identity_of_perpetrators("male_identity_of_perpetrators1",  "Identity of Perpetrators", "male_aggregate1", "male_violence_type1", "male_place_of_victimizations1");
              		text += "<input type='text' onkeypress='return isNumberKey(event)' id='male_aggregate1' disabled=disabled placeholder='Aggregate' class='gbvis_smallBoxInputs' title='Aggregate'><div style='line-height:50%;'><br></div>";
              		text += "</td>";

              		text += "<td style='padding: 5px 5px 5px 5px;'>";
              		text += add_option_violence_type("male_violence_type2",  "Violence Type", "male_aggregate2", "male_identity_of_perpetrators2", "male_place_of_victimizations2");
              		text += add_option_place_of_victimizations("male_place_of_victimizations2",  "Place of Victimizations", "male_aggregate2", "male_violence_type2", "male_identity_of_perpetrators2");
              		text += add_option_identity_of_perpetrators("male_identity_of_perpetrators2",  "Identity of Perpetrators", "male_aggregate2", "male_violence_type2", "male_place_of_victimizations2");
              		text += "<input type='text' onkeypress='return isNumberKey(event)' id='male_aggregate2' disabled=disabled placeholder='Aggregate' class='gbvis_smallBoxInputs' title='Aggregate'><div style='line-height:50%;'><br></div>";
              		text += "</td>";

              		text += "<td style='padding: 5px 5px 5px 5px;'>";
              		text += add_option_violence_type("female_violence_type1",  "Violence Type", "female_aggregate1", "female_identity_of_perpetrators1", "female_place_of_victimizations1");
              		text += add_option_place_of_victimizations("female_place_of_victimizations1",  "Place of Victimizations", "female_aggregate1", "female_violence_type1", "female_identity_of_perpetrators1");
              		text += add_option_identity_of_perpetrators("female_identity_of_perpetrators1",  "Identity of Perpetrators", "female_aggregate1", "female_violence_type1", "female_place_of_victimizations1");
              		text += "<input type='text' onkeypress='return isNumberKey(event)' id='female_aggregate1' disabled=disabled placeholder='Aggregate' class='gbvis_smallBoxInputs' title='Aggregate'><div style='line-height:50%;'><br></div>";
              		text += "</td>";

              		text += "<td style='padding: 5px 5px 5px 5px;'>";
              		text += add_option_violence_type("female_violence_type2",  "Violence Type", "female_aggregate2", "female_identity_of_perpetrators2", "female_place_of_victimizations2");
              		text += add_option_place_of_victimizations("female_place_of_victimizations2",  "Place of Victimizations", "female_aggregate2", "female_violence_type2", "female_identity_of_perpetrators2");
              		text += add_option_identity_of_perpetrators("female_identity_of_perpetrators2",  "Identity of Perpetrators", "female_aggregate2", "female_violence_type2", "female_place_of_victimizations2");
              		text += "<input type='text' onkeypress='return isNumberKey(event)' id='female_aggregate2' disabled=disabled placeholder='Aggregate' class='gbvis_smallBoxInputs' title='Aggregate'><div style='line-height:50%;'><br></div>";
              		text += "</td>";
              		
          			text += "</tr></table>";

              		//>18 years old
          			text += "<table border=1 style='border-collapse: collapse; border: 1px solid gray;'><tr style='border: 1px solid gray; background-color: #D8D8D8;'><td colspan=2 align='center'><b>>18 Yrs<br>Male</b></td><td colspan=2 align='center'><b>>18 Yrs<br>Female</b></td></tr>";
          			text += "<tr>";
          			
              		text += "<td style='padding: 5px 5px 5px 5px;'>";
              		text += add_option_violence_type("male_violence_type1_more18",  "Violence Type", "male_aggregate1_more18", "male_identity_of_perpetrators1_more18", "male_place_of_victimizations1_more18");
              		text += add_option_place_of_victimizations("male_place_of_victimizations1_more18",  "Place of Victimizations", "male_aggregate1_more18", "male_violence_type1_more18", "male_identity_of_perpetrators1_more18");
              		text += add_option_identity_of_perpetrators("male_identity_of_perpetrators1_more18",  "Identity of Perpetrators", "male_aggregate1_more18", "male_violence_type1_more18", "male_place_of_victimizations1_more18");
              		text += "<input type='text' onkeypress='return isNumberKey(event)' id='male_aggregate1_more18' disabled=disabled placeholder='Aggregate' class='gbvis_smallBoxInputs' title='Aggregate'><div style='line-height:50%;'><br></div>";
              		text += "</td>";

              		text += "<td style='padding: 5px 5px 5px 5px;'>";
              		text += add_option_violence_type("male_violence_type2_more18",  "Violence Type", "male_aggregate2_more18", "male_identity_of_perpetrators2_more18", "male_place_of_victimizations2_more18");
              		text += add_option_place_of_victimizations("male_place_of_victimizations2_more18",  "Place of Victimizations", "male_aggregate2_more18", "male_violence_type2", "male_identity_of_perpetrators2_more18");
              		text += add_option_identity_of_perpetrators("male_identity_of_perpetrators2_more18",  "Identity of Perpetrators", "male_aggregate2", "male_violence_type2_more18", "male_place_of_victimizations2_more18");
              		text += "<input type='text' onkeypress='return isNumberKey(event)' id='male_aggregate2_more18' disabled=disabled placeholder='Aggregate' class='gbvis_smallBoxInputs' title='Aggregate'><div style='line-height:50%;'><br></div>";
              		text += "</td>";

              		text += "<td style='padding: 5px 5px 5px 5px;'>";
              		text += add_option_violence_type("female_violence_type1_more18",  "Violence Type", "female_aggregate1_more18", "female_identity_of_perpetrators1_more18", "female_place_of_victimizations1_more18");
              		text += add_option_place_of_victimizations("female_place_of_victimizations1_more18",  "Place of Victimizations", "female_aggregate1_more18", "female_violence_type1_more18", "female_identity_of_perpetrators1_more18");
              		text += add_option_identity_of_perpetrators("female_identity_of_perpetrators1_more18",  "Identity of Perpetrators", "female_aggregate1_more18", "female_violence_type1_more18", "female_place_of_victimizations1_more18");
              		text += "<input type='text' onkeypress='return isNumberKey(event)' id='female_aggregate1_more18' disabled=disabled placeholder='Aggregate' class='gbvis_smallBoxInputs' title='Aggregate'><div style='line-height:50%;'><br></div>";
              		text += "</td>";

              		text += "<td style='padding: 5px 5px 5px 5px;'>";
              		text += add_option_violence_type("female_violence_type2_more18",  "Violence Type", "female_aggregate2_more18", "female_identity_of_perpetrators2_more18", "female_place_of_victimizations2_more18");
              		text += add_option_place_of_victimizations("female_place_of_victimizations2_more18",  "Place of Victimizations", "female_aggregate2_more18", "female_violence_type2_more18", "female_identity_of_perpetrators2_more18");
              		text += add_option_identity_of_perpetrators("female_identity_of_perpetrators2_more18",  "Identity of Perpetrators", "female_aggregate2_more18", "female_violence_type2_more18", "female_place_of_victimizations2_more18");
              		text += "<input type='text' onkeypress='return isNumberKey(event)' id='female_aggregate2_more18' disabled=disabled placeholder='Aggregate' class='gbvis_smallBoxInputs' title='Aggregate'><div style='line-height:50%;'><br></div>";
              		text += "</td>";
              		
          			text += "</tr></table>";
            		  $("#indicator34").html(text);  
        		  }

               function selectOption(select_comp, tf_comp){
      			  if($('#' + select_comp).val() == ""){
      				  $('#' + tf_comp).val("");
      			  }
      			  $('#' + tf_comp).prop('disabled', $('#' + select_comp).val() == "");
               }
      		  

               /*Disable aggregate field if any of those options is unselected*/
               function selectMultiOption(select_comp1, select_comp2, select_comp3, tf_comp){
        			  if($('#' + select_comp1).val() == "" || $('#' + select_comp2).val() == "" || $('#' + select_comp3).val() == ""){
        				  $('#' + tf_comp).val("");
        			  }
        			  $('#' + tf_comp).prop('disabled', !($('#' + select_comp1).val() != "" && $('#' + select_comp2).val() != "" && $('#' + select_comp3).val() != ""));
        		  }

        		  function add_option_violence_type(select_id, select_option, aggregate_id, comp2_id, comp3_id){
        			  return"<select id='" + select_id + "' class='gbvis_select' title='" + select_option + 
        			  "' width='400px' onchange='selectMultiOption(\"" + select_id + "\",\"" + comp2_id + "\",\"" + comp3_id + "\",\"" + aggregate_id + "\")'>" +
    					"<option value=''>-- Select " + select_option + " --</option>" +
          			   <?php
            						echo "\"";
            						foreach ($violence_types as $urows) {
            						   echo "<option value='" . $urows['0'] . "'>" . ucfirst($urows['1']) . "</option>";
            						}
            						echo "</select>\" + ";
            							    ?>
            				 "&nbsp;&nbsp;<div style='line-height:50%;'><br></div>";

            	  }

            	  function selectPlaceOfVictimization(select_comp, comp){
            		  var place_of_vic = $('#' + select_comp).val();
            		  //alert(comp);
            		 // $('#' + comp).append('<option value=\"1\">AAAA</option>');
            		  if(place_of_vic == "2"){ //school
            			  <?php
        						foreach ($identity_of_perpetrators as $urows) {
        						    if($urows['0'] === '1'){
        						    ?>
        						    $('#' + comp).append('<option value=\"1\"><?php echo ucfirst($urows['1'])?></option>');
        						<?php }}
        						
        							    ?>
            		  }
            	  }

            	  function selectPlaceOfVictimization(select_comp, comp){
            		  var place_of_vic = $('#' + select_comp).val();
            		  $('#' + comp).empty();
            		  $('#' + comp).append('<option value=\"\">-- Select Identity Of Perpetrator --</option>');
            		  if(place_of_vic == ""){ //no selection
            			  $('#' + comp).empty();
                		  $('#' + comp).append('<option value=\"\">Select Place of Victimization first</option>');
            		  }else if(place_of_vic == "1"){ //home
            			  <?php
        						foreach ($identity_of_perpetrators as $urows) {
        						    if($urows['0'] === '1' || $urows['0'] === '2' || $urows['0'] === '4' || $urows['0'] === '5'){
        						    ?>
        						    $('#' + comp).append('<option value=\"<?php echo ucfirst($urows['0'])?>\"><?php echo ucfirst($urows['1'])?></option>');
        						<?php }}?>
            		  }else if(place_of_vic == "2"){ //school
            			  <?php
            						foreach ($identity_of_perpetrators as $urows) {
            						    if($urows['0'] === '3' || $urows['0'] === '9'){
            						    ?>
            						    $('#' + comp).append('<option value=\"<?php echo ucfirst($urows['0'])?>\"><?php echo ucfirst($urows['1'])?></option>');
            						<?php }}?>
                		  }else if(place_of_vic == "3"){ //outside home
                			  <?php
                						foreach ($identity_of_perpetrators as $urows) {
                						    if($urows['0'] === '3' || $urows['0'] === '1' || $urows['0'] === '2' || $urows['0'] === '4' || $urows['0'] === '5' || $urows['0'] === '7' || $urows['0'] === '9'){
                						    ?>
                						    $('#' + comp).append('<option value=\"<?php echo ucfirst($urows['0'])?>\"><?php echo ucfirst($urows['1'])?></option>');
                						<?php }}?>
                    		  }
                		  else if(place_of_vic == "4"){ //place of worship
                			  <?php
                						foreach ($identity_of_perpetrators as $urows) {
                						    if($urows['0'] === '6'){
                						    ?>
                						    $('#' + comp).append('<option value=\"<?php echo ucfirst($urows['0'])?>\"><?php echo ucfirst($urows['1'])?></option>');
                						<?php }}?>
                    		  }
                		  else if(place_of_vic == "5"){ //transport
                			  <?php
                						foreach ($identity_of_perpetrators as $urows) {
                						    if($urows['0'] === '8'){
                						    ?>
                						    $('#' + comp).append('<option value=\"<?php echo ucfirst($urows['0'])?>\"><?php echo ucfirst($urows['1'])?></option>');
                						<?php }}?>
                    		  }
            	  }

//         		  function add_option_identity_of_perpetrators(select_id, select_option, aggregate_id, comp2_id, comp3_id){
//         			  return"<select id='" + select_id + "' class='gbvis_select' title='" + select_option + 
//         			  "' width='400px' onchange='selectOption(\"" + select_id + "\",\"" + comp2_id + "\",\"" + comp3_id + "\",\"" + aggregate_id + "\")'>" +
//     					"<option value=''>-- Select " + select_option + " --</option>" +
          			   <?php
//             						echo "\"";
//             						foreach ($identity_of_perpetrators as $urows) {
//             						   echo "<option value='" . $urows['0'] . "'>" . ucfirst($urows['1']) . "</option>";
//             						}
//             						echo "</select>\" + ";
//             							    ?>
//             				 "&nbsp;&nbsp;<div style='line-height:50%;'><br></div>";
//             	}

            		 function add_option_identity_of_perpetrators(select_id, select_option, aggregate_id, comp2_id, comp3_id){
              			  return"<select id='" + select_id + "' class='gbvis_select' title='" + select_option + 
              			  "' width='400px' onchange='selectMultiOption(\"" + select_id + "\",\"" + comp2_id + "\",\"" + comp3_id + "\",\"" + aggregate_id + "\")'>" +
          					"<option value=''>Select Place of Victimization first</option></select>&nbsp;&nbsp;<div style='line-height:50%;'><br></div>";
                  	}

        		  function add_option_place_of_victimizations(select_id, select_option, aggregate_id, comp2_id, comp3_id){
        			  return"<select id='" + select_id + "' class='gbvis_select' title='" + select_option + 
        			  "' width='400px' onchange='selectMultiOption(\"" + select_id + "\",\"" + comp2_id + "\",\"" + comp3_id + "\",\"" + aggregate_id + "\");" +
        			  "selectPlaceOfVictimization(\"" + select_id + "\", \"" + comp3_id + "\");'>" +
    					"<option value=''>-- Select " + select_option + " --</option>" +
          			   <?php
            						echo "\"";
            						foreach ($place_of_victimizations as $urows) {
            						   echo "<option value='" . $urows['0'] . "'>" . ucfirst($urows['1']) . "</option>";
            						}
            						echo "</select>\" + ";
            							    ?>
            				 "&nbsp;&nbsp;<div style='line-height:50%;'><br></div>";
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

				<h2 class="page-title-section">Education sector data entry</h2>
				<table width="1200px" border="0" cellspacing="5"
					style='font-family: Verdana, Geneva, sans-serif; font-size: 12px;'>

					<tr>
						<td colspan=4><select id="county" class="gbvis_select"
							width='400px' title="County">
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
					<tr>
						<td>
						<!-- 36: Number of teachers or secretariat staff trained in SGBV-->
							<b>Indicator 8.1.a Number of teachers and secretariat staff trained in SGBV</b><br>
						<div id='indicator36'></div> <script type='text/javascript'>add_indicator31_32_33_36(36)</script><br>
						
						<!-- 33: Number of MOEST staff trained in SGBV--> 
							<b>Indicator 8.1.b Number of MOEST staff trained in SGBV</b><br>
						<div id='indicator33'></div> <script type='text/javascript'>add_indicator31_32_33_36(33)</script><br>
						
						<!-- 30: Total number of schools surveyed for implementing life skills curriculum--> 
							<b>Indicator 8.2.a Total number of schools surveyed for implementing life skills curriculum</b><br>
						<div id='indicator30'></div> <script type='text/javascript'>add_indicator29_30(30)</script><br>
						
							<!-- 29: Number of schools implementing life skills curriculum that teaches students on what to do in case of victimization-->
							<b>Indicator 8.2.b Number of schools implementing life skills curriculum that teaches students on what to do in case of violation</b><br>
						<div id='indicator29'></div> <script type='text/javascript'>add_indicator29_30(29)</script><br>

						<!-- 31: Total number of children in the sample--> 
							<b>Indicator 8.3.a Total number of children in the sample</b><br>
						<div id='indicator31'></div> <script type='text/javascript'>add_indicator31_32_33_36(31)</script><br>	
							
							<!-- 32: Number of children who possess life skills--> 
							<b>Indicator 8.3.b Number of children who possess life skills</b><br>
						<div id='indicator32'></div> <script type='text/javascript'>add_indicator31_32_33_36(32)</script><br>

							<!-- 34: Number of children who report being victims of violence in the last 12 months-->
							<b>Indicator 8.4 Number of children who have indicated via self reports that they have been violated at home/school in the last 12 months</b><br>
						<div id='indicator34'></div> <script type='text/javascript'>add_indicator34()</script><br>

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