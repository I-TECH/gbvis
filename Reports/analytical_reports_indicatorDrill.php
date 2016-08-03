<?php
//index.php
  $page_title = "Analytical Reports | GBV";
    $current_page = "Analytical Reports";
	
require_once 'includes/global.inc.php';


 //check to see if they're logged in
if(isset($_SESSION['logged_in'])) {

//get the user object from the session
$user = unserialize($_SESSION['user']);


include "includes/Dash_header.php";include "includes/topbar.php"; //TA:60:1 
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
	<h3 class="page-title">Analytical reports</h3>
	<hr size="1" color="#CCCCCC">       
		   <div class="profile-data" align="left">
   

     <?php 
	 //create a new database object.
		$db = new DB();
		
	   $rows=$db->select("indicators","indicator_id");
	   
	 foreach ($rows as $Data)
	 
	 {
	  $id  = $Data['indicator_id'];
	   $indicator  = $Data['indicator'];
	 ?>
	<table width="100%" border="0" align="center" cellspacing="1" class="table-hover">
	 <thead>
	  <td align="left" width="20px"><b></b></td>
          <td align="left" ><b></b></td>
	 </thead>
	 <tr>
	<td align="left" width="20px" ><?php  echo $id; ?></td>
      <td align="left"><a class="data-links" href='analyticalreports/drilldown.php?id=<?php echo $id; ?>'><?php echo $indicator; ?></a></td>
	 </tr>
	</table>
	 <?php }?>
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