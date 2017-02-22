<?php
//TA:60:4
$page_title = "Enter Data | GBV";
$current_page = "home";

require_once 'includes/global.inc.php';

require_once '../utils.php';

if (isset ( $_SESSION ['logged_in'] )) {
	
	$user = unserialize ( $_SESSION ['user'] );
	
if( !($userTools->isAdmin($user->user_group) &&  $user->sector === '2')){
        print " You do not have permission to access this page.";
        return;
    }
	
	$mode = $_GET['mode'];
	$county_id = $_GET['county_id'];
	$indicator1 = $_GET['indicator1'];
	$indicator2 = $_GET['indicator2'];
	$indicator3 = $_GET['indicator3'];
	$indicator4 = $_GET['indicator4'];
	$indicator5 = $_GET['indicator5'];
	$indicator6 = $_GET['indicator6'];
	$indicator11 = $_GET['indicator11'];
	$indicator37 = $_GET['indicator37'];
	$indicator38 = $_GET['indicator38'];
	$indicator39 = $_GET['indicator39'];
	
	
	$indicator_id = $_GET['indicator_id'];
	$date = $_GET['date'];
	$date_arr = explode("/", $date);
	 //$date_new = $date_arr[2] ."-" .  $date_arr[0] . "-" . $date_arr[1]; //YYYY-MM-DD in database
	   $date_new = $date_arr[1] ."-" .  $date_arr[0] . "-01"; //YYYY-MM-DD in database
	
	$county = $db->selectAllOrderedWhere("counties", "county_name", " county_id=" . $county_id)[0][1];
	$indicator = $db->selectAllOrderedWhere("indicators", "indicator", " indicator_id=" . $indicator_id)[0][3];
	
	$db = new DB();
	
	
	if($mode === 'add_aggregates'){
	
	    $message = "";
	    
	   
	   if($indicator37 && $indicator37 !== ''){
	       $data = array();
	       $data['county_id'] = $county_id;
	       $data['date'] = "'" . $date_new . "'";
	       $data['created_by'] = $user->id;
	       $data['timestamp_created'] = "'" . date("Y-m-d H:i:s") . "'";
	       $data['indicator_id'] = 37;
	       $message .= "\nIndicator 4.1.a Total number of health facilities surveyed:\n";
	       $data['aggregate'] = $indicator37;
	       if($db->insertData($data, "health_aggregates")){
	           $message .= $data['aggregate'] . " aggregate(s) is inserted.\n";
	       }else{
	           $message .= $data['aggregate'] . " aggregate(s) is NOT inserted.\n";
	       }
	   }  
	   if($indicator1 && $indicator1 !== ''){
	       $data = array();
	       $data['county_id'] = $county_id;
	       $data['date'] = "'" . $date_new . "'";
	       $data['created_by'] = $user->id;
	       $data['timestamp_created'] = "'" . date("Y-m-d H:i:s") . "'";
	       $data['indicator_id'] = 1;
	       $ownerships = explode(";" , $indicator1);
	       $message .= "\nIndicator 4.1.b Number of health facilities providing comprehensive clinical management services for survivors of sexual violence:\n";
	       for($i=0;$i<count($ownerships);$i++){
	           $ownership = explode("," , $ownerships[$i]);
	           $data['ownership_id'] = $ownership[0];
	           $data['aggregate'] = $ownership[1];
	           if($db->insertData($data, "health_aggregates")){
	               $message .= $data['aggregate'] . " aggregate(s) is inserted.\n";
	           }else{
	               $message .= $data['aggregate'] . " aggregate(s) is NOT inserted.\n";
	           }
	       }
	   }
	   if($indicator2 && $indicator2 !== ''){
	       $data = array();
	       $data['county_id'] = $county_id;
	       $data['date'] = "'" . $date_new . "'";
	       $data['created_by'] = $user->id;
	       $data['timestamp_created'] = "'" . date("Y-m-d H:i:s") . "'";
	       $data['indicator_id'] = 2;
	       $cadres = explode(";" , $indicator2);
	       $message .= "\nIndicator 4.2 Number of service providers trained on management of SGBV survivors:\n";
	       for($i=0;$i<count($cadres);$i++){
	           $cadre = explode("," , $cadres[$i]);
	          $data['gender'] = "'" . $cadre[0] . "'";
	           $data['cadre_id'] = $cadre[1];
	           $data['aggregate'] = $cadre[2];
	          
	           if($db->insertData($data, "health_aggregates")){
	               $message .= $data['aggregate'] . " aggregate(s) is inserted.\n";
	           }else{
	               $message .= $data['aggregate'] . " aggregate(s) is NOT inserted.\n";
	           }
	       }    
	   }
	   
	  if($indicator3 && $indicator3 !== ''){
	     $message .= insert_gender_indicators($indicator3, 3, $db, $date_new, $user->id, '4.3.a Number of rape survivors', $county_id);
	   }
	   if($indicator38 && $indicator38 !== ''){
	       $message .= insert_gender_indicators($indicator38, 38, $db, $date_new, $user->id, '4.3.b Number presenting within 72 hours', $county_id);
	   }
	   if($indicator4 && $indicator4 !== ''){
	       $message .= insert_gender_indicators($indicator4, 4, $db, $date_new, $user->id, '4.4 Number initiated PEP', $county_id);
	   }
	   if($indicator11 && $indicator11 !== ''){
	       $message .= insert_gender_indicators($indicator11, 11, $db, $date_new, $user->id, '4.5 Number completed PEP', $county_id);
	   }
	   if($indicator5 && $indicator5 !== ''){
	       $message .= insert_gender_indicators($indicator5, 5, $db, $date_new, $user->id, '4.6.a Number given STI treatment', $county_id);
	   }
	   if($indicator6 && $indicator6 !== ''){
	       $message .= insert_gender_indicators($indicator6, 6, $db, $date_new, $user->id, '4.6.b Number given Emergency Contraceptive Pill', $county_id);
	   }
	   if($indicator39 && $indicator39 !== ''){
	       $message .= insert_gender_indicators($indicator39, 39, $db, $date_new, $user->id, '4.3.c Number completed trauma counseling', $county_id);
	   }
	   
	   if($message){
	       //print "\nCounty: " . $county . "\nDate: " . $date . "\n\n" . $message;
	       print "Data uploaded successfully"; //do not print out diagnostics
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
	    if($row1[0] === 'Health Sector Template Indicator 4.1'){
	        //validate headers
	        $row2 = explode("," , $rows[1]);
	        $error_upload .= validate_header($row2[0], "County Code", "A", "2");
	        $error_upload .= validate_header($row2[1], "County Name", "B", "2");
	        $error_upload .= validate_header($row2[2], "Total number of health facilities", "C", "2"); //indicator_id=37
	        $error_upload .= validate_header($row2[4], "Number of health facilities providing comprehensive clinical management services for survivors of sexual violence", "E", "2"); //indicator_id=1
	        $row3 = explode("," , $rows[2]);
	        $error_upload .= validate_header($row3[2], "Date (MM/YYYY)", "C", "3");
	        $error_upload .= validate_header($row3[3], "Aggregate", "D", "3");
	        $error_upload .= validate_header($row3[4], "Date (MM/YYYY)", "E", "3");
	        $error_upload .= validate_header($row3[5], "Academic", "F", "3");
	        $error_upload .= validate_header($row3[6], "Armed forces", "G", "3");
	        $error_upload .= validate_header($row3[7], "Christian Health Association of Kenya", "H", "3");
	        $error_upload .= validate_header($row3[8], "Community", "I", "3");
	        $error_upload .= validate_header($row3[9], "Community Development Fund", "J", "3");
	        $error_upload .= validate_header($row3[10], "Company Medical Services", "K", "3");
	        $error_upload .= validate_header($row3[11], "Humanitarian agencies", "L", "3");
	        $error_upload .= validate_header($row3[12], "Kenya Episcopal Conference-Catholic Secretariat", "M", "3");
	        $error_upload .= validate_header($row3[13], "Local Authority", "N", "3");
	        $error_upload .= validate_header($row3[14], "Local authority T fund", "O", "3");
	        $error_upload .= validate_header($row3[15], "Ministry of Health", "P", "3");
	        $error_upload .= validate_header($row3[16], "Non-Governmental Organizations", "Q", "3");
	        $error_upload .= validate_header($row3[17], "Other Faith Based", "R", "3");
	        $error_upload .= validate_header($row3[18], "Other Public Institutions", "S", "3");
	        $error_upload .= validate_header($row3[19], "Parastatal", "T", "3");
	        $error_upload .= validate_header($row3[20], "Private Enterprise (Institution)", "U", "3");
	        $error_upload .= validate_header($row3[21], "Private Practice-Clinical Officer", "V", "3");
	        $error_upload .= validate_header($row3[22], "Private Practice-General Practitioner", "W", "3");
	        $error_upload .= validate_header($row3[23], "Private Practice-Medical Specialist", "X", "3");
	        $error_upload .= validate_header($row3[24], "Private Practice-Nurse/Midwife", "Y", "3");
	        $error_upload .= validate_header($row3[25], "Private Practice-Unspecified", "Z", "3");
	        $error_upload .= validate_header($row3[26], "State Corporation", "AA", "3");
	        $error_upload .= validate_header($row3[27], "Supreme Council for Kenya Muslims", "AB", "3");
	        
	        //validate data rows
	        for($i=3; $i<count($rows)-1; $i++){
	            $row_data = explode("," , $rows[$i]);
	            $error_upload .= validate_data_indicator37($row_data[0], $row_data[2], $row_data[3], "C", "D", $i+1); //indicator_id=37
	            $error_upload .= validate_data_indicator1($row_data[0], $row_data[4], $row_data[5], $row_data[6], $row_data[7], $row_data[8], $row_data[9], $row_data[10], $row_data[11], $row_data[12], $row_data[13], 
	                $row_data[14], $row_data[15], $row_data[16],
	            $row_data[17], $row_data[18], $row_data[19], $row_data[20], $row_data[21], $row_data[22], $row_data[23], $row_data[24], $row_data[25], $row_data[26], $row_data[27], "E", "F-AB", $i+1); //indicator_id=1
	        }
	        
	        if($error_upload !== ""){
	            print_message("'" . $_FILES["fileToUpload"]["name"] . "' was not uploaded into database. Please correct CSV file.\n\n" . $error_upload);
	            return;
	        }
	        
	        //insert data
	        $date_created = date("Y-m-d H:i:s");
	        for($i=3; $i<count($rows)-1; $i++){
	            $row = explode("," , $rows[$i]);
	            $message_upload .= insert_to_db_indicator37($row[0], $row[2], $row[3], $user->id, $date_created, '37', $db, $row[1], 'Total number of health facilities');
	            $indicator_name = "Number of health facilities providing comprehensive clinical management services for survivors of sexual violence";
	            $message_upload .= insert_to_db_indicator1($row[0], $row[4], $row[5], $user->id, $date_created, '1', $db, $row[1], $indicator_name, "1", "Academic");
	            $message_upload .= insert_to_db_indicator1($row[0], $row[4], $row[6], $user->id, $date_created, '1', $db, $row[1], $indicator_name, "2", "Armed forces");
	            $message_upload .= insert_to_db_indicator1($row[0], $row[4], $row[7], $user->id, $date_created, '1', $db, $row[1], $indicator_name, "3", "Christian Health Association of Kenya");
	            $message_upload .= insert_to_db_indicator1($row[0], $row[4], $row[8], $user->id, $date_created, '1', $db, $row[1], $indicator_name, "4", "Community");
	            $message_upload .= insert_to_db_indicator1($row[0], $row[4], $row[9], $user->id, $date_created, '1', $db, $row[1], $indicator_name, "5", "Community Development Fund");
	            $message_upload .= insert_to_db_indicator1($row[0], $row[4], $row[10], $user->id, $date_created, '1', $db, $row[1], $indicator_name, "6", "Company Medical Services");
	            $message_upload .= insert_to_db_indicator1($row[0], $row[4], $row[11], $user->id, $date_created, '1', $db, $row[1], $indicator_name, "7", "Humanitarian agencies");
	            $message_upload .= insert_to_db_indicator1($row[0], $row[4], $row[12], $user->id, $date_created, '1', $db, $row[1], $indicator_name, "8", "Kenya Episcopal Conference-Catholic Secretariat");
	            $message_upload .= insert_to_db_indicator1($row[0], $row[4], $row[13], $user->id, $date_created, '1', $db, $row[1], $indicator_name, "9", "Local Authority");
	            $message_upload .= insert_to_db_indicator1($row[0], $row[4], $row[14], $user->id, $date_created, '1', $db, $row[1], $indicator_name, "10", "Local authority T fund");
	            $message_upload .= insert_to_db_indicator1($row[0], $row[4], $row[15], $user->id, $date_created, '1', $db, $row[1], $indicator_name, "11", "Ministry of Health");
	            $message_upload .= insert_to_db_indicator1($row[0], $row[4], $row[16], $user->id, $date_created, '1', $db, $row[1], $indicator_name, "12", "Non-Governmental Organizations");
	            $message_upload .= insert_to_db_indicator1($row[0], $row[4], $row[17], $user->id, $date_created, '1', $db, $row[1], $indicator_name, "13", "Other Faith Based");
	            $message_upload .= insert_to_db_indicator1($row[0], $row[4], $row[18], $user->id, $date_created, '1', $db, $row[1], $indicator_name, "14", "Other Public Institutions");
	            $message_upload .= insert_to_db_indicator1($row[0], $row[4], $row[19], $user->id, $date_created, '1', $db, $row[1], $indicator_name, "15", "Parastatal");
	            $message_upload .= insert_to_db_indicator1($row[0], $row[4], $row[20], $user->id, $date_created, '1', $db, $row[1], $indicator_name, "16", "Private Enterprise (Institution)");
	            $message_upload .= insert_to_db_indicator1($row[0], $row[4], $row[21], $user->id, $date_created, '1', $db, $row[1], $indicator_name, "17", "Private Practice-Clinical Officer");
	            $message_upload .= insert_to_db_indicator1($row[0], $row[4], $row[22], $user->id, $date_created, '1', $db, $row[1], $indicator_name, "18", "Private Practice-General Practitioner");
	            $message_upload .= insert_to_db_indicator1($row[0], $row[4], $row[23], $user->id, $date_created, '1', $db, $row[1], $indicator_name, "19", "Private Practice-Medical Specialist");
	            $message_upload .= insert_to_db_indicator1($row[0], $row[4], $row[24], $user->id, $date_created, '1', $db, $row[1], $indicator_name, "20", "Private Practice-Nurse/Midwife");
	            $message_upload .= insert_to_db_indicator1($row[0], $row[4], $row[25], $user->id, $date_created, '1', $db, $row[1], $indicator_name, "21", "Private Practice-Unspecified");
	            $message_upload .= insert_to_db_indicator1($row[0], $row[4], $row[26], $user->id, $date_created, '1', $db, $row[1], $indicator_name, "22", "State Corporation");
	            $message_upload .= insert_to_db_indicator1($row[0], $row[4], $row[27], $user->id, $date_created, '1', $db, $row[1], $indicator_name, "23", "Supreme Council for Kenya Muslims");
	        }
	         
	    }else if($row1[0] === 'Health Sector Template Indicator 4.2'){
	        //validate headers
	        $row2 = explode("," , $rows[1]);
	        $error_upload .= validate_header($row2[0], "County Code", "A", "2");
	        $error_upload .= validate_header($row2[1], "County Name", "B", "2");
	        $error_upload .= validate_header($row2[2], "Number of service providers trained on management of SGBV survivors", "C", "2"); //indicator_id=2
	        $row3 = explode("," , $rows[2]);
	        $error_upload .= validate_header($row3[2], "Date (MM/YYYY)", "C", "3");
	        $error_upload .= validate_header($row3[3], "Male", "D", "3");
	        $error_upload .= validate_header($row3[8], "Female", "I", "3");
	        $row4 = explode("," , $rows[3]);
	        $error_upload .= validate_header($row4[3], "Nursing officer", "D", "4");
	        $error_upload .= validate_header($row4[4], "Medical officer", "E", "4");
	        $error_upload .= validate_header($row4[5], "Clinical officer", "F", "4");
	        $error_upload .= validate_header($row4[6], "Counsellor", "G", "4");
	        $error_upload .= validate_header($row4[7], "Laboratory technologist", "H", "4");
	        $error_upload .= validate_header($row4[8], "Nursing officer", "I", "4");
	        $error_upload .= validate_header($row4[9], "Medical officer", "J", "4");
	        $error_upload .= validate_header($row4[10], "Clinical officer", "K", "4");
	        $error_upload .= validate_header($row4[11], "Counsellor", "L", "4");
	        $error_upload .= validate_header($row4[12], "Laboratory technologist", "M", "4");
	        
	        //validate data rows
	        for($i=4; $i<count($rows)-1; $i++){
	            $row_data = explode("," , $rows[$i]);
	            $error_upload .= validate_data_indicator2($row_data[0], $row_data[2], $row_data[3], $row_data[4], $row_data[5], $row_data[6], 
	                $row_data[7], $row_data[8], $row_data[9], $row_data[10], $row_data[11], $row_data[12],"C", "D-M", $i+1); //indicator_id=2
	        }
	        
	        if($error_upload !== ""){
	            print_message("'" . $_FILES["fileToUpload"]["name"] . "' was not uploaded into database. Please correct CSV file.\n\n" . $error_upload);
	            return;
	        }
	        
	        //insert data
	        $date_created = date("Y-m-d H:i:s");
	        for($i=4; $i<count($rows)-1; $i++){
	            $row = explode("," , $rows[$i]);
	            $indicator_name = "Number of service providers trained on management of SGBV survivors";
	            $message_upload .= insert_to_db_indicator2($row[0], $row[2], $row[3], $user->id, $date_created, '2', $db, $row[1], $indicator_name, "2", "Nursing officer", "Male");
	            $message_upload .= insert_to_db_indicator2($row[0], $row[2], $row[4], $user->id, $date_created, '2', $db, $row[1], $indicator_name, "1", "Medical officer", "Male");
	            $message_upload .= insert_to_db_indicator2($row[0], $row[2], $row[5], $user->id, $date_created, '2', $db, $row[1], $indicator_name, "3", "Clinical officer", "Male");
	            $message_upload .= insert_to_db_indicator2($row[0], $row[2], $row[6], $user->id, $date_created, '2', $db, $row[1], $indicator_name, "15", "Counsellor", "Male");
	            $message_upload .= insert_to_db_indicator2($row[0], $row[2], $row[7], $user->id, $date_created, '2', $db, $row[1], $indicator_name, "16", "Laboratory technologist", "Male");
	            $message_upload .= insert_to_db_indicator2($row[0], $row[2], $row[8], $user->id, $date_created, '2', $db, $row[1], $indicator_name, "2", "Nursing officer", "Female");
	            $message_upload .= insert_to_db_indicator2($row[0], $row[2], $row[9], $user->id, $date_created, '2', $db, $row[1], $indicator_name, "1", "Medical officer", "Female");
	            $message_upload .= insert_to_db_indicator2($row[0], $row[2], $row[10], $user->id, $date_created, '2', $db, $row[1], $indicator_name, "3", "Clinical officer", "Female");
	            $message_upload .= insert_to_db_indicator2($row[0], $row[2], $row[11], $user->id, $date_created, '2', $db, $row[1], $indicator_name, "15", "Counsellor", "Female");
	            $message_upload .= insert_to_db_indicator2($row[0], $row[2], $row[12], $user->id, $date_created, '2', $db, $row[1], $indicator_name, "16", "Laboratory technologist", "Female");
	             
	        }
	        
	    }else if($row1[0] === 'Helath Sector Template Indicators 4.3-4.6'){
	        
	        //validate headers
	        $row2 = explode("," , $rows[1]);
	        $error_upload .= validate_header($row2[0], "County Code", "A", "2");
	        $error_upload .= validate_header($row2[1], "County Name", "B", "2");
	        $error_upload .= validate_header($row2[2], "Number of rape survivors", "C", "2"); //indicator_id=3
	        $error_upload .= validate_header($row2[11], "Number initiated on PEP", "L", "2"); //indicator_id=4
	        $error_upload .= validate_header($row2[20], "Number completed PEP", "U", "2"); //indicator_id=11
	        $error_upload .= validate_header($row2[29], "Number given STI treatment", "AD", "2"); //indicator_id=5
	        $error_upload .= validate_header($row2[38], "Number given emergency contraceptive pill", "AM", "2"); //indicator_id=6
	      //  $error_upload .= validate_header($row2[43], "Number completed trauma counselling", "AR", "2"); //indicator_id=39
	        $row3 = explode("," , $rows[2]);
	        $error_upload .= validate_header($row3[2], "Date (MM/YYYY)", "C", "3");
	        $error_upload .= validate_header($row3[3], "Male", "D", "3");
	        $error_upload .= validate_header($row3[7], "Female", "H", "3");
	        $error_upload .= validate_header($row3[11], "Date (MM/YYYY)", "L", "3");
	        $error_upload .= validate_header($row3[12], "Male", "M", "3");
	        $error_upload .= validate_header($row3[16], "Female", "Q", "3");
	        $error_upload .= validate_header($row3[20], "Date (MM/YYYY)", "U", "3");
	        $error_upload .= validate_header($row3[21], "Male", "V", "3");
	        $error_upload .= validate_header($row3[25], "Female", "Z", "3");
	        $error_upload .= validate_header($row3[29], "Date (MM/YYYY)", "AD", "3");
	        $error_upload .= validate_header($row3[30], "Male", "AE", "3");
	        $error_upload .= validate_header($row3[34], "Female", "AI", "3");
	        $error_upload .= validate_header($row3[38], "Date (MM/YYYY)", "AM", "3");
	        $error_upload .= validate_header($row3[39], "Female", "AN", "3");
	        $row4 = explode("," , $rows[3]);
	        $error_upload .= validate_header($row4[3], "0-11 Yrs", "D", "4");
	        $error_upload .= validate_header($row4[4], "12-17 Yrs", "E", "4");
	        $error_upload .= validate_header($row4[5], "18-49 Yrs", "F", "4");
	        $error_upload .= validate_header($row4[7], "0-11 Yrs", "H", "4");
	        $error_upload .= validate_header($row4[8], "12-17 Yrs", "I", "4");
	        $error_upload .= validate_header($row4[9], "18-49 Yrs", "J", "4");
	        $error_upload .= validate_header($row4[12], "0-11 Yrs", "M", "4");
	        $error_upload .= validate_header($row4[13], "12-17 Yrs", "N", "4");
	        $error_upload .= validate_header($row4[14], "18-49 Yrs", "O", "4");
	        $error_upload .= validate_header($row4[16], "0-11 Yrs", "Q", "4");
	        $error_upload .= validate_header($row4[17], "12-17 Yrs", "R", "4");
	        $error_upload .= validate_header($row4[18], "18-49 Yrs", "S", "4");
	        $error_upload .= validate_header($row4[21], "0-11 Yrs", "V", "4");
	        $error_upload .= validate_header($row4[22], "12-17 Yrs", "W", "4");
	        $error_upload .= validate_header($row4[23], "18-49 Yrs", "X", "4");
	        $error_upload .= validate_header($row4[25], "0-11 Yrs", "Z", "4");
	        $error_upload .= validate_header($row4[26], "12-17 Yrs", "AA", "4");
	        $error_upload .= validate_header($row4[27], "18-49 Yrs", "AB", "4");
	        $error_upload .= validate_header($row4[30], "0-11 Yrs", "AE", "4");
	        $error_upload .= validate_header($row4[31], "12-17 Yrs", "AF", "4");
	        $error_upload .= validate_header($row4[32], "18-49 Yrs", "AG", "4");
	        $error_upload .= validate_header($row4[34], "0-11 Yrs", "AI", "4");
	        $error_upload .= validate_header($row4[35], "12-17 Yrs", "AJ", "4");
	        $error_upload .= validate_header($row4[36], "18-49 Yrs", "AK", "4");
	        $error_upload .= validate_header($row4[39], "0-11 Yrs", "AN", "4");
	        $error_upload .= validate_header($row4[40], "12-17 Yrs", "AO", "4");
	        $error_upload .= validate_header($row4[41], "18-49 Yrs", "AP", "4");
	        
	        
	        //validate data rows
	        for($i=4; $i<count($rows)-2; $i++){
	            $row_data = explode("," , $rows[$i]);
	           $error_upload .= validate_data_indicators_3_4_5_11($row_data[0], $row_data[2], $row_data[3], $row_data[4], $row_data[5], $row_data[6], $row_data[7], $row_data[8], $row_data[9], $row_data[10],"C", "D-K", $i+1); //indicator_id=3
	           $error_upload .= validate_data_indicators_3_4_5_11($row_data[0], $row_data[11], $row_data[12], $row_data[13], $row_data[14], $row_data[15], $row_data[16], $row_data[17], $row_data[18], $row_data[19],"L", "M-T", $i+1); //indicator_id=4
	           $error_upload .= validate_data_indicators_3_4_5_11($row_data[0], $row_data[20], $row_data[21], $row_data[22], $row_data[23], $row_data[24], $row_data[25], $row_data[26], $row_data[27], $row_data[28],"U", "V-AC", $i+1); //indicator_id=11
	           $error_upload .= validate_data_indicators_3_4_5_11($row_data[0], $row_data[29], $row_data[30], $row_data[31], $row_data[32], $row_data[33], $row_data[34], $row_data[35], $row_data[36], $row_data[37],"AD", "AE-AL", $i+1); //indicator_id=5
	           $error_upload .= validate_data_indicators_6($row_data[0], $row_data[38], $row_data[39], $row_data[40], $row_data[41], $row_data[42],"AM", "AN-AQ", $i+1); //indicator_id=5  
	        }

	        if($error_upload !== ""){
	            print_message("'" . $_FILES["fileToUpload"]["name"] . "' was not uploaded into database. Please correct CSV file.\n\n" . $error_upload);
	            return;
	        }
	        
	        //insert data
	        $date_created = date("Y-m-d H:i:s");
	        for($i=4; $i<count($rows)-2; $i++){
 	            $row = explode("," , $rows[$i]);
 	           $indicator_name = "Number of rape survivors";
	            $message_upload .= insert_to_db_indicator3_4_5_11_6($row[0], $row[2], $row[3], $user->id, $date_created, '3', $db,  $row[1], $indicator_name, "0-11", "Male");
	            $message_upload .= insert_to_db_indicator3_4_5_11_6($row[0], $row[2], $row[4], $user->id, $date_created, '3', $db,  $row[1], $indicator_name, "12-17", "Male");
	            $message_upload .= insert_to_db_indicator3_4_5_11_6($row[0], $row[2], $row[5], $user->id, $date_created, '3', $db,  $row[1], $indicator_name, "18-49", "Male");
	            $message_upload .= insert_to_db_indicator3_4_5_11_6($row[0], $row[2], $row[6], $user->id, $date_created, '3', $db,  $row[1], $indicator_name, "50+", "Male");
	            $message_upload .= insert_to_db_indicator3_4_5_11_6($row[0], $row[2], $row[7], $user->id, $date_created, '3', $db,  $row[1], $indicator_name, "0-11", "Female");
	            $message_upload .= insert_to_db_indicator3_4_5_11_6($row[0], $row[2], $row[8], $user->id, $date_created, '3', $db,  $row[1], $indicator_name, "12-17", "Female");
	            $message_upload .= insert_to_db_indicator3_4_5_11_6($row[0], $row[2], $row[9], $user->id, $date_created, '3', $db,  $row[1], $indicator_name, "18-49", "Female");
	            $message_upload .= insert_to_db_indicator3_4_5_11_6($row[0], $row[2], $row[10], $user->id, $date_created, '3', $db,  $row[1], $indicator_name, "50+", "Female");
	            $indicator_name = "Number initiated on PEP";
	            $message_upload .= insert_to_db_indicator3_4_5_11_6($row[0], $row[11], $row[12], $user->id, $date_created, '4', $db,  $row[1], $indicator_name, "0-11", "Male");
	            $message_upload .= insert_to_db_indicator3_4_5_11_6($row[0], $row[11], $row[13], $user->id, $date_created, '4', $db,  $row[1], $indicator_name, "12-17", "Male");
	            $message_upload .= insert_to_db_indicator3_4_5_11_6($row[0], $row[11], $row[14], $user->id, $date_created, '4', $db,  $row[1], $indicator_name, "18-49", "Male");
	            $message_upload .= insert_to_db_indicator3_4_5_11_6($row[0], $row[11], $row[15], $user->id, $date_created, '4', $db,  $row[1], $indicator_name, "50+", "Male");
	            $message_upload .= insert_to_db_indicator3_4_5_11_6($row[0], $row[11], $row[16], $user->id, $date_created, '4', $db,  $row[1], $indicator_name, "0-11", "Female");
	            $message_upload .= insert_to_db_indicator3_4_5_11_6($row[0], $row[11], $row[17], $user->id, $date_created, '4', $db,  $row[1], $indicator_name, "12-17", "Female");
	            $message_upload .= insert_to_db_indicator3_4_5_11_6($row[0], $row[11], $row[18], $user->id, $date_created, '4', $db,  $row[1], $indicator_name, "18-49", "Female");
	            $message_upload .= insert_to_db_indicator3_4_5_11_6($row[0], $row[11], $row[19], $user->id, $date_created, '4', $db,  $row[1], $indicator_name, "50+", "Female");
	            $indicator_name = "Number completed PEP";
	            $message_upload .= insert_to_db_indicator3_4_5_11_6($row[0], $row[20], $row[21], $user->id, $date_created, '11', $db,  $row[1], $indicator_name, "0-11", "Male");
	            $message_upload .= insert_to_db_indicator3_4_5_11_6($row[0], $row[20], $row[22], $user->id, $date_created, '11', $db,  $row[1], $indicator_name, "12-17", "Male");
	            $message_upload .= insert_to_db_indicator3_4_5_11_6($row[0], $row[20], $row[23], $user->id, $date_created, '11', $db,  $row[1], $indicator_name, "18-49", "Male");
	            $message_upload .= insert_to_db_indicator3_4_5_11_6($row[0], $row[20], $row[24], $user->id, $date_created, '11', $db,  $row[1], $indicator_name, "50+", "Male");
	            $message_upload .= insert_to_db_indicator3_4_5_11_6($row[0], $row[20], $row[25], $user->id, $date_created, '11', $db,  $row[1], $indicator_name, "0-11", "Female");
	            $message_upload .= insert_to_db_indicator3_4_5_11_6($row[0], $row[20], $row[26], $user->id, $date_created, '11', $db,  $row[1], $indicator_name, "12-17", "Female");
	            $message_upload .= insert_to_db_indicator3_4_5_11_6($row[0], $row[20], $row[27], $user->id, $date_created, '11', $db,  $row[1], $indicator_name, "18-49", "Female");
	            $message_upload .= insert_to_db_indicator3_4_5_11_6($row[0], $row[20], $row[28], $user->id, $date_created, '11', $db,  $row[1], $indicator_name, "50+", "Female");
	            $indicator_name = "Number given STI treatment";
	            $message_upload .= insert_to_db_indicator3_4_5_11_6($row[0], $row[29], $row[30], $user->id, $date_created, '5', $db,  $row[1], $indicator_name, "0-11", "Male");
	            $message_upload .= insert_to_db_indicator3_4_5_11_6($row[0], $row[29], $row[31], $user->id, $date_created, '5', $db,  $row[1], $indicator_name, "12-17", "Male");
	            $message_upload .= insert_to_db_indicator3_4_5_11_6($row[0], $row[29], $row[32], $user->id, $date_created, '5', $db,  $row[1], $indicator_name, "18-49", "Male");
	            $message_upload .= insert_to_db_indicator3_4_5_11_6($row[0], $row[29], $row[33], $user->id, $date_created, '5', $db,  $row[1], $indicator_name, "50+", "Male");
	            $message_upload .= insert_to_db_indicator3_4_5_11_6($row[0], $row[29], $row[34], $user->id, $date_created, '5', $db,  $row[1], $indicator_name, "0-11", "Female");
	            $message_upload .= insert_to_db_indicator3_4_5_11_6($row[0], $row[29], $row[35], $user->id, $date_created, '5', $db,  $row[1], $indicator_name, "12-17", "Female");
	            $message_upload .= insert_to_db_indicator3_4_5_11_6($row[0], $row[29], $row[36], $user->id, $date_created, '5', $db,  $row[1], $indicator_name, "18-49", "Female");
	            $message_upload .= insert_to_db_indicator3_4_5_11_6($row[0], $row[29], $row[37], $user->id, $date_created, '5', $db,  $row[1], $indicator_name, "50+", "Female");
	            $indicator_name = "Number given emergency contraceptive pill";
	            $message_upload .= insert_to_db_indicator3_4_5_11_6($row[0], $row[38], $row[39], $user->id, $date_created, '6', $db,  $row[1], $indicator_name, "0-11", "Female");
	            $message_upload .= insert_to_db_indicator3_4_5_11_6($row[0], $row[38], $row[40], $user->id, $date_created, '6', $db,  $row[1], $indicator_name, "12-17", "Female");
	            $message_upload .= insert_to_db_indicator3_4_5_11_6($row[0], $row[38], $row[41], $user->id, $date_created, '6', $db,  $row[1], $indicator_name, "18-49", "Female");
	            $message_upload .= insert_to_db_indicator3_4_5_11_6($row[0], $row[38], $row[42], $user->id, $date_created, '6', $db,  $row[1], $indicator_name, "50+", "Female");
	            $indicator_name = "Number of presenting within 72 hours";
	            $message_upload .= insert_to_db_indicator3_4_5_11_6($row[0], $row[43], $row[44], $user->id, $date_created, '38', $db,  $row[1], $indicator_name, "0-11", "Male");
	            $message_upload .= insert_to_db_indicator3_4_5_11_6($row[0], $row[43], $row[45], $user->id, $date_created, '38', $db,  $row[1], $indicator_name, "12-17", "Male");
	            $message_upload .= insert_to_db_indicator3_4_5_11_6($row[0], $row[43], $row[46], $user->id, $date_created, '38', $db,  $row[1], $indicator_name, "18-49", "Male");
	            $message_upload .= insert_to_db_indicator3_4_5_11_6($row[0], $row[43], $row[47], $user->id, $date_created, '38', $db,  $row[1], $indicator_name, "50+", "Male");
	            $message_upload .= insert_to_db_indicator3_4_5_11_6($row[0], $row[43], $row[48], $user->id, $date_created, '38', $db,  $row[1], $indicator_name, "0-11", "Female");
	            $message_upload .= insert_to_db_indicator3_4_5_11_6($row[0], $row[43], $row[49], $user->id, $date_created, '38', $db,  $row[1], $indicator_name, "12-17", "Female");
	            $message_upload .= insert_to_db_indicator3_4_5_11_6($row[0], $row[43], $row[50], $user->id, $date_created, '38', $db,  $row[1], $indicator_name, "18-49", "Female");
	            $message_upload .= insert_to_db_indicator3_4_5_11_6($row[0], $row[43], $row[51], $user->id, $date_created, '38', $db,  $row[1], $indicator_name, "50+", "Female");
	            $indicator_name = "Number completed trauma counselling";
	            $message_upload .= insert_to_db_indicator3_4_5_11_6($row[0], $row[52], $row[53], $user->id, $date_created, '39', $db,  $row[1], $indicator_name, "0-11", "Male");
	            $message_upload .= insert_to_db_indicator3_4_5_11_6($row[0], $row[52], $row[54], $user->id, $date_created, '39', $db,  $row[1], $indicator_name, "12-17", "Male");
	            $message_upload .= insert_to_db_indicator3_4_5_11_6($row[0], $row[52], $row[55], $user->id, $date_created, '39', $db,  $row[1], $indicator_name, "18-49", "Male");
	            $message_upload .= insert_to_db_indicator3_4_5_11_6($row[0], $row[52], $row[56], $user->id, $date_created, '39', $db,  $row[1], $indicator_name, "50+", "Male");
	            $message_upload .= insert_to_db_indicator3_4_5_11_6($row[0], $row[52], $row[57], $user->id, $date_created, '39', $db,  $row[1], $indicator_name, "0-11", "Female");
	            $message_upload .= insert_to_db_indicator3_4_5_11_6($row[0], $row[52], $row[58], $user->id, $date_created, '39', $db,  $row[1], $indicator_name, "12-17", "Female");
	            $message_upload .= insert_to_db_indicator3_4_5_11_6($row[0], $row[52], $row[59], $user->id, $date_created, '39', $db,  $row[1], $indicator_name, "18-49", "Female");
	            $message_upload .= insert_to_db_indicator3_4_5_11_6($row[0], $row[52], $row[60], $user->id, $date_created, '39', $db,  $row[1], $indicator_name, "50+", "Female");
	            
	        }

	    }else{
            print_message("'" . $_FILES["fileToUpload"]["name"] . "' was not uploaded into database. Wrong file format. Template is not defined. Please correct CSV file.\n\n" . $error_upload);
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



/*
 * returns empty message if success or error message
 */
function validate_data_indicator37($county_id, $date, $aggregate, $column_date, $column_aggregate, $row){
    if($county_id === ""){
        return "ERROR: Wrong file format. County id is not defined (row " . $row . ").\n"; //wrong format
    }
    if($date !== ""){
        //validate date format
        if(!validateDate($date)){
            return "ERROR: Date format is wrong  (column " . $column_date . ", row " . $row . "). Must be MM/YYYY.\n"; //date format is wrong
        }
        if(isAggregateEmpty($aggregate)){
            return "ERROR: Aggregate is empty (column " . $column_aggregate . ", row " . $row . ").\n"; //empty aggregate
        }
        if(!(validateAggregate($aggregate))){
            return "ERROR: Aggregate must be a positive integer number (columns " . $column_aggregate . ", row " . $row . "). Please correct value.\n"; //not number aggregate
        }
    }else if($aggregate !== ""){
        return "ERROR: Date is empty (column " . $column_date . ", row " . $row . ").\n"; //empty date;
    }
    return "";
}

/*
 * returns empty message if success or error message
 */
function validate_data_indicator1($county_id, $date, $aggregate1, $aggregate2, $aggregate3, $aggregate4, $aggregate5, $aggregate6, $aggregate7, $aggregate8, $aggregate9, $aggregate10, $aggregate11, $aggregate12,
    $aggregate13, $aggregate14, $aggregate15, $aggregate16, $aggregate17, $aggregate18, $aggregate19, $aggregate20, $aggregate21, $aggregate22, $aggregate23, $column_date, 
    $columns_aggregate, $row){
    if($county_id === ""){
        return "ERROR: Wrong file format. County id is not defined (row " . $row . ").\n"; //wrong format
    }
    if($date !== ""){
        //validate date format
        if(!validateDate($date)){
            return "ERROR: Date format is wrong  (column " . $column_date . ", row " . $row . "). Must be MM/YYYY.\n"; //date format is wrong
        }
        if(isAggregateEmpty($aggregate1) && isAggregateEmpty($aggregate2) && isAggregateEmpty($aggregate3) && isAggregateEmpty($aggregate4) && 
            isAggregateEmpty($aggregate5 ) && isAggregateEmpty($aggregate6 ) && isAggregateEmpty($aggregate7 ) && isAggregateEmpty($aggregate8 ) && 
            isAggregateEmpty($aggregate9 ) && isAggregateEmpty($aggregate10 ) && isAggregateEmpty($aggregate11 ) && isAggregateEmpty($aggregate12 ) && 
            isAggregateEmpty($aggregate13 ) && isAggregateEmpty($aggregate14) && isAggregateEmpty($aggregate15 ) && isAggregateEmpty($aggregate16 ) && 
            isAggregateEmpty($aggregate17) && isAggregateEmpty($aggregate18) && isAggregateEmpty($aggregate19 ) && isAggregateEmpty($aggregate20) && 
            isAggregateEmpty($aggregate21) && isAggregateEmpty($aggregate22 ) && isAggregateEmpty($aggregate23 )){
            return "ERROR: All aggregates are empty (columns " . $columns_aggregate . ", row " . $row . "). Please insert values.\n"; //empty aggregate
        }
        if(!(validateAggregate($aggregate1) && validateAggregate($aggregate2) && validateAggregate($aggregate3) && validateAggregate($aggregate4) 
            && validateAggregate($aggregate5) && validateAggregate($aggregate6) && validateAggregate($aggregate7) && validateAggregate($aggregate8)
            && validateAggregate($aggregate9) && validateAggregate($aggregate10) && validateAggregate($aggregate11) && validateAggregate($aggregate12)
            && validateAggregate($aggregate13) && validateAggregate($aggregate14) && validateAggregate($aggregate15) && validateAggregate($aggregate16)
            && validateAggregate($aggregate17) && validateAggregate($aggregate18) && validateAggregate($aggregate19) && validateAggregate($aggregate20)
            && validateAggregate($aggregate21) && validateAggregate($aggregate22) && validateAggregate($aggregate23) 
            )){
            return "ERROR: Aggregates must be a positive integer number (columns " . $columns_aggregate . ", row " . $row . "). Please correct value.\n"; //not number aggregate
        }
    }else if($aggregate1 !== "" || $aggregate2 !== "" || $aggregate3 !== "" || $aggregate4 !== "" || $aggregate5 !== "" || $aggregate6 !== "" || $aggregate7 !== "" || $aggregate8 !== "" || $aggregate9 !== "" ||
        $aggregate10 !== "" || $aggregate11 !== "" || $aggregate12 !== "" || $aggregate13 !== "" || $aggregate14 !== "" || $aggregate15 !== "" || $aggregate16 !== "" || $aggregate17 !== "" || $aggregate18 !== "" ||
        $aggregate19 !== "" || $aggregate20 !== "" || $aggregate21 !== "" || $aggregate22 !== "" || $aggregate23 !== ""){
        return "ERROR: Date is empty (column " . $column_date . ", row " . $row . ").\n"; //empty date;
    }
    return "";
}

/*
 * returns empty message if success or error message
 */
function validate_data_indicator2($county_id, $date, $aggregate1, $aggregate2, $aggregate3, $aggregate4, $aggregate5, $aggregate6, 
    $aggregate7, $aggregate8, $aggregate9, $aggregate10, $column_date, $columns_aggregate, $row){
    if($county_id === ""){
        return "ERROR: Wrong file format. County id is not defined (row " . $row . ").\n"; //wrong format
    }
    if($date !== ""){
        //validate date format
        if(!validateDate($date)){
            return "ERROR: Date format is wrong  (column " . $column_date . ", row " . $row . "). Must be MM/YYYY.\n"; //date format is wrong
        }
        if(isAggregateEmpty($aggregate1) && isAggregateEmpty($aggregate2) && isAggregateEmpty($aggregate3) && isAggregateEmpty($aggregate4) && 
            isAggregateEmpty($aggregate5 ) && isAggregateEmpty($aggregate6 ) && isAggregateEmpty($aggregate7 ) && isAggregateEmpty($aggregate8 )
            && isAggregateEmpty($aggregate9 ) && isAggregateEmpty($aggregate10 )){
            return "ERROR: All aggregates are empty (columns " . $columns_aggregate . ", row " . $row . "). Please insert values.\n"; //empty aggregate
        }
        if(!(validateAggregate($aggregate1) && validateAggregate($aggregate2) && validateAggregate($aggregate3) && validateAggregate($aggregate4)
            && validateAggregate($aggregate5) && validateAggregate($aggregate6) && validateAggregate($aggregate7) && validateAggregate($aggregate8)
            && validateAggregate($aggregate9) && validateAggregate($aggregate10)
        )){
            return "ERROR: Aggregates must be a positive integer number (columns " . $columns_aggregate . ", row " . $row . "). Please correct value.\n"; //not number aggregate
        }
    }else if($aggregate1 !== "" || $aggregate2 !== "" || $aggregate3 !== "" || $aggregate4 !== "" || $aggregate5 !== "" || $aggregate6 !== ""
        || $aggregate7 !== "" || $aggregate8 !== "" || $aggregate9 !== "" || $aggregate10 !== ""){
        return "ERROR: Date is empty (column " . $column_date . ", row " . $row . ").\n"; //empty date;
    }
    return "";
}

/*
 * returns empty message if success or error message
 */
function validate_data_indicators_3_4_5_11($county_id, $date, $aggregate1, $aggregate2, $aggregate3, $aggregate4, $aggregate5, $aggregate6, $aggregate7, $aggregate8, $column_date, $columns_aggregate, $row){
    if($county_id === ""){
        return "ERROR: Wrong file format. County id is not defined (row " . $row . ").\n"; //wrong format
    }
    if($date !== ""){
        //validate date format
        if(!validateDate($date)){
            return "ERROR: Date format is wrong  (column " . $column_date . ", row " . $row . "). Must be MM/YYYY.\n"; //date format is wrong
        }
        if(isAggregateEmpty($aggregate1) && isAggregateEmpty($aggregate2) && isAggregateEmpty($aggregate3) && isAggregateEmpty($aggregate4) &&
            isAggregateEmpty($aggregate5) && isAggregateEmpty($aggregate6) && isAggregateEmpty($aggregate7) && isAggregateEmpty($aggregate8)){
            return "ERROR: All aggregates are empty (columns " . $columns_aggregate . ", row " . $row . "). Please insert values.\n"; //empty aggregate
        }
        if(!(validateAggregate($aggregate1) && validateAggregate($aggregate2) && validateAggregate($aggregate3) && validateAggregate($aggregate4) && validateAggregate($aggregate5) && 
            validateAggregate($aggregate6) && validateAggregate($aggregate7) && validateAggregate($aggregate8))){
            return "ERROR: Aggregates must be a positive integer number (columns " . $columns_aggregate . ", row " . $row . "). Please correct value.\n"; //not number aggregate
        }
    }else if($aggregate1 !== "" || $aggregate2 !== "" || $aggregate3 !== "" || $aggregate4 !== "" || $aggregate5 !== "" || $aggregate6 !== "" || $aggregate7 !== "" || $aggregate8 !== ""){
        return "ERROR: Date is empty (column " . $column_date . ", row " . $row . ").\n"; //empty date;
    }
    return "";
}
/*
 * returns empty message if success or error message
 */
function validate_data_indicators_6($county_id, $date, $aggregate1, $aggregate2, $aggregate3, $aggregate4, $column_date, $columns_aggregate, $row){
    if($county_id === ""){
        return "ERROR: Wrong file format. County id is not defined (row " . $row . ").\n"; //wrong format
    }
    if($date !== ""){
        //validate date format
        if(!validateDate($date)){
            return "ERROR: Date format is wrong  (column " . $column_date . ", row " . $row . "). Must be MM/YYYY.\n"; //date format is wrong
        }
        if(isAggregateEmpty($aggregate1) && isAggregateEmpty($aggregate2) && isAggregateEmpty($aggregate3) && isAggregateEmpty($aggregate4)){
            return "ERROR: All aggregates are empty (columns " . $columns_aggregate . ", row " . $row . "). Please insert values.\n"; //empty aggregate
        }
        if(!(validateAggregate($aggregate1) && validateAggregate($aggregate2) && validateAggregate($aggregate3) && validateAggregate($aggregate4) )){
            return "ERROR: Aggregates must be a positive integer number (columns " . $columns_aggregate . ", row " . $row . "). Please correct value.\n"; //not number aggregate
        }
    }else if($aggregate1 !== "" || $aggregate2 !== "" || $aggregate3 !== "" || $aggregate4 !== ""){
        return "ERROR: Date is empty (column " . $column_date . ", row " . $row . ").\n"; //empty date;
    }
    return "";
}

function insert_to_db_indicator37($county_id, $date, $aggregate, $user_id, $date_created, $indicator_id, $db, $county_name, $indicator){
    if($date !== "" && $aggregate != ""){
         
        $data['timestamp_created'] = "'" . $date_created . "'";
        $data['county_id'] = $county_id;
        $data['indicator_id'] = $indicator_id;
        $data['aggregate'] = $aggregate;
        $data['created_by'] = $user_id;
        $date_arr = explode("/", $date);
        $date_new = $date_arr[1] ."-" .  $date_arr[0] . "-01"; //YYYY-MM-DD in database
        $data['date'] = "'" . $date_new . "'";
        if($db->insertData($data, "health_aggregates")){
            return "County: " . $county_name . "; Indicator: '" .  $indicator . "'; Aggregates:" . $aggregate . ".\n";
        }else{
            return "ERROR date not inserted => County:" . $county_name . "; Indicator: '"  .  $indicator . "' Aggregates:" . $aggregate . ".\n";
        }
    }     
}

function insert_to_db_indicator1($county_id, $date, $aggregate, $user_id, $date_created, $indicator_id, $db, $county_name, $indicator, $ownership_id, $ownership){
    if($date !== "" && $aggregate != "" && $ownership_id != ""){
         
        $data['timestamp_created'] = "'" . $date_created . "'";
        $data['county_id'] = $county_id;
        $data['indicator_id'] = $indicator_id;
        $data['aggregate'] = $aggregate;
        $data['created_by'] = $user_id;
        $data['ownership_id'] = $ownership_id;
        $date_arr = explode("/", $date);
        $date_new = $date_arr[1] ."-" .  $date_arr[0] . "-01"; //YYYY-MM-DD in database
        $data['date'] = "'" . $date_new . "'";
        if($db->insertData($data, "health_aggregates")){
            return "County: " . $county_name . "; Indicator: '" .  $indicator . "'; Aggregates:" . $aggregate . "; Ownership: " . $ownership . ".\n";
        }else{
            return "ERROR date not inserted => County:" . $county_name . "; Indicator: '"  .  $indicator . "; Ownership: " . $ownership . ".\n";
        }
    }
}

function insert_to_db_indicator2($county_id, $date, $aggregate, $user_id, $date_created, $indicator_id, $db, $county_name, $indicator, $cadre_id, $cadre, $gender){
    if($date !== "" && $aggregate != ""  && $aggregate !== '0' && $cadre_id != ""){
         
        $data['timestamp_created'] = "'" . $date_created . "'";
        $data['county_id'] = $county_id;
        $data['indicator_id'] = $indicator_id;
        $data['aggregate'] = $aggregate;
        $data['created_by'] = $user_id;
        $data['cadre_id'] = $cadre_id;
        $data['gender'] = "'" . $gender . "'";
        $date_arr = explode("/", $date);
        $date_new = $date_arr[1] ."-" .  $date_arr[0] . "-01"; //YYYY-MM-DD in database
        $data['date'] = "'" . $date_new . "'";
        if($db->insertData($data, "health_aggregates")){
            return "County: " . $county_name . "; Indicator: '" .  $indicator . "'; Aggregates:" . $aggregate . "; Cadre: " . $cadre . "; Gender: " . $gender . ".\n";
        }else{
            return "ERROR date not inserted => County:" . $county_name . "; Indicator: '" .  $indicator . "'; Aggregates:" . $aggregate . "; Cadre: " . $cadre . "; Gender: " . $gender . ".\n";
        }
    }
}

function insert_to_db_indicator3_4_5_11_6($county_id, $date, $aggregate, $user_id, $date_created, $indicator_id, $db, $county_name, $indicator, $age_range, $gender){
    if($date !== "" && $aggregate !== '' && $aggregate !== '0'){
         
        $data['timestamp_created'] = "'" . $date_created . "'";
        $data['county_id'] = $county_id;
        $data['indicator_id'] = $indicator_id;
        $data['created_by'] = $user_id;
        $date_arr = explode("/", $date);
        $date_new = $date_arr[1] ."-" .  $date_arr[0] . "-01"; //YYYY-MM-DD in database
        $data['date'] = "'" . $date_new . "'";
         $data['aggregate'] = $aggregate;
            $data['age_range'] = "'" . $age_range . "'";
            $data['gender'] = "'" . $gender . "'";;
        if($db->insertData($data, "health_aggregates")){
            return "County: " . $county_name . "; Indicator: '" .  $indicator . "'; Aggregates:" . $aggregate . "; Age range: " . $age_range . "; Gender: " . $gender . ".\n";
        }else{
            return "ERROR date not inserted => County:" . $county_name . "; Indicator: '" .  $indicator . "'; Aggregates:" . $aggregate . "; Age range: " . $age_range . "; Gender: " . $gender . ".\n";
        }
    }
}

/*
 * returns empty message if success or error message
 */
function validate2($county_id, $date, $female_less_18, $female_above_18){
    if($county_id === ""){
        return "Wrong file format.\n"; //wrong format
    }
    if($date !== ""){
        if($female_less_18 === "" && $female_above_18 === ""){
            return "Aggregates are empty.\n"; //empty aggregate
        }
    }else if($female_less_18 !== "" || $female_above_18 !== ""){
        return "Date is empty.\n";
    }
    return "";
}



function insert_gender_indicators($indicator_data, $indicator_id, $db, $date_new, $created_by, $indicator_index, $county_id){  
    
    $data['date'] = "'" . $date_new . "'";
    $data['created_by'] = $created_by;
//     $data['timestamp_created'] = "'" . $created_date . "'";
    $data['timestamp_created'] = "'" . date("Y-m-d H:i:s") . "'";
    $data['county_id'] = $county_id;
    
    $data['indicator_id'] = $indicator_id;
    $genders = explode(";" , $indicator_data);
    $message = "";
    //print_r($genders); print "\n\n";
    for($i=0;$i<count($genders);$i++){
        $gender = explode("," , $genders[$i]);
        if($gender[1] > 0){
            $message .= "\nIndicator " . $indicator_index . ":\n";
            $data['aggregate'] = $gender[1];
            if($gender[0] === 'female_0_11'){
                $data['gender'] = "'Female'";
                $data['age_range'] = "'0-11'";
                //print_r($data);
                if($db->insertData($data, "health_aggregates")){
                    $message .= "Female age range 0-11: " . $data['aggregate'] . " aggregate(s) is inserted.\n";
                }else{
                    $message .= "Female age range 0-11: " . $data['aggregate'] . " aggregate(s) is NOT inserted.\n";
                }
            }else if($gender[0] === 'female_12_17'){
                $data['gender'] = "'Female'";
                $data['age_range'] = "'12-17'";
                if($db->insertData($data, "health_aggregates")){
                    $message .= "Female age range 12-17: " . $data['aggregate'] . " aggregate(s) is inserted.\n";
                }else{
                    $message .= "Female age range 12-17: " . $data['aggregate'] . " aggregate(s) is NOT inserted.\n";
                }
            }else if($gender[0] === 'female_18_49'){
                $data['gender'] = "'Female'";
                $data['age_range'] = "'18-49'";
                if($db->insertData($data, "health_aggregates")){
                    $message .= "Female age range 18_49: " . $data['aggregate'] . " aggregate(s) is inserted.\n";
                }else{
                    $message .= "Female age range 18_49: " . $data['aggregate'] . " aggregate(s) is NOT inserted.\n";
                }
            }else if($gender[0] === 'female_50'){
                $data['gender'] = "'Female'";
                $data['age_range'] = "'50+'";
                if($db->insertData($data, "health_aggregates")){
                    $message .= "Female age range 50+: " . $data['aggregate'] . " aggregate(s) is inserted.\n";
                }else{
                    $message .= "Female age range 50+: " . $data['aggregate'] . " aggregate(s) is NOT inserted.\n";
                }
            }
            if($indicator_id !== '6'){
                if($gender[0] === 'male_0_11'){
                    $data['gender'] = "'Male'";
                    $data['age_range'] = "'0-11'";
                    if($db->insertData($data, "health_aggregates")){
                        $message .= "Male age range 0-11: " . $data['aggregate'] . " aggregate(s) is inserted.\n";
                    }else{
                        $message .= "Male age range 0-11: " . $data['aggregate'] . " aggregate(s) is NOT inserted.\n";
                    }
                }else if($gender[0] === 'male_12_17'){
                    $data['gender'] = "'Male'";
                    $data['age_range'] = "'12-17'";
                    if($db->insertData($data, "health_aggregates")){
                        $message .= "Male age range 12-17: " . $data['aggregate'] . " aggregate(s) is inserted.\n";
                    }else{
                        $message .= "Male age range 12-17: " . $data['aggregate'] . " aggregate(s) is NOT inserted.\n";
                    }
                }else if($gender[0] === 'male_18_49'){
                    $data['gender'] = "'Male'";
                    $data['age_range'] = "'18-49'";
                    if($db->insertData($data, "health_aggregates")){
                        $message .= "Male age range 18_49: " . $data['aggregate'] . " aggregate(s) is inserted.\n";
                    }else{
                        $message .= "Male age range 18_49: " . $data['aggregate'] . " aggregate(s) is NOT inserted.\n";
                    }
                }else if($gender[0] === 'male_50'){
                    $data['gender'] = "'Male'";
                    $data['age_range'] = "'50+'";
                    if($db->insertData($data, "health_aggregates")){
                        $message .= "Male age range 50+: " . $data['aggregate'] . " aggregate(s) is inserted.\n";
                    }else{
                        $message .= "Male age range 50+: " . $data['aggregate'] . " aggregate(s) is NOT inserted.\n";
                    }
                }        
            }
        }
    }
    

  return $message;  
    
}

?>