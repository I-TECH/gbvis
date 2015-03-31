 <?php
 
 
  $fileName = "police_aggregates_database_format.xlsx"; 
		
  $UploadedFilePath = "/Upload_Excel/Uploads/".$fileName;
		
		// Check to see if file exists in uploads folder 
		
	function is_file_exists($filePath)
{
      return is_file($filePath) && file_exists($filePath);
}
    
	 
	is_file_exists($UploadedFilePath); 
	 
?>
