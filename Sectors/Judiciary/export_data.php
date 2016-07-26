<?php
//TA:60:4
$page_title = "Export Data | Judiciary Sector | GBV";
$current_page = "home";

require_once 'includes/global.inc.php';

if (isset ( $_SESSION ['logged_in'] )) {
	
	$user = unserialize ( $_SESSION ['user'] );
	
if( !($userTools->isSuperAdmin($user->user_group) || ($userTools->isAdmin($user->user_group) &&  $user->sector === '1'))){
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
	//'cadres' table ids
	$cadres['4'] = "";
	$cadres['5'] = "";
	$cadres['6'] = "";
	$cadres['7'] = "";
	$cadres['8'] = "";
	$cadres['9'] = "";
	$cadres['10'] = "";
	$cadres['11'] = "";
	$cadres['12'] = "";
	$cadres['13'] = "";
	$cadres['14'] = "";
	//print_r($counties);
	//prepare output rows for all counties
	$print_data = array();
	foreach ($counties as $urows) {
 	    $print_data[$urows['0']] = array('county_id_name' => $urows['0'] . "," . $urows['1'], 'dates'=>',', '28'=>array('MALE'=>$cadres, 'FEMALE'=>$cadres), '7'=>'', '8'=>'', '9'=>'', '10'=>'');
	}
	
	if($mode === 'export_csv'){
	    
	//    print "Under development."; return;
	   if($indicator === '7.1-7.4'){
	    
	    $filename="Judiciary_SGBVIS_data_export_sheet.csv";
	    header("Content-disposition: attachment;filename=$filename");
	    
	    print "County Code,County Name,From Date (MM/YYYY),To Date (MM/YYYY),Number of judges/magistrates trained in SGVB,,,,,,,,,,,,,,,,,,,,,,Number of prosecuted SGBV cases,Number of prosecuted SGBV cases withdrawn,Number of prosecuted SGBV cases that resulted in a conviction,Average time to conclude a SGBV case (weeks)\n";
	    print ",,,,Male,,,,,,,,,,,Female,,,,,,,,,,,,,,\n";
	    print ",,,,Supreme Court Judge, Court of Appeal Judge, High Court Judge,Chief Magistrate,Senior Principal Magistrate,Principal Magistrate,Senior Resident Magistrate, Resident Magistrate,Chief Kadhi,Deputy Chief Kadhi,Kadhi,Supreme Court Judge, Court of Appeal Judge, High Court Judge,Chief Magistrate,Senior Principal Magistrate,Principal Magistrate,Senior Resident Magistrate, Resident Magistrate,Chief Kadhi,Deputy Chief Kadhi,Kadhi,,,,\n";
	    
	    //indicator 28
	    $result = mysql_query("select counties.county_id, counties.county_name, cadres.id as cadre_id, cadres.cadre, 
sum(judiciary_aggregates.aggregate) as aggregate, judiciary_aggregates.sex from judiciary_aggregates
join cadres on cadres.id=judiciary_aggregates.cadre
join counties on judiciary_aggregates.county_id=counties.county_id
where indicator_id=28 and judiciary_aggregates.date BETWEEN '" . $start_date_new . "' AND '" . $end_date_new . "'
group by judiciary_aggregates.sex, cadres.cadre, counties.county_id 
order by counties.county_id, judiciary_aggregates.sex, cadres.id");
	    //output: county_id, county_name, cadre_id, cadre, aggreagte, sex
	    // !!!! cadre ordered by id, the same way as in "cadres" table, suppose that Excel has the same cadre order
	    $data=$db->processRowSet($result);
	    foreach ( $data as $row ) {
	            $print_data[$row['county_id']]['28'][strtoupper($row['sex'])][$row['cadre_id']] = $row['aggregate'];
	            $print_data[$row['county_id']]['dates']= $start_date . "," . $end_date;
	    }
	    
	    //indicator 7, 8, 9, 10
	    $indicators = array('7', '8', '9', '10');
	    for($i=0; $i<count($indicators); $i++){
	    $result = mysql_query("select counties.county_id, counties.county_name, 
sum(judiciary_aggregates.aggregate) as aggregate from judiciary_aggregates
join counties on judiciary_aggregates.county_id=counties.county_id
where indicator_id=" . $indicators[$i] . " and judiciary_aggregates.date BETWEEN '" . $start_date_new . "' AND '" . $end_date_new . "'
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
	       print $row['county_id_name'] .  "," . $row['dates']  . "," . implode(",", $row['28']['MALE']) . "," . implode(",", $row['28']['FEMALE']) .  
	       "," . $row['7'] .   "," . $row['8'] .  "," . $row['9'] .  "," . $row['10'] .  "\n";
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