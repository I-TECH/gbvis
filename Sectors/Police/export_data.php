<?php
//TA:60:4
$page_title = "Export Data | Police Sector | GBV";
$current_page = "home";

require_once 'includes/global.inc.php';

if (isset ( $_SESSION ['logged_in'] )) {
	
	$user = unserialize ( $_SESSION ['user'] );
	

    if( !($userTools->isSuperAdmin($user->user_group) || ($userTools->isAdmin($user->user_group) &&  $user->sector === '3'))){
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
	//'ranks' table ids
	$ranks['1'] = "";
	$ranks['2'] = "";
	$ranks['3'] = "";
	$ranks['4'] = "";
	$ranks['5'] = "";
	$ranks['6'] = "";
	$ranks['7'] = "";
	$ranks['8'] = "";
	$ranks['9'] = "";
	$ranks['10'] = "";
	$ranks['11'] = "";
	$ranks['12'] = "";
	$ranks['14'] = "";
	$ranks['23'] = "";
	//prepare output rows for all counties
	$print_data = array();
	if($indicator === '5.2'){
	    foreach ($counties as $urows) {
	        $print_data[$urows['0']] = array('county_id_name' => $urows['0'] . "," . $urows['1'], 'dates'=>',', '27'=>array('MALE'=>$ranks, 'FEMALE'=>$ranks));
	    }
	}else  if($indicator === '5.1,5.3,5.4'){
	    foreach ($counties as $urows) {
	        $print_data[$urows['0']] = array('county_id_name' => $urows['0'] . "," . $urows['1'], 'dates'=>',', '22'=>'', '23'=>'' , '24'=>'', '25'=>'');
	    }
	}
	
	
	if($mode === 'export_csv'){
	    
	  //  print "Under development."; return;
	    
	    if($indicator === '5.2'){
	    
	    $filename="Police_indicator_5.2_SGBVIS_data_export_sheet.csv";
	    header("Content-disposition: attachment;filename=$filename");
	    
	    print "County Code,County Name,From Date (MM/YYYY),To Date (MM/YYYY),Number of police who have been trained to respond and investigate cases of SGBV,,,,,,,,,,,,,,,,,,,,,,,,,,\n";
	    print ",,,,Inspector-General,,Deputy Inspector-General,,Senior Assistant Inspector,,Assistant Inspector-General,,Senior Superintendent,,Superintendent,,Assistant Superintendent,,Chief Inspector,,Inspector,,Senior Sergeant,,Sergeant,,Constable,,Commissioner,,Corporal\n";
	    print ",,,,Male,Female,Male,Female,Male,Female,Male,Female,Male,Female,Male,Female,Male,Female,Male,Female,Male,Female,Male,Female,Male,Female,Male,Female,Male,Female,Male,Female\n";
	    
	    //indicator 27
	    $result = mysql_query("select counties.county_id, counties.county_name, ranks.id as rank_id, ranks.rank,
sum(police_aggregates.aggregate) as aggregate, police_aggregates.sex from police_aggregates
join ranks on ranks.id=police_aggregates.rank
join counties on police_aggregates.county_id=counties.county_id
where indicator_id=27 and police_aggregates.date BETWEEN '" . $start_date_new . "' AND '" . $end_date_new . "'
group by police_aggregates.sex, ranks.rank, counties.county_id
order by counties.county_id, police_aggregates.sex, ranks.id");
	    //output: county_id, county_name, cadre_id, cadre, aggreagte, sex
	    // !!!! rank ordered by id, the same way as in "ranks" table, suppose that Excel has the same rank order
	    $data=$db->processRowSet($result);
	    foreach ( $data as $row ) {
	        $print_data[$row['county_id']]['27'][strtoupper($row['sex'])][$row['rank_id']] = $row['aggregate'];
	        $print_data[$row['county_id']]['dates']= $start_date . "," . $end_date;
	    }
	    foreach ( $print_data as $row ) {
	        print $row['county_id_name'] .  "," . $row['dates']  . "," . implode(",", $row['27']['MALE']) . "," . implode(",", $row['27']['FEMALE']) ."\n";
	    }
	    
	    readfile($filename);
	    }else if($indicator === '5.1,5.3,5.4'){
	        $filename="Police_indicator_5.1,5.3,5.4_SGBVIS_data_export_sheet.csv";
	        header("Content-disposition: attachment;filename=$filename");
	        
	        print "County Code,County Name,From Date (MM/YYYY),To Date (MM/YYYY),Total number of police stations surveyed,Number of police stations with a functional gender desk,Number of SGBV cases reported to National Police Service (NPS),Number of SGBV cases investigated by the national police\n";
	        //indicator 22, 23, 24, 25
	        $indicators = array('22', '23', '24', '25');
	        for($i=0; $i<count($indicators); $i++){
	            $result = mysql_query("select counties.county_id, counties.county_name,
sum(police_aggregates.aggregate) as aggregate from police_aggregates
join counties on police_aggregates.county_id=counties.county_id
where indicator_id=" . $indicators[$i] . " and police_aggregates.date BETWEEN '" . $start_date_new . "' AND '" . $end_date_new . "'
group by counties.county_id
order by counties.county_id");
	            //output: county_id, county_name, aggreagte
	            $data=$db->processRowSet($result);
	            foreach ( $data as $row ) {
	                $print_data[$row['county_id']][$indicators[$i]] = $row['aggregate'];
	                $print_data[$row['county_id']]['dates']= $start_date . "," . $end_date;
	            }
	        }
	         
	        foreach ( $print_data as $row ) {
	            print $row['county_id_name'] .  "," . $row['dates']  .
	            "," . $row['22'] .   "," . $row['23'] .  "," . $row['24'] . "," . $row['25'] ."\n";
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