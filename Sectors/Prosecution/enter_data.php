<?php
//TA:60:4
$page_title = "Enter Data | Prosecution Sector | GBV";
$current_page = "home";

require_once 'includes/global.inc.php';

if (isset ( $_SESSION ['logged_in'] )) {
	
	$user = unserialize ( $_SESSION ['user'] );
	
if( !($userTools->isAdmin($user->user_group) &&  $user->sector === '4')){
        print " You do not have permission to access this page.";
        return;
    }
	
	$mode = $_GET['mode'];
	$county_id = $_GET['county_id'];
	$indicator15 = $_GET['indicator15'];
	$indicator16 = $_GET['indicator16'];
	$indicator17 = $_GET['indicator17'];
	
	$date = $_GET['date'];
	$date_arr = explode("/", $date);
	//$date_new = $date_arr[2] ."-" .  $date_arr[0] . "-" . $date_arr[1]; //YYYY-MM-DD in database
	$date_new = $date_arr[1] ."-" .  $date_arr[0] . "-01"; //YYYY-MM-DD in database
	
	$county = $db->selectAllOrderedWhere("counties", "county_name", " county_id=" . $county_id)[0][1];
	
	$db = new DB();
	
	
	if($mode === 'add_aggregates'){
	$message = "";
	   $data['county_id'] = $county_id;
	   $data['created_by'] = $user->id;
	   $data['timestamp_created'] = "'" . date("Y-m-d H:i:s") . "'";
	   $data['date'] = "'" . $date_new . "'";
	   
	   if($indicator15 && $indicator15 !== ''){
	   	$data['indicator_id'] = 15;
	   	$ranks = explode(";" , $indicator15);
	   	$message .= "\nIndicator 6.1 Number of prosecutors who have been trained in SGBV using SGBV prosecutor's manual:\n";
	   	for($i=0;$i<count($ranks);$i++){
	   		$rank = explode("," , $ranks[$i]);
	   		$data['sex'] = "'" . $rank[0] . "'";
	   		$data['rank'] = $rank[1];
	   		$data['aggregate'] = $rank[2];
	   		if($db->insertData($data, "prosecution_aggregates")){
	   			$message .= $data['aggregate'] . " aggregate(s) is inserted.\n";
	   		}else{
	   			$message .= $data['aggregate'] . " aggregate(s) is NOT inserted.\n";
	   		}
	   	}
	   }
	   if($indicator17 && $indicator17 !== ''){
	       $data['indicator_id'] = 17;
	       $data['aggregate'] = $indicator17;
	       $message .= "\nIndicator 6.2.a Number of SGBV cases that were prosecuted during the specified time period:\n";
	       if($db->insertData($data, "prosecution_aggregates")){
	           $message .= $data['aggregate'] . " aggregate(s) is inserted.\n";
	       }else{
	           $message .= $data['aggregate'] . " aggregate(s) is NOT inserted.\n";
	       }
	   }
	   if($indicator16 && $indicator16 !== ''){
	   	$data['indicator_id'] = 16;
	   	$data['aggregate'] = $indicator16;
	   	$message .= "\nIndicator 6.2.b Total number of SGBV cases reported to the police in the same time period:\n";
	   	if($db->insertData($data, "prosecution_aggregates")){
	   		$message .= $data['aggregate'] . " aggregate(s) is inserted.\n";
	   	}else{
	   		$message .= $data['aggregate'] . " aggregate(s) is NOT inserted.\n";
	   	}
	   }
	   
	   
	   if($message){
	       print "Data uploaded successfully"; //do not print out diagnostics
	   	//print "\nCounty: " . $county . "\n\n" . $message;
	   	return;
	   }
	   

	}else if($mode === 'add_aggregates_csv'){
	    $target_dir = "uploads/";
	    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
	    $message_upload = "";
	    $error_upload = "";
	    
	     //end of line characteristcs is different:
           // Windows - \r\n
           //MAC - \r
           //Linux - \n
           // to handle all cases we replaced them by #, then split it by #
            $my_string = preg_replace(array('/\n/', '/\r/'), '#', file_get_contents($_FILES["fileToUpload"]["tmp_name"]));
            $my_string = preg_replace('/##/', '#', $my_string); // in case for Windows where will have \r\n replaces by ##
            $rows = explode('#', $my_string);
            
	    //validate template
	    $row1 = explode("," , $rows[0]);
	    if($row1[0] === 'Prosecution Sector Template Indicator 6.1'){
	        //validate headers
	        $row2 = explode("," , $rows[1]);
	        $error_upload .= validate_header($row2[0], "County Code", "A", "2");
	        $error_upload .= validate_header($row2[1], "County Name", "B", "2");
	        $error_upload .= validate_header($row2[2], "Number of police who have been trained to respond and investigate cases of SGBV", "C", "2"); //indicator_id=15
	        $row3 = explode("," , $rows[2]);
	        $error_upload .= validate_header($row3[2], "Date (MM/YYYY)", "C", "3");
	        $error_upload .= validate_header($row3[3], "Attorney General", "D", "3"); 
	        $error_upload .= validate_header($row3[5], "Solicitor General", "F", "3");
	        $error_upload .= validate_header($row3[7], "Director of Public prosecutions", "H", "3");
	        $error_upload .= validate_header($row3[9], "Assistant director of Public prosecutions", "J", "3");
	        $error_upload .= validate_header($row3[11], "Senior principal state counsel", "L", "3");
	        $error_upload .= validate_header($row3[13], "Senior state counsel", "N", "3");
	        $error_upload .= validate_header($row3[15], "State counsel One", "P", "3");
	        $error_upload .= validate_header($row3[17], "State counsel Two", "R", "3");
	        $row4 = explode("," , $rows[3]);
	        $error_upload .= validate_header($row4[3], "Male", "D", "4");
	        $error_upload .= validate_header($row4[4], "Female", "E", "4");
	        $error_upload .= validate_header($row4[5], "Male", "F", "4");
	        $error_upload .= validate_header($row4[6], "Female", "G", "4");
	        $error_upload .= validate_header($row4[7], "Male", "H", "4");
	        $error_upload .= validate_header($row4[8], "Female", "I", "4");
	        $error_upload .= validate_header($row4[9], "Male", "J", "4");
	        $error_upload .= validate_header($row4[10], "Female", "K", "4");
	        $error_upload .= validate_header($row4[11], "Male", "L", "4");
	        $error_upload .= validate_header($row4[12], "Female", "M", "4");
	        $error_upload .= validate_header($row4[13], "Male", "N", "4");
	        $error_upload .= validate_header($row4[14], "Female", "O", "4");
	        $error_upload .= validate_header($row4[15], "Male", "P", "4");
	        $error_upload .= validate_header($row4[16], "Female", "Q", "4");
	        $error_upload .= validate_header($row4[17], "Male", "R", "4");
	        $error_upload .= validate_header($row4[18], "Female", "S", "4");
	        
	        //validate data rows
	        for($i=4; $i<count($rows)-1; $i++){
	            $row_data = explode("," , $rows[$i]);
	            $error_upload .= validate_data_indicator15($row_data[0], $row_data[2],
	                $row_data[3], $row_data[4], $row_data[5], $row_data[6], $row_data[7], $row_data[8], $row_data[9], $row_data[10], $row_data[11], $row_data[12], $row_data[13], $row_data[14],
	                $row_data[15], $row_data[16], $row_data[17], $row_data[18], 
	                "C", "D-AE", $i+1); //indicator_id=15
	        }
	         
	        if($error_upload !== ""){
	            print_message("'" . $_FILES["fileToUpload"]["name"] . "' was not uploaded into database. Please correct CSV file.\n\n" . $error_upload);
	            return;
	        }
	        
	        //insert data
	        $date_created = date("Y-m-d H:i:s");
	        for($i=4; $i<count($rows)-1; $i++){
	            $row = explode("," , $rows[$i]);
	            // $county_id, $date, $aggregate, $user_id, $date_created, $indicator_id, $db, $county_name, $indicator, $sex, $rank
	            $indicator_name = 'Number of police who have been trained to respond and investigate cases of SGBV';
	            $indicator_id = '15';
	            $message_upload .= insert_indicator15($row[0], $row[2], $row[3], $user->id, $date_created, $indicator_id, $db, $row[1], $indicator_name, "Male", "15");
	            $message_upload .= insert_indicator15($row[0], $row[2], $row[4], $user->id, $date_created, $indicator_id, $db, $row[1], $indicator_name, "Female", "15");
	            $message_upload .= insert_indicator15($row[0], $row[2], $row[5], $user->id, $date_created, $indicator_id, $db, $row[1], $indicator_name, "Male", "16");
	            $message_upload .= insert_indicator15($row[0], $row[2], $row[6], $user->id, $date_created, $indicator_id, $db, $row[1], $indicator_name, "Female", "16");
	            $message_upload .= insert_indicator15($row[0], $row[2], $row[7], $user->id, $date_created, $indicator_id, $db, $row[1], $indicator_name, "Male", "17");
	            $message_upload .= insert_indicator15($row[0], $row[2], $row[8], $user->id, $date_created, $indicator_id, $db, $row[1], $indicator_name, "Female", "17");
	            $message_upload .= insert_indicator15($row[0], $row[2], $row[9], $user->id, $date_created, $indicator_id, $db, $row[1], $indicator_name, "Male", "18");
	            $message_upload .= insert_indicator15($row[0], $row[2], $row[10], $user->id, $date_created, $indicator_id, $db, $row[1], $indicator_name, "Female", "18");
	            $message_upload .= insert_indicator15($row[0], $row[2], $row[11], $user->id, $date_created, $indicator_id, $db, $row[1], $indicator_name, "Male", "19");
	            $message_upload .= insert_indicator15($row[0], $row[2], $row[12], $user->id, $date_created, $indicator_id, $db, $row[1], $indicator_name, "Female", "19");
	            $message_upload .= insert_indicator15($row[0], $row[2], $row[13], $user->id, $date_created, $indicator_id, $db, $row[1], $indicator_name, "Male", "20");
	            $message_upload .= insert_indicator15($row[0], $row[2], $row[14], $user->id, $date_created, $indicator_id, $db, $row[1], $indicator_name, "Female", "20");
	            $message_upload .= insert_indicator15($row[0], $row[2], $row[15], $user->id, $date_created, $indicator_id, $db, $row[1], $indicator_name, "Male", "21");
	            $message_upload .= insert_indicator15($row[0], $row[2], $row[16], $user->id, $date_created, $indicator_id, $db, $row[1], $indicator_name, "Female", "21");
	            $message_upload .= insert_indicator15($row[0], $row[2], $row[17], $user->id, $date_created, $indicator_id, $db, $row[1], $indicator_name, "Male", "22");
	            $message_upload .= insert_indicator15($row[0], $row[2], $row[18], $user->id, $date_created, $indicator_id, $db, $row[1], $indicator_name, "Female", "22");
	            
	        }
	    }else if($row1[0] === 'Prosecution Sector Template Indicator 6.2'){
	        
	        //validate headers
	        $row2 = explode("," , $rows[1]);
	        $error_upload .= validate_header($row2[0], "County Code", "A", "2");
	        $error_upload .= validate_header($row2[1], "County Name", "B", "2");
	        $error_upload .= validate_header($row2[2], "Total number of SGBV cases reported to the police in the same time period", "C", "2"); //indicator_id=16
	        $error_upload .= validate_header($row2[4], "Number of SGBV cases that were prosecuted during the specified time period", "E", "2"); //indicator_id=17
	        $row3 = explode("," , $rows[2]);
	        $error_upload .= validate_header($row3[2], "Date (MM/YYYY)", "C", "3");
	        $error_upload .= validate_header($row3[3], "Aggregate", "D", "3");
	        $error_upload .= validate_header($row3[4], "Date (MM/YYYY)", "E", "3");
	        $error_upload .= validate_header($row3[5], "Aggregate", "F", "3");
	        
	        //validate data rows
	        for($i=3; $i<count($rows)-1; $i++){
	            $row_data = explode("," , $rows[$i]);
	            $error_upload .= validate_data_indicator16_17($row_data[0], $row_data[2], $row_data[3], "C", "D", $i+1); //indicator_id=16
	            $error_upload .= validate_data_indicator16_17($row_data[0], $row_data[4], $row_data[5], "E", "F", $i+1); //indicator_id=17
	        }
	         
	        
	        if($error_upload !== ""){
	            print_message("'" . $_FILES["fileToUpload"]["name"] . "' was not uploaded into database. Please correct CSV file.\n\n" . $error_upload);
	            return;
	        }
	         
	        //insert data
	        $date_created = date("Y-m-d H:i:s");
	        for($i=3; $i<count($rows)-1; $i++){
	            $row = explode("," , $rows[$i]);
	            // $county_id, $date, $aggregate, $user_id, $date_created, $indicator_id, $db, $county_name, $indicator
	            $message_upload .= insert_indicators16_17($row[0], $row[2], $row[3], $user->id, $date_created, '22', $db, $row[1], 'Total number of SGBV cases reported to the police in the same time period');//indicator_id=16
	            $message_upload .= insert_indicators16_17($row[0], $row[4], $row[5], $user->id, $date_created, '23', $db, $row[1], 'Number of SGBV cases that were prosecuted during the specified time period');//indicator_id=17
	        }
	        
	    }else{
	       print_message("'" . $_FILES["fileToUpload"]["name"] . "' was not uploaded into database. ERROR: Wrong file format. Template is not defined. Please correct CSV file.\n\n");
            return;
	    }
	    
	if($message_upload){
	    $message_upload = ""; //do not print out diagnostics
            print_message("'" . $_FILES["fileToUpload"]["name"] . "' was successfully uploaded into database.\n\n" . $message_upload);
	        return;
	    }else{
	        print_message("'" . $_FILES["fileToUpload"]["name"] . "' does not have any data to upload into database.\n\n");
	        return;
	    }
	}else{
	    print "ERROR: No mode is selected.";
	}
	
 
	}else{
	//Redirect user back to login page if there is no valid session created
	header("Location: ../../login.php");
}

function print_message($message){
    $message = str_replace("'","\\'",$message);
    $message = str_replace("\n","\\n",$message);
    print "<script type='text/javascript'> alert('" . $message . "');window.location.href = 'import_excel.php';</script>";
}

//date format mm/YYYY
function validateDate($date){
    $date = trim($date);
    $date_arr = explode("/", $date);
    return checkdate ( $date_arr[0] , "01" , $date_arr[1] );

}

function validate_header($current_value, $value, $column, $row){
    $current_value = str_replace("+", "", $current_value);
    if($current_value !== $value){
        return "ERROR: Wrong file format. Header (column " . $column . ", row " . $row . ") must be '" . $value . "'=" . $current_value ."\n";
    }
    return "";
}

function validateAggregate($aggregate){
    $aggregate = trim($aggregate);
    if($aggregate === ''){
        return true;
    }else if(is_numeric($aggregate) && $aggregate>=0){
        return true;
    }
    return false;
}

/*
 * returns empty message if success or error message
 */
function validate_data_indicator15($county_id, $date, $aggregate1, $aggregate2, $aggregate3, $aggregate4, $aggregate5, $aggregate6, $aggregate7, $aggregate8, $aggregate9, $aggregate10, $aggregate11, $aggregate12,
    $aggregate13, $aggregate14, $aggregate15, $aggregate16, $column_date, $columns_aggregate, $row){
    if($county_id === ""){
        return "ERROR: Wrong file format. County id is not defined (row " . $row . ").\n"; //wrong format
    }
    if($date !== ""){
        //validate date format
        if(!validateDate($date)){
            return "ERROR: Date format is wrong  (column " . $column_date . ", row " . $row . "). Must be MM/YYYY.\n"; //date format is wrong
        }
        if($aggregate1 === "" && $aggregate2 === "" && $aggregate3 === "" && $aggregate4 === "" && $aggregate5 === "" && $aggregate6 === "" && $aggregate7 === "" && $aggregate8 === "" && $aggregate9 === "" &&
            $aggregate10 === "" && $aggregate11 === "" && $aggregate12 === "" && $aggregate13 === "" && $aggregate14 === "" && $aggregate15 === "" && $aggregate16 === "" ){
            return "ERROR: All aggregates are empty (columns " . $columns_aggregate . ", row " . $row . "). Please insert values.\n"; //empty aggregate
        }
    }else if($aggregate1 !== "" || $aggregate2 !== "" || $aggregate3 !== "" || $aggregate4 !== "" || $aggregate5 !== "" || $aggregate6 !== "" || $aggregate7 !== "" || $aggregate8 !== "" || $aggregate9 !== "" ||
        $aggregate10 !== "" || $aggregate11 !== "" || $aggregate12 !== "" || $aggregate13 !== "" || $aggregate14 !== "" || $aggregate15 !== "" || $aggregate16 !== "" ){
        return "ERROR: Date is empty (column " . $column_date . ", row " . $row . ").\n"; //empty date;
    }
    return "";
}

/*
 * returns empty message if success or error message
 */
function validate_data_indicator16_17($county_id, $date, $aggregate, $column_date, $column_aggregate, $row){
    if($county_id === ""){
        return "ERROR: Wrong file format. County id is not defined (row " . $row . ").\n"; //wrong format
    }
    if($date !== ""){
        //validate date format
        if(!validateDate($date)){
            return "ERROR: Date format is wrong  (column " . $column_date . ", row " . $row . "). Must be MM/YYYY.\n"; //date format is wrong
        }
        if($aggregate === ""){
            return "ERROR: Aggregate is empty (column " . $column_aggregate . ", row " . $row . ").\n"; //empty aggregate
        }
    }else if($aggregate !== ""){
        return "ERROR: Date is empty (column " . $column_date . ", row " . $row . ").\n"; //empty date;
    }
    return "";
}

function insert_indicator15($county_id, $date, $aggregate, $user_id, $date_created, $indicator_id, $db, $county_name, $indicator, $sex, $rank){
    if($date !== "" && $aggregate != ""  && $aggregate !== '0'){
         
        $data['timestamp_created'] = "'" . $date_created . "'";
        $data['county_id'] = $county_id;
        $data['indicator_id'] = $indicator_id;
        $data['aggregate'] = $aggregate;
        $data['created_by'] = $user_id;
        $date_arr = explode("/", $date);
        $date_new = $date_arr[1] ."-" .  $date_arr[0] . "-01"; //YYYY-MM-DD in database
        $data['date'] = "'" . $date_new . "'";
        $data['sex'] = "'" . $sex . "'";
        $data['rank'] = $rank;
        if($db->insertData($data, "prosecution_aggregates")){
            return "County: " . $county_name . "; Indicator: '" .  $indicator . "'; Aggregates:" . $aggregate . ".\n";
        }else{
            return "ERROR date not inserted => County:" . $county_name . "; Indicator: '"  .  $indicator . "' Aggregates:" . $aggregate . ".\n";
        }
    }
}

function insert_indicators16_17($county_id, $date, $aggregate, $user_id, $date_created, $indicator_id, $db, $county_name, $indicator){
    if($date !== "" && $aggregate != ""  && $aggregate !== '0'){
         
        $data['timestamp_created'] = "'" . $date_created . "'";
        $data['county_id'] = $county_id;
        $data['indicator_id'] = $indicator_id;
        $data['aggregate'] = $aggregate;
        $data['created_by'] = $user_id;
        $date_arr = explode("/", $date);
        $date_new = $date_arr[1] ."-" .  $date_arr[0] . "-01"; //YYYY-MM-DD in database
        $data['date'] = "'" . $date_new . "'";
        if($db->insertData($data, "prosecution_aggregates")){
            return "County: " . $county_name . "; Indicator: '" .  $indicator . "'; Aggregates:" . $aggregate . ".\n";
        }else{
            return "ERROR date not inserted => County:" . $county_name . "; Indicator: '"  .  $indicator . "' Aggregates:" . $aggregate . ".\n";
        }
    }
}
?>