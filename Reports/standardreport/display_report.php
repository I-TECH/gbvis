<?php
//index.php
  $page_title = "Home | GBV";
    $current_page = "Display Report";
	
require_once '../includes/globallevel2.inc.php';
require_once('../../classes/dropdown.class.php');

 //check to see if they're logged in
if(isset($_SESSION['logged_in'])) {

//get the user object from the session
$user = unserialize($_SESSION['user']);


include "../includes/headerleve2.php"; 
?>
	  <div id="sidebar">
	  <center><h3 style="text-size:18px;  font-family: TStar-Bol"></h3></center>
	<div class="sidebar-nav">
	<?php
	  include "../includes/sidebarlevel2.php"; 
	  ?>
	</div> 
	  </div> 
	  <div id="main-content_with_side_bar">
	    <div id="bread-crumbs">
	      <!--breadcrumbs-->
	    </div>
        <div id="content-body">
		<h3 class="page-title"></h3>
		
	       
   <div class="profile-data" align="left">
   <br clear="all">
   <table width="100%" border="0" align="center" cellspacing="1" class="table-hover">
       <tr>
           <td  width="400px">
	   <div class="DatePickerSec">
	   <section class="alignLeft">
            
            <span class="calendar-icon"></span>
            <input id="fromdate" name="fromdate" placeholder="From Date">
         
           </section>
           <section class="alignRight">
             
            <span class="calendar-icon"></span>
            <input id="todate" name="todate" placeholder="To Date">
             </section>
             </div>
            </td>
            <td width="350px" >
            <span class="labelsDiv">County:</span>
            <?php

             $ddl=new dropdown();
       
            $ddl->dropdown('counties');
  
               ?>
              </td>
              <td>
              <button type="button" class="submit_button">Generate Report</button>
              </td>
              </tr>
         </table>
         <hr size="1" color="#CCCCCC">
             </div>
             <br clear="all">
   
    <br clear="all">
	 
</div>
  
<br clear="all">
	    </div> 		

	 </div> 
	 
	<script src="../../css/datepicker/datepickr.min.js"></script>
        <script>
            // Regular datepickr
            datepickr('#datepickr');

            // Custom date format
            datepickr('.datepickr', { dateFormat: 'd-m-Y'});
            

            // Min and max date
            datepickr('#minAndMax', {
                // few days ago
                minDate: new Date().getTime() - 2.592e8,
                // few days from now
                maxDate: new Date().getTime() + 2.592e8
            });

            // datepickr on an icon, using altInput to store the value
            // altInput must be a direct reference to an input element (for now)
            datepickr('.calendar-icon', { altInput: document.getElementById('fromdate') });
            // If the input contains a value, datepickr will attempt to run Date.parse on it
            datepickr('[title="parseMe"]');
            
           datepickr('.calendar-icon', { altInput: document.getElementById('todate') });
            // If the input contains a value, datepickr will attempt to run Date.parse on it
            datepickr('[title="parseMe"]');

            // Overwrite the global datepickr prototype
            // Won't affect previously created datepickrs, but will affect any new ones
            datepickr.prototype.l10n.months.shorthand = ['Jan', 'February', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'];
            datepickr.prototype.l10n.months.longhand = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'October', 'September', 'October', 'November', 'December'];
            datepickr.prototype.l10n.weekdays.shorthand = ['Mon', 'Tue', 'Wed', 'Thur', 'Fri', 'Sat', 'Sun'];
            datepickr.prototype.l10n.weekdays.longhand = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
            datepickr('#someFrench.sil-vous-plait', { dateFormat: '\\le M D Y' });
        </script>
 <?php
 include "../includes/footer.php"; 
	}
else
{
	//Redirect user back to login page if there is no valid session created
	header("Location: ../../login.php");
}
?>