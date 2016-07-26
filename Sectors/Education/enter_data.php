<?php
//TA:60:4
$page_title = "Enter Data | Education Sector | GBV";
$current_page = "home";

require_once 'includes/global.inc.php';

if (isset ( $_SESSION ['logged_in'] )) {
	
	$user = unserialize ( $_SESSION ['user'] );
	
if( !($userTools->isAdmin($user->user_group) &&  $user->sector === '5')){
        print " You do not have permission to access this page.";
        return;
    }
	
	$mode = $_GET['mode'];
	$county_id = $_GET['county_id'];
	$indicator29 = $_GET['indicator29'];
	$indicator30 = $_GET['indicator30'];
	$indicator36 = $_GET['indicator36'];
	$indicator33 = $_GET['indicator33'];
	$indicator32 = $_GET['indicator32'];
	$indicator31 = $_GET['indicator31'];
	$indicator34 = $_GET['indicator34'];
	
	
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
	   
	   if($indicator36 && $indicator36 !== ''){
	       $data['indicator_id'] = 36;
	       $sexs = explode(";" , $indicator36);
	       $message .= "\nIndicator 8.1.a Number of teachers and secretariat staff trained in SGBV:\n";
	       for($i=0;$i<count($sexs);$i++){
	           $sex = explode("," , $sexs[$i]);
	           $data['sex'] = "'" . $sex[0] . "'";
	           $data['aggregate'] = $sex[1];
	           $data['ownership'] = 0;
	           if($db->insertData($data, "education_aggregates")){
	               $message .= $data['aggregate'] . " aggregate(s) is inserted.\n";
	           }else{
	               $message .= $data['aggregate'] . " aggregate(s) is NOT inserted.\n";
	           }
	       }
	   }
	   if($indicator33 && $indicator33 !== ''){
	       $data['indicator_id'] = 33;
	       $sexs = explode(";" , $indicator33);
	       $message .= "\nIndicator 8.1.b Number of MOEST staff trained in SGBV:\n";
	       for($i=0;$i<count($sexs);$i++){
	           $sex = explode("," , $sexs[$i]);
	           $data['sex'] = "'" . $sex[0] . "'";
	           $data['aggregate'] = $sex[1];
	           $data['ownership'] = 0;
	           if($db->insertData($data, "education_aggregates")){
	               $message .= $data['aggregate'] . " aggregate(s) is inserted.\n";
	           }else{
	               $message .= $data['aggregate'] . " aggregate(s) is NOT inserted.\n";
	           }
	       }
	   }
	   if($indicator30 && $indicator30 !== ''){
	       $data['indicator_id'] = 30;
	       $ownerships = explode(";" , $indicator30);
	       $message .= "\nIndicator 8.2.a Total number of schools surveyed:\n";
	       for($i=0;$i<count($ownerships);$i++){
	           $ownership = explode("," , $ownerships[$i]);
	           $data['ownership'] = $ownership[0];
	           $data['aggregate'] = $ownership[1];
	           $data['sex'] = "''";
	           if($db->insertData($data, "education_aggregates")){
	               $message .= $data['aggregate'] . " aggregate(s) is inserted.\n";
	           }else{
	               $message .= $data['aggregate'] . " aggregate(s) is NOT inserted.\n";
	           }
	       }
	   }
	   if($indicator29 && $indicator29 !== ''){
	   	$data['indicator_id'] = 29;
	   	$ownerships = explode(";" , $indicator29);
	   	$message .= "\nIndicator 8.2.b Number of schools implementing life skills curriculum that teaches students on what to do in case of violation:\n";
	   	for($i=0;$i<count($ownerships);$i++){
	   		$ownership = explode("," , $ownerships[$i]);
	   		$data['ownership'] = $ownership[0];
	   		$data['aggregate'] = $ownership[1];
	   		$data['sex'] = "''";
	   		if($db->insertData($data, "education_aggregates")){
	   			$message .= $data['aggregate'] . " aggregate(s) is inserted.\n";
	   		}else{
	   			$message .= $data['aggregate'] . " aggregate(s) is NOT inserted.\n";
	   		}
	   	}
	   }
	   if($indicator31 && $indicator31 !== ''){
	       $data['indicator_id'] = 31;
	       $sexs = explode(";" , $indicator31);
	       $message .= "\nIndicator 8.3.a Total number of children in the sample:\n";
	       for($i=0;$i<count($sexs);$i++){
	           $sex = explode("," , $sexs[$i]);
	           $data['sex'] = "'" . $sex[0] . "'";
	           $data['aggregate'] = $sex[1];
	           $data['ownership'] = 0;
	           if($db->insertData($data, "education_aggregates")){
	               $message .= $data['aggregate'] . " aggregate(s) is inserted.\n";
	           }else{
	               $message .= $data['aggregate'] . " aggregate(s) is NOT inserted.\n";
	           }
	       }
	   }
	   if($indicator32 && $indicator32 !== ''){
	   	$data['indicator_id'] = 32;
	   	$sexs = explode(";" , $indicator32);
	   	$message .= "\nIndicator 8.3.b Number of children who possess life skills:\n";
	   	for($i=0;$i<count($sexs);$i++){
	   		$sex = explode("," , $sexs[$i]);
	   		$data['sex'] = "'" . $sex[0] . "'";
	   		$data['aggregate'] = $sex[1];
	   		$data['ownership'] = 0;
	   		if($db->insertData($data, "education_aggregates")){
	   			$message .= $data['aggregate'] . " aggregate(s) is inserted.\n";
	   		}else{
	   			$message .= $data['aggregate'] . " aggregate(s) is NOT inserted.\n";
	   		}
	   	}
	   }
	   
	   if($indicator34 && $indicator34 !== ''){
	   	$data['indicator_id'] = 34;
	   	//[sex],[age],[violence_type],[identity_of_perpetrator],[place_of_victimization];[sex],[violence_type],[identity_of_perpetrator],[place_of_victimization];
	   	//example: 'female,>18 yrs,2,1,2,2;male,<18 yrs,5,8,5,1'
	   	$sexs = explode(";" , $indicator34);
	   	$message .= "\nIndicator 8.4 Number of children who have indicated via self reports that they have been violated at home/school in the last 12 months:\n";
	   	for($i=0;$i<count($sexs);$i++){
	   		$sex = explode("," , $sexs[$i]);
	   		$data['sex'] = "'" . $sex[0] . "'";
	   		$data['age'] = "'" . $sex[1] . "'";
	   		$data['violence_type'] = $sex[2];
	   		$data['identity_of_perpetrator'] = $sex[3];
	   		$data['place_of_victimization'] = $sex[4];
	   		$data['aggregate'] = $sex[5];
	   		if($db->insertData($data, "education_aggregates")){
	   			$message .= $data['aggregate'] . " aggregate(s) is inserted.\n";
	   		}else{
	   			$message .= $data['aggregate'] . " aggregate(s) is NOT inserted.\n";
	   		}
	   	}
	   }
	  if($message){
	       //print "\nCounty: " . $county . "\n\n" . $message;
	      print "Data uploaded successfully";
	       return;
	   }

	}else if($mode === 'add_aggregates_csv'){
	    
	    $target_dir = "uploads/";
	    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
	    
	    if(isset($_POST["submit"])) {
	     
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
	   
	    if($row1[0] === 'Education Sector Template Indicators 8.1-8.3'){
	        //validate headers
	        $row2 = explode("," , $rows[1]);
	        $error_upload .= validate_header($row2[0], "County Code", "A", "2");
	        $error_upload .= validate_header($row2[1], "County Name", "B", "2");
	        $error_upload .= validate_header($row2[2], "Number of teachers and secretariat staff trained in SGBV", "C", "2"); //indicator_id=36
	        $error_upload .= validate_header($row2[5], "Number of  MOEST staff trained in SGBV", "F", "2"); //indicator_id=33
	        $error_upload .= validate_header($row2[8], "Total Number of schools surveyed", "I", "2"); //indicator_id=30
	        $error_upload .= validate_header($row2[11], "Number of schools implementing life skills curriculum that teaches students on what to do in case of victimization", "L", "2"); //indicator_id=29
	        $error_upload .= validate_header($row2[14], "Number of children who possess life skills", "O", "2"); //indicator_id=32
	        $error_upload .= validate_header($row2[17], "Total number of children in the sample", "R", "2"); //indicator_id=31
	        $row3 = explode("," , $rows[2]);
	        $error_upload .= validate_header($row3[2], "Date (MM/YYYY)", "C", "3");
	        $error_upload .= validate_header($row3[3], "Aggregate", "D", "3");
	        $error_upload .= validate_header($row3[5], "Date (MM/YYYY)", "F", "3");
	        $error_upload .= validate_header($row3[6], "Aggregate", "G", "3");
	        $error_upload .= validate_header($row3[8], "Date (MM/YYYY)", "I", "3");
	        $error_upload .= validate_header($row3[9], "Aggregate", "J", "3");
	        $error_upload .= validate_header($row3[11], "Date (MM/YYYY)", "L", "3");
	        $error_upload .= validate_header($row3[12], "Aggregate", "M", "3");
	        $error_upload .= validate_header($row3[14], "Date (MM/YYYY)", "O", "3");
	        $error_upload .= validate_header($row3[15], "Aggregate", "P", "3");
	        $error_upload .= validate_header($row3[17], "Date (MM/YYYY)", "R", "3");
	        $error_upload .= validate_header($row3[18], "Aggregate", "S", "3");
	        $row4 = explode("," , $rows[3]);
	        $error_upload .= validate_header($row4[3], "Male", "D", "4");
	        $error_upload .= validate_header($row4[4], "Female", "E", "4");
	        $error_upload .= validate_header($row4[6], "Male", "G", "4");
	        $error_upload .= validate_header($row4[7], "Female", "H", "4");
	        $error_upload .= validate_header($row4[9], "Private", "J", "4");
	        $error_upload .= validate_header($row4[10], "Public", "K", "4");
	        $error_upload .= validate_header($row4[12], "Private", "M", "4");
	        $error_upload .= validate_header($row4[13], "Public", "N", "4");
	        $error_upload .= validate_header($row4[15], "Male", "P", "4");
	        $error_upload .= validate_header($row4[16], "Female", "Q", "4");
	        $error_upload .= validate_header($row4[18], "Male", "S", "4");
	        $error_upload .= validate_header($row4[19], "Female", "T", "4");
	        
	        //validate data rows
	        for($i=4; $i<count($rows)-2; $i++){
	            $row_data = explode("," , $rows[$i]);
	            //$county_id, $date, $aggregate1, $aggregate2, $column_date, $column_aggregate, $row
	            $error_upload .= validate_data_indicator29_30_31_32_33_36($row_data[0], $row_data[2], $row_data[3], $row_data[4], "C", "D-E", $i+1); //indicator_id=36
	            $error_upload .= validate_data_indicator29_30_31_32_33_36($row_data[0], $row_data[5], $row_data[6], $row_data[7], "F", "G-H", $i+1); //indicator_id=33
	            $error_upload .= validate_data_indicator29_30_31_32_33_36($row_data[0], $row_data[8], $row_data[9], $row_data[10], "I", "J-K", $i+1); //indicator_id=30
	            $error_upload .= validate_data_indicator29_30_31_32_33_36($row_data[0], $row_data[11], $row_data[12], $row_data[13], "L", "M-N", $i+1); //indicator_id=29
	            $error_upload .= validate_data_indicator29_30_31_32_33_36($row_data[0], $row_data[14], $row_data[15], $row_data[16], "O", "P-Q", $i+1); //indicator_id=32
	            $error_upload .= validate_data_indicator29_30_31_32_33_36($row_data[0], $row_data[17], $row_data[18], $row_data[19], "R", "S-T", $i+1); //indicator_id=31  
	        }
	            
	        if($error_upload !== ""){
	            print_message("'" . $_FILES["fileToUpload"]["name"] . "' was not uploaded into database.\n\n" . $error_upload);
                return;
	        }
	        
	       
	        //insert data
	        $date_created = date("Y-m-d H:i:s");
	        for($i=3; $i<count($rows)-1; $i++){
	            $row = explode("," , $rows[$i]);
	            //$county_id, $date, $aggregate, $user_id, $date_created, $indicator_id, $db, $county_name, $indicator, $sex
	            $message_upload .= insert_indicators31_32_33_36($row[0], $row[2], $row[3], $user->id, $date_created, '36', $db, $row[1], 'Number of teachers and secretariat staff trained in SGBV', 'Male'); 
	            $message_upload .= insert_indicators31_32_33_36($row[0], $row[2], $row[4], $user->id, $date_created, '36', $db, $row[1], 'Number of teachers and secretariat staff trained in SGBV', 'Female');
	            $message_upload .= insert_indicators31_32_33_36($row[0], $row[5], $row[6], $user->id, $date_created, '33', $db, $row[1], 'Number of  MOEST staff trained in SGBV', 'Male');
	            $message_upload .= insert_indicators31_32_33_36($row[0], $row[5], $row[7], $user->id, $date_created, '33', $db, $row[1], 'Number of  MOEST staff trained in SGBV', 'Female');
	            $message_upload .= insert_indicators31_32_33_36($row[0], $row[14], $row[15], $user->id, $date_created, '32', $db, $row[1], 'Number of children who possess life skills', 'Male');
	            $message_upload .= insert_indicators31_32_33_36($row[0], $row[14], $row[16], $user->id, $date_created, '32', $db, $row[1], 'Number of children who possess life skills', 'Female');
	            $message_upload .= insert_indicators31_32_33_36($row[0], $row[17], $row[18], $user->id, $date_created, '31', $db, $row[1], 'Total number of children in the sample', 'Male');
	            $message_upload .= insert_indicators31_32_33_36($row[0], $row[17], $row[19], $user->id, $date_created, '31', $db, $row[1], 'Total number of children in the sample', 'Female');
	            $message_upload .= insert_indicators29_30($row[0], $row[8], $row[9], $user->id, $date_created, '30', $db, $row[1], 'Total Number of schools surveyed', 24);
	            $message_upload .= insert_indicators29_30($row[0],  $row[8], $row[10], $user->id, $date_created, '30', $db, $row[1], 'Total Number of schools surveyed', 25);
	            $message_upload .= insert_indicators29_30($row[0],  $row[11], $row[12], $user->id, $date_created, '29', $db, $row[1], 'Number of schools implementing life skills curriculum that teaches students on what to do in case of victimization', 24);
	            $message_upload .= insert_indicators29_30($row[0],  $row[11], $row[13], $user->id, $date_created, '29', $db, $row[1], 'Number of schools implementing life skills curriculum that teaches students on what to do in case of victimization', 25);        
	        }
	    }else if($row1[0] === 'Education Sector Template Indicator 8.4'){
	        
	        //validate headers
	        $row2 = explode("," , $rows[1]);
	        $error_upload .= validate_header($row2[0], "Number of children who report being victims of violence in the last 12 months", "A", "2");
	        $row3 = explode("," , $rows[2]);
	        $error_upload .= validate_header($row3[0], "County Code", "A", "3");
	        $error_upload .= validate_header($row3[1], "County Name", "B", "3");
	        $error_upload .= validate_header($row3[2], "Date (MM/YYYY)", "C", "3");
	        $error_upload .= validate_header($row3[3], "Rape", "D", "3");
	        $error_upload .= validate_header($row3[29], "County Code", "AD", "3");
	        $error_upload .= validate_header($row3[30], "County Name", "AE", "3");
	        $error_upload .= validate_header($row3[31], "Date (MM/YYYY)", "AF", "3");
	        $error_upload .= validate_header($row3[32], "Molestation", "AG", "3");
	        $error_upload .= validate_header($row3[58], "County Code", "BG", "3");
	        $error_upload .= validate_header($row3[59], "County Name", "BH", "3");
	        $error_upload .= validate_header($row3[60], "Date (MM/YYYY)", "BI", "3");
	        $error_upload .= validate_header($row3[61], "Sexual slavery", "BJ", "3");
	        $error_upload .= validate_header($row3[87], "County Code", "CJ", "3");
	        $error_upload .= validate_header($row3[88], "County Name", "CK", "3");
	        $error_upload .= validate_header($row3[89], "Date (MM/YYYY)", "CL", "3");
	        $error_upload .= validate_header($row3[90], "Forced Marriage", "CM", "3");
	        $error_upload .= validate_header($row3[116], "County Code", "DM", "3");
	        $error_upload .= validate_header($row3[117], "County Name", "DN", "3");
	        $error_upload .= validate_header($row3[118], "Date (MM/YYYY)", "DO", "3");
	        $error_upload .= validate_header($row3[119], "Forced Sexual Acts", "DP", "3");
	        $row4 = explode("," , $rows[3]);
	        $error_upload .= validate_header($row4[3], "School", "D", "4");
	        $error_upload .= validate_header($row4[5], "Home", "F", "4");
	        $error_upload .= validate_header($row4[13], "Outside the Home", "N", "4");
	        $error_upload .= validate_header($row4[25], "Place of worship", "Z", "4");
	        $error_upload .= validate_header($row4[27], "Means of transport", "AB", "4");
	        $error_upload .= validate_header($row4[32], "School", "AG", "4");
	        $error_upload .= validate_header($row4[34], "Home", "AI", "4");
	        $error_upload .= validate_header($row4[42], "Outside the Home", "AQ", "4");
	        $error_upload .= validate_header($row4[54], "Place of worship", "BC", "4");
	        $error_upload .= validate_header($row4[56], "Means of transport", "BE", "4");
	        $error_upload .= validate_header($row4[61], "School", "BJ", "4");
	        $error_upload .= validate_header($row4[63], "Home", "BL", "4");
	        $error_upload .= validate_header($row4[71], "Outside the Home", "BT", "4");
	        $error_upload .= validate_header($row4[83], "Place of worship", "CF", "4");
	        $error_upload .= validate_header($row4[85], "Means of transport", "CH", "4");
	        $error_upload .= validate_header($row4[90], "School", "CM", "4");
	        $error_upload .= validate_header($row4[92], "Home", "CO", "4");
	        $error_upload .= validate_header($row4[100], "Outside the Home", "CW", "4");
	        $error_upload .= validate_header($row4[112], "Place of worship", "DI", "4");
	        $error_upload .= validate_header($row4[114], "Means of transport", "DK", "4");
	        $error_upload .= validate_header($row4[119], "School", "DP", "4");
	        $error_upload .= validate_header($row4[121], "Home", "DR", "4");
	        $error_upload .= validate_header($row4[129], "Outside the Home", "DZ", "4");
	        $error_upload .= validate_header($row4[141], "Place of worship", "EL", "4");
	        $error_upload .= validate_header($row4[143], "Means of transport", "EN", "4");
	        $row5 = explode("," , $rows[4]);
	        $error_upload .= validate_header($row5[3], "Teacher", "D", "5");
	        $error_upload .= validate_header($row5[5], "Parent", "F", "5");
	        $error_upload .= validate_header($row5[7], "Guardian", "H", "5");
	        $error_upload .= validate_header($row5[9], "Sibling", "J", "5");
	        $error_upload .= validate_header($row5[11], "Other relative", "L", "5");
	        $error_upload .= validate_header($row5[13], "Teacher", "N", "5");
	        $error_upload .= validate_header($row5[15], "Parent", "P", "5");
	        $error_upload .= validate_header($row5[17], "Guardian", "R", "5");
	        $error_upload .= validate_header($row5[19], "Sibling", "T", "5");
	        $error_upload .= validate_header($row5[21], "Other relative", "V", "5");
	        $error_upload .= validate_header($row5[23], "Stranger", "X", "5");
	        $error_upload .= validate_header($row5[25], "Religious Official", "Z", "5");
	        $error_upload .= validate_header($row5[27], "Operator", "AB", "5");
	        
	        $error_upload .= validate_header($row5[32], "Teacher", "AG", "5");
	        $error_upload .= validate_header($row5[34], "Parent", "AI", "5");
	        $error_upload .= validate_header($row5[36], "Guardian", "AK", "5");
	        $error_upload .= validate_header($row5[38], "Sibling", "AM", "5");
	        $error_upload .= validate_header($row5[40], "Other relative", "AO", "5");
	        $error_upload .= validate_header($row5[42], "Teacher", "AQ", "5");
	        $error_upload .= validate_header($row5[44], "Parent", "AS", "5");
	        $error_upload .= validate_header($row5[46], "Guardian", "AU", "5");
	        $error_upload .= validate_header($row5[48], "Sibling", "AW", "5");
	        $error_upload .= validate_header($row5[50], "Other relative", "AY", "5");
	        $error_upload .= validate_header($row5[52], "Stranger", "BA", "5");
	        $error_upload .= validate_header($row5[54], "Religious Official", "BC", "5");
	        $error_upload .= validate_header($row5[56], "Operator", "BE", "5");
	        
	        $error_upload .= validate_header($row5[61], "Teacher", "BJ", "5");
	        $error_upload .= validate_header($row5[63], "Parent", "BL", "5");
	        $error_upload .= validate_header($row5[65], "Guardian", "BN", "5");
	        $error_upload .= validate_header($row5[67], "Sibling", "BP", "5");
	        $error_upload .= validate_header($row5[69], "Other relative", "BR", "5");
	        $error_upload .= validate_header($row5[71], "Teacher", "BT", "5");
	        $error_upload .= validate_header($row5[73], "Parent", "BV", "5");
	        $error_upload .= validate_header($row5[75], "Guardian", "BX", "5");
	        $error_upload .= validate_header($row5[77], "Sibling", "BZ", "5");
	        $error_upload .= validate_header($row5[79], "Other relative", "CB", "5");
	        $error_upload .= validate_header($row5[81], "Stranger", "CD", "5");
	        $error_upload .= validate_header($row5[83], "Religious Official", "CF", "5");
	        $error_upload .= validate_header($row5[85], "Operator", "CH", "5");
	        
	        $error_upload .= validate_header($row5[90], "Teacher", "CM", "5");
	        $error_upload .= validate_header($row5[92], "Parent", "CO", "5");
	        $error_upload .= validate_header($row5[94], "Guardian", "CQ", "5");
	        $error_upload .= validate_header($row5[96], "Sibling", "CS", "5");
	        $error_upload .= validate_header($row5[98], "Other relative", "CU", "5");
	        $error_upload .= validate_header($row5[100], "Teacher", "CW", "5");
	        $error_upload .= validate_header($row5[102], "Parent", "CY", "5");
	        $error_upload .= validate_header($row5[104], "Guardian", "DA", "5");
	        $error_upload .= validate_header($row5[106], "Sibling", "DC", "5");
	        $error_upload .= validate_header($row5[108], "Other relative", "DE", "5");
	        $error_upload .= validate_header($row5[110], "Stranger", "DG", "5");
	        $error_upload .= validate_header($row5[112], "Religious Official", "DI", "5");
	        $error_upload .= validate_header($row5[114], "Operator", "DK", "5");
	        
	        $error_upload .= validate_header($row5[119], "Teacher", "DP", "5");
	        $error_upload .= validate_header($row5[121], "Parent", "DR", "5");
	        $error_upload .= validate_header($row5[123], "Guardian", "DT", "5");
	        $error_upload .= validate_header($row5[125], "Sibling", "DV", "5"); 
	        $error_upload .= validate_header($row5[127], "Other relative", "DX", "5");
	        $error_upload .= validate_header($row5[129], "Teacher", "DZ", "5");
	        $error_upload .= validate_header($row5[131], "Parent", "EB", "5");
	        $error_upload .= validate_header($row5[133], "Guardian", "ED", "5");
	        $error_upload .= validate_header($row5[135], "Sibling", "EF", "5");
	        $error_upload .= validate_header($row5[137], "Other relative", "EH", "5");
	        $error_upload .= validate_header($row5[139], "Stranger", "EJ", "5");
	        $error_upload .= validate_header($row5[141], "Religious Official", "EL", "5");
	        $error_upload .= validate_header($row5[143], "Operator", "EN", "5");
	        
	        //validate data rows
	        for($i=7; $i<count($rows)-1; $i++){
	            $row_data = explode("," , $rows[$i]);
	            //$county_id, $date, $aggregate1, $aggregate2, ...  $aggregate26, $column_date, $column_aggregate, $row
	            $error_upload .= validate_data_indicator34($row_data[0], $row_data[2], 
	                $row_data[3], $row_data[4], $row_data[5],$row_data[6],$row_data[7],$row_data[8],$row_data[9],$row_data[10],
	                $row_data[11],$row_data[12],$row_data[13],$row_data[14],$row_data[15],$row_data[16],$row_data[17],$row_data[18],$row_data[19],$row_data[20],$row_data[21],$row_data[22],$row_data[23],
	                $row_data[24],$row_data[25],$row_data[26],$row_data[27],$row_data[28],
	                "C", "D-AC", $i+1); //indicator_id=34 
	            $error_upload .= validate_data_indicator34($row_data[0], $row_data[31],
	                $row_data[32], $row_data[33], $row_data[34],$row_data[35],$row_data[36],$row_data[37],$row_data[38],$row_data[39],
	                $row_data[40],$row_data[41],$row_data[42],$row_data[43],$row_data[44],$row_data[45],$row_data[46],$row_data[47],$row_data[48],$row_data[49],$row_data[50],$row_data[51],$row_data[52],
	                $row_data[53],$row_data[54],$row_data[55],$row_data[56],$row_data[57],
	                "AF", "AG-BF", $i+1);
	            $error_upload .= validate_data_indicator34($row_data[0], $row_data[60],
	                $row_data[61], $row_data[62], $row_data[63],$row_data[64],$row_data[65],$row_data[66],$row_data[67],$row_data[68],
	                $row_data[69],$row_data[70],$row_data[71],$row_data[72],$row_data[73],$row_data[74],$row_data[75],$row_data[76],$row_data[77],$row_data[78],$row_data[79],$row_data[80],$row_data[81],
	                $row_data[82],$row_data[83],$row_data[84],$row_data[85],$row_data[86],
	                "BI", "BJ-CI", $i+1);
	            $error_upload .= validate_data_indicator34($row_data[0], $row_data[89],
	                $row_data[90], $row_data[91], $row_data[92],$row_data[93],$row_data[94],$row_data[95],$row_data[96],$row_data[97],
	                $row_data[98],$row_data[99],$row_data[100],$row_data[101],$row_data[102],$row_data[103],$row_data[104],$row_data[105],$row_data[106],$row_data[107],$row_data[108],$row_data[109],$row_data[110],
	                $row_data[111],$row_data[112],$row_data[113],$row_data[114],$row_data[115],
	                "CL", "CM-DL", $i+1);
	            $error_upload .= validate_data_indicator34($row_data[0], $row_data[118],
	                $row_data[119], $row_data[120], $row_data[121],$row_data[122],$row_data[123],$row_data[124],$row_data[125],$row_data[126],
	                $row_data[127],$row_data[128],$row_data[129],$row_data[130],$row_data[131],$row_data[132],$row_data[133],$row_data[134],$row_data[135],$row_data[136],$row_data[137],$row_data[138],$row_data[139],
	                $row_data[140],$row_data[141],$row_data[142],$row_data[143],$row_data[144],
	                "DO", "DP-EO", $i+1);
	        }
	              
	        if($error_upload !== ""){
	            print_message("'" . $_FILES["fileToUpload"]["name"] . "' was not uploaded into database. Please correct CSV file.\n\n" . $error_upload);
	            return;
	        }
	        
	         
	        //insert data
	        $date_created = date("Y-m-d H:i:s");
	        for($i=7; $i<count($rows)-1; $i++){
	           
	            $row = explode("," , $rows[$i]);
	 //$county_id, $date, $aggregate, $user_id, $date_created, $indicator_id, $db, $county_name, $indicator, $sex, $violence_type, $place_of_victimization, $identity_of_perpetrator
                $indicator_name = "Number of children who report being victims of violence in the last 12 months";
     $date = $row[2];         
 $violence_type = '1'; //rape
$place_of_victimization = '2'; //school
$identity_of_perpetrator = '3'; //teacher
$message_upload .= insert_indicators34($row[0], $date, $row[3], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Male', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$message_upload .= insert_indicators34($row[0], $date, $row[4], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Female', $violence_type, $place_of_victimization, $identity_of_perpetrator);   	      
$place_of_victimization = '1'; //home
$identity_of_perpetrator= '1'; //parent
$message_upload .= insert_indicators34($row[0], $date, $row[5], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Male', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$message_upload .= insert_indicators34($row[0], $date, $row[6], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Female', $violence_type, $place_of_victimization, $identity_of_perpetrator);   	      
$identity_of_perpetrator= '2'; //guardian
$message_upload .= insert_indicators34($row[0], $date, $row[7], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Male', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$message_upload .= insert_indicators34($row[0], $date, $row[8], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Female', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$identity_of_perpetrator= '4'; //sibling
$message_upload .= insert_indicators34($row[0], $date, $row[9], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Male', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$message_upload .= insert_indicators34($row[0], $date, $row[10], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Female', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$identity_of_perpetrator= '5'; //other relative
$message_upload .= insert_indicators34($row[0], $date, $row[11], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Male', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$message_upload .= insert_indicators34($row[0], $date, $row[12], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Female', $violence_type, $place_of_victimization, $identity_of_perpetrator);

$place_of_victimization = '3'; //outside home
$identity_of_perpetrator = '3'; //teacher
$message_upload .= insert_indicators34($row[0], $date, $row[13], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Male', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$message_upload .= insert_indicators34($row[0], $date, $row[14], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Female', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$identity_of_perpetrator= '1'; //parent
$message_upload .= insert_indicators34($row[0], $date, $row[15], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Male', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$message_upload .= insert_indicators34($row[0], $date, $row[16], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Female', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$identity_of_perpetrator= '2'; //guardian
$message_upload .= insert_indicators34($row[0], $date, $row[17], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Male', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$message_upload .= insert_indicators34($row[0], $date, $row[18], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Female', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$identity_of_perpetrator= '4'; //sibling
$message_upload .= insert_indicators34($row[0], $date, $row[19], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Male', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$message_upload .= insert_indicators34($row[0], $date, $row[20], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Female', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$identity_of_perpetrator= '5'; //other relative
$message_upload .= insert_indicators34($row[0], $date, $row[21], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Male', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$message_upload .= insert_indicators34($row[0], $date, $row[22], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Female', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$identity_of_perpetrator= '7'; //stranger
$message_upload .= insert_indicators34($row[0], $date, $row[23], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Male', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$message_upload .= insert_indicators34($row[0], $date, $row[24], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Female', $violence_type, $place_of_victimization, $identity_of_perpetrator);

$place_of_victimization = '4'; //place of worship
$identity_of_perpetrator = '6'; //religious official
$message_upload .= insert_indicators34($row[0], $date, $row[25], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Male', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$message_upload .= insert_indicators34($row[0], $date, $row[26], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Female', $violence_type, $place_of_victimization, $identity_of_perpetrator);

$place_of_victimization = '5'; //maen of transport
$identity_of_perpetrator = '8'; //operator
$message_upload .= insert_indicators34($row[0], $date, $row[27], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Male', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$message_upload .= insert_indicators34($row[0], $date, $row[28], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Female', $violence_type, $place_of_victimization, $identity_of_perpetrator);

$date = $row[31];
$violence_type = '2'; //molestation
$place_of_victimization = '2'; //school
$identity_of_perpetrator = '3'; //teacher
$message_upload .= insert_indicators34($row[0], $date, $row[32], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Male', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$message_upload .= insert_indicators34($row[0], $date, $row[33], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Female', $violence_type, $place_of_victimization, $identity_of_perpetrator);

$place_of_victimization = '1'; //home
$identity_of_perpetrator= '1'; //parent
$message_upload .= insert_indicators34($row[0], $date, $row[34], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Male', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$message_upload .= insert_indicators34($row[0], $date, $row[35], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Female', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$identity_of_perpetrator= '2'; //guardian
$message_upload .= insert_indicators34($row[0], $date, $row[36], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Male', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$message_upload .= insert_indicators34($row[0], $date, $row[37], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Female', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$identity_of_perpetrator= '4'; //sibling
$message_upload .= insert_indicators34($row[0], $date, $row[38], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Male', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$message_upload .= insert_indicators34($row[0], $date, $row[39], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Female', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$identity_of_perpetrator= '5'; //other relative
$message_upload .= insert_indicators34($row[0], $date, $row[40], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Male', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$message_upload .= insert_indicators34($row[0], $date, $row[41], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Female', $violence_type, $place_of_victimization, $identity_of_perpetrator);

$place_of_victimization = '3'; //outside home
$identity_of_perpetrator = '3'; //teacher
$message_upload .= insert_indicators34($row[0], $date, $row[42], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Male', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$message_upload .= insert_indicators34($row[0], $date, $row[43], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Female', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$identity_of_perpetrator= '1'; //parent
$message_upload .= insert_indicators34($row[0], $date, $row[44], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Male', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$message_upload .= insert_indicators34($row[0], $date, $row[45], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Female', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$identity_of_perpetrator= '2'; //guardian
$message_upload .= insert_indicators34($row[0], $date, $row[46], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Male', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$message_upload .= insert_indicators34($row[0], $date, $row[47], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Female', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$identity_of_perpetrator= '4'; //sibling
$message_upload .= insert_indicators34($row[0], $date, $row[48], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Male', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$message_upload .= insert_indicators34($row[0], $date, $row[49], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Female', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$identity_of_perpetrator= '5'; //other relative
$message_upload .= insert_indicators34($row[0], $date, $row[50], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Male', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$message_upload .= insert_indicators34($row[0], $date, $row[51], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Female', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$identity_of_perpetrator= '7'; //stranger
$message_upload .= insert_indicators34($row[0], $date, $row[52], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Male', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$message_upload .= insert_indicators34($row[0], $date, $row[53], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Female', $violence_type, $place_of_victimization, $identity_of_perpetrator);

$place_of_victimization = '4'; //place of worship
$identity_of_perpetrator = '6'; //religious official
$message_upload .= insert_indicators34($row[0], $date, $row[54], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Male', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$message_upload .= insert_indicators34($row[0], $date, $row[55], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Female', $violence_type, $place_of_victimization, $identity_of_perpetrator);

$place_of_victimization = '5'; //maen of transport
$identity_of_perpetrator = '8'; //operator
$message_upload .= insert_indicators34($row[0], $date, $row[56], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Male', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$message_upload .= insert_indicators34($row[0], $date, $row[57], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Female', $violence_type, $place_of_victimization, $identity_of_perpetrator);

$date = $row[60];
$violence_type = '3'; //Sexual slavery
$place_of_victimization = '2'; //school
$identity_of_perpetrator = '3'; //teacher
$message_upload .= insert_indicators34($row[0], $date, $row[61], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Male', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$message_upload .= insert_indicators34($row[0], $date, $row[62], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Female', $violence_type, $place_of_victimization, $identity_of_perpetrator);

$place_of_victimization = '1'; //home
$identity_of_perpetrator= '1'; //parent
$message_upload .= insert_indicators34($row[0], $date, $row[63], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Male', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$message_upload .= insert_indicators34($row[0], $date, $row[64], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Female', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$identity_of_perpetrator= '2'; //guardian
$message_upload .= insert_indicators34($row[0], $date, $row[65], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Male', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$message_upload .= insert_indicators34($row[0], $date, $row[66], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Female', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$identity_of_perpetrator= '4'; //sibling
$message_upload .= insert_indicators34($row[0], $date, $row[67], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Male', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$message_upload .= insert_indicators34($row[0], $date, $row[68], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Female', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$identity_of_perpetrator= '5'; //other relative
$message_upload .= insert_indicators34($row[0], $date, $row[69], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Male', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$message_upload .= insert_indicators34($row[0], $date, $row[70], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Female', $violence_type, $place_of_victimization, $identity_of_perpetrator);

$place_of_victimization = '3'; //outside home
$identity_of_perpetrator = '3'; //teacher
$message_upload .= insert_indicators34($row[0], $date, $row[71], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Male', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$message_upload .= insert_indicators34($row[0], $date, $row[72], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Female', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$identity_of_perpetrator= '1'; //parent
$message_upload .= insert_indicators34($row[0], $date, $row[73], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Male', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$message_upload .= insert_indicators34($row[0], $date, $row[74], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Female', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$identity_of_perpetrator= '2'; //guardian
$message_upload .= insert_indicators34($row[0], $date, $row[75], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Male', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$message_upload .= insert_indicators34($row[0], $date, $row[76], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Female', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$identity_of_perpetrator= '4'; //sibling
$message_upload .= insert_indicators34($row[0], $date, $row[77], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Male', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$message_upload .= insert_indicators34($row[0], $date, $row[78], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Female', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$identity_of_perpetrator= '5'; //other relative
$message_upload .= insert_indicators34($row[0], $date, $row[79], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Male', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$message_upload .= insert_indicators34($row[0], $date, $row[80], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Female', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$identity_of_perpetrator= '7'; //stranger
$message_upload .= insert_indicators34($row[0], $date, $row[81], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Male', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$message_upload .= insert_indicators34($row[0], $date, $row[82], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Female', $violence_type, $place_of_victimization, $identity_of_perpetrator);

$place_of_victimization = '4'; //place of worship
$identity_of_perpetrator = '6'; //religious official
$message_upload .= insert_indicators34($row[0], $date, $row[83], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Male', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$message_upload .= insert_indicators34($row[0], $date, $row[84], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Female', $violence_type, $place_of_victimization, $identity_of_perpetrator);

$place_of_victimization = '5'; //maen of transport
$identity_of_perpetrator = '8'; //operator
$message_upload .= insert_indicators34($row[0], $date, $row[85], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Male', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$message_upload .= insert_indicators34($row[0], $date, $row[86], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Female', $violence_type, $place_of_victimization, $identity_of_perpetrator);

$date = $row[89];
$violence_type = '4'; //Forced Marriage
$place_of_victimization = '2'; //school
$identity_of_perpetrator = '3'; //teacher
$message_upload .= insert_indicators34($row[0], $date, $row[90], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Male', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$message_upload .= insert_indicators34($row[0], $date, $row[91], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Female', $violence_type, $place_of_victimization, $identity_of_perpetrator);

$place_of_victimization = '1'; //home
$identity_of_perpetrator= '1'; //parent
$message_upload .= insert_indicators34($row[0], $date, $row[92], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Male', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$message_upload .= insert_indicators34($row[0], $date, $row[93], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Female', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$identity_of_perpetrator= '2'; //guardian
$message_upload .= insert_indicators34($row[0], $date, $row[94], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Male', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$message_upload .= insert_indicators34($row[0], $date, $row[95], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Female', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$identity_of_perpetrator= '4'; //sibling
$message_upload .= insert_indicators34($row[0], $date, $row[96], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Male', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$message_upload .= insert_indicators34($row[0], $date, $row[97], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Female', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$identity_of_perpetrator= '5'; //other relative
$message_upload .= insert_indicators34($row[0], $date, $row[98], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Male', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$message_upload .= insert_indicators34($row[0], $date, $row[99], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Female', $violence_type, $place_of_victimization, $identity_of_perpetrator);

$place_of_victimization = '3'; //outside home
$identity_of_perpetrator = '3'; //teacher
$message_upload .= insert_indicators34($row[0], $date, $row[100], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Male', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$message_upload .= insert_indicators34($row[0], $date, $row[101], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Female', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$identity_of_perpetrator= '1'; //parent
$message_upload .= insert_indicators34($row[0], $date, $row[102], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Male', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$message_upload .= insert_indicators34($row[0], $date, $row[103], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Female', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$identity_of_perpetrator= '2'; //guardian
$message_upload .= insert_indicators34($row[0], $date, $row[104], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Male', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$message_upload .= insert_indicators34($row[0], $date, $row[105], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Female', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$identity_of_perpetrator= '4'; //sibling
$message_upload .= insert_indicators34($row[0], $date, $row[106], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Male', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$message_upload .= insert_indicators34($row[0], $date, $row[107], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Female', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$identity_of_perpetrator= '5'; //other relative
$message_upload .= insert_indicators34($row[0], $date, $row[108], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Male', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$message_upload .= insert_indicators34($row[0], $date, $row[109], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Female', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$identity_of_perpetrator= '7'; //stranger
$message_upload .= insert_indicators34($row[0], $date, $row[110], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Male', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$message_upload .= insert_indicators34($row[0], $date, $row[111], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Female', $violence_type, $place_of_victimization, $identity_of_perpetrator);

$place_of_victimization = '4'; //place of worship
$identity_of_perpetrator = '6'; //religious official
$message_upload .= insert_indicators34($row[0], $date, $row[112], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Male', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$message_upload .= insert_indicators34($row[0], $date, $row[113], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Female', $violence_type, $place_of_victimization, $identity_of_perpetrator);

$place_of_victimization = '5'; //maen of transport
$identity_of_perpetrator = '8'; //operator
$message_upload .= insert_indicators34($row[0], $date, $row[114], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Male', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$message_upload .= insert_indicators34($row[0], $date, $row[115], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Female', $violence_type, $place_of_victimization, $identity_of_perpetrator);

$date = $row[118];
$violence_type = '5'; //Forced Sexual Acts
$place_of_victimization = '2'; //school
$identity_of_perpetrator = '3'; //teacher
$message_upload .= insert_indicators34($row[0], $date, $row[119], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Male', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$message_upload .= insert_indicators34($row[0], $date, $row[120], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Female', $violence_type, $place_of_victimization, $identity_of_perpetrator);

$place_of_victimization = '1'; //home
$identity_of_perpetrator= '1'; //parent
$message_upload .= insert_indicators34($row[0], $date, $row[121], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Male', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$message_upload .= insert_indicators34($row[0], $date, $row[122], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Female', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$identity_of_perpetrator= '2'; //guardian
$message_upload .= insert_indicators34($row[0], $date, $row[123], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Male', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$message_upload .= insert_indicators34($row[0], $date, $row[124], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Female', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$identity_of_perpetrator= '4'; //sibling
$message_upload .= insert_indicators34($row[0], $date, $row[125], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Male', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$message_upload .= insert_indicators34($row[0], $date, $row[126], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Female', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$identity_of_perpetrator= '5'; //other relative
$message_upload .= insert_indicators34($row[0], $date, $row[127], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Male', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$message_upload .= insert_indicators34($row[0], $date, $row[128], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Female', $violence_type, $place_of_victimization, $identity_of_perpetrator);

$place_of_victimization = '3'; //outside home
$identity_of_perpetrator = '3'; //teacher
$message_upload .= insert_indicators34($row[0], $date, $row[129], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Male', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$message_upload .= insert_indicators34($row[0], $date, $row[130], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Female', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$identity_of_perpetrator= '1'; //parent
$message_upload .= insert_indicators34($row[0], $date, $row[131], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Male', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$message_upload .= insert_indicators34($row[0], $date, $row[132], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Female', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$identity_of_perpetrator= '2'; //guardian
$message_upload .= insert_indicators34($row[0], $date, $row[133], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Male', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$message_upload .= insert_indicators34($row[0], $date, $row[134], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Female', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$identity_of_perpetrator= '4'; //sibling
$message_upload .= insert_indicators34($row[0], $date, $row[135], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Male', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$message_upload .= insert_indicators34($row[0], $date, $row[136], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Female', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$identity_of_perpetrator= '5'; //other relative
$message_upload .= insert_indicators34($row[0], $date, $row[137], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Male', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$message_upload .= insert_indicators34($row[0], $date, $row[138], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Female', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$identity_of_perpetrator= '7'; //stranger
$message_upload .= insert_indicators34($row[0], $date, $row[139], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Male', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$message_upload .= insert_indicators34($row[0], $date, $row[140], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Female', $violence_type, $place_of_victimization, $identity_of_perpetrator);

$place_of_victimization = '4'; //place of worship
$identity_of_perpetrator = '6'; //religious official
$message_upload .= insert_indicators34($row[0], $date, $row[141], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Male', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$message_upload .= insert_indicators34($row[0], $date, $row[142], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Female', $violence_type, $place_of_victimization, $identity_of_perpetrator);

$place_of_victimization = '5'; //maen of transport
$identity_of_perpetrator = '8'; //operator
$message_upload .= insert_indicators34($row[0], $date, $row[143], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Male', $violence_type, $place_of_victimization, $identity_of_perpetrator);
$message_upload .= insert_indicators34($row[0], $date, $row[144], $user->id, $date_created, '34', $db, $row[1], $indicator_name, 'Female', $violence_type, $place_of_victimization, $identity_of_perpetrator);

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
	    }      
	} else{
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
function validate_data_indicator29_30_31_32_33_36($county_id, $date, $aggregate1, $aggregate2, $column_date, $columns_aggregate, $row){
    if($county_id === ""){
        return "ERROR: Wrong file format. County id is not defined (row " . $row . ").\n"; //wrong format
    }
    if($date !== ""){
        //validate date format
        if(!validateDate($date)){
            return "ERROR: Date format is wrong  (column " . $column_date . ", row " . $row . "). Must be MM/YYYY.\n"; //date format is wrong
        }
        if($aggregate1 === "" && $aggregate2 === ""){
            return "ERROR: All aggregates are empty (columns " . $columns_aggregate . ", row " . $row . "). Please insert values.\n"; //empty aggregate
        }
    }else if($aggregate1 !== "" || $aggregate2 !== ""){
        return "ERROR: Date is empty (column " . $column_date . ", row " . $row . ").\n"; //empty date;
    }
    return "";
}

/*
 * returns empty message if success or error message
 */
function validate_data_indicator34($county_id, $date, $aggregate1, $aggregate2, $aggregate3, $aggregate4, $aggregate5, $aggregate6, $aggregate7, $aggregate8, $aggregate9, $aggregate10, $aggregate11, $aggregate12,
    $aggregate13, $aggregate14, $aggregate15, $aggregate16,$aggregate17, $aggregate18,$aggregate19, $aggregate20,$aggregate21, $aggregate22,$aggregate23,$aggregate24,$aggregate25,$aggregate26,
    $column_date, $columns_aggregate, $row){
    if($county_id === ""){
        return "ERROR: Wrong file format. County id is not defined (row " . $row . ").\n"; //wrong format
    }
    if($date !== ""){
        //validate date format
        if(!validateDate($date)){
            return "ERROR: Date format is wrong  (column " . $column_date . ", row " . $row . "). Must be MM/YYYY.\n"; //date format is wrong
        }
        if($aggregate1 === "" && $aggregate2 === "" && $aggregate3 === "" && $aggregate4 === "" && $aggregate5 === "" && $aggregate6 === ""
            && $aggregate7 === "" && $aggregate8 === "" && $aggregate9 === "" && $aggregate10 === "" && $aggregate11 === "" && $aggregate12 === ""
            && $aggregate13 === "" && $aggregate14 === "" && $aggregate15 === "" && $aggregate16 === "" && $aggregate17 === "" && $aggregate18 === "" && $aggregate19 === "" && $aggregate20 === ""
            && $aggregate21 === "" && $aggregate22 === "" && $aggregate23 === "" && $aggregate24 === "" && $aggregate25 === "" && $aggregate26 === ""){
            return "ERROR: All aggregates are empty (columns " . $columns_aggregate . ", row " . $row . "). Please insert values.\n"; //empty aggregate
        }
    }else if($aggregate1 !== "" || $aggregate2 !== "" || $aggregate3 !== "" || $aggregate4 !== "" || $aggregate5 !== "" || $aggregate6 !== "" || $aggregate7 !== "" || $aggregate8 !== ""
         || $aggregate9 !== "" || $aggregate10 !== "" || $aggregate11 !== "" || $aggregate12 !== "" || $aggregate13 !== "" || $aggregate14 !== "" || $aggregate15 !== "" || $aggregate16 !== ""
         || $aggregate17 !== "" || $aggregate18 !== "" || $aggregate19 !== "" || $aggregate20 !== "" || $aggregate21 !== "" || $aggregate22 !== "" || $aggregate23 !== "" || $aggregate24 !== ""
         || $aggregate25 !== "" || $aggregate26 !== ""){
        return "ERROR: Date is empty (column " . $column_date . ", row " . $row . ").\n"; //empty date;
    }
    return "";
}


function insert_indicators31_32_33_36($county_id, $date, $aggregate, $user_id, $date_created, $indicator_id, $db, $county_name, $indicator, $sex){
    if($date !== "" && $aggregate != ""  && $aggregate !== '0'){
        $data['timestamp_created'] = "'" . $date_created . "'";
        $data['county_id'] = $county_id;
        $data['indicator_id'] = $indicator_id;
        $data['aggregate'] = $aggregate;
        $data['sex'] = "'" . $sex . "'";
        $data['created_by'] = $user_id;
        $date_arr = explode("/", $date);
        $date_new = $date_arr[1] ."-" .  $date_arr[0] . "-01"; //YYYY-MM-DD in database
        $data['date'] = "'" . $date_new . "'";
        if($db->insertData($data, "education_aggregates")){
            return "County: " . $county_name . "; Indicator: '" .  $indicator . "'; Aggregates:" . $aggregate . ".\n";
        }else{
            return "ERROR date not inserted => County:" . $county_name . "; Indicator: '"  .  $indicator . "' Aggregates:" . $aggregate . ".\n";
        }
    }
}

function insert_indicators34($county_id, $date, $aggregate, $user_id, $date_created, $indicator_id, $db, $county_name, $indicator, $sex,
    $violence_type, $place_of_victimization, $identity_of_perpetrator){
    if($date !== "" && $aggregate != ""  && $aggregate !== '0'){
        $data['timestamp_created'] = "'" . $date_created . "'";
        $data['county_id'] = $county_id;
        $data['indicator_id'] = $indicator_id;
        $data['aggregate'] = $aggregate;
        $data['sex'] = "'" . $sex . "'";
        $data['created_by'] = $user_id;
        $date_arr = explode("/", $date);
        $date_new = $date_arr[1] ."-" .  $date_arr[0] . "-01"; //YYYY-MM-DD in database
        $data['date'] = "'" . $date_new . "'";
        $data['age'] = "'" . "<18 Yrs" . "'";
        $data['violence_type'] = $violence_type;
        $data['place_of_victimization'] = $place_of_victimization;
        $data['identity_of_perpetrator'] = $identity_of_perpetrator;
        if($db->insertData($data, "education_aggregates")){
            return "County: " . $county_name . "; Indicator: '" .  $indicator . "'; Aggregates:" . $aggregate . ".\n";
        }else{
            return "ERROR date not inserted => County:" . $county_name . "; Indicator: '"  .  $indicator . "' Aggregates:" . $aggregate . ".\n";
        }
    }
}

function insert_indicators29_30($county_id, $date, $aggregate, $user_id, $date_created, $indicator_id, $db, $county_name, $indicator, $ownership){
    if($date !== "" && $aggregate != ""  && $aggregate !== '0'){
        $data['timestamp_created'] = "'" . $date_created . "'";
        $data['county_id'] = $county_id;
        $data['indicator_id'] = $indicator_id;
        $data['aggregate'] = $aggregate;
        $data['ownership'] = $ownership;
        $data['created_by'] = $user_id;
        $date_arr = explode("/", $date);
        $date_new = $date_arr[1] ."-" .  $date_arr[0] . "-01"; //YYYY-MM-DD in database
        $data['date'] = "'" . $date_new . "'";
        if($db->insertData($data, "education_aggregates")){
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
        if($db->insertData($data, "education_aggregates")){
            return "County: " . $county_name . "; Indicator: '" .  $indicator . "'; Aggregates:" . $aggregate . "\n";
        }else{
            return "ERROR date not inserted => County:" . $county_name . "; Indicator: '"  .  $indicator . "' Aggregates:" . $aggregate . "\n";
        }
    }
     
}
?>