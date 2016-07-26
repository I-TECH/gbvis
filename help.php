<?php
//index.php
  $page_title = "Help | GBV";
    $current_page = "Help";
	
require_once 'includes/global.inc.php';


 //check to see if they're logged in
// if(isset($_SESSION['logged_in'])) {

//get the user object from the session
$user = unserialize($_SESSION['user']);


include "includes/Dash_header.php"; 
include "includes/topbar.php"; //TA:60:1

?>

 

<script type="text/javascript">

function toggle(displayText, toggleText) {
	var ele = document.getElementById(toggleText);
	var text = document.getElementById(displayText);
	if(ele.style.display == "block") {
    		ele.style.display = "none";
  		  text.innerHTML = "<img src='UI/images/arrow-right.png' width=15px height=15px>";
  	}else {
		ele.style.display = "block";
		text.innerHTML = "<img src='UI/images/arrow-bottom.png' width=15px height=15px>";
	}
} 

</script>
	
	 
	  <div id="main-content">
	    
        <div id="content-body">
		<center><h2 class="page-title">Welcome to the National Sexual Gender Violence Information System (GBVIS)</h2></center> 
	      <hr size="1" color="#fff">
	        
		   <div class="profile-data" align="left" style='font-family: Verdana, Geneva, sans-serif; font-size: 12px;'>
		   <h2 class="page-title-section"></h2>
		   <div style="font-size: 18px; font-family: Verdana, Geneva, sans-serif;"><b>HELP: Frequently Asked Questions</b></div>
		   
		   <?php $index=1;?>
		   
		   <br><div id='help_text' style="padding-left:20px;"><h3>LOGIN HELP</h3></div>
		   
		   <div id='help_text' style="padding-left:40px;"> 
		   <a id="displayText<?php echo $index;?>" href="javascript:toggle('displayText<?php echo $index;?>', 'toggleText<?php echo $index;?>');"><img src='UI/images/arrow-right.png' width=15px height=15px></a>
		   <b>I can't access the SGBVIS platform.</b></div>
           <div id="toggleText<?php echo $index;?>" style="display: none; padding-left:60px;">
           <ul>
           <li>Check that you have entered the correct URL address.</li>
           <li>Check to ensure that you are connected to Internet. If you cannot connect, check your computer's network setting to ensure you are connected to Wi-Fi or a cabled connection. If cabled, check that all cables are snugly connected.</li>
           <li>If you still cannot log in, contact the system administrator for your facility or contact the NGEC SGBVIS Help Line:  Tel: 0203213199 email: <a href="mailto:sgbvis@ngeckenya.org">sgbvis@ngeckenya.org</a></li>
           </ul>
           </div>
            <?php $index++;?>
           
		   <div id='help_text' style="padding-left:40px;"> 
		   <a id="displayText<?php echo $index;?>" href="javascript:toggle('displayText<?php echo $index;?>', 'toggleText<?php echo $index;?>');"><img src='UI/images/arrow-right.png' width=15px height=15px></a>
		   <b>I can't log in to SGBVIS.</b></div>
           <div id="toggleText<?php echo $index;?>" style="display: none; padding-left:60px;">
           <ul>
           <li>Check that you have correctly spelled your user name and password.</li>
           <li>Check that CAPS LOCK is not enabled on your keyboard.</li>
           <li>If you still cannot log in, contact the system administrator for your facility or contact the NGEC SGBVIS Help Line: 	Tel: 0203213199 email: <a href="mailto:sgbvis@ngeckenya.org">sgbvis@ngeckenya.org</a></li>
           </ul>
           </div>
            <?php $index++;?>
            
            <div id='help_text' style="padding-left:40px;"> 
		   <a id="displayText<?php echo $index;?>" href="javascript:toggle('displayText<?php echo $index;?>', 'toggleText<?php echo $index;?>');"><img src='UI/images/arrow-right.png' width=15px height=15px></a>
		   <b>I forgot my password.</b></div>
           <div id="toggleText<?php echo $index;?>" style="display: none; padding-left:60px;">
           <ul>
           <li>Click Reset on the login page. Follow the steps.</li>
           <li>Check that CAPS LOCK is not enabled on your keyboard.</li>
           <li>If the above does not work, contact the system administrator for your facility or contact the NGEC SGBVIS Help Line:    
           Tel: 0203213199 email: <a href="mailto:sgbvis@ngeckenya.org">sgbvis@ngeckenya.org</a></li>
           </ul>
           </div>
            <?php $index++;?>
            
           
           <br><div id='help_text' style="padding-left:20px;"><h3>NAVIGATION HELP</h3></div> 
            
          <div id='help_text' style="padding-left:40px;"> 
		   <a id="displayText<?php echo $index;?>" href="javascript:toggle('displayText<?php echo $index;?>', 'toggleText<?php echo $index;?>');"><img src='UI/images/arrow-right.png' width=15px height=15px></a>
		   <b>I cannot see the data entry page/ I can only view data, not enter data or run reports/I cannot see the tab I need.</b></div>
           <div id="toggleText<?php echo $index;?>" style="display: none; padding-left:60px;">
           <ul>
           <li>Double check that you have permission to enter data in your user profile. Check with your administrator to make sure that your user profile gives you the appropriate permissions.</li>
           </ul>
           </div>
            <?php $index++;?>
            
            <br><div id='help_text' style="padding-left:20px;"><h3>DATE ENTRY AND REPORT HELP</h3></div>
            
            <div id='help_text' style="padding-left:40px;"> 
		   <a id="displayText<?php echo $index;?>" href="javascript:toggle('displayText<?php echo $index;?>', 'toggleText<?php echo $index;?>');"><img src='UI/images/arrow-right.png' width=15px height=15px></a>
		   <b>I enter my data manually and I click on ENTER and nothing happens.</b></div>
           <div id="toggleText<?php echo $index;?>" style="display: none; padding-left:60px;">
           <ul>
           <li>Log out and log in again. Re-enter the data.</li>
           <li>Check that CAPS LOCK is not enabled on your keyboard.</li>
           <li>If the above does not work, this may be a software bug. Contact the system administrator for your facility or contact the NGEC SGBVIS Help Line:    
           Tel: 0203213199 email: <a href="mailto:sgbvis@ngeckenya.org">sgbvis@ngeckenya.org</a></li>
           </ul>
           </div>
            <?php $index++;?>
            
		  <div id='help_text' style="padding-left:40px;"> 
		   <a id="displayText<?php echo $index;?>" href="javascript:toggle('displayText<?php echo $index;?>', 'toggleText<?php echo $index;?>');"><img src='UI/images/arrow-right.png' width=15px height=15px></a>
		   <b>The Excel upload did not work.</b></div>
           <div id="toggleText<?php echo $index;?>" style="display: none; padding-left:60px;">
           <ul>
           <li>Make sure that you filled the Excel template in correctly. Do not change columns or rows in the Excel template.</li>
           <li>If the above does not work, this may be a software bug. Contact the system administrator for your facility or contact the NGEC SGBVIS Help Line:   
           Tel: 0203213199 email: <a href="mailto:sgbvis@ngeckenya.org">sgbvis@ngeckenya.org</a></li>
           </ul>
           </div>
            <?php $index++;?>
            
		  <div id='help_text' style="padding-left:40px;"> 
		   <a id="displayText<?php echo $index;?>" href="javascript:toggle('displayText<?php echo $index;?>', 'toggleText<?php echo $index;?>');"><img src='UI/images/arrow-right.png' width=15px height=15px></a>
		   <b>The report does not match the data I entered.</b></div>
           <div id="toggleText<?php echo $index;?>" style="display: none; padding-left:60px;">
           <ul>
           <li>Check for data entry errors (reversed numbers, mistyped figures, etc.).</li>
           </ul>
           </div>
            <?php $index++;?>
            
		  <div id='help_text' style="padding-left:40px;"> 
		   <a id="displayText<?php echo $index;?>" href="javascript:toggle('displayText<?php echo $index;?>', 'toggleText<?php echo $index;?>');"><img src='UI/images/arrow-right.png' width=15px height=15px></a>
		   <b>I hit Generate report but nothing happens.</b></div>
           <div id="toggleText<?php echo $index;?>" style="display: none; padding-left:60px;">
           <ul>
           <li>Make sure you have selected the sector, report name, dates, and county before proceeding.</li>
           </ul>
           </div>
            <?php $index++;?>

		   
		   <br><div style="padding-left:20px;font-size: 12px;
font-family: Verdana, Geneva, sans-serif;">NGEC SGBVIS Help Line<br>
Tel: 0203213199 Email: <a href="mailto:sgbvis@ngeckenya.org">sgbvis@ngeckenya.org</a>
		   </div>
		   
		   </div>
       
		   
		   
     

</div><br clear="all">

	    </div> 		
	 	
 <?php
 include "includes/footer.php"; 
/*	}else{
	//Redirect user back to login page if there is no valid session created
	header("Location: login.php");
}*/
?>


