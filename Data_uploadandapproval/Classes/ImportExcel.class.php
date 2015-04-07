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
	
	               $status='Approved';
                       $date_modified = date('Y-m-d H:i:s');
     
                     if($uploaded)
                     {
                      
 	              //prep the data for saving in a new user object
                         
                        $data['status'] = $status;
  		        $data['date'] = $date_modified;
	
	             //create the new file upload object
	         
	                 $newUpload = new DB ($data);
	        //save the new file upload to the database
	    
 		    $data = array (
 		 		"status" => "'$status'",
				"date" => "'$date_modified'"
 		              );
	           $id = $newUpload->update($data, 'file_uploads');
	           
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
