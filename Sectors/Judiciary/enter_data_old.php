<?php
//TA:60:4
$page_title = "Enter Data | Judiciary Sector | GBV";
$current_page = "home";

require_once 'includes/global.inc.php';

if (isset ( $_SESSION ['logged_in'] )) {
	
	$user = unserialize ( $_SESSION ['user'] );
	
    if( !($userTools->isSuperAdmin($user->user_group) || ($userTools->isAdmin($user->user_group) &&  $userTools->judiciary($user->sector)))){
        print " You do not have permission to access this page.";
        return;
    }
	
	$mode = $_GET['mode'];
	$county_id = $_GET['county_id'];
	$indicator_id = $_GET['indicator_id'];
	$aggregate = $_GET['aggregate'];
	$date = $_GET['date'];
	$date_arr = explode("/", $date);
	$date_new = $date_arr[2] ."-" .  $date_arr[0] . "-" . $date_arr[1]; //YYYY-MM-DD in database
	$sex = $_GET['sex'];
	$cadre_id = $_GET['cadre_id'];
	
	$county = $db->selectAllOrderedWhere("counties", "county_name", " county_id=" . $county_id)[0][1];
	$indicator = $db->selectAllOrderedWhere("indicators", "indicator", " indicator_id=" . $indicator_id)[0][3];
	
	$db = new DB();
	$message = "";
	$message_upload = "";
	
	if($mode === 'add_aggregates'){
	   $data['county_id'] = $county_id;
	   $data['indicator_id'] = $indicator_id;
	   $data['aggregate'] = $aggregate;
	   $data['created_by'] = $user->id;
	   $data['timestamp_created'] = "'" . date("Y-m-d H:i:s") . "'";
	   $data['date'] = "'" . $date_new . "'";
	   if($indicator_id === '28'){
	       $data['sex'] = "'" . $sex . "'";
	       $data['cadre'] = $cadre_id;
	   }
	   if($db->insertData($data, "judiciary_aggregates")){
	       $message .= $aggregate . " aggregate(s) is inserted.\n";
	   }else{
	       $message .= $aggregate . " aggregate(s) is NOT inserted.\n";
	   }

	}else if($mode === 'add_aggregates_csv'){
	      
        include "import_excel.php";
         
	    $error_upload = "";
	    
	    $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        if(isset($_POST["submit"])) {
            
           $rows = explode("\n" ,file_get_contents($_FILES["fileToUpload"]["tmp_name"]));
           
           //validate file format
           //validate headers
           $row1 = explode("," , $rows[0]);
           if($row1[0] !== 'County Code'){
               $error_upload .= "ERROR: Wrong file format. Header was changed.\\n";
           }
           if($row1[1] !== 'County Name'){
               $error_upload .= "ERROR: Wrong file format. Header was changed.\\n";
           }
           if($row1[2] !== 'Number of judges/magistrates trained in SGVB'){ //indicator_id=28
               $error_upload .= "ERROR: Wrong file format. Header was changed.\\n";
           }
           if($row1[4] !== 'Number of prosecuted SGBV cases'){//indicator_id=7
               $error_upload .= "ERROR: Wrong file format. Header was changed.\\n";
           }
           if($row1[6] !== 'Number of prosecuted SGBV cases withdrawn'){//indicator_id=8
               $error_upload .= "ERROR: Wrong file format. Header was changed.\\n";
           }
           if($row1[8] !== 'Number of prosecuted SGBV cases that resulted in a conviction'){//indicator_id=9
               $error_upload .= "ERROR: Wrong file format. Header was changed.\\n";
           }
           if($row1[10] !== 'Average time to conclude a SGBV case'){//indicator_id=10
               $error_upload .= "ERROR: Wrong file format. Header was changed.\\n";
           }
           $row2 = explode("," , $rows[1]);
           if($row2[2] !== 'Date (MM/YYYY)' || $row2[4] !== 'Date (MM/YYYY)' || $row2[6] !== 'Date (MM/YYYY)' || $row2[8] !== 'Date (MM/YYYY)' || $row2[10] !== 'Date (MM/YYYY)'){
               $error_upload .= "ERROR: Wrong file format. Header was changed.\\n";
           }
           if($row2[3] !== 'Aggregate' || $row2[5] !== 'Aggregate' || $row2[7] !== 'Aggregate' || $row2[9] !== 'Aggregate' || $row2[11] !== 'Aggregate'){
              $error_upload .= "ERROR: Wrong file format. Header was changed.\\n";
           }
           //validate data rows
           for($i=2; $i<count($rows)-2; $i++){
               $row = explode("," , $rows[$i]);
               $validate_out = validate($row[0], $row[2], $row[3]); //indicator_id=28
               if($validate_out !== ""){
                   $error_upload .= "ERROR in CSV file row " . ($i+1) . ": " . $validate_out. "\\n";
               }
               $validate_out = validate($row[0], $row[4], $row[5]); //indicator_id=7
               if($validate_out !== ""){
                   $error_upload .= "ERROR in CSV file row " . ($i+1) . ": " . $validate_out. "\\n";
               }
               $validate_out = validate($row[0], $row[6], $row[7]); //indicator_id=8
               if($validate_out !== ""){
                   $error_upload .= "ERROR in CSV file row " . ($i+1) . ": " . $validate_out. "\\n";
               }
               $validate_out = validate($row[0], $row[8], $row[9]); //indicator_id=9
               if($validate_out !== ""){
                   $error_upload .= "ERROR in CSV file row " . ($i+1) . ": " . $validate_out. "\\n";
               }
               $validate_out = validate($row[0], $row[10], $row[11]); //indicator_id=10
               if($validate_out !== ""){
                   $error_upload .= "ERROR in CSV file row " . ($i+1) . ": " . $validate_out . "\\n";
               }
           }
           if($error_upload !== ""){
               echo "<script type='text/javascript'> alert('\\'" . $_FILES["fileToUpload"]["name"] .  "\\' was not uploaded into database.\\n\\n" . $error_upload . "');window.location.href = 'import_excel.php';</script>";
           }
           //insert data
           $date_created = date("Y-m-d H:i:s");
           for($i=2; $i<count($rows)-2; $i++){
               $row = explode("," , $rows[$i]);
               $message_upload .= insert_to_db($row[0], $row[2], $row[3], $user->id, $date_created, '28', $db, $row[1], 'Number of judges/magistrates trained in SGVB');
               $message_upload .= insert_to_db($row[0], $row[4], $row[5], $user->id, $date_created, '7', $db, $row[1], 'Number of prosecuted SGBV cases');
               $message_upload .= insert_to_db($row[0], $row[6], $row[7], $user->id, $date_created, '8', $db, $row[1], 'Number of prosecuted SGBV cases withdrawn');
               $message_upload .= insert_to_db($row[0], $row[8], $row[9], $user->id, $date_created, '9', $db, $row[1], 'Number of prosecuted SGBV cases that resulted in a conviction');
               $message_upload .= insert_to_db($row[0], $row[10], $row[11], $user->id, $date_created, '10', $db, $row[1], 'Average time to conclude a SGBV case');
           }
        }
	}else{
	    print "ERROR: No mode is selected.";
	}
	if($message){
	    print "\nIndicator: " . $indicator . "\nCounty: " . $county . "\nNumber: " . $aggregate . "\n\n" . $message;
	}
	if($message_upload){
	    echo "<script type='text/javascript'> alert('\\'" . $_FILES["fileToUpload"]["name"] .  "\\' was successfully uploaded to database');window.location.href = 'import_excel.php';</script>";
	}
 
	}else{
	//Redirect user back to login page if there is no valid session created
	header("Location: ../../login.php");
}

/*
 * returns empty message if success or error message
 */
function validate($county_id, $date, $aggregate){
    if($county_id === ""){
        return "Wrong file format.\\n"; //wrong format
    }
    if($date !== ""){
        if($aggregate === ""){
           return "Aggregate is empty.\\n"; //empty aggregate
        }
    }else if($aggregate !== ""){
        return "Date is empty.\\n";
    }
    return "";
}

function insert_to_db($county_id, $date, $aggregate, $user_id, $date_created, $indicator_id, $db, $county_name, $indicator){
    if($date !== "" && $aggregate != ""){
           
            $data['timestamp_created'] = "'" . $date_created . "'";
            $data['county_id'] = $county_id;
	       $data['indicator_id'] = $indicator_id;
	       $data['aggregate'] = $aggregate;
	       $data['created_by'] = $user_id;
	       $date_arr = explode("/", $date);
	       $date_new = $date_arr[1] ."-" .  $date_arr[0] . "-01"; //YYYY-MM-DD in database
	       $data['date'] = "'" . $date_new . "'";  
        if($db->insertData($data, "judiciary_aggregates")){
	       return "County: " . $county_name . "; Indicator: \\'" .  $indicator . "\\'; Aggregates:" . $aggregate . "\n";
	   }else{
	        return "ERROR date not inserted => County:" . $county_name . "; Indicator: \\'"  .  $indicator . "\\' Aggregates:" . $aggregate . "\n";
	   }  
    }   
       
}
?>