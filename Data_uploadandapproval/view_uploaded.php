<?php
	//index.php
  $page_title = "Data Import | GBV";
    $current_page = "Data Import ";
	
require_once '../includes/globallevel2.inc.php';
 //check to see if they're logged in
if(isset($_SESSION['logged_in'])) {

//get the user object from the session
$user = unserialize($_SESSION['user']);
include "../includes/headerlevel2.php"; 
?>
 <div id="sidebar">
	  <center><h3 style="text-size:18px;  font-family: TStar-Bol"></h3></center>
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
		<h3 class="page-title">Data Import</h3>
		 <hr size="1" color="#CCCCCC">
		

<?php
/************************ YOUR DATABASE CONNECTION START HERE   ****************************/
$db = new DB();
$db->connect();

/************************ YOUR DATABASE CONNECTION END HERE  ****************************/


set_include_path(get_include_path() . PATH_SEPARATOR . 'Classes/');

include 'PHPExcel/IOFactory.php';

// This is the file path to be uploaded.
//$inputFileName = 'discussdesk13.xlsx'; 
$Upload_id = $_GET['id'];

$upload = $db->selectData("file_uploads"," id = $Upload_id");

foreach ($upload as $urows) 
{
  
  $Upload_id = $urows['id'];
  $fileName = $urows['name'];
  $path = $urows['path'];

}
$file = "../Uploaded_files/" .$fileName;
  
$inputFileName = $file;

try {
	$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
} catch(Exception $e) {
	die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
}


$allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

// Here get total count of row in that Excel sheet
$arrayCount = count($allDataInSheet); 
?>
<div class="profile-data" align="left">
 <table width="100%" border="0" align="center" cellspacing="1" class="table-hover">
            <thead>
                          <th align="left"><b>ID</b></th>
                          <th align="left"><b>Indicator</b></th>
			  <th align="left"><b>County</b></th>
			  <th align="left"><b>Survey Period</b></th>
			  <th align="left"><b>Agregates</b></th>
			  <!--<th align="left"><b>Date</b></th>-->
                         
			
            </thead>
<?php
for($i=2;$i<=$arrayCount;$i++)
{

//$name = trim($allDataInSheet[$i]["A"]);
//$email = trim($allDataInSheet[$i]["B"]);

$indicator_id= trim($allDataInSheet[$i]["A"]);
$indicator= trim($allDataInSheet[$i]["B"]);
$county=trim($allDataInSheet[$i]["C"]);
$survey_period=trim($allDataInSheet[$i]["D"]);
$aggregates=trim($allDataInSheet[$i]["E"]);
//$date=trim($allDataInSheet[$i]["F"]);

?>

       <tr bgcolor="#FFFFFF" style="border-bottom: 1px solid #B4B5B0;">
                                 <td><?php echo $indicator_id; ?></td>
                                  <td><?php echo $indicator; ?></td>
				 <td><?php echo $county; ?></td>
				  <td><?php echo $survey_period; ?></td>
				  <td><?php echo $aggregates; ?></td>
				<!--<td><?php echo $date; ?></td>-->
				</tr>
			<?php } ?>	
       </table>     
  </div>
<br clear="all">         
</div>
</div>
<?php

 include "../includes/footer.php"; 
	
}
else
{
	//Redirect user back to login page if there is no valid session created
	header("Location: ../../login.php");
}
?>