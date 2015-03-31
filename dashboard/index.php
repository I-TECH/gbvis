<?php
//index.php
  $page_title = "Home | GBV";
    $current_page = "Home";
	
require_once 'includes/global.inc.php';


 //check to see if they're logged in
if(isset($_SESSION['logged_in'])) {

//get the user object from the session
$user = unserialize($_SESSION['user']);


include "includes/header.php"; 
?>
	  <div id="sidebar">
	  <center><h3 style="text-size:18px;  font-family: TStar-Bol"></h3></center>
	<div class="sidebar-nav">
	<?php
	  include "includes/sidebar.php"; 
	  ?>
	</div> 
	  </div> 
	  <div id="main-content">
	    <div id="bread-crumbs">
	      <!--breadcrumbs-->
	    </div>
        <div id="content-body">
		<center><h3 class="page-title">Welcome to GBVIS</h3></center>
	       <hr size="1" color="#CCCCCC">
		   <div class="profile-data" align="left">
		   
		   <center>
            <div id="dashboard" >
			
			<div id="dashboardTop"  >
				<!--<h2>Main features</h2>-->
			<section class="float_left">
			  <table width="100%" border="0" align="center" cellspacing="1" class="table-hover" >
			   <thead>
                                   <th align="left" colspan="2" width="20px"><b><center>Health Sector</center></b></th>
                                
                               </thead>
                                <thead style="padding-left:5px;">
                                  
                                   <th align="left" ><b style="padding-left:5px;">Indicator</b></th>
			           <th align="left"><b>Aggregates </b></th>
			           <!--<th align="left"><b>More</b></th>-->
                               </thead>
                               <tr bgcolor="#FFFFFF" >
                                 <td><p style="padding-left:5px;">Number of cases Reported</p></td>
				 <td>560</td>
				 </tr>
				  <tr bgcolor="#FFFFFF" >
				  <td><p style="padding-left:5px;">Health Facilities providing Comprehensive clinical service For SBV Survivors</p></td>
				 <td>346</td>
				 </tr>
			      <tr bgcolor="#FFFFFF" >
				  <td><p style="padding-left:5px;">SGBV Survivors who recieved comprensive care</p></td>
				 <td>346</td>
				 </tr>
			       
			       <tr bgcolor="#FFFFFF" >
				  <td><p style="padding-left:5px;">Service Providers trained on management of SGBV Survivors</p> </td>
				 <td>200</td>
				 </tr>
				  <tr bgcolor="#FFFFFF" >
				  <td><p style="padding-left:5px;">SV survivors inititated on post_exposure prophylaxis</p> </td>
				 <td>200</td>
				 </tr>
				  </tr>
				  <tr bgcolor="#FFFFFF" >
				  <td><p style="padding-left:5px;">SV survivors completed  post_exposure prophylaxis</p> </td>
				 <td>200</td>
				 </tr>
			       
			    </table>
		       </section>
		    <section class="float_right">
		     <section class="float_right_section1">
		     	  <table width="100%" border="0" align="center" cellspacing="1" class="table-hover" >
			         <thead>
                                   <th align="left" colspan="2" width="20px"><b><center>Top 5 Counties with SGBV Reports</center></b></th>
                                
                               </thead>
                                <thead style="padding-left:5px;">
                                  
                                   <th align="left" ><b style="padding-left:5px;">County</b></th>
			           <th align="left"><b>Aggreagates </b></th>
			           <!--<th align="left"><b>More</b></th>-->
                               </thead>
                               <tr bgcolor="#FFFFFF" >
                                 <td><p style="padding-left:5px;">Mombasa</p></td>
				 <td><p>560</p></td>
			      <tr bgcolor="#FFFFFF" >
				  <td><p style="padding-left:5px;">Kisumu</p></td>
				 <td><p>346</p></td>
				 </tr>
			       </tr>
			       <tr bgcolor="#FFFFFF" >
				  <td><p style="padding-left:5px;">Nairobi</p> </td>
				 <td><p>200</p></td>
				 </tr>
				 <tr bgcolor="#FFFFFF" >
				  <td><p style="padding-left:5px;">Kiambu</p> </td>
				 <td><p>200<p></td>
				 </tr>
			       </tr>
			    </table>
		     </section>
		    <section class="float_right_section2">
		    	  <table width="100%" border="0" align="center" cellspacing="1" class="table-hover" >
			         <thead>
                                   <th align="left" colspan="2" width="20px"><b><center>Top 5 Counties with SGBV Reports</center></b></th>
                                
                               </thead>
                                <thead style="padding-left:5px;">
                                  
                                   <th align="left" ><b style="padding-left:5px;">County</b></th>
			           <th align="left"><b>Aggreagates </b></th>
			           <!--<th align="left"><b>More</b></th>-->
                               </thead>
                               <tr bgcolor="#FFFFFF" >
                                 <td><p style="padding-left:5px;">Mombasa</p></td>
				 <td>560</td>
			      <tr bgcolor="#FFFFFF" >
				  <td><p style="padding-left:5px;">Kisumu</p></td>
				 <td>346</td>
				 </tr>
			       </tr>
			       <tr bgcolor="#FFFFFF" >
				  <td><p style="padding-left:5px;">Nairobi</p> </td>
				 <td>200</td>
				 </tr>
				 <tr bgcolor="#FFFFFF" >
				  <td><p style="padding-left:5px;">Kiambu</p> </td>
				 <td>200</td>
				 </tr>
			       </tr>
			    </table>
		    </section>
		    <section class="float_right_section3">
		    	  <table width="100%" border="0" align="center" cellspacing="1" class="table-hover" >
			         <thead>
                                   <th align="left" colspan="2" width="20px"><b><center>Top 5 Counties with SGBV Reports</center></b></th>
                                
                               </thead>
                                <thead style="padding-left:5px;">
                                  
                                   <th align="left" ><b style="padding-left:5px;">County</b></th>
			           <th align="left"><b>Aggreagates </b></th>
			           <!--<th align="left"><b>More</b></th>-->
                               </thead>
                               <tr bgcolor="#FFFFFF" >
                                 <td><p style="padding-left:5px;">Mombasa</p></td>
				 <td>560</td>
			      <tr bgcolor="#FFFFFF" >
				  <td><p style="padding-left:5px;">Kisumu</p></td>
				 <td>346</td>
				 </tr>
			       </tr>
			       <tr bgcolor="#FFFFFF" >
				  <td><p style="padding-left:5px;">Nairobi</p> </td>
				 <td>200</td>
				 </tr>
				 <tr bgcolor="#FFFFFF" >
				  <td><p style="padding-left:5px;">Kiambu</p> </td>
				 <td>200</td>
				 </tr>
			       </tr>
			    </table>
		    </section>
		    <section class="float_right_section4">
		    	  <table width="100%" border="0" align="center" cellspacing="1" class="table-hover" >
			         <thead>
                                   <th align="left" colspan="2" ><b><center>Top 5 Counties with SGBV Reports</center></b></th>
                                
                               </thead>
                                <thead style="padding-left:5px;">
                                  
                                   <th align="left" ><b style="padding-left:5px;">County</b></th>
			           <th align="left"><b>Aggreagates </b></th>
			           <!--<th align="left"><b>More</b></th>-->
                               </thead>
                               <tr bgcolor="#FFFFFF" >
                                 <td><p style="padding-left:5px;">Mombasa</p></td>
				 <td>560</td>
			      <tr bgcolor="#FFFFFF" >
				  <td><p style="padding-left:5px;">Kisumu</p></td>
				 <td>346</td>
				 </tr>
			       </tr>
			       <tr bgcolor="#FFFFFF" >
				  <td><p style="padding-left:5px;">Nairobi</p> </td>
				 <td>200</td>
				 </tr>
				 <tr bgcolor="#FFFFFF" >
				  <td><p style="padding-left:5px;">Kiambu</p> </td>
				 <td>200</td>
				 </tr>
			       </tr>
			    </table>
		          </section>
		    
				</section>
				</div>
			<div id="dashboardBottom"  >
				
				<section class="float_left">
				<table width="100%" border="0" align="center" cellspacing="1" class="table-hover" >
			   <thead>
                                   <th align="left" colspan="2" width="20px"><b><center>Judiciary Sector</center></b></th>
                                
                               </thead>
                                <thead style="padding-left:5px;">
                                  
                                   <th align="left" ><b style="padding-left:5px;">Indicator</b></th>
			           <th align="left"><b>Aggreagates </b></th>
			           <!--<th align="left"><b>More</b></th>-->
                               </thead>
                               <tr bgcolor="#FFFFFF" >
                                 <td><p style="padding-left:5px;">Trained prosecutors using SGBV prosecutors Manual</p></td>
				 <td>560</td>
			      <tr bgcolor="#FFFFFF" >
				  <td><p style="padding-left:5px;">Proportion of  Prosecuted SGBV withdrawn</p></td>
				 <td>346</td>
				 </tr>
			       </tr>
			       <tr bgcolor="#FFFFFF" >
				  <td><p style="padding-left:5px;">Proportion of  Prosecuted SGBV Convicted</p> </td>
				 <td>200</td>
				 </tr>
				  <tr bgcolor="#FFFFFF" >
				  <td><p style="padding-left:5px;">Average time to conclude SGBV Cases</p> </td>
				 <td>200</td>
				 </tr>
			       </tr>
			    </table>
				</section>
				<section class="float_right">
				<table width="100%" border="0" align="center" cellspacing="1" class="table-hover" >
			         <thead>
                                   <th align="left" colspan="2" width="20px"><b><center>Top 5 Counties with SGBV Reports</center></b></th>
                                
                               </thead>
                                <thead style="padding-left:5px;">
                                  
                                   <th align="left" ><b style="padding-left:5px;">County</b></th>
			           <th align="left"><b>Aggreagates </b></th>
			           <!--<th align="left"><b>More</b></th>-->
                               </thead>
                               <tr bgcolor="#FFFFFF" >
                                 <td><p style="padding-left:5px;">Mombasa</p></td>
				 <td>560</td>
			      <tr bgcolor="#FFFFFF" >
				  <td><p style="padding-left:5px;">Kisumu</p></td>
				 <td>346</td>
				 </tr>
			       </tr>
			       <tr bgcolor="#FFFFFF" >
				  <td><p style="padding-left:5px;">Nairobi</p> </td>
				 <td>200</td>
				 </tr>
				 <tr bgcolor="#FFFFFF" >
				  <td><p style="padding-left:5px;">Kiambu</p> </td>
				 <td>200</td>
				 </tr>
			       </tr>
			    </table>
				
				</section>
				<section class="float_left">
				<table width="100%" border="0" align="center" cellspacing="1" class="table-hover" >
			   <thead>
                                   <th align="left" colspan="2" width="20px"><b><center>Police Sector</center></b></th>
                                
                               </thead>
                                <thead style="padding-left:5px;">
                                  
                                   <th align="left" ><b style="padding-left:5px;">Indicator</b></th>
			           <th align="left"><b>Aggreagates </b></th>
			           <!--<th align="left"><b>More</b></th>-->
                               </thead>
                               <tr bgcolor="#FFFFFF" >
                                 <td><p style="padding-left:5px;">SBV Cases Reported</p></td>
				 <td>746</td>
			      <tr bgcolor="#FFFFFF" >
				  <td><p style="padding-left:5px;">Trained Police on response to SGBV incidents</p></td>
				 <td>5346</td>
				 </tr>
			       </tr>
			       <tr bgcolor="#FFFFFF" >
				  <td><p style="padding-left:5px;">SGBV Cases prosecuted by law</p> </td>
				 <td>260</td>
				 </tr>
				  <tr bgcolor="#FFFFFF" >
				  <td><p style="padding-left:5px;">Police Stations with functional  Gender Desks</p> </td>
				 <td>200</td>
				 </tr>
			       </tr>
			    </table>
				</section>
				<section class="float_right">
				<table width="100%" border="0" align="center" cellspacing="1" class="table-hover" >
			         <thead>
                                   <th align="left" colspan="2" width="20px"><b><center>Top 5 Counties with SGBV Reports</center></b></th>
                                
                               </thead>
                                <thead style="padding-left:5px;">
                                  
                                   <th align="left" ><b style="padding-left:5px;">County</b></th>
			           <th align="left"><b>Aggreagates </b></th>
			           <!--<th align="left"><b>More</b></th>-->
                               </thead>
                               <tr bgcolor="#FFFFFF" >
                                 <td><p style="padding-left:5px;">Mombasa</p></td>
				 <td>560</td>
			      <tr bgcolor="#FFFFFF" >
				  <td><p style="padding-left:5px;">Kisumu</p></td>
				 <td>346</td>
				 </tr>
			       </tr>
			       <tr bgcolor="#FFFFFF" >
				  <td><p style="padding-left:5px;">Nairobi</p> </td>
				 <td>200</td>
				 </tr>
				 <tr bgcolor="#FFFFFF" >
				  <td><p style="padding-left:5px;">Kiambu</p> </td>
				 <td>200</td>
				 </tr>
			       </tr>
			    </table>
				</section>
				
				
				</div>
				
				</div>
				
	         <a href="MoreDashboard.php" align="left" style="font-family:Verdana, Geneva, sans-serif; font-size:15px; color:white; text-decoration:none;padding-right:2px;">More Summary</a>     
          </div>    
        </center>
		   
		   
      <br clear="all">

</div><br clear="all">
</center>
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