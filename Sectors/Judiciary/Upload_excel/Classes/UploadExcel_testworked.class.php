<?php


class UploadExcel
 {
 
    
	public $conn;
	public $db;
	public $uploadedStatus;
	public $fileName; 
	public $status;
	public $description;
        public $date;
        public $msg;
     
 
    //Constructor is called whenever a new object is created.
    //Takes an associative array with the DB row as an argument.
    function __construct() {
	
	$this->db = new DB();
	$this->db->connect();
      
    }
 
    public function checkUploadedStatus($submit,$file) 
	{
       $this->uploadedStatus = 0;

  	if ( isset($_POST["submit"]) ) {
	if ( isset($_FILES["file"])) {
	//if there was an error uploading the file
	if ($_FILES["file"]["error"] > 0) {
	echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
	}
	else 
	{
	    
	    $fileName = $_FILES["file"]["name"]; 
            $tmpName = $_FILES['file']['tmp_name'];
            $fileSize = $_FILES['file']['size'];
            $fileType = $_FILES['file']['type'];
            $status='Not Apoproved';
            $date = date('Y-m-d H:i:s');
            $uploadDir ='Uploads/';
            $description =$_POST['description'];
            $filePath = $uploadDir . $fileName;
            $result = move_uploaded_file($tmpName, $filePath);
		
		
	 	// Check to see if file exists in uploads folder 

        if (file_exists($uploadDir . $_FILES["file"]["name"]))
        {
          $_SESSION["uploadMessage"] = $_FILES["file"]["name"] . " already exists in Uploads folder";
        }
		// If it doesn't move to uploads folder
		
        elseif (move_uploaded_file($_FILES["file"]["tmp_name"], $filePath))
           $_SESSION["uploadMessage"]= "Stored in: " .$filePath;
           
			
			// Filename to be persisted for uploading data to MySQL
		
			$_SESSION["inputFileName"]= $filePath;
			
			 if(!get_magic_quotes_gpc())
                          {
                         $fileName = addslashes($fileName);
                         $filePath = addslashes($filePath);
                           }
                           
                       
	          
	
	 $this->uploadedStatus = 1;
	}
	} 
	else
	 {
	echo "No file selected <br />";
	}
	}

	
 
   
	
	return $this->uploadedStatus;
	
	
    }

 public function UploadedStatus($submit,$file)
	{
	
	
	
	return $this->checkUploadedStatus($submit,$file);

	
	
	
	}



}
 
?>
