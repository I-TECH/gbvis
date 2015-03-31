<?php
//session_start(); 

require_once 'Classes/UploadExcel.class.php';

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

?>


<html>

<head>
<title>Demo - Import Excel file data in mysql database using PHP, Upload Excel file data in database</title>
<meta name="description" content="This tutorial will learn how to import excel sheet data in mysql database using php. Here, first upload an excel sheet into your server and then click to import it into database. All column of excel sheet will store into your corrosponding database table."/>
<meta name="keywords" content="import excel file data in mysql, upload ecxel file in mysql, upload data, code to import excel data in mysql database, php, Mysql, Ajax, Jquery, Javascript, download, upload, upload excel file,mysql"/>

</head>

<body>

<table width="600" style="margin:115px auto; background:#f8f8f8; border:1px solid #eee; padding:10px;">

<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" enctype="multipart/form-data">

<tr>
  <td colspan="2" style="font:bold 21px arial; text-align:center; border-bottom:1px solid #eee; padding:5px 0 10px 0;">&nbsp;</td>
</tr>

<tr>
  <td colspan="2" style="font:bold 15px arial; text-align:center; padding:0 0 5px 0;">Data Import System</td>
</tr>

<tr>

<td width="50%" style="font:bold 12px tahoma, arial, sans-serif; text-align:right; border-bottom:1px solid #eee; padding:5px 10px 5px 0px; border-right:1px solid #eee;">Select file</td>

<td width="50%" style="border-bottom:1px solid #eee; padding:5px;"><input type="file" name="file" id="file" /></td>

</tr>





<tr>

<td style="font:bold 12px tahoma, arial, sans-serif; text-align:right; padding:5px 10px 5px 0px; border-right:1px solid #eee;">Submit</td>

<td width="50%" style=" padding:5px;"><input type="submit" name="submit" /></td>

</tr>

</table>

<?php  
if (isset($_POST["submit"]) && isset($_FILES["file"]))
	 {
if($uploadExcel->isUploaded($_POST["submit"],$_FILES["file"]))
{



echo "<table align='center'><tr><td  ><center>============================= <b>File Uploaded<b/> =============================================</center></td></tr>";

echo '<tr><td ><center>============================= <b>Do you want to upload the data <a href="police_insert.php?filename='.$uploadExcel->postFileName.'">Click Here</a> </b>========================</center></td></tr></table>';

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

</body>

</html>