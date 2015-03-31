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
	<h3 class="page-title">Reports</h3>
	<hr size="1" color="#CCCCCC"> 
	       
		   <div class="profile-data" align="left">
                
                             
				<a href="stardard_reports.php" style="float:left; width:25%; height:100px;  margin-right:15px; text-decoration:none;" title="Standard Reports" >
				 <p>Standard Reports</p>  <p><img src="images/reports.jpeg" height="70" /></p>
				</a>
				<a href="analytical_reports.php" style="float:left; width:25%; height:100px;  margin-right:15px; text-decoration:none;" >
				  <p>Analytical Reports</p><p><img src="images/analytical.jpeg" height="70" title="Analytical Reports" /></p> 
				</a>

<br clear="all">
<hr size="1" color="#CCCCCC">
<br clear="all"><br clear="all"><br clear="all">
<!--&nbsp;Your MD5 encrypted password: <font color="white"><?php //echo $passwd; ?></font>-->


<br clear="all"><br clear="all"><br clear="all">


<br clear="all"><br clear="all"><br clear="all">
</div><br clear="all">
</center>
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