<?php
//index.php
  $page_title = "Analytical Reports | GBV";
    $current_page = "Analytical Reports";
	
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
	<h3 class="page-title">Analytical reports</h3>
	<hr size="1" color="#CCCCCC">       
		   <div class="profile-data" align="left">
   
	<table width="100%" border="0" align="center" cellspacing="1" class="table-hover">
	 <thead>
          <td align="left" ><b></b></td>
	 </thead>
	  <tr>
         <td align="left"><a class="data-links" href='Highcharts/examples/pie-drilldown/index3.php'>Total SGBV Aggregates</a></td>
	 </tr>
	 <tr>
	
      <td align="left"><a class="data-links" href='Highcharts/examples/pie-drilldown/index3.php'>National SGBV Prosecuted Cases</a></td>
	 </tr>
	  <tr>
	
      <td align="left"><a class="data-links" href='Highcharts/examples/pie-drilldown/index3.php'>National SGBV Cases Reported</a></td>
	 </tr>
	  <tr>
	
      <td align="left"><a class="data-links" href='Highcharts/examples/pie-drilldown/index3.php'>Top Counties With most SGV incidence</a></td>
	 </tr>
	  <tr>
      <td align="left"><a class="data-links" href='Highcharts/examples/pie-drilldown/index3_column.php'>National Total Aggregates per indicator</a></td>
	 </tr>
	</table>
	
    <br clear="all"><br clear="all">

<hr size="1" color="#CCCCCC">
<br clear="all">

</div>
<br clear="all">

	    </div> 		

	 </div> 	 
 <?php
 include "includes/footer.php"; 
	}
else
{
	//Redirect user back to login page if there is no valid session created
	header("Location: ../login.php");
}
?>