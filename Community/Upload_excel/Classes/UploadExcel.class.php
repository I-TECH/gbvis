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
            $uploadDir ='../../Uploaded_files/.';
            $description =$_POST['description'];
            $Logged_user =$_POST['Logged_user'];
            $user_email =$_POST['user_email'];
            $user_sector =$_POST['user_sector'];
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
                           
                        $uploaded =true;
                        
                     if($uploaded)
                     {
                     
// 	              //prep the data for saving in a new user object
//                         $data['name'] = $fileName;
//                         $data['size'] = $fileSize;
//                         $data['type'] = $fileType;
//                         $data['path'] = $filePath;
//                         $data['status'] = $status;
// 		        $data['description'] = $description;
// 		        $data['sector'] =  $user_sector;
// 		        $data['uploadedby']= $Logged_user;
// 		        $data['useremail'] = $user_email;
// 		        $data['date'] = $date;
	
	             //create the new file upload object
	           $newUpload = new DB ();
	          
	        //save the new file upload to the database
	    
		    $data = array (
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
	           $id = $newUpload->insert($data, 'file_uploads');
	           
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
