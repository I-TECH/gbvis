<?php
//TA:60:4
$page_title = "Enter Data | Police Sector | GBV";
$current_page = "home";

require_once 'includes/global.inc.php';

if (isset ( $_SESSION ['logged_in'] )) {
	
	$user = unserialize ( $_SESSION ['user'] );
	
if( !($userTools->isAdmin($user->user_group) &&  $user->sector === '3')){
        print " You do not have permission to access this page.";
        return;
    }
	
	$mode = $_GET['mode'];
	$county_id = $_GET['county_id'];
	$indicator22 = $_GET['indicator22'];
	$indicator23 = $_GET['indicator23'];
	$indicator24 = $_GET['indicator24'];
	$indicator25 = $_GET['indicator25'];
	$indicator26 = $_GET['indicator26'];
	$indicator27 = $_GET['indicator27'];
	
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
	   
	   if($indicator22 && $indicator22 !== ''){
	       $data['indicator_id'] = 22;
	       $data['aggregate'] = $indicator22;
	       $message .= "\nIndicator 5.1.a Number of police stations surveyed:\n";
	       if($db->insertData($data, "police_aggregates")){
	           $message .= $data['aggregate'] . " aggregate(s) is inserted.\n";
	       }else{
	           $message .= $data['aggregate'] . " aggregate(s) is NOT inserted.\n";
	       }
	   }
	   if($indicator23 && $indicator23 !== ''){
	   	$data['indicator_id'] = 23;
	   	$data['aggregate'] = $indicator23;
	   	$message .= "\nIndicator 5.1.b Number of police stations that have a functional gender desk:\n";
	   	if($db->insertData($data, "police_aggregates")){
	   		$message .= $data['aggregate'] . " aggregate(s) is inserted.\n";
	   	}else{
	   		$message .= $data['aggregate'] . " aggregate(s) is NOT inserted.\n";
	   	}
	   }
	   if($indicator27 && $indicator27 !== ''){
	   	$data['indicator_id'] = 27;
	   	$ranks = explode(";" , $indicator27);
	   	$message .= "\nIndicator 5.2 Number of police who have been trained to respond and investigate cases of SGBV:\n";
	   	for($i=0;$i<count($ranks);$i++){
	   		$rank = explode("," , $ranks[$i]);
	   		$data['sex'] = "'" . $rank[0] . "'";
	   		$data['rank'] = $rank[1];
	   		$data['aggregate'] = $rank[2];
	   		if($db->insertData($data, "police_aggregates")){
	   			$message .= $data['aggregate'] . " aggregate(s) is inserted.\n";
	   		}else{
	   			$message .= $data['aggregate'] . " aggregate(s) is NOT inserted.\n";
	   		}
	   	}
	   }
	   if($indicator24 && $indicator24 !== ''){
	       $data['indicator_id'] = 24;
	       $data['aggregate'] = $indicator24;
	       $message .= "\nIndicator 5.3 Number of SGBV cases reported to National Police Service (NPS):\n";
	       if($db->insertData($data, "police_aggregates")){
	           $message .= $data['aggregate'] . " aggregate(s) is inserted.\n";
	       }else{
	           $message .= $data['aggregate'] . " aggregate(s) is NOT inserted.\n";
	       }
	   }
	   if($indicator25 && $indicator25 !== ''){
	       $data['indicator_id'] = 25;
	       $data['aggregate'] = $indicator25;
	       $message .= "\nIndicator 5.4 Number of SGBV cases investigated by the National Police Service:\n";
	       if($db->insertData($data, "police_aggregates")){
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
	    if($row1[0] === 'Police Sector Template Indicator 5.1 5.3 5.4'){
	        //validate headers
	        $row2 = explode("," , $rows[1]);
	        $error_upload .= validate_header($row2[0], "County Code", "A", "2");
	        $error_upload .= validate_header($row2[1], "County Name", "B", "2");
	        $error_upload .= validate_header($row2[2], "Total number of police stations surveyed", "C", "2"); //indicator_id=22
	        $error_upload .= validate_header($row2[4], "Number of police stations that have a functional gender desk", "E", "2"); //indicator_id=23
	        $error_upload .= validate_header($row2[6], "Number of cases reported to National Police Service (NPS)", "G", "2"); //indicator_id=24
	        $error_upload .= validate_header($row2[8], "Number of SGBV cases investigated by the National Police Service", "I", "2"); //indicator_id=25
	        $row3 = explode("," , $rows[2]);
	        $error_upload .= validate_header($row3[2], "Date (MM/YYYY)", "C", "3");
	        $error_upload .= validate_header($row3[3], "Aggregate", "D", "3");       
	        $error_upload .= validate_header($row3[4], "Date (MM/YYYY)", "E", "3");
	        $error_upload .= validate_header($row3[5], "Aggregate", "F", "3");
	        $error_upload .= validate_header($row3[6], "Date (MM/YYYY)", "G", "3");
	        $error_upload .= validate_header($row3[7], "Aggregate", "H", "3");
	        $error_upload .= validate_header($row3[8], "Date (MM/YYYY)", "I", "3");
	        $error_upload .= validate_header($row3[9], "Aggregate", "J", "3");
	        
	        //validate data rows
	        for($i=3; $i<count($rows)-1; $i++){
	            $row_data = explode("," , $rows[$i]);
	            $error_upload .= validate_data_indicator22_23_24_25($row_data[0], $row_data[2], $row_data[3], "C", "D", $i+1); //indicator_id=22  
	            $error_upload .= validate_data_indicator22_23_24_25($row_data[0], $row_data[4], $row_data[5], "E", "F", $i+1); //indicator_id=23
	            $error_upload .= validate_data_indicator22_23_24_25($row_data[0], $row_data[6], $row_data[7], "G", "H", $i+1); //indicator_id=24
	            $error_upload .= validate_data_indicator22_23_24_25($row_data[0], $row_data[8], $row_data[9], "I", "J", $i+1); //indicator_id=25
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
	            $message_upload .= insert_indicators22_23_24_25($row[0], $row[2], $row[3], $user->id, $date_created, '22', $db, $row[1], 'Total number of police stations surveyed');//indicator_id=22
	            $message_upload .= insert_indicators22_23_24_25($row[0], $row[4], $row[5], $user->id, $date_created, '23', $db, $row[1], 'Number of police stations that have a functional gender desk');//indicator_id=23
	            $message_upload .= insert_indicators22_23_24_25($row[0], $row[6], $row[7], $user->id, $date_created, '24', $db, $row[1], 'Number of cases reported to National Police Service (NPS)');//indicator_id=24
	            $message_upload .= insert_indicators22_23_24_25($row[0], $row[8], $row[9], $user->id, $date_created, '25', $db, $row[1], 'Number of SGBV cases investigated by the National Police Service');//indicator_id=25
	        }
	    }else if($row1[0] === 'Police Sector Template Indicator 5.2'){
	        
	        //validate headers
	        $row2 = explode("," , $rows[1]);
	        $error_upload .= validate_header($row2[0], "County Code", "A", "2");
	        $error_upload .= validate_header($row2[1], "County Name", "B", "2");
	        $error_upload .= validate_header($row2[2], "Number of police who have been trained to respond and investigate cases of SGBV", "C", "2"); //indicator_id=27
	        $row3 = explode("," , $rows[2]);
	        $error_upload .= validate_header($row3[2], "Date (MM/YYYY)", "C", "3");
	        $error_upload .= validate_header($row3[3], "Inspector-General", "D", "3"); //rank id=1
	        $error_upload .= validate_header($row3[5], "Deputy Inspector-General", "F", "3");//rank id=2
	        $error_upload .= validate_header($row3[7], "Senior Assistant Inspector General", "H", "3");//rank id=3
	        $error_upload .= validate_header($row3[9], "Assistant Inspector-General", "J", "3");//rank id=4
	        $error_upload .= validate_header($row3[11], "Commissioner", "L", "3");//rank id=14
	        $error_upload .= validate_header($row3[13], "Senior Superintendent", "N", "3");//rank id=5
	        $error_upload .= validate_header($row3[15], "Superintendent", "P", "3");//rank id=6
	        $error_upload .= validate_header($row3[17], "Assistant Superintendent", "R", "3");//rank id=7
	        $error_upload .= validate_header($row3[19], "Chief Inspector", "T", "3");//rank id=8
	        $error_upload .= validate_header($row3[21], "Inspector", "V", "3");//rank id=9
	        $error_upload .= validate_header($row3[23], "Senior Sergeant", "X", "3");//rank id=10
	        $error_upload .= validate_header($row3[25], "Sergeant", "Z", "3");//rank id=11
	        $error_upload .= validate_header($row3[27], "Corporal", "AB", "3");//rank id=23
	        $error_upload .= validate_header($row3[29], "Constable", "AD", "3");//rank id=12
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
	        $error_upload .= validate_header($row4[19], "Male", "T", "4");
	        $error_upload .= validate_header($row4[20], "Female", "U", "4");
	        $error_upload .= validate_header($row4[21], "Male", "V", "4");
	        $error_upload .= validate_header($row4[22], "Female", "W", "4");
	        $error_upload .= validate_header($row4[23], "Male", "X", "4");
	        $error_upload .= validate_header($row4[24], "Female", "Y", "4");
	        $error_upload .= validate_header($row4[25], "Male", "Z", "4");
	        $error_upload .= validate_header($row4[26], "Female", "AA", "4");
	        $error_upload .= validate_header($row4[27], "Male", "AB", "4");
	        $error_upload .= validate_header($row4[28], "Female", "AC", "4");
	        $error_upload .= validate_header($row4[29], "Male", "AD", "4");
	        $error_upload .= validate_header($row4[30], "Female", "AE", "4");
	        
	        //validate data rows
	        for($i=4; $i<count($rows)-1; $i++){
	            $row_data = explode("," , $rows[$i]);
	            $error_upload .= validate_data_indicator27($row_data[0], $row_data[2], 
	                $row_data[3], $row_data[4], $row_data[5], $row_data[6], $row_data[7], $row_data[8], $row_data[9], $row_data[10], $row_data[11], $row_data[12], $row_data[13], $row_data[14],
	            $row_data[15], $row_data[16], $row_data[17], $row_data[18], $row_data[19], $row_data[20], $row_data[21], $row_data[22], $row_data[23], $row_data[24], $row_data[25], $row_data[26], $row_data[27],
	                $row_data[28],$row_data[29],$row_data[30],
	                "C", "D-AE", $i+1); //indicator_id=27
	        }
	        
	        if($error_upload !== ""){
	            print_message("'" . $_FILES["fileToUpload"]["name"] . "' was not uploaded into database. Please correct CSV file.\n\n" . $error_upload);
	            return;
	        }
	        
	        //insert data
	        $date_created = date("Y-m-d H:i:s");
	        for($i=4; $i<count($rows)-1; $i++){
	            $row = explode("," , $rows[$i]);
	            $indicator_name = "Number of police who have been trained to respond and investigate cases of SGBV";
	            $indicator_id='27';
	            // $county_id, $date, $aggregate, $user_id, $date_created, $indicator_id, $db, $county_name, $indicator, $sex, $rank
	            $message_upload .= insert_indicator27($row[0], $row[2], $row[3], $user->id, $date_created, $indicator_id, $db, $row[1], $indicator_name, "Male", "1");
	            $message_upload .= insert_indicator27($row[0], $row[2], $row[4], $user->id, $date_created, $indicator_id, $db, $row[1], $indicator_name, "Female", "1");
	            $message_upload .= insert_indicator27($row[0], $row[2], $row[5], $user->id, $date_created, $indicator_id, $db, $row[1], $indicator_name, "Male", "2");
	            $message_upload .= insert_indicator27($row[0], $row[2], $row[6], $user->id, $date_created, $indicator_id, $db, $row[1], $indicator_name, "Female", "2");
	            $message_upload .= insert_indicator27($row[0], $row[2], $row[7], $user->id, $date_created, $indicator_id, $db, $row[1], $indicator_name, "Male", "3");
	            $message_upload .= insert_indicator27($row[0], $row[2], $row[8], $user->id, $date_created, $indicator_id, $db, $row[1], $indicator_name, "Female", "3");
	            $message_upload .= insert_indicator27($row[0], $row[2], $row[9], $user->id, $date_created, $indicator_id, $db, $row[1], $indicator_name, "Male", "4");
	            $message_upload .= insert_indicator27($row[0], $row[2], $row[10], $user->id, $date_created, $indicator_id, $db, $row[1], $indicator_name, "Female", "4");
	            $message_upload .= insert_indicator27($row[0], $row[2], $row[11], $user->id, $date_created, $indicator_id, $db, $row[1], $indicator_name, "Male", "14");
	            $message_upload .= insert_indicator27($row[0], $row[2], $row[12], $user->id, $date_created, $indicator_id, $db, $row[1], $indicator_name, "Female", "14");
	            $message_upload .= insert_indicator27($row[0], $row[2], $row[13], $user->id, $date_created, $indicator_id, $db, $row[1], $indicator_name, "Male", "5");
	            $message_upload .= insert_indicator27($row[0], $row[2], $row[14], $user->id, $date_created, $indicator_id, $db, $row[1], $indicator_name, "Female", "5");
	            $message_upload .= insert_indicator27($row[0], $row[2], $row[15], $user->id, $date_created, $indicator_id, $db, $row[1], $indicator_name, "Male", "6");
	            $message_upload .= insert_indicator27($row[0], $row[2], $row[16], $user->id, $date_created, $indicator_id, $db, $row[1], $indicator_name, "Female", "6");
	            $message_upload .= insert_indicator27($row[0], $row[2], $row[17], $user->id, $date_created, $indicator_id, $db, $row[1], $indicator_name, "Male", "7");
	            $message_upload .= insert_indicator27($row[0], $row[2], $row[18], $user->id, $date_created, $indicator_id, $db, $row[1], $indicator_name, "Female", "7");
	            $message_upload .= insert_indicator27($row[0], $row[2], $row[19], $user->id, $date_created, $indicator_id, $db, $row[1], $indicator_name, "Male", "8");
	            $message_upload .= insert_indicator27($row[0], $row[2], $row[20], $user->id, $date_created, $indicator_id, $db, $row[1], $indicator_name, "Female", "8");
	            $message_upload .= insert_indicator27($row[0], $row[2], $row[21], $user->id, $date_created, $indicator_id, $db, $row[1], $indicator_name, "Male", "9");
	            $message_upload .= insert_indicator27($row[0], $row[2], $row[22], $user->id, $date_created, $indicator_id, $db, $row[1], $indicator_name, "Female", "9");
	            $message_upload .= insert_indicator27($row[0], $row[2], $row[23], $user->id, $date_created, $indicator_id, $db, $row[1], $indicator_name, "Male", "10");
	            $message_upload .= insert_indicator27($row[0], $row[2], $row[24], $user->id, $date_created, $indicator_id, $db, $row[1], $indicator_name, "Female", "10");
	            $message_upload .= insert_indicator27($row[0], $row[2], $row[25], $user->id, $date_created, $indicator_id, $db, $row[1], $indicator_name, "Male", "11");
	            $message_upload .= insert_indicator27($row[0], $row[2], $row[26], $user->id, $date_created, $indicator_id, $db, $row[1], $indicator_name, "Female", "11");
	            $message_upload .= insert_indicator27($row[0], $row[2], $row[27], $user->id, $date_created, $indicator_id, $db, $row[1], $indicator_name, "Male", "23");
	            $message_upload .= insert_indicator27($row[0], $row[2], $row[28], $user->id, $date_created, $indicator_id, $db, $row[1], $indicator_name, "Female", "23");
	            $message_upload .= insert_indicator27($row[0], $row[2], $row[29], $user->id, $date_created, $indicator_id, $db, $row[1], $indicator_name, "Male", "12");
	            $message_upload .= insert_indicator27($row[0], $row[2], $row[30], $user->id, $date_created, $indicator_id, $db, $row[1], $indicator_name, "Female", "12");
	           
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
function validate_data_indicator22_23_24_25($county_id, $date, $aggregate, $column_date, $column_aggregate, $row){
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

/*
 * returns empty message if success or error message
 */
function validate_data_indicator27($county_id, $date, $aggregate1, $aggregate2, $aggregate3, $aggregate4, $aggregate5, $aggregate6, $aggregate7, $aggregate8, $aggregate9, $aggregate10, $aggregate11, $aggregate12,
    $aggregate13, $aggregate14, $aggregate15, $aggregate16, $aggregate17, $aggregate18, $aggregate19, $aggregate20, $aggregate21, $aggregate22, $aggregate23, $aggregate24, $aggregate25, $aggregate26, 
    $aggregate27, $aggregate28, $column_date, $columns_aggregate, $row){
    if($county_id === ""){
        return "ERROR: Wrong file format. County id is not defined (row " . $row . ").\n"; //wrong format
    }
    if($date !== ""){
        //validate date format
        if(!validateDate($date)){
            return "ERROR: Date format is wrong  (column " . $column_date . ", row " . $row . "). Must be MM/YYYY.\n"; //date format is wrong
        }
        if($aggregate1 === "" && $aggregate2 === "" && $aggregate3 === "" && $aggregate4 === "" && $aggregate5 === "" && $aggregate6 === "" && $aggregate7 === "" && $aggregate8 === "" && $aggregate9 === "" &&
            $aggregate10 === "" && $aggregate11 === "" && $aggregate12 === "" && $aggregate13 === "" && $aggregate14 === "" && $aggregate15 === "" && $aggregate16 === "" && $aggregate17 === "" && $aggregate18 === "" &&
            $aggregate19 === "" && $aggregate20 === "" && $aggregate21 === "" && $aggregate22 === "" && $aggregate23 === "" && $aggregate24 === "" && $aggregate25 === "" && 
            $aggregate26 === "" && $aggregate27 === "" && $aggregate28 === ""){
            return "ERROR: All aggregates are empty (columns " . $columns_aggregate . ", row " . $row . "). Please insert values.\n"; //empty aggregate
        }
    }else if($aggregate1 !== "" || $aggregate2 !== "" || $aggregate3 !== "" || $aggregate4 !== "" || $aggregate5 !== "" || $aggregate6 !== "" || $aggregate7 !== "" || $aggregate8 !== "" || $aggregate9 !== "" ||
        $aggregate10 !== "" || $aggregate11 !== "" || $aggregate12 !== "" || $aggregate13 !== "" || $aggregate14 !== "" || $aggregate15 !== "" || $aggregate16 !== "" || $aggregate17 !== "" || $aggregate18 !== "" ||
        $aggregate19 !== "" || $aggregate20 !== "" || $aggregate21 !== "" || $aggregate22 !== "" || $aggregate23 !== "" || $aggregate24 !== "" || $aggregate25 !== "" || $aggregate26 !== "" || $aggregate27 !== ""
        || $aggregate28 !== ""){
        return "ERROR: Date is empty (column " . $column_date . ", row " . $row . ").\n"; //empty date;
    }
    return "";
}

function insert_indicators22_23_24_25($county_id, $date, $aggregate, $user_id, $date_created, $indicator_id, $db, $county_name, $indicator){
    if($date !== "" && $aggregate != ""  && $aggregate !== '0'){
         
        $data['timestamp_created'] = "'" . $date_created . "'";
        $data['county_id'] = $county_id;
        $data['indicator_id'] = $indicator_id;
        $data['aggregate'] = $aggregate;
        $data['created_by'] = $user_id;
        $date_arr = explode("/", $date);
        $date_new = $date_arr[1] ."-" .  $date_arr[0] . "-01"; //YYYY-MM-DD in database
        $data['date'] = "'" . $date_new . "'";
        if($db->insertData($data, "police_aggregates")){
            return "County: " . $county_name . "; Indicator: '" .  $indicator . "'; Aggregates:" . $aggregate . ".\n";
        }else{
            return "ERROR date not inserted => County:" . $county_name . "; Indicator: '"  .  $indicator . "' Aggregates:" . $aggregate . ".\n";
        }
    }
}

function insert_indicator27($county_id, $date, $aggregate, $user_id, $date_created, $indicator_id, $db, $county_name, $indicator, $sex, $rank){
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
        if($db->insertData($data, "police_aggregates")){
            return "County: " . $county_name . "; Indicator: '" .  $indicator . "'; Aggregates:" . $aggregate . ".\n";
        }else{
            return "ERROR date not inserted => County:" . $county_name . "; Indicator: '"  .  $indicator . "' Aggregates:" . $aggregate . ".\n";
        }
    }
}
?>