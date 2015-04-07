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
                                   <th align="left" colspan="2" width="20px"><b><center>
                                     Prosecution Sector
                                   </center></b></th>
                                
                               </thead>
                                <thead style="padding-left:5px;">
                                  
                                   <th align="left" ><b style="padding-left:5px;">Indicator</b></th>
			           <th align="left"><b>Aggreagates </b></th>
			           <!--<th align="left"><b>More</b></th>-->
                               </thead>
                                <?php   $result = mysql_query("select b.title,a.aggregates from viewprosecutionsummary a
inner join indicators_titles b on a.indicator_id=b.titleid");
					
						   while($ro = mysql_fetch_array($result)){  ?>
        <tr bgcolor="#FFFFFF" ><td><p style="padding-left:5px; font-size: 10px;"><?php echo $ro['title'];?></p></td><td><?php echo $ro['aggregates'];?></td></tr>
			     <?php } ?>    
			    </table>
			    </table>
		       </section>
		    <section class="float_right">
		     <section class="float_right_section1">
			    <table width="100%" border="0" align="center" cellspacing="1" class="table-hover" >
			         <thead>
                                   <th align="left" colspan="2" width="20px"><b><center>
                                     Number of prosecutors trained
                                   </center></b></th>
                                
                               </thead>
                                <thead style="padding-left:5px;">
                                  
                                   <th align="left" ><b style="padding-left:5px;">County</b></th>
			           <th align="left"><b>Aggreagates </b></th>
			           <!--<th align="left"><b>More</b></th>-->
                               </thead>
                               <?php   $result = mysql_query("SELECT * FROM viewtop5prosecutorstrained");
					
						   while($ro = mysql_fetch_array($result)){  ?>
        <tr bgcolor="#FFFFFF" ><td><p style="padding-left:5px; font-size: 10px;"><?php echo $ro['county_name'];?></p></td><td><?php echo $ro['Trained'];?></td></tr>
			     <?php } ?>    
			     
			    </table>
		     </section>
		    <section class="float_right_section2">
		    	  <table width="100%" border="0" align="center" cellspacing="1" class="table-hover" >
			         <thead>
                                   <th align="left" colspan="2" width="20px"><b><center>
                                     Proportion of prosecuted cases
                                   </center>
                                   </b></th>
                                
                               </thead>
                                <thead style="padding-left:5px;">
                                  
                                   <th align="left" ><b style="padding-left:5px; ">County</b></th>
			           <th align="left"><b>Aggreagates </b></th>
			           <!--<th align="left"><b>More</b></th>-->
                               </thead>
                                 <?php   $result = mysql_query("SELECT * FROM viewtop5prosecutedcases");
					
						   while($ro = mysql_fetch_array($result)){  ?>
        <tr bgcolor="#FFFFFF" ><td><p style="padding-left:5px; font-size: 10px;"><?php echo $ro['county_name'];?></p></td><td><?php echo $ro['countyPercentage'];?></td></tr>
			     <?php } ?>    
			    </table> 
			    
			    
		    </section>
		     <section class="float_right_section3">
		    	  <table width="100%" border="0" align="center" cellspacing="1" class="table-hover" >
			         <thead>
                                   <th align="left" colspan="2" width="20px"><b><center>
                                     Number of cases received
                                   </center>
                                   </b></th>
                                
                               </thead>
                                <thead style="padding-left:5px;">
                                  
                                   <th align="left" ><b style="padding-left:5px;">County</b></th>
			           <th align="left"><b>Aggreagates </b></th>
			           <!--<th align="left"><b>More</b></th>-->
                            </thead> 
			      <?php   $result = mysql_query("SELECT * FROM viewtop5receivedcases");
					
						   while($ro = mysql_fetch_array($result)){  ?>
        <tr bgcolor="#FFFFFF" ><td><p style="padding-left:5px; font-size: 10px;"><?php echo $ro['county_name'];?></p></td><td><?php echo $ro['Aggregate'];?></td></tr>
			     <?php } ?>    
			    </table>
		    </section>
		    
				</section>
				</div>
			<div id="dashboardBottom"  >
				
				
				
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