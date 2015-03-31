<?php

 
require_once 'DB.class.php';
 
 
class UploadExcel
 {
 
    
	public $conn;
	public $db;
	public $uploadedStatus;
    public $postFileName;
 
    //Constructor is called whenever a new object is created.
    //Takes an associative array with the DB row as an argument.
	
    function __construct() {
	
	$this->db = new DB();
	$this->db->connect();
      
    }
 
    public function checkUploadedStatus($submit,$file) 
	{
       $this->uploadedStatus = 0;
	   
	   
	  
	   

  	if ( isset($_POST["submit"]) ) 
	{
	if ( isset($_FILES["file"]))
	 {
	//if there was an error uploading the file
	if ($_FILES["file"]["error"] > 0) 
	{
	echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
	}
	else 
	{
	    
		
		$target_path = $_SERVER['DOCUMENT_ROOT']."/Upload_Excel/Uploads/";
		$target_path .= $_FILES['file']['name'];
		
		//basename( $_FILES['file']['name'])
		
		if (!empty($_FILES['file']['name']))
		{
		 	//$msg=1;
			@unlink(getcwd() . $target_path);
		}
		
		
		
	    
		move_uploaded_file($_FILES["file"]["tmp_name"],$target_path);
		$this->postFileName=$target_path;
		$this->uploadedStatus = 1;
		//echo $msg;
	


	
	
	
	
			
}			
	
	}
	
	}
	else
	{
	echo "No file selected <br />";
	// was recently added
	$this->uploadedStatus = 0;
	}
	
	
     return $this->uploadedStatus;
	
    }

 public function isUploaded($submit,$file)
	{
	
	
	
	if($this->checkUploadedStatus($submit,$file)==1)
	{

	return true;
	
	
	}
	else
	{
	
	return false;
	
	}

}

}
 
?>
