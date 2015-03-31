<?php

	/*
This script is use to upload any Excel file into database.
Here, you can browse your Excel file and upload it into 
your database.


*/
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Demo - Import Excel file data in mysql database using PHP, Upload Excel file data in database</title>
<meta name="description" content="This tutorial will learn how to import excel sheet data in mysql database using php. Here, first upload an excel sheet into your server and then click to import it into database. All column of excel sheet will store into your corrosponding database table."/>
<meta name="keywords" content="import excel file data in mysql, upload ecxel file in mysql, upload data, code to import excel data in mysql database, php, Mysql, Ajax, Jquery, Javascript, download, upload, upload excel file,mysql"/>
</head>
<body>

<?php
//session_start();
/************************ YOUR DATABASE CONNECTION START HERE   ****************************/
require_once 'Classes/DB.class.php';

$db = new DB();
$db->connect();




/************************ YOUR DATABASE CONNECTION END HERE  ****************************/


set_include_path(get_include_path() . PATH_SEPARATOR . 'Classes/');

include 'PHPExcel/IOFactory.php';

// This is the file path to be uploaded.
//$inputFileName = 'discussdesk13.xlsx'; 
//$inputFileName = $_SESSION["inputFileName"]; 
$inputFileName = $_GET['filename'];






try {
	$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
} catch(Exception $e) {
	die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
}


$allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

// Here get total count of row in that Excel sheet
$arrayCount = count($allDataInSheet);




$msg="";
$msg1="";



for($i=2;$i<= $arrayCount;$i++)
{


$ID= trim($allDataInSheet[$i]["A"]);
$indicator= trim($allDataInSheet[$i]["B"]);
$survey_date=trim($allDataInSheet[$i]["C"]);
$county=trim($allDataInSheet[$i]["D"]);
$aggregate=trim($allDataInSheet[$i]["E"]);



// Get IDs' for the respective survey,sector and indicator

$getIDs = $db->select("indicators","indicator_id='$ID'");

foreach($getIDs as $dataRow)
{
$surveyID =$dataRow['survey_id'];
$sectorID =$dataRow['sector_id'];
$indicatorID =$dataRow['indicator_id'];

}

// Get the county ID

$getcountyID = $db->select("counties","county_name='$county'");


foreach($getcountyID as $dataRow)
{
$countyID =$dataRow['county_id'];
}





$resultCount=$db->resultQueryCount("judiciary_aggregates","county_id='$countyID' AND survey_id='$surveyID' AND indicator_id='$indicatorID'");

if($resultCount <= 0)
{

$aggregateArray = array("county_id" => "'$countyID'","survey_id" => "' $surveyID'","indicator_id" => "'$indicatorID'","aggregate" => "'$aggregate'");
  
$insertTable=$db->insert($aggregateArray,"judiciary_aggregates");

}
else
{

continue;

}









}




echo "<div style='font: bold 18px arial,verdana;padding: 45px 0 0 500px;'>".$msg."</div>";
echo "<div style='font: bold 18px arial,verdana;padding: 45px 0 0 500px;'>".$msg1."</div>";
echo '<a href="upload2.php">Go Back to upload page</a>';









 

?>
<body>
</html>
