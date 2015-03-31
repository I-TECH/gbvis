<?php
	//index.php
  $page_title = "Data Import | GBV";
    $current_page = "Data Import ";
	error_reporting(0);
require_once '../includes/globallevel2.inc.php';
 //check to see if they're logged in
if(isset($_SESSION['logged_in'])) {

//get the user object from the session
$user = unserialize($_SESSION['user']);

include "../includes/headerlevel2.php";
include 'smtpmail/library.php'; // include the library file
include "smtpmail/classes/class.phpmailer.php"; // include the class name

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
	  <div id="main-content">
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
  $uploadedby = $urows['uploadedby'];
  $uploaderemail = $urows['useremail'];
  $file_sector = $urows['sector'];
  $path = $urows['path'];

}
$file = "../Uploaded_files/".$fileName;
  
$inputFileName = $file;

try {
	$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
} catch(Exception $e) {
	die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
}


$allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

// Here get total count of row in that Excel sheet
$arrayCount = count($allDataInSheet);  

$html="<table width='100%' border='0' align='center' cellspacing='1' class='table-hover'><tr><th>ID</th><th>Indicator</th><th>Survey Period</th><th>County</th><th>Aggregate</th></tr>";
       
$ImportAllStatus=false;
$importSuccessful=false;

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
//Check the sector that the file belongs to
if($file_sector=1){

$resultCount=$db->resultQueryCount("judiciary_aggregates","county_id='$countyID' AND survey_id='$surveyID' AND indicator_id='$indicatorID'");

//Check if there is a similar record in the database 
if($resultCount <= 0)
{

$aggregateArray = array("county_id" => "'$countyID'","survey_id" => "' $surveyID'","indicator_id" => "'$indicatorID'","aggregate" => "'$aggregate'");
  
$insertTable=$db->insert($aggregateArray,"judiciary_aggregates");

$ImportAllStatus=true;
}
else
{
//continue;
$html.="<tr><td>$ID</td><td>$indicator</td><td>$county</td></td><td>$survey_date</td><td>$aggregate</td></tr>";

$ImportAllStatus=false;
}
}

 if($file_sector=2){
 
 
$ID= trim($allDataInSheet[$i]["A"]);
$indicator= trim($allDataInSheet[$i]["B"]);
$survey_date=trim($allDataInSheet[$i]["C"]);
$county=trim($allDataInSheet[$i]["D"]);
$gender=trim($allDataInSheet[$i]["E"]);
$aggregate=trim($allDataInSheet[$i]["F"]);


$resultCount=$db->resultQueryCount("health_aggregates","county_id='$countyID' AND survey_id='$surveyID' AND indicator_id='$indicatorID' AND gender='$gender'");

if($resultCount <= 0)
{

$aggregateArray = array("county_id" => "'$countyID'","survey_id" => "' $surveyID'","indicator_id" => "'$indicatorID'","aggregate" => "'$aggregate'",,"gender" => "'$gender");
  
$insertTable=$db->insert($aggregateArray,"health_aggregates");

$ImportAllStatus=true;
}
else
{
//continue;
$html.="<tr><td>$ID</td><td>$indicator</td><td>$county</td></td><td>$survey_date</td><td>$aggregate</td></tr>";

$ImportAllStatus=false;
}

}

if ($file_sector=3){

$resultCount=$db->resultQueryCount("police_aggregates","county_id='$countyID' AND survey_id='$surveyID' AND indicator_id='$indicatorID'");

if($resultCount <= 0)
{

$aggregateArray = array("county_id" => "'$countyID'","survey_id" => "' $surveyID'","indicator_id" => "'$indicatorID'","aggregate" => "'$aggregate'");
  
$insertTable=$db->insert($aggregateArray,"police_aggregates");

$ImportAllStatus=true;
}
else
{
//continue;
$html.="<tr><td>$ID</td><td>$indicator</td><td>$county</td></td><td>$survey_date</td><td>$aggregate</td></tr>";

$ImportAllStatus=false;
}
}
if ($file_sector=4){

$resultCount=$db->resultQueryCount("prosecution_aggregates","county_id='$countyID' AND survey_id='$surveyID' AND indicator_id='$indicatorID'");

if($resultCount <= 0)
{

$aggregateArray = array("county_id" => "'$countyID'","survey_id" => "' $surveyID'","indicator_id" => "'$indicatorID'","aggregate" => "'$aggregate'");
  
$insertTable=$db->insert($aggregateArray,"prosecution_aggregates");

$ImportAllStatus=true;
}
else
{
//continue;
$html.="<tr><td>$ID</td><td>$indicator</td><td>$county</td></td><td>$survey_date</td><td>$aggregate</td></tr>";

$ImportAllStatus=false;
}
}

//$ImportStatus=true;
}

 if($ImportAllStatus){
 
 
 
                   $importSuccessful=true;
 
                       $status='Approved';
                       $date_modified = date('Y-m-d H:i:s');
     
                     if($importSuccessful)
                     {
                      
 	              //prep the data for saving in a new user object
                        $data['id'] = $Upload_id;
                        $data['status'] = $status;
  		        $data['date'] = $date_modified;
	
	             //create the new file upload object
	         
	                 $newUpload = new DB ($data);
	        //save the new file upload to the database
	    
 		    $data = array (
 		 		"status" => "'$status'",
				"date" => "'$date_modified'"
 		              );
	           $Upload_id = $newUpload->update($data, "file_uploads", "id = $Upload_id");
	           
	            $uploadUpdated =true;
	           
	           if($uploadUpdated)
                     {
                     
                     $fromName ='GBV Information System';
                     $ToName =$uploaderemail;
	             $mail	= new PHPMailer; // call the class 
                     $mail->IsSMTP(); 
                     $mail->SMTPDebug = 0;

                     //Ask for HTML-friendly debug output
                     $mail->Debugoutput = 'html';
                     $mail->Host = SMTP_HOST; //Hostname of the mail server
                     $mail->Port = SMTP_PORT; //Port of the SMTP like to be 25, 80, 465 or 587
                     $mail->SMTPAuth = true; //Whether to use SMTP authentication
                     $mail->Username = SMTP_UNAME; //Username for SMTP authentication any valid email created in your domain
                     $mail->Password = SMTP_PWORD;
                     $mail->AddReplyTo("info@ardech.co.ke", "GBV System Administrator"); //reply-to address
                     $mail->SetFrom("info@ardech.co.ke", "Gbv System"); //From address of the mail
                       // put your while loop here like below,
                     $mail->Subject = "GBV DATA APPROVAL"; //Subject od your mail
                     $recipients = array(
                            $uploaderemail => $uploadedBy,
                            $user_email =>  $Logged_user
                                 );
                       foreach($recipients as $email => $name){
	               // it will display the emails of all users in their Mailbox 'To' area. Simple multiple mail.
	             $mail->AddAddress($email, $name); //To address who will receive this email
	             $mail->msgHTML(file_get_contents('smtpmail/contents.html'), dirname(__FILE__)); //Put your body of the message you can place html code here
	             $mail->AddAttachment('smtpmail/images/logo.jpg'); //Attach a file here if any or comment this line,  
	             $send = $mail->Send(); //Send the mails
	             // if you want to does not show other users email addresses like newsletter, daily, weekly, subscription emails means use the below line to clear previous email address
	             $mail->ClearAddresses();
                         }
	            if($send){
		       $msg='<center><h3 style="color:#009933;">Mail sent successfully</h3></center>';
	                }
	               else{
		        $msg='<center><h3 style="color:#FF3300;">Mail error: </h3></center>'.$mail->ErrorInfo;
	                }
	            }
	          }
	          $emailSent=true;
	          
	          if($emailSent)
                     {
	              echo "All records imported successfully and uploader Updated";
                    }
                    else{ 
                    echo "All records imported successfully but uploader Updated";
                    }
 }
 else if (!$ImportAllStatus){
 
 $html.="</table>";
echo "The following data Could not be inserted. Data of similar details have already exist";
echo $html;
 
 }

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
	header("Location: ../login.php");
}
?>