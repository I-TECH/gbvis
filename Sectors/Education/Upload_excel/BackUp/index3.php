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
session_start();
/************************ YOUR DATABASE CONNECTION START HERE   ****************************/
require_once 'Classes/DB.class.php';

$db = new DB();
$db->connect();




/************************ YOUR DATABASE CONNECTION END HERE  ****************************/


set_include_path(get_include_path() . PATH_SEPARATOR . 'Classes/');

include 'PHPExcel/IOFactory.php';

// This is the file path to be uploaded.
//$inputFileName = 'discussdesk13.xlsx'; 
$inputFileName = $_SESSION["inputFileName"]; 






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

$msg = 'Record already exist in database. <div style="Padding:20px 0 0 0;"><a href="upload2.php">Go Back to tutorial</a></div>';

}

else

{
  $indicatorcount = array("indicator" => "'$indicator'","county" => "'$county'","subcounty" => "'$subcounty'","tally" => "'$tally'","date" => "'$date'");
  
  $insertTable=$db->insert($indicatorcount ,"judiciary_count");
  
 
 $msg = 'Record has been added to database. <div style="Padding:20px 0 0 0;"><a href="upload2.php">Go Back to Upload page</a></div>';

}


}


echo "<div style='font: bold 18px arial,verdana;padding: 45px 0 0 500px;'>".$msg."</div>";









 

?>
<body>
</html>