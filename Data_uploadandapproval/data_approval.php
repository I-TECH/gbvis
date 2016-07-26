<?php
//index.php
  $page_title = "Data Approval | GBV";
    $current_page = "Data Approval";
	

require_once '../includes/globallevel2.inc.php';

// Same as error_reporting(E_ALL);
ini_set("error_reporting", E_ALL);

 //check to see if they're logged in
if(isset($_SESSION['logged_in'])) {

//get the user object from the session
$user = unserialize($_SESSION['user']);

//initialize php variables used in the form
$name = "";
$size= "";
$type= "";
$uploadedby= "";
$sector = "";
$description = "";
$useremail = "";
$status = "";
$error = ""; 
$reason_rejected="";

//check to see that the form has been submitted

	

//include "../includes/headerlevel2.php"; 
include "../includes/Dash_header.php"; 
include "../includes/topbar.php"; //TA:60:1
include_once('../includes/connection.php');
include_once('../includes/functions.php');

?>

	    <div id="sidebar">
	  <center><h3 style="text-size:18px; font-family: TStar-Bol"></h3></center>
<div class="sidebar-nav">
	<?php
	  include "../includes/sidebarlevel2.php"; 
	  ?>
	</div> 
	  </div> 
	  <div id="main-content">
	    <div id="bread-crumbs">
	      <!--breadcrumbs-->
	    </div>
        <div id="content-body">
		<h3 class="page-title">Uploaded files Approval</h3>
		<br clear="all">
        <div class="" align="left"> 
		<section class="" style="width:85%;">
	       <form action="#">
          <input type="text" name="search" value="" id="id_search" placeholder="Filter records here" autofocus />
          <a class="link-btn" href="">Export to csv</a>
           <a class="link-btn" href="">Export to excel</a>
        </form>
		</section>
		 <hr size="1" color="#CCCCCC">
        <div class="profile-data" align="left">
            <table width="100%" border="0" align="center" cellspacing="1" class="table-hover">
            <thead>
                          <th align="left" width="30px" ><b>ID</b></th>
			  <th align="left" width="100px"><b>File name</b></th>
			   <th align="left" width="150px"><b>Description</b></th>
			  <th align="left" width="100px"><b>Uploaded By</b></th>
			  <th align="left" width="100px"><b>Email</b></th>
			  <th align="left" width="80px"><b>Sector</b></th>
			  <th align="left" width="150px"><b>Date</b></th>
                          <th align="left" width="50px"><b></b></th>
                          <th align="left" width="50px"><b></b></th>
                          <th align="left" width="50px"><b></b></th>
			
            </thead>
       <script>
function div_show() {
document.getElementById('reject_form).style.display = "block";
}
</script>
            <?php
            
             
 
     $page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
            if ($page <= 0) $page = 1;
 
          $per_page = 6; // Set how many records do you want to display per page.
 
          $startpoint = ($page * $per_page) - $per_page;
 
       $statement = "`file_uploads` WHERE status='Not Approved'"; // Change `records` according to your table name.
  
       $results = mysqli_query($conDB,"SELECT * FROM {$statement} LIMIT {$startpoint} , {$per_page}");
        
        if (mysqli_num_rows($results)!= 0) {
     
       // displaying records.
        while ($row = mysqli_fetch_array($results)) {
         
        $id= $row['id'];
        $file_name = $row['name'];
          $file_type = $row['type'];
           $description = $row['description'];
            $uploadedby = $row['uploadedby'];
              $useremail = $row['useremail'];
        $sector = $row['sector'];
        $date =$row['date'];
        
        
    ?>
              <tr bgcolor="#FFFFFF" style="border-bottom: 1px solid #B4B5B0;">
                                 <td><?php echo $id; ?></td>
				 <td><?php echo $file_name; ?></td>
				  <td><?php echo $description; ?></td>
				   <td><?php echo $uploadedby; ?></td>
				    <td><?php echo $useremail; ?></td>
				     <td><?php echo $sector; ?></td>
				<td><?php echo $date; ?></td>
                 <td align="center"><a href='javascript:void(0)' onclick='confirm_View(<?php echo $id; ?>);'>View<a></td>
		<td align="center"><a href="javascript:void(0)" onclick='confirm_approve(<?php echo $id; ?>);'>Approve</a></td>
                <td align="center"><a href="javascript:void(0)" onclick='confirm_reject(<?php echo $id; ?>);'>Reject</a></td>
               </tr>
            <?php
            }
            } 
            else
            {
            ?>
            <tr>
          <td colspan="8"><?php echo "No records are found.";?></td>
          </tr>
              <?php }
            
 // displaying paginaiton.
        ?>
       <tr>
          <td colspan="8"><?php echo pagination($statement,$per_page,$page,$url='?');?></td>
          </tr>
          </table>
      <br clear="all"><br clear="all"><br clear="all">
      </div><br clear="all">
	  </div>
   
		</div>		
	  </div> 
      </div>
	  <br clear="all">
	    </div> 		
	  </div> 
	  <!--Pop up starts here -->

      <!--Pop up ends here -->
      
      
<!--filter includes-->
    <script type="text/javascript" src="css/filter-as-you-type/jquery.min.js"></script>
    <script type="text/javascript" src="css/filter-as-you-type/jquery.quicksearch.js"></script>
    
    <script type="text/javascript">
                $(function() {
                  $('input#id_search').quicksearch('table tbody tr');
                });
    </script>
    <script>
      function show_confirm(id) {
        if (confirm("Are you Sure you want to delete?")) {
          location.replace('users_accounts.php?id='+ id);
        } else {
          return false;
        }
      }
    </script>
     <script>
      function confirm_approve(id) {
        if (confirm("Are you Sure you want to approve this data?")) {
          location.replace('data_import.php?id='+ id);
        } else {
          return false;
        }
      }
    </script>
        <script>
      function confirm_reject(id) {
        if (confirm("Are you Sure you want to approve this data?")) {
          location.replace('reject_file.php?id='+ id);
        } else {
          return false;
        }
      }
    </script>
   <script>
      function confirm_View(id) {
        if (confirm("Click ok to view File Data")) {
          location.replace('view_uploaded.php?id='+ id);
        } else {
          return false;
        }
      }
    </script>


	
<?php
 include "../includes/footer.php";
	
	}

else
{
	//Redirect user back to login page if there is no valid session created
	header("location: ../login.php");
}
?>

