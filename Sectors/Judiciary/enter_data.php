<?php
//TA:60:4
$page_title = "Enter Data | Judiciary Sector | GBV";
$current_page = "home";

require_once 'includes/global.inc.php';

if (isset ( $_SESSION ['logged_in'] )) {
	
	$user = unserialize ( $_SESSION ['user'] );
	
if( !($userTools->isAdmin($user->user_group) &&  $user->sector === '1')){
        print " You do not have permission to access this page.";
        return;
    }
	
	$mode = $_GET['mode'];
	$county_id = $_GET['county_id'];
	$indicator28 = $_GET['indicator28'];
	$indicator7 = $_GET['indicator7'];
	$indicator8 = $_GET['indicator8'];
	$indicator9 = $_GET['indicator9'];
	$indicator10 = $_GET['indicator10'];
	
	$date = $_GET['date'];
	$date_arr = explode("/", $date);
	//$date_new = $date_arr[2] ."-" .  $date_arr[0] . "-" . $date_arr[1]; //YYYY-MM-DD in database
	   $date_new = $date_arr[1] ."-" .  $date_arr[0] . "-01"; //YYYY-MM-DD in database
	
	$county = $db->selectAllOrderedWhere("counties", "county_name", " county_id=" . $county_id)[0][1];
	$indicator = $db->selectAllOrderedWhere("indicators", "indicator", " indicator_id=" . $indicator_id)[0][3];
	
	$db = new DB();
	
	
	if($mode === 'add_aggregates'){
	    
	    $message = "";
	   $data['county_id'] = $county_id;
	   $data['created_by'] = $user->id;
	   $data['timestamp_created'] = "'" . date("Y-m-d H:i:s") . "'";
	   $data['date'] = "'" . $date_new . "'";
	   if($indicator7 && $indicator7 !== ''){
	   	$data['indicator_id'] = 7;
	   	$data['aggregate'] = $indicator7;
	   	$message .= "\nIndicator 7.2.a Number of prosecuted SGBV cases:\n";
	   	if($db->insertData($data, "judiciary_aggregates")){
	   		$message .= $data['aggregate'] . " aggregate(s) is inserted.\n";
	   	}else{
	   		$message .= $data['aggregate'] . " aggregate(s) is NOT inserted.\n";
	   	}
	   }
	   if($indicator8 && $indicator8 !== ''){
	   	$data['indicator_id'] = 8;
	   	$data['aggregate'] = $indicator8;
	   	$message .= "\nIndicator 7.2.b Number of cases withdrawn:\n";
	   	if($db->insertData($data, "judiciary_aggregates")){
	   		$message .= $data['aggregate'] . " aggregate(s) is inserted.\n";
	   	}else{
	   		$message .= $data['aggregate'] . " aggregate(s) is NOT inserted.\n";
	   	}
	   }
	   if($indicator9 && $indicator9 !== ''){
	   	$data['indicator_id'] = 9;
	   	$data['aggregate'] = $indicator9;
	   	$message .= "\nIndicator 7.3 Number of cases convicted:\n";
	   	if($db->insertData($data, "judiciary_aggregates")){
	   		$message .= $data['aggregate'] . " aggregate(s) is inserted.\n";
	   	}else{
	   		$message .= $data['aggregate'] . " aggregate(s) is NOT inserted.\n";
	   	}
	   }
	   if($indicator10 && $indicator10 !== ''){
	   	$data['indicator_id'] = 10;
	   	$data['aggregate'] = $indicator10;
	   	$message .= "\nIndicator 7.4 Average time to conclude case (months):\n";
	   	if($db->insertData($data, "judiciary_aggregates")){
	   		$message .= $data['aggregate'] . " aggregate(s) is inserted.\n";
	   	}else{
	   		$message .= $data['aggregate'] . " aggregate(s) is NOT inserted.\n";
	   	}
	   }
	   if($indicator28 && $indicator28 !== ''){
	       $data['indicator_id'] = 28;
	       $cadres = explode(";" , $indicator28);
	       $message .= "\nIndicator 7.1 Number of judges/magistrates trained in SGVB:\n";
	       for($i=0;$i<count($cadres);$i++){
	           $cadre = explode("," , $cadres[$i]);
	           $data['sex'] = "'" . $cadre[0] . "'";
	           $data['cadre'] = $cadre[1];
	           $data['aggregate'] = $cadre[2];
	           if($db->insertData($data, "judiciary_aggregates")){
	               $message .= $data['aggregate'] . " aggregate(s) is inserted.\n";
	           }else{
	               $message .= $data['aggregate'] . " aggregate(s) is NOT inserted.\n";
	           }
	       }
	   }
	   
	   
	 if($message){
	       //print "\nCounty: " . $county . "\n\n" . $message;
	       print "Data uploaded successfully"; //do not print out diagnostics
	       return;
	   }

	}else if($mode === 'add_aggregates_csv'){
	    
	    $target_dir = "uploads/";
	    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
	    
        if(isset($_POST["submit"])) {
            
           $error_upload = "";
           $message_upload = "";

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
           if($row1[0] === 'Judiciary Sector Template 1'){
               //validate headers
               $row2 = explode("," , $rows[1]);
               $error_upload .= validate_header($row2[0], "County Code", "A", "2");
               $error_upload .= validate_header($row2[1], "County Name", "B", "2");
               $error_upload .= validate_header($row2[2], "Number of judges/magistrates trained in SGVB", "C", "2");                    //indicator_id=28
               $error_upload .= validate_header($row2[22], "Number of prosecuted SGBV cases", "W", "2");                                 //indicator_id=7
               $error_upload .= validate_header($row2[24], "Number of prosecuted SGBV cases withdrawn", "Y", "2");                       //indicator_id=8
               $error_upload .= validate_header($row2[26], "Number of prosecuted SGBV cases that resulted in a conviction", "AA", "2");   //indicator_id=9
               $error_upload .= validate_header($row2[28], "Average time to conclude a SGBV case (weeks)", "AC", "2");                    //indicator_id=10
               $row3 = explode("," , $rows[2]);
               $error_upload .= validate_header($row3[2], "Date (MM/YYYY)", "C", "3");
               $error_upload .= validate_header($row3[3], "Male", "D", "3");
               $error_upload .= validate_header($row3[14], "Female", "O", "3");
               $error_upload .= validate_header($row3[22], "Date (MM/YYYY)", "W", "3");
               $error_upload .= validate_header($row3[23], "Aggregate", "X", "3");
               $error_upload .= validate_header($row3[24], "Date (MM/YYYY)", "Y", "3");
               $error_upload .= validate_header($row3[25], "Aggregate", "Z", "3");
               $error_upload .= validate_header($row3[26], "Date (MM/YYYY)", "AA", "3");
               $error_upload .= validate_header($row3[27], "Aggregate", "AB", "3");
               $error_upload .= validate_header($row3[28], "Date (MM/YYYY)", "AE", "3");
               $error_upload .= validate_header($row3[29], "Aggregate", "AD", "3");
               $row4 = explode("," , $rows[3]);
               $error_upload .= validate_header($row4[3], "Supreme Court Judge", "D", "4");
               $error_upload .= validate_header($row4[4], "Court of Appeal Judge", "E", "4");
               $error_upload .= validate_header($row4[5], "High Court Judge", "F", "4");
               $error_upload .= validate_header($row4[6], "Chief Magistrate", "G", "4");
               $error_upload .= validate_header($row4[7], "Senior Principal Magistrate", "H", "4");
               $error_upload .= validate_header($row4[8], "Principal Magistrate", "I", "4");
               $error_upload .= validate_header($row4[9], "Senior Resident Magistrate", "J", "4");
               $error_upload .= validate_header($row4[10], "Resident Magistrate", "K", "4");
               $error_upload .= validate_header($row4[11], "Chief Kadhi", "L", "4");
               $error_upload .= validate_header($row4[12], "Deputy Chief Kadhi", "M", "4");
               $error_upload .= validate_header($row4[13], "Kadhi", "N", "4");
               $error_upload .= validate_header($row4[14], "Supreme Court Judge", "O", "4");
               $error_upload .= validate_header($row4[15], "Court of Appeal Judge", "P", "4");
               $error_upload .= validate_header($row4[16], "High Court Judge", "Q", "4");
               $error_upload .= validate_header($row4[17], "Chief Magistrate", "R", "4");
               $error_upload .= validate_header($row4[18], "Senior Principal Magistrate", "S", "4");
               $error_upload .= validate_header($row4[19], "Principal Magistrate", "T", "4");
               $error_upload .= validate_header($row4[20], "Senior Resident Magistrate", "U", "4");
               $error_upload .= validate_header($row4[21], "Resident Magistrate", "V", "4");
              
           }
           
           //validate data rows
           for($i=4; $i<count($rows)-2; $i++){
               $row_data = explode("," , $rows[$i]);
               $error_upload .= validate_data_indicator28($row_data[0], $row_data[2], $row_data[3], $row_data[4], $row_data[5], $row_data[6], 
               		$row_data[7], $row_data[8], $row_data[9], $row_data[10], $row_data[11], $row_data[12], $row_data[13], $row_data[14],
               		$row_data[15], $row_data[16], $row_data[17], $row_data[18], $row_data[19], $row_data[20], $row_data[21], 
               		"C", "D-V", $i+1);//indicator_id=28
               //$county_id, $date, $aggregate, $column_date, $column_aggregate, $row
               $error_upload .= validate_data_indicators_7_8_9_10($row_data[0], $row_data[22], $row_data[23], "W", "X", $i+1); //indicator_id=7
               $error_upload .= validate_data_indicators_7_8_9_10($row_data[0], $row_data[24], $row_data[25], "Y", "Z", $i+1); //indicator_id=8
               $error_upload .= validate_data_indicators_7_8_9_10($row_data[0], $row_data[26], $row_data[27], "AA", "AB", $i+1);//indicator_id=9
               $error_upload .= validate_data_indicators_7_8_9_10($row_data[0], $row_data[28], $row_data[29], "AC", "AD",$i+1);//indicator_id=10
           }
           
           if($error_upload !== ""){
               print_message("'" . $_FILES["fileToUpload"]["name"] . "' was not uploaded into database. Please correct CSV file.\n\n" . $error_upload);
	            return;
           }
           
           
           //insert data
           $date_created = date("Y-m-d H:i:s");
           for($i=4; $i<count($rows)-2; $i++){
               $row = explode("," , $rows[$i]);
               $indicator_name = "Number of judges/magistrates trained in SGVB";
               $message_upload .= insert_to_db_indicator28($row[0], $row[2], $row[3],  $user->id, $date_created, '28', $db, $row[1], $indicator_name, "Male", 4); //indicator_id=28
               $message_upload .= insert_to_db_indicator28($row[0], $row[2], $row[4],  $user->id, $date_created, '28', $db, $row[1], $indicator_name, "Male", 5); //indicator_id=28
               $message_upload .= insert_to_db_indicator28($row[0], $row[2], $row[5],  $user->id, $date_created, '28', $db, $row[1], $indicator_name, "Male", 6); //indicator_id=28
               $message_upload .= insert_to_db_indicator28($row[0], $row[2], $row[6],  $user->id, $date_created, '28', $db, $row[1], $indicator_name, "Male", 7); //indicator_id=28
               $message_upload .= insert_to_db_indicator28($row[0], $row[2], $row[7],  $user->id, $date_created, '28', $db, $row[1], $indicator_name, "Male", 8); //indicator_id=28
               $message_upload .= insert_to_db_indicator28($row[0], $row[2], $row[8],  $user->id, $date_created, '28', $db, $row[1], $indicator_name, "Male", 9); //indicator_id=28
               $message_upload .= insert_to_db_indicator28($row[0], $row[2], $row[9],  $user->id, $date_created, '28', $db, $row[1], $indicator_name, "Male", 10); //indicator_id=28
               $message_upload .= insert_to_db_indicator28($row[0], $row[2], $row[10],  $user->id, $date_created, '28', $db, $row[1], $indicator_name, "Male", 11); //indicator_id=28
               $message_upload .= insert_to_db_indicator28($row[0], $row[2], $row[11],  $user->id, $date_created, '28', $db, $row[1], $indicator_name, "Male", 12); //indicator_id=28
               $message_upload .= insert_to_db_indicator28($row[0], $row[2], $row[12],  $user->id, $date_created, '28', $db, $row[1], $indicator_name, "Male", 13); //indicator_id=28
               $message_upload .= insert_to_db_indicator28($row[0], $row[2], $row[13],  $user->id, $date_created, '28', $db, $row[1], $indicator_name, "Male", 14); //indicator_id=28
               $message_upload .= insert_to_db_indicator28($row[0], $row[2], $row[14],  $user->id, $date_created, '28', $db, $row[1], $indicator_name, "Female", 4); //indicator_id=28
               $message_upload .= insert_to_db_indicator28($row[0], $row[2], $row[15],  $user->id, $date_created, '28', $db, $row[1], $indicator_name, "Female", 5); //indicator_id=28
               $message_upload .= insert_to_db_indicator28($row[0], $row[2], $row[16],  $user->id, $date_created, '28', $db, $row[1], $indicator_name, "Female", 6); //indicator_id=28
               $message_upload .= insert_to_db_indicator28($row[0], $row[2], $row[17],  $user->id, $date_created, '28', $db, $row[1], $indicator_name, "Female", 7); //indicator_id=28
               $message_upload .= insert_to_db_indicator28($row[0], $row[2], $row[18],  $user->id, $date_created, '28', $db, $row[1], $indicator_name, "Female", 8); //indicator_id=28
               $message_upload .= insert_to_db_indicator28($row[0], $row[2], $row[19],  $user->id, $date_created, '28', $db, $row[1], $indicator_name, "Female", 9); //indicator_id=28
               $message_upload .= insert_to_db_indicator28($row[0], $row[2], $row[20],  $user->id, $date_created, '28', $db, $row[1], $indicator_name, "Female", 10); //indicator_id=28
               $message_upload .= insert_to_db_indicator28($row[0], $row[2], $row[21],  $user->id, $date_created, '28', $db, $row[1], $indicator_name, "Female", 11); //indicator_id=28
               
              // $county_id, $date, $aggregate, $user_id, $date_created, $indicator_id, $db, $county_name, $indicator
               $message_upload .= insert_to_db_indicator7_8_9_10($row[0], $row[22], $row[23], $user->id, $date_created, '7', $db, $row[1], 'Number of prosecuted SGBV cases');  //indicator_id=7         
               $message_upload .= insert_to_db_indicator7_8_9_10($row[0], $row[24], $row[25], $user->id, $date_created, '8', $db, $row[1], 'Number of prosecuted SGBV cases withdrawn'); //indicator_id=8
               $message_upload .= insert_to_db_indicator7_8_9_10($row[0], $row[26], $row[27], $user->id, $date_created, '9', $db, $row[1], 'Number of prosecuted SGBV cases that resulted in a conviction'); //indicator_id=9
               $message_upload .= insert_to_db_indicator7_8_9_10($row[0], $row[28], $row[29], $user->id, $date_created, '10', $db, $row[1], 'Average time to conclude a SGBV case'); //indicator_id=10
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
        print_message("'" . $_FILES["fileToUpload"]["name"] . "' was not uploaded into database. ERROR: Wrong file format. Template is not defined. Please correct CSV file.\n\n");
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
        return "ERROR: Wrong file format. Header (column " . $column . ", row " . $row . ") must be '" . $value . "'.\n";
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
function validate_data_indicator28($county_id, $date, $aggregate1, $aggregate2, $aggregate3, $aggregate4, $aggregate5, $aggregate6, $aggregate7, $aggregate8,
		$aggregate9, $aggregate10, $aggregate11, $aggregate12, $aggregate13, $aggregate14, $aggregate15, $aggregate16,
		$aggregate17, $aggregate18, $aggregate19, 
		$column_date, $columns_aggregate, $row){
    if($county_id === ""){
        return "ERROR: Wrong file format. County id is not defined (row " . $row . ").\n"; //wrong format
    }
    if($date !== ""){
        //validate date format
        if(!validateDate($date)){
            return "ERROR: Date format is wrong  (column " . $column_date . ", row " . $row . "). Must be MM/YYYY.\n"; //date format is wrong
        }
        if($aggregate1 === "" && $aggregate2 === "" && $aggregate3 === "" && $aggregate4 === "" &&
$aggregate5 === "" && $aggregate6 === "" && $aggregate7 === "" && $aggregate8 === "" &&
$aggregate9 === "" && $aggregate10 === "" && $aggregate11 === "" && $aggregate12 === "" &&
$aggregate13 === "" && $aggregate14 === "" && $aggregate15 === "" && $aggregate16 === "" &&
$aggregate17 === "" && $aggregate18 === "" && $aggregate19 === ""){
            return "ERROR: All aggregates are empty (columns " . $columns_aggregate . ", row " . $row . "). Please insert values.\n"; //empty aggregate
        }
    }else if($aggregate1 !== "" || $aggregate2 !== "" || $aggregate3 !== "" || $aggregate4 !== "" ||
$aggregate5 !== "" || $aggregate6 !== "" || $aggregate7 !== "" || $aggregate8 !== "" ||
$aggregate9 !== "" || $aggregate10 !== "" || $aggregate11 !== "" || $aggregate12 !== "" ||
$aggregate13 !== "" || $aggregate14 !== "" || $aggregate15 !== "" || $aggregate16 !== "" ||
$aggregate17 !== "" || $aggregate18 !== "" || $aggregate19 !== "" ){
        return "ERROR: Date is empty (column " . $column_date . ", row " . $row . ").\n"; //empty date;
    }
    return "";
}

/*
 * returns empty message if success or error message
 */
function validate_data_indicators_7_8_9_10($county_id, $date, $aggregate, $column_date, $column_aggregate, $row){
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

//TODO after get reply from Kenya team, cadres are different from database and template
function insert_to_db_indicator28($county_id, $date, $aggregate, $user_id, $date_created, $indicator_id, $db, $county_name, $indicator, $sex, $cadre_id){
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
        $data['cadre'] = $cadre_id;
        if($db->insertData($data, "judiciary_aggregates")){
            return "County: " . $county_name . "; Indicator: '" .  $indicator . "'; Aggregates:" . $aggregate . ".\n";
        }else{
            return "ERROR date not inserted => County:" . $county_name . "; Indicator: '"  .  $indicator . "' Aggregates:" . $aggregate . ".\n";
        }
    }
}

function insert_to_db_indicator7_8_9_10($county_id, $date, $aggregate, $user_id, $date_created, $indicator_id, $db, $county_name, $indicator){
    if($date !== "" && $aggregate != ""  && $aggregate !== '0'){
         
        $data['timestamp_created'] = "'" . $date_created . "'";
        $data['county_id'] = $county_id;
        $data['indicator_id'] = $indicator_id;
        $data['aggregate'] = $aggregate;
        $data['created_by'] = $user_id;
        $date_arr = explode("/", $date);
        $date_new = $date_arr[1] ."-" .  $date_arr[0] . "-01"; //YYYY-MM-DD in database
        $data['date'] = "'" . $date_new . "'";
        if($db->insertData($data, "judiciary_aggregates")){
            return "County: " . $county_name . "; Indicator: '" .  $indicator . "'; Aggregates:" . $aggregate . ".\n";
        }else{
            return "ERROR date not inserted => County:" . $county_name . "; Indicator: '"  .  $indicator . "' Aggregates:" . $aggregate . ".\n";
        }
    }
}

/*
 * returns empty message if success or error message
 */
function validate($county_id, $date, $aggregate){
    if($county_id === ""){
        return "Wrong file format.\n"; //wrong format
    }
    if($date !== ""){
        if($aggregate === ""){
           return "Aggregate is empty.\n"; //empty aggregate
        }
    }else if($aggregate !== ""){
        return "Date is empty.\n";
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
	       return "County: " . $county_name . "; Indicator: '" .  $indicator . "'; Aggregates:" . $aggregate . "\n";
	   }else{
	        return "ERROR date not inserted => County:" . $county_name . "; Indicator: '"  .  $indicator . "' Aggregates:" . $aggregate . "\n";
	   }  
    }   
       
}
?>