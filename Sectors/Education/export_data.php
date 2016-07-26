<?php
//TA:60:4
$page_title = "Export Data | Education Sector | GBV";
$current_page = "home";

require_once 'includes/global.inc.php';

if (isset ( $_SESSION ['logged_in'] )) {
	
	$user = unserialize ( $_SESSION ['user'] );
	
    if( !($userTools->isSuperAdmin($user->user_group) || ($userTools->isAdmin($user->user_group) &&  $user->sector === '5'))){
        print " You do not have permission to access this page.";
        return;
    }
	
	$mode = $_GET['mode'];
	$indicator = $_GET['indicator'];
	$start_date = $_GET['start_date'];
	$end_date = $_GET['end_date'];
	
	$date_arr = explode("/", $start_date);
	$start_date_new = $date_arr[1] ."-" .  $date_arr[0] . "-01"; //YYYY-MM-DD in database
	$date_arr = explode("/", $end_date);
	$end_date_new = $date_arr[1] ."-" .  $date_arr[0] . "-01"; //YYYY-MM-DD in database
	
	$db = new DB();
	$counties = $db->selectAllOrdered("counties", "county_id");
	//print_r($counties);
	
	//prepare data to show indicator 8.4 data, example: 'Rape' at 'School' by 'Stranger' who 'Male' = aggregate (array of array of array of array)
	
	//by the spec genders is lowest level of the output report
	$gender['MALE'] = "";
	$gender['FEMALE'] = "";
	
	//by the spec array $gender inserted into each element of array $identity_of_perpetrator
	//key is id column from 'identity_of_perpetrator' table
// 	$identity_of_perpetrator['1'] = $gender;//Parent
// 	$identity_of_perpetrator['2'] = $gender; // Guardian
// 	$identity_of_perpetrator['3'] = $gender; //Teacher
// 	$identity_of_perpetrator['4'] = $gender; //Sibling
// 	$identity_of_perpetrator['5'] = $gender; //Relative
// 	$identity_of_perpetrator['6'] = $gender; //Religious official
// 	$identity_of_perpetrator['7'] = $gender; //Stranger
// 	$identity_of_perpetrator['8'] = $gender; //Operator
	
	$school_identity_of_perpetrator['3'] = $gender;//Teacher
	
	$home_identity_of_perpetrator['1'] = $gender;//Parent
	$home_identity_of_perpetrator['2'] = $gender; // Guardian
	$home_identity_of_perpetrator['4'] = $gender; //Sibling
	$home_identity_of_perpetrator['5'] = $gender; //Relative
	
	$outside_home_identity_of_perpetrator['3'] = $gender; //Teacher
	$outside_home_identity_of_perpetrator['1'] = $gender;//Parent
	$outside_home_identity_of_perpetrator['2'] = $gender; // Guardian
	$outside_home_identity_of_perpetrator['4'] = $gender; //Sibling
	$outside_home_identity_of_perpetrator['5'] = $gender; //Relative
	$outside_home_identity_of_perpetrator['7'] = $gender; //Stranger
	
	$worship_identity_of_perpetrator['6'] = $gender; //Religious official
	
	$transport_identity_of_perpetrator['8'] = $gender; //Operator
	
	//by the spec array $identity_of_perpetrator inserted into each element of array $place_of_victimization
	//key is id column from 'place_of_victimization' table
	//not all identity_of_perpetrator inserted it depends on place (see spec)
	
	$place_of_victimization['2'] = $school_identity_of_perpetrator; //School
	$place_of_victimization['1'] = $home_identity_of_perpetrator; //Home
 	$place_of_victimization['3'] = $outside_home_identity_of_perpetrator; //out side home
 	$place_of_victimization['4'] = $worship_identity_of_perpetrator; //place of worship
 	$place_of_victimization['5'] = $transport_identity_of_perpetrator; //transport
 	
 	//by the spec array $place_of_victimization inserted into each element of array $violence_types
 	//key is id column from 'violence_types' table
 	$violence_types['1'] = $place_of_victimization;
 	$violence_types['2'] = $place_of_victimization;
 	$violence_types['3'] = $place_of_victimization;
 	$violence_types['4'] = $place_of_victimization;
 	$violence_types['5'] = $place_of_victimization;
	
	//prepare output rows for all counties
	$print_data = array();
	if($indicator === '8.1-8.3'){
	    foreach ($counties as $urows) {
	        $print_data[$urows['0']] = array('county_id_name' => $urows['0'] . "," . $urows['1'], 'dates'=>',', 
	        '36'=>array('MALE'=>'', 'FEMALE'=>''), 
	        '33'=>array('MALE'=>'', 'FEMALE'=>''),
	        '30'=>array('PRIVATE'=>'', 'PUBLIC'=>''),
	        '29'=>array('PRIVATE'=>'', 'PUBLIC'=>''),
	        '31'=>array('MALE'=>'', 'FEMALE'=>''),
	        '32'=>array('MALE'=>'', 'FEMALE'=>'')
	    );
	    }
	}else  if($indicator === '8.4'){
	    foreach ($counties as $urows) {
	        $print_data[$urows['0']] = array('county_id_name' => $urows['0'] . "," . $urows['1'], 'dates'=>',', 
	            '34'=>$violence_types);
	    }
	}
	    
	 //   print_r($print_data);
	
	
	if($mode === 'export_csv'){
	    
	    //print "Under development."; return;
	    
	    if($indicator === '8.1-8.3'){ 
	        $filename="Education_indicator_8.1-8.3_SGBVIS_data_export_sheet.csv";
	        header("Content-disposition: attachment;filename=$filename");
	        
            print "County Code,County Name,From date (MM/YYYY),To date (MM/YYYY),Number of teachers and secretariat staff trained in SGBV,,Number of  MOEST staff trained in SGBV,,Total Number of schools surveyed,,Number of schools implementing life skills curriculum that teaches students on what to do in case of violation,,Total number of children in the sample,,Number of children who possess life skills,\n";
            print ",,,,Male,Female,Male,Female,Private,Public,Private,Public,Male,Female,Male,Female\n";

	        //indicator '36', '33', '32', '31'
	        $indicators = array('36', '33', '32', '31');
	        for($i=0; $i<count($indicators); $i++){
	            $result = mysql_query("select counties.county_id, counties.county_name, 
sum(education_aggregates.aggregate) as aggregate, education_aggregates.sex from education_aggregates
join counties on education_aggregates.county_id=counties.county_id
where indicator_id=" . $indicators[$i] . " and education_aggregates.date BETWEEN '" . $start_date_new . "' AND '" . $end_date_new . "'
group by education_aggregates.sex, counties.county_id
order by counties.county_id, education_aggregates.sex");
	            //output: county_id, county_name, aggreagte
	            $data=$db->processRowSet($result);
	            foreach ( $data as $row ) {
	                $print_data[$row['county_id']][$indicators[$i]][strtoupper($row['sex'])] = $row['aggregate'];
	                $print_data[$row['county_id']]['dates']= $start_date . "," . $end_date;
	            }
	        }
	        
	        //indicator 16, 17
	        $indicators = array('30', '29');
	        for($i=0; $i<count($indicators); $i++){
	            $result = mysql_query("select counties.county_id, counties.county_name, ownerships.id as ownerships_id, ownerships.ownership,
sum(education_aggregates.aggregate) as aggregate from education_aggregates
join ownerships on ownerships.id=education_aggregates.ownership
join counties on education_aggregates.county_id=counties.county_id
where indicator_id=" . $indicators[$i] . " and education_aggregates.date BETWEEN '" . $start_date_new . "' AND '" . $end_date_new . "'
group by ownerships.ownership, counties.county_id
order by counties.county_id, ownerships.id");
	            //output: county_id, county_name, aggreagte
	            $data=$db->processRowSet($result);
	            foreach ( $data as $row ) {
	                $print_data[$row['county_id']][$indicators[$i]][strtoupper($row['ownership'])] = $row['aggregate'];
	                $print_data[$row['county_id']]['dates']= $start_date . "," . $end_date;
	            }
	        }
	        
	        foreach ( $print_data as $row ) {
	            print $row['county_id_name'] .  "," . $row['dates']  . "," .
	   	            $row['36']['MALE'] . "," . $row['36']['FEMALE'] . "," .
	   	            $row['33']['MALE'] . "," . $row['33']['FEMALE'] . "," .
	   	            $row['30']['PRIVATE'] . "," . $row['30']['PUBLIC'] . "," .
	                $row['29']['PRIVATE'] . "," . $row['29']['PUBLIC'] . "," .
	                $row['31']['MALE'] . "," . $row['31']['FEMALE'] . "," .
	                $row['32']['MALE'] . "," . $row['32']['FEMALE'] . "\n";
	        }
	        
	        readfile($filename);
	        
	    }else if($indicator === '8.4'){ 
	       $filename="Education_indicator_8.4_SGBVIS_data_export_sheet.csv";
	       header("Content-disposition: attachment;filename=$filename");
// 	       // print "Under development."; return;
	       
	       print "Number of children who report being victims of violence in the last 12 months ,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,\n";
print "County Code,County Name,From Date (MM/YYYY),To Date (MM/YYYY),Rape,,,,,,,,,,,,,,,,,,,,,,,,,,Molestation,,,,,,,,,,,,,,,,,,,,,,,,,,Sexual slavery,,,,,,,,,,,,,,,,,,,,,,,,,,Forced Marriage,,,,,,,,,,,,,,,,,,,,,,,,,,Forced Sexual Acts,,,,,,,,,,,,,,,,,,,,,,,,,,\n";
print ",,,,School,,Home,,,,,,,,Outside the Home,,,,,,,,,,,,Place of worship,,Means of transport,,School,,Home,,,,,,,,Outside the Home,,,,,,,,,,,,Place of worship,,Means of transport,,School,,Home,,,,,,,,Outside the Home,,,,,,,,,,,,Place of worship,,Means of transport,,School,,Home,,,,,,,,Outside the Home,,,,,,,,,,,,Place of worship,,Means of transport,,School,,Home,,,,,,,,Outside the Home,,,,,,,,,,,,Place of worship,,Means of transport,,\n";
print ",,,,Teacher,,Parent,,Guardian,,Sibling,,Other relative,,Teacher,,Parent,,Guardian,,Sibling,,Other relative,,Stranger,,Religious Official,,Operator,,Teacher,,Parent,,Guardian,,Sibling,,Other relative,,Teacher,,Parent,,Guardian,,Sibling,,Other relative,,Stranger,,Religious Official,,Operator,,Teacher,,Parent,,Guardian,,Sibling,,Other relative,,Teacher,,Parent,,Guardian,,Sibling,,Other relative,,Stranger,,Religious Official,,Operator,,Teacher,,Parent,,Guardian,,Sibling,,Other relative,,Teacher,,Parent,,Guardian,,Sibling,,Other relative,,Stranger,,Religious Official,,Operator,,Teacher,,Parent,,Guardian,,Sibling,,Other relative,,Teacher,,Parent,,Guardian,,Sibling,,Other relative,,Stranger,,Religious Official,,Operator,,\n";
print ",,,,<18 yrs,,<18 yrs,,<18 yrs,,<18 yrs,,<18 yrs,,<18 yrs,,<18 yrs,,<18 yrs,,<18 yrs,,<18 yrs,,<18 yrs,,<18 yrs,,<18 yrs,,<18 yrs,,<18 yrs,,<18 yrs,,<18 yrs,,<18 yrs,,<18 yrs,,<18 yrs,,<18 yrs,,<18 yrs,,<18 yrs,,<18 yrs,,<18 yrs,,<18 yrs,,<18 yrs,,<18 yrs,,<18 yrs,,<18 yrs,,<18 yrs,,<18 yrs,,<18 yrs,,<18 yrs,,<18 yrs,,<18 yrs,,<18 yrs,,<18 yrs,,<18 yrs,,<18 yrs,,<18 yrs,,<18 yrs,,<18 yrs,,<18 yrs,,<18 yrs,,<18 yrs,,<18 yrs,,<18 yrs,,<18 yrs,,<18 yrs,,<18 yrs,,<18 yrs,,<18 yrs,,<18 yrs,,<18 yrs,,<18 yrs,,<18 yrs,,<18 yrs,,<18 yrs,,<18 yrs,,<18 yrs,,<18 yrs,,<18 yrs,,<18 yrs,,<18 yrs,,\n";
print ",,,,Male,Female,Male,Female,Male,Female,Male,Female,Male,Female,Female,Male,Female,Male,Female,Female,Male,Female,Male,Female,Male,Female,Male,Female,Male,Female,Male,Female,Male,Female,Male,Female,Male,Female,Male,Female,Female,Male,Female,Male,Female,Female,Male,Female,Male,Female,Male,Female,Male,Female,Male,Female,Male,Female,Male,Female,Male,Female,Male,Female,Male,Female,Female,Male,Female,Male,Female,Female,Male,Female,Male,Female,Male,Female,Male,Female,Male,Female,Male,Female,Male,Female,Male,Female,Male,Female,Male,Female,Female,Male,Female,Male,Female,Female,Male,Female,Male,Female,Male,Female,Male,Female,Male,Female,Male,Female,Male,Female,Male,Female,Male,Female,Male,Female,Female,Male,Female,Male,Female,Female,Male,Female,Male,Female,Male,Female,Male,Female,Male,Female\n";
	       
        //indicator 34
        $result = mysql_query("select counties.county_id, counties.county_name,sex, 
violence_types.id as violence_type_id, violence_types.violence_type,
identity_of_perpetrator.id as identity_of_perpetrator_id, identity_of_perpetrator.identity,
place_of_victimization.id as place_of_victimization_id, place_of_victimization.place,
sum(education_aggregates.aggregate) as aggregate from education_aggregates
join violence_types on violence_types.id=education_aggregates.violence_type
join identity_of_perpetrator on education_aggregates.identity_of_perpetrator = identity_of_perpetrator.id
join place_of_victimization on education_aggregates.place_of_victimization = place_of_victimization.id
join counties on education_aggregates.county_id=counties.county_id
where indicator_id=34
and education_aggregates.date BETWEEN '" . $start_date_new . "' AND '" . $end_date_new . "'
group by violence_types.id, identity_of_perpetrator.id, place_of_victimization.id, counties.county_id
order by counties.county_id, violence_types.id, identity_of_perpetrator.id, place_of_victimization.id");
        $data=$db->processRowSet($result);
       // print_r($data); return;
        foreach ( $data as $row ) {
            $print_data[$row['county_id']]['34'][$row['violence_type_id']][$row['place_of_victimization_id']][$row['identity_of_perpetrator_id']][strtoupper($row['sex'])] = $row['aggregate'];
            $print_data[$row['county_id']]['dates']= $start_date . "," . $end_date;
        }
       // print_r($print_data); return;
	    foreach ( $print_data as $row ) {
               print $row['county_id_name'] .  "," . $row['dates']  . ",";
               foreach ( $row['34'] as $row2 ) {
                   foreach ( $row2 as $row3 ) {
                       foreach ( $row3 as $row4 ) {
                           print $row4['MALE'] . "," . $row4['FEMALE']. ",";
                          // print implode(",", $row4);
                       }
                   }
               }
               print "\n";
           }
        
        readfile($filename);
	        
	    }else{
	        print "ERROR: No indicator is selected.";
	    }
	}else{
	    print "ERROR: No mode is selected.";
	}
	
	
 
	}else{
	//Redirect user back to login page if there is no valid session created
	header("Location: ../../login.php");
}





 
       

?>