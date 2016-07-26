<?php
//index.php
  $page_title = "Home | GBV";
    $current_page = "home";
	

require_once '../includes/globallevel2.inc.php';

 //check to see if they're logged in
if(isset($_SESSION['logged_in'])) {

//get the user object from the session
$user = unserialize($_SESSION['user']);


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
	  <div id="main-content">
	    <div id="bread-crumbs">
	      <!--breadcrumbs-->
	    </div>
        <div id="content-body">
	<h3 class="page-title">Home</h3>
	   <hr size="1" color="#CCCCCC">
<div class="profile-data" align="left">




<?php  

if (isset($_POST["submit"]) && isset($_FILES["file"]))
	 {
if($uploadExcel->UploadedStatus($_POST["submit"],$_FILES["file"]))
{



echo "<table align='center'><tr><td><center><b>File Uploaded<b/></center></td></tr>";

echo '<tr><td><center><b><a href="index2.php?filename='.$uploadExcel->fileName.'">Import Uploaded file</a> </b></center></td></tr></table>';

}

}
?>



</form>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-38304687-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
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