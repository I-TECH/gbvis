<?php


//index.php
  $page_title = "Home | GBV";
    $current_page = "home";
	
require_once 'includes/global.inc.php';


 //check to see if they're logged in
if(isset($_SESSION['logged_in'])) {

//get the user object from the session
$user = unserialize($_SESSION['user']);

include "includes/Dash_header.php";include "includes/topbar.php"; //TA:60:1 
include_once('includes/connection.php');
include_once('includes/functions.php');
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
		<center><h3 class="page-title">Home</h3></center>
	       <hr size="1" color="#CCCCCC">
   <div class="profile-data" align="left">
 <table width="100%" border="0" align="center" cellspacing="1" class="table-hover">
            <thead>
              <th><b>ID</b></th>
			  <th><b>Sector</b></th>
			  <th><b>Description</b></th>
			   <th><b>Status</b></th>
			     <th><b>Date</b></th>
                          <th><b>View</b></th>
                          <th><b>Edit</b></th>
			  <th><b>Delete</b></th>
            </thead>

<?php
$page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
if ($page <= 0) $page = 1;

$per_page = 10; // Set how many records do you want to display per page.

$startpoint = ($page * $per_page) - $per_page;

$statement = "`sectors` ORDER BY `id` ASC"; // Change `records` according to your table name.
 
$results = mysqli_query($conDB,"SELECT * FROM {$statement} LIMIT {$startpoint} , {$per_page}");

if (mysqli_num_rows($results) != 0) {
    
	// displaying records.
    while ($row = mysqli_fetch_array($results)) {
    
         ?>
    <tr>
        <td><?php echo $row['sector']; ?></td>
       <td><?php  echo $row['description'] ; ?></td>
        <td><?php echo $row['status']; ?></td>
         <td> <?php  echo $row['date']; ?></td>
         </tr>
       <?php  
    }
 
} else {
     ?>
<tr>
     <td><?php echo "No records are found.";?></td>
     </tr>
    
     <?php
}

 // displaying paginaiton.
echo pagination($statement,$per_page,$page,$url='?');
?>


</div><br clear="all">
	    </div> 		
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