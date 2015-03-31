<?php
/*********************************************************************
* Author: Benard Koech
* Email: benardkkoech@gmail.com.
* Gender Base violence Information system
***********************************************************************/
//index.php
  $page_title = "Settings | GBV";
    $current_page = "Settings";
	
require_once 'includes/global.inc.php';


 //check to see if they're logged in
if(isset($_SESSION['logged_in'])) {

//get the user object from the session
$user = unserialize($_SESSION['user']);


include "includes/header.php";
?>

	    <div id="sidebar">
	  <center><h3 style="text-size:18px;  background:#DDCF0D;  color:#81519C; font-family: TStar-Bol">Side Bar</h3></center>
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
		<center><h3 class="page-title">Settings</h3></center>
        <div class="profile-data"  align="left">
		   <div style=" float:left; width:100%; display:block;">
            <section style=" float:left; width:50%; display:block; height:100%;" class="">
			<p><a href="sectors.php" style="text-decoration:none;"><img src="images/secs.jpg" height="70" /> Sectors<a/></p>
			</section>
			<section style=" float:left; width:50%; display:block; height:100%;" class="">
						<p><a href="devolved_structure.php" style="text-decoration:none;"><img src="images/reg.jpg" height="70" /> Devolved Structure<a/></p>
			</section>
			</div>
			<div>
             <section style=" float:left; width:50%;" class="">
			<a href="admin_indicators.php" style="text-decoration:none;"><img src="images/stats.jpg" height="70" /> Indicators<a/>
			</section>
			<section style=" float:left; width:50%;" class="">
						<section><a href="" style="text-decoration:none;"><img src="images/reports.jpg" height="70" /> Reports<a/>
			</section>
			</div>
      <br clear="all"><br clear="all"><br clear="all">
      </div><br clear="all">

	    </div> 		
	  </div> 
	
     
<!--filter includes-->
    <script type="text/javascript" src="css/filter-as-you-type/jquery.min.js"></script>
    <script type="text/javascript" src="css/filter-as-you-type/jquery.quicksearch.js"></script>
    <script type="text/javascript">
                $(function() {
                  $('input#id_search').quicksearch('table tbody tr');
                });
    </script>
    <script>
      function show_confirm(member_id) {
        if (confirm("Are you Sure you want to delete?")) {
          location.replace('users_accounts.php?id=' + id);
        } else {
          return false;
        }
      }
    </script>
<?php

 include "includes/footer.php";
}

else
{
	//Redirect user back to login page if there is no valid session created
	header("location: login.php");
}
?>

