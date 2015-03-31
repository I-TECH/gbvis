<?php

	
//require_once 'includes/global.inc.php';

// Start with collecting from data ///

@$county=$_POST['county'];
@$survey=$_POST['survey'];
@$indicator=$_POST['indicator'];
@$aggregates=$_POST['aggregates'];
@$date = date("Y-m-d");

$status_form = "OK";// Set a flag to check
$msg=""; // Message variable

//$row=array("s1"=>"T","s3"=>"T","t1"=>"T","msg"=>"","status_form"=>"OK");
$row=array("s1"=>"T","s2"=>"T","s3"=>"T","t1"=>"T","msg"=>"","status_form"=>"OK");




if(strlen($county) < 1){
$row["status_form"]="NOTOK";
$row["s1"]="F";
$msg .= "Please select county<br>";
}

else if(strlen($survey) < 1)
{
$row["status_form"]="NOTOK";
$row["s2"]="F";
$msg .= "Please select survey<br>";
}

else if(strlen($indicator) < 1){
$row["status_form"]="NOTOK";
$row["s3"]="F";
$msg .= "Please select indicator<br>";
}


else if(strlen($aggregates) < 1)
{
if (!preg_match('/^[0-9]+$/', $aggregates)) 
{
  // contains only 0-9
    $row["status_form"]="NOTOK";
  	$row["t1"]="F";
	$msg .= "Enter valid number<br>";
 }
}




else
{
$row["status_form"]="OK";

// Database code to go here
$conect = mysql_connect("localhost", "root", "1234");
mysql_select_db("gbvis", $conect);

$sql = "insert into prosecution_aggregates set county_id='".$county."', survey_id='".$survey."',indicator_id='".$indicator."',aggregate='".$aggregates."'";
$sql = @mysql_query($sql);

//$db=new DB();

//$aggregateArray = array("county_id" => "'$county'","survey_id" => "' $survey'","indicator_id" => "'$indicator'","aggregate" => "'$aggregates'","date" => "'$date'");
  
//$insertTable=$db->insert($aggregateArray,"health_aggregates");


if(!$sql)
{
    $msg .= "Data Of simlar Details(Indicator,Survey Period,County) Already exist";
}


//echo '<p style="padding:8px; color:red; padding-left:10px; font:normal 12px arial; width:425px; margin: 10px auto 0;">Your enquiry has been submitted successfully. </p>';

else
{

$msg .= "Data Added Successfully";
}


}

$row["msg"]="$msg";


$main = array('data'=>array($row)); 
echo json_encode($main); 

?>
