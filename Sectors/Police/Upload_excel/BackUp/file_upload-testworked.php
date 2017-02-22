<?php
//index.php
  $page_title = "File Upload | GBV";
    $current_page = "File Upload";
	

require_once '../includes/globallevel2.inc.php';

 //check to see if they're logged in
if(isset($_SESSION['logged_in'])) {

//get the user object from the session
$user = unserialize($_SESSION['user']);
;


require_once 'Classes/UploadExcel.class.php';
include 'smtpmail/library.php'; // include the library file
include "smtpmail/classes/class.phpmailer.php"; // include the class name

if (isset($_POST["submit"]) && isset($_FILES["file"]))
	 {
	
	$uploadExcel = new UploadExcel(); 
	
	$uploadExcel->checkUploadedStatus($_POST["submit"],$_FILES["file"]);
	
	}

	/*
This script is use to upload any Excel file into database.
Here, you can browse your Excel file and upload it into 
your database.
*/

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
	  <div id="main-content_with_side_bar">
	    <div id="bread-crumbs">
	      <!--breadcrumbs-->
	    </div>
        <div id="content-body">
	<h3 class="page-title">Excel Data Import</h3>
	   <hr size="1" color="#CCCCCC">
	<div class="profile-data" align="left">
	
	
	     <table width="600" style="margin:25px auto; background:#f8f8f8; border:1px solid #eee; padding:10px;">

<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" enctype="multipart/form-data">

<tr>
  <td colspan="2" style="font:bold 21px arial; text-align:center; border-bottom:1px solid #eee; padding:5px 0 10px 0;">&nbsp; </td>
</tr>

<tr>
  <td colspan="2" style="font:bold 15px arial; text-align:center; padding:0 0 5px 0;">Data Import System</td>
</tr>

<tr>

<td width="50%" style="font:bold 12px tahoma, arial, sans-serif; text-align:right; border-bottom:1px solid #eee; padding:5px 10px 5px 0px; border-right:1px solid #eee;">Select file</td>

<td width="50%" style="border-bottom:1px solid #eee; padding:5px;"><input type="hidden" name="MAX_FILE_SIZE" value="2000000"><input type="file" name="file" id="file" /></td>

</tr>
<tr>

<td width="50%" style="font:bold 12px tahoma, arial, sans-serif; text-align:right; border-bottom:1px solid #eee; padding:5px 10px 5px 0px; border-right:1px solid #eee;">Description</td>

<td width="50%" style="border-bottom:1px solid #eee; padding:5px;" ><textarea type="text" name="description" id="file"  class="form_textbox_inputs" styel="height:100px; width:227px;"></textarea></td>

</tr>
<tr>

<td style="font:bold 12px tahoma, arial, sans-serif; text-align:right; padding:5px 10px 5px 0px; border-right:1px solid #eee;">Submit</td>

<td width="50%" style=" padding:5px;"><input type="submit" name="submit" value="upload" class="gbvis_general_button"/></td>

</tr>

</table>

<?php  
if (isset($_POST["submit"]) && isset($_FILES["file"]))
	 {
if($uploadExcel->UploadedStatus($_POST["submit"],$_FILES["file"]))
{

                      $uploaded =true;
                      $db = new DB();
                     if($uploaded)
                     {
                     
	              //prep the data for saving in a new user object
                        $data['name'] = $fileName;
                        $data['size'] = $fileSize;
                        $data['type'] = $fileType;
                        $data['path'] = $filePath;
                        $data['status'] = $status;
		        $data['description'] = $description;
		        $data['sector'] =  $user_sector;
		        $data['uploadedby']= $Logged_user;
		        $data['useremail'] = $user_email;
		        $data['date'] = $date;
	
	             //create the new file upload object
	           $newUpload = new DB ($data);
	          
	        //save the new file upload to the database
	    
		  $data = array(
		 		"name" => "'$fileName'",
		 		"size" => "'$fileSize'",
		 		"type" => "'$fileType'",
		 		"path" => "'$filePath'",
		 		"status" => "'$status'",
				"description" => "'$description'",
				"sector" => "'$user_sector'",
				"uploadedby" => "'$Logged_user'",
				"useremail" => "'$user_email'",
				"date" => "'$date'"
		              );
	           $id = $db->insert($data, 'file_uploads');
	           $uploadsaved =true;
	           
	           if($uploadsaved)
                     {
                     
                     //$fromName ='GBV Information System';
                     //$ToName ='Sector Data Admin';
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
                            'benardkkoech@gmail.com' => 'Benard',
                             'ekitonyo@gmail.com ' => 'Ebenezer'
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


echo "<script type='text/javascript'>alert('Upload successfully! await approval')</script>";


}

}
?>

</form>
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