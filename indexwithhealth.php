<?php
//index.php
  $page_title = "Home | GBV";
    $current_page = "Home";
	
require_once 'includes/global.inc.php';


 //check to see if they're logged in
if(isset($_SESSION['logged_in'])) {

//get the user object from the session
$user = unserialize($_SESSION['user']);


include "includes/Dash_header.php"; 
?>
	  <div id="sidebar">
	  <center><h3 style="text-size:18px;  font-family: TStar-Bol"></h3></center>
	<div class="sidebar-nav">
	<?php
	  include "includes/sidebar.php"; 
	  ?>
	</div> 
	  </div> 
	  <div id="main-content_with_side_bar">
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
                                   <th align="left" colspan="4" width="20px"><b><center>
                                     Judiciary Sector
                                   </center>
                                   </b></th>
                                
                               </thead>
                                <thead style="padding-left:5px;">
                                  
                                   <th align="left" ><b style="">Indicator</b></th>
			           <th align="left"><b>Prosecuted </b></th>
			            <th align="left"><b>Total </b></th>
			           <th align="left"><b>Percentage(%) </b></th>
                               </thead>
                                 <?php   $result = mysql_query("SELECT * FROM viewsummarytriedcases");
					
						   while($ro = mysql_fetch_array($result)){  ?>
        <tr bgcolor="#FFFFFF" >
        <td><p style="padding-left:5px; font-size: 10px;"><?php echo $ro['indicator'];?></p></td>
        <td><?php echo $ro['nationalTriedTotal'];?></td>
         <td><?php echo $ro['nationalProsecutionTotal'];?></td>
          <td><?php echo $ro['IndicatorPercentage'];?></td>
        </tr>
			     <?php } ?>    
			    </table>
		       </section>
		    <section class="float_right">
		     <script src="Highcharts/js/highcharts.js"></script>
                     <script src="Highcharts/js/modules/exporting.js"></script>

                  <section id="container" style="min-width: 350px; height: 200px; max-width: 420px; margin: 0 auto"></section>
		  
		    </section>
				</div>
			<div id="dashboardBottom"  >
				
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
                               <?php   $result = mysql_query("SELECT * FROM viewhealthsummary a  inner join indicators_titles b
On a.indicator_id=b.titleid");
					
						   while($ro = mysql_fetch_array($result)){  ?>
        <tr bgcolor="#FFFFFF" ><td><p style="padding-left:5px;"><?php echo $ro['title'];?></p></td><td><?php echo $ro['Aggregates'];?></td></tr>
			     <?php } ?>    
			       
			    </table>
					
				</section>
				<section class="float_right">
				 <section class="float_right_section1">
		     	  	  <table width="100%" border="0" align="center" cellspacing="1" class="table-hover" >
			         <thead>
                                   <th align="left" colspan="2" width="20px"><b><center>
                                     Number of health cases reported
                                   </center>
                                   </b></th>
                                
                               </thead>
                                <thead style="padding-left:5px;">
                                  
                                   <th align="left" ><b style="padding-left:5px;">County</b></th>
			           <th align="left"><b>Aggreagates </b></th>
			           <!--<th align="left"><b>More</b></th>-->
                               </thead>
                              <?php   $result = mysql_query("SELECT * FROM viewtop5healthcasesreported");
					
						   while($ro = mysql_fetch_array($result)){  ?>
        <tr bgcolor="#FFFFFF" ><td><p style="padding-left:5px;"><?php echo $ro['county'];?></p></td><td><?php echo $ro['countyAggregate'];?></td></tr>
			     <?php } ?>    
			    </table>
		     </section>
		    <section class="float_right_section2">
		    	  <table width="100%" border="0" align="center" cellspacing="1" class="table-hover" >
			         <thead>
                                   <th align="left" colspan="2" width="20px"><b><center>Number of service providers trained</center></b></th>
                                
                               </thead>
                                <thead style="padding-left:5px;">
                                  
                                   <th align="left" ><b style="padding-left:5px;">County</b></th>
			           <th align="left"><b>Aggreagates </b></th>
			           <!--<th align="left"><b>More</b></th>-->
                               </thead>
                                 <?php   $result = mysql_query("SELECT * FROM viewtop5serviceproviderstrained");
					
						   while($ro = mysql_fetch_array($result)){  ?>
        <tr bgcolor="#FFFFFF" ><td><p style="padding-left:5px;"><?php echo $ro['county'];?></p></td><td><?php echo $ro['countyAggregate'];?></td></tr>
			     <?php } ?>    
			    </table>
		    </section>
		    .....
		     <section class="float_right_section3">
		    	  <table width="100%" border="0" align="center" cellspacing="1" class="table-hover" >
			         <thead>
                                   <th align="left" colspan="2" width="20px"><b><center>
                                     Survivors initiated on PEP
                                   </center>
                                   </b></th>
                                
                               </thead>
                                <thead style="padding-left:5px;">
                                  
                                   <th align="left" ><b style="padding-left:5px;">County</b></th>
			           <th align="left"><b>Aggreagates </b></th>
			           <!--<th align="left"><b>More</b></th>-->
                               </thead>
                              
                                 <?php   $result = mysql_query("SELECT * FROM viewtop5pepinitiated");
					
						   while($ro = mysql_fetch_array($result)){  ?>
        <tr bgcolor="#FFFFFF" ><td><p style="padding-left:5px;"><?php echo $ro['county'];?></p></td><td><?php echo $ro['countyAggregate'];?></td></tr>
			     <?php } ?>    
			    </table>
		    </section>
		    <section class="float_right_section4">
		    	  <table width="100%" border="0" align="center" cellspacing="1" class="table-hover" >
			         <thead>
                                   <th align="left" colspan="2" ><b><center>
                                     Survivors who have completed PEP
                                   </center></b></th>
                                
                               </thead>
                                <thead style="padding-left:5px;">
                                  
                                   <th align="left" ><b style="padding-left:5px;">County</b></th>
			           <th align="left"><b>Aggreagates </b></th>
			           <!--<th align="left"><b>More</b></th>-->
                               </thead>
                               <?php   $result = mysql_query("SELECT * FROM viewtop5pepcompleted");
					
						   while($ro = mysql_fetch_array($result)){  ?>
        <tr bgcolor="#FFFFFF" ><td><p style="padding-left:5px;"><?php echo $ro['county'];?></p></td><td><?php echo $ro['countyAggregate'];?></td></tr>
			     <?php } ?>    
			    </table>
		          </section>
		   
				</section>
				<section class="float_left">
				<table width="100%" border="0" align="center" cellspacing="1" class="table-hover" >
			   <thead>
                                   <th align="left" colspan="2" width="20px"><b><center>Police Sector</center></b></th>
                                
                               </thead>
                               <?php   $result = mysql_query("select b.title,a.aggregates from viewpolicesummary a
inner join indicators_titles b on a.indicator_id=b.titleid");
					
						   while($ro = mysql_fetch_array($result)){  ?>
        <tr bgcolor="#FFFFFF" ><td><p style="padding-left:5px;"><?php echo $ro['title'];?></p></td><td><?php echo $ro['aggregates'];?></td></tr>
			     <?php } ?>    
			    </table>
				</section>
				<section class="float_right">
				<table width="100%" border="0" align="center" cellspacing="1" class="table-hover" >
			         <thead>
                                   <th align="left" colspan="2" width="20px"><b><center>Number of sgbv cases reported to police</center></b></th>
                                
                               </thead>
                                <thead style="padding-left:5px;">
                                  
                                   <th align="left" ><b style="padding-left:5px; ">County</b></th>
			           <th align="left"><b>Aggreagates </b></th>
			           <!--<th align="left"><b>More</b></th>-->
                               </thead>
                             <?php   $result = mysql_query("SELECT * FROM viewtop5casesreported");
					
						   while($ro = mysql_fetch_array($result)){  ?>
        <tr bgcolor="#FFFFFF" ><td><p style="padding-left:5px; font-size: 9px;"><?php echo $ro['county'];?></p></td><td><?php echo $ro['countyTotal'];?></td></tr>
			     <?php } ?>  
			    </table>
				</section>
				
				
				</div>
				
				</div>
				
	         <a href="moreDashboard.php" align="left" style="font-family:Verdana, Geneva, sans-serif; font-size:15px; color:#3E1F60; text-decoration:none;padding-right:2px;">More Summary</a>     
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