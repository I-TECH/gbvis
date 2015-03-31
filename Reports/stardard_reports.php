<?php
//index.php
  $page_title = "Home | GBV";
    $current_page = "home";
	
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
	<h3 class="page-title">Stardard reports</h3>
	<br clear="all">
	    <form action="#">
          <input type="text" name="search" value="" id="id_search" placeholder="Filter records here" autofocus />
        </form>
	
	<hr size="1" color="#CCCCCC">       
		   <div class="profile-data" align="left">
   

	<table width="100%" border="0" align="center" cellspacing="1" class="table-hover">
	 <thead>
	 
          <td align="left" ><b></b></td>
	 </thead>
	 <tr>
        <td align="left"><a class="data-links" href='standardreport/casesreported.php'>National SGBV Cases Reported</a></td>
       </tr>
        <tr>
      <td align="left"><a class="data-links" href='standardreport/standardreport.php'>National SGBV Prosecuted Cases</a></td>
       </tr>
        <tr>
       <td align="left"><a class="data-links" href='standardreport/display_report.php'>National Prosecutor Trained </a></td>
        </tr>
        <tr>
        <td align="left"><a class="data-links" href='standardreport/display_report.php'>Top Counties With most SGV incidence</a></td>
	 </tr>
        <tr>
	 <td align="left"><a class="data-links" href='standardreport/display_report.php'>Proportion Of SV Survivors initiated on Post exposure prophylaxix</a></td>
	</tr>
	<tr>
	 <td align="left"><a class="data-links" href='standardreport/display_report.php'>Proportion Of SV Survivors who have completed Post exposure prophylaxix</a></td>
	</tr>
	</table>
	
    <br clear="all"><br>
<br clear="all">

</div>
<br clear="all">

<!--filter includes-->
    <script type="text/javascript" src="../css/filter-as-you-type/jquery.min.js"></script>
    <script type="text/javascript" src="../css/filter-as-you-type/jquery.quicksearch.js"></script>
    <script type="text/javascript">
                $(function() {
                  $('input#id_search').quicksearch('table tbody tr');
                });
    </script>

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