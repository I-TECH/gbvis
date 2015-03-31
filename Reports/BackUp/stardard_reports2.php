<?php
//index.php
  $page_title = "Home | GBV";
    $current_page = "home";
	
require_once 'includes/global.inc.php';


 //check to see if they're logged in
if(isset($_SESSION['logged_in'])) {

//get the user object from the session
$user = unserialize($_SESSION['user']);

 require_once 'classes/Pagination.class.php';
  $limit      = ( isset( $_GET['limit'] ) ) ? $_GET['limit'] : 25;
    $page       = ( isset( $_GET['page'] ) ) ? $_GET['page'] : 1;
    $links      = ( isset( $_GET['links'] ) ) ? $_GET['links'] : 7;

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
		<center><h3 class="page-title">Home</h3></center>
	       
		   <div class="profile-data" align="left">
    <table width="100%" border="0" align="center" cellspacing="1" class="table-hover">
     <thead>
	  <td><b></b></td>
          <td><b></b></td>
    </thead>
     <?php 
	 //create a new database object.
		$db = new DB();
		
	   $table = $db->select("indicators","id");
	   $Paginator  = new Paginator( $db, $table);
 
        $results    = $Paginator->getData( $page, $limit );
        
     for( $i = 0; $i < count( $results->data ); $i++ ) { 
     ?>
        <tr>
         <td><?php echo $results->data[$i]['id']; ?></td>
        <td><a class="data-links" href='display_report.php?id=<?php echo $id; ?>'><?php echo $results->data[$i]['Name']; ?></a></td>
	 </tr>   
     <?php } ?>
     </table>
	 
    <br clear="all"><br clear="all">
 <?php echo $Paginator->createLinks( $links, 'pagination pagination-sm' ); ?> 
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
	header("Location: login.php");
}
?>