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
	 $fileName = $_FILES["file"]["name"]; 
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

<td width="50%" style="border-bottom:1px solid #eee; padding:5px;"><input type="hidden" name="Logged_user" value="<?php echo $Logged_user;?>"><input type="hidden" name="user_sector" value="<?php echo $user_sector;?>"> <input type="hidden" name="user_email" value="<?php echo $user_email;?>"><input type="hidden" name="MAX_FILE_SIZE" value="2000000"><input type="file" name="file" id="file" /></td>




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

 if(!mailsent){
  echo "<script type='text/javascript'>alert('Mail error: .$mail->ErrorInfo')</script>";
 }
 else{
echo "<script type='text/javascript'>alert('Upload successfully! await approval')</script>";
}

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