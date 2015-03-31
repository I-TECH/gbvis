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
		<center><h3 class="page-title">Data Import</h3></center>
		<div class="profile-data" align="left">

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
  
$inputFileName = $path;

try {
	$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
} catch(Exception $e) {
	die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
}


$allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

// Here get total count of row in that Excel sheet
$arrayCount = count($allDataInSheet);  


for($i=2;$i<=$arrayCount;$i++)
{

//$name = trim($allDataInSheet[$i]["A"]);
//$email = trim($allDataInSheet[$i]["B"]);

$indicator= trim($allDataInSheet[$i]["A"]);
$county=trim($allDataInSheet[$i]["B"]);
$subcounty=trim($allDataInSheet[$i]["C"]);
$tally=trim($allDataInSheet[$i]["D"]);
$date=trim($allDataInSheet[$i]["E"]);





//$rows = $db->select("contacts","name='$name' AND email= '$email'");
$rows = $db->select("judiciary_count","indicator='$indicator' AND county= '$county' AND subcounty='$subcounty'");

if(count($rows) > 0)
{

$msg = 'Record already exist in database. <div style="Padding:20px 0 0 0;"><a href="file_upload.php">Go Back to Upload page</a></div>';

}

else

{
  $indicatorcount = array("indicator" => "'$indicator'","county" => "'$county'","subcounty" => "'$subcounty'","tally" => "'$tally'","date" => "'$date'");
  
  $insertTable=$db->insert($indicatorcount ,"judiciary_count");
  
 
 $msg = 'Record has been added to database. <div style="Padding:20px 0 0 0;"><a href="file_upload.php">Go Back to Upload page</a></div>';

}


}


echo "<div style='font: bold 18px arial,verdana;padding: 45px 0 0 500px;'>".$msg."</div>";

?>


</div>
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