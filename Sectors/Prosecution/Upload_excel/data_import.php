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


$indicatorID ="";
$countyID = "";
$surveyID = "";

?>
 <div id="sidebar">
	  <center><h3 style="text-size:18px;  font-family: TStar-Bol"></h3></center>
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
		<h3 class="page-title">Data Import</h3>
		 <hr size="1" color="#CCCCCC">
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
$file = "Uploads/" .$fileName;
  
$inputFileName = $file;

try {
	$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
} catch(Exception $e) {
	die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
}


$allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

// Here get total count of row in that Excel sheet
$arrayCount = count($allDataInSheet);  

$html="<table width='100%' border='0' align='center' cellspacing='1' class='table-hover'><tr><th>Indicator</th><th>Survey Period</th><th>County</th><th>Aggregate</th></tr>";
       


 for($i=2;$i<= $arrayCount;$i++)
{


$ID= trim($allDataInSheet[$i]["A"]);
$indicator= trim($allDataInSheet[$i]["B"]);
$survey_date=trim($allDataInSheet[$i]["C"]);
$county=trim($allDataInSheet[$i]["D"]);
$aggregate=trim($allDataInSheet[$i]["E"]);

 

// Get IDs' for the respective survey,sector and indicator

$getIDs = $db->selectData("indicators","indicator_id='$ID'");

foreach($getIDs as $dataRow)
{
$surveyID =$dataRow['survey_id'];
$sectorID =$dataRow['sector_id'];
$indicatorID =$dataRow['indicator_id'];

}

// Get the county ID

$getcountyID = $db->selectData("counties","county_name='$county'");


foreach($getcountyID as $dataRow)
{
$countyID =$dataRow['county_id'];
}

$resultCount=$db->resultQueryCount("health_aggregates","county_id='$countyID' AND survey_id='$surveyID' AND indicator_id='$indicatorID'");

if($resultCount <= 0)
{

$aggregateArray = array("county_id" => "'$countyID'","survey_id" => "' $surveyID'","indicator_id" => "'$indicatorID'","aggregate" => "'$aggregate'");
  
$insertTable=$db->insert($aggregateArray,"health_aggregates");

}
else
{
//continue;
$html.="<tr><td>$indicator</td><td>$survey_date</td><td>$county</td><td>$aggregate</td></tr>";

}

}

$html.="</table>";


echo "The following data Could not be inserted. Data of similar details have already exist";
echo $html;


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