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
if(isset($_POST['submit-form'])) { 

	$date_recorded = date("Y-m-d");
	$county_id  = $_POST['county'];
	$survey_id  = $_POST['survey'];
	$indicator_id = $_POST['indicator'];
	$aggregates = $_POST['aggregates'];
	
	

	//initialize variables for form validation
	$success = true;
	$db = new DB();
	 
	 //validate that the form was filled out correctly
	//check to see if user name already exists
	
	if($success)
	{
	
	$Added=false;
	
	    //prep the data for saving in a new user object
	    $data['county_id'] = $county_id;
	    $data['indicator_id'] = $indicator_id;
	    $data['survey_id'] = $survey_id;
	    $data['aggregates'] = $aggregates;
	    $data['date'] = $date_recorded;
		 
	
	    //create the new indicator object
	    $Jud_indicators = new DB ($data);
	
	    //save the new user group to the database
	    
		$data = array(
				"county_id" => "'$county_id'",
				"indicator_id"=> "'$indicator_id'",
				"survey_id"=> "'$survey_id'",
				"aggregates"=> "'$aggregates'",
				"date"=> "'$date_recorded'"
				
		);
	    $id = $db->update($data, 'file_uploads');
	    
	  $Added = true;
	  
	}

}

	

include "../includes/headerlevel2.php"; 
include_once('../../includes/connection.php');
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
	  <div id="main-content_with_side_bar">
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
			  <th align="left" width="150px"><b>Type</b></th>
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
 
       $statement = "`file_uploads` WHERE sector_id=$user_sector_name"; // Change `records` according to your table name.
  
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
				  <td><?php echo $file_type; ?></td>
				  <td><?php echo $description; ?></td>
				   <td><?php echo $uploadedby; ?></td>
				    <td><?php echo $useremail; ?></td>
				     <td><?php echo $sector; ?></td>
				<td><?php echo $date; ?></td>
                 <td align="center"><a href='javascript:void(0)' onclick='confirm_View(<?php echo $id; ?>);'>View<a></td>
		<td align="center"><a href="javascript:void(0)" onclick='confirm_Approve(<?php echo $id; ?>);'>Approve</a></td>
                <td align="center"><a title="Reject Upload" href="#" onclick='reject_upload(<?php echo $id; ?>);'>Reject</a></td>
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


<div id="abc" style="display:none;">
<!-- Popup Div Starts Here -->
<center>
<div id="popupContact">
<!-- Contact Us Form -->
<form action="#" id="form" method="post" name="form">
<section><h2>Rejection Reason</h2>
<img id="close" src="../images/fail.png" height="20" width="20" onclick ="div_hide()"></section>
<hr>
<textarea id="reason" name="Rejection_reason" placeholder="Rejection Reason"></textarea>
<input type="submit" onclick='javascript:%20check_empty()' name="submit_reason;" id="submit" value="Send" class="gbvis_general_button"/>
<input type="reset" name="submit-form" value="Reset" class="gbvis_general_button"/>
</form>
</div>
</center>
</div>
<script>

//Function To Display Popup
function reject_upload() {
document.getElementById('abc').style.display = "block";
}
//Function to Hide Popup
function div_hide(){
document.getElementById('abc').style.display = "none";
}

// Validating Empty Field
function check_empty() {
if (document.getElementById('name').value == "" || document.getElementById('reason').value == "") {
alert("reason cannot be empty!");
} else {
document.getElementById('form').submit();
alert("Form Submitted Successfully...");
}
}

</script>
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
      function confirm_Approve(id) {
        if (confirm("Are you Sure you want to approve this data?")) {
          location.replace('data_import.php?id='+ id);
        } else {
          return false;
        }
      }
    </script>
     <script>
      function confirm_Reject(id) {
        if (confirm("Are you Sure you want to Reject this data?")) {
          location.replace('#abc');
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
 include "../../includes/footer.php";
	
	}

else
{
	//Redirect user back to login page if there is no valid session created
	header("location: ../../login.php");
}
?>

