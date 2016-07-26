<?php
//TA:60:4
$page_title = "Export Data | Prosecution Sector | GBV";
$current_page = "home";

require_once 'includes/global.inc.php';

if (isset ( $_SESSION ['logged_in'] )) {
	
	$user = unserialize ( $_SESSION ['user'] );
	
    if( !($userTools->isSuperAdmin($user->user_group) || ($userTools->isAdmin($user->user_group) &&  $user->sector === '4'))){
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
	$ranks['15'] = "";
	$ranks['16'] = "";
	$ranks['17'] = "";
	$ranks['18'] = "";
	$ranks['19'] = "";
	$ranks['20'] = "";
	$ranks['21'] = "";
	$ranks['22'] = "";
	//prepare output rows for all counties
	$print_data = array();
	if($indicator === '6.1'){
	    foreach ($counties as $urows) {
	        $print_data[$urows['0']] = array('county_id_name' => $urows['0'] . "," . $urows['1'], 'dates'=>',', '15'=>array('MALE'=>$ranks, 'FEMALE'=>$ranks));
	    } 
	}else  if($indicator === '6.2'){
	foreach ($counties as $urows) {
	    $print_data[$urows['0']] = array('county_id_name' => $urows['0'] . "," . $urows['1'], 'dates'=>',', '16'=>'', '17'=>'');
	}
	}
	
	
	if($mode === 'export_csv'){
	    
	   // print "Under development."; return;
	    
	    if($indicator === '6.1'){ 
	       $filename="Prosecution_indicator_6.1_SGBVIS_data_export_sheet.csv";
	       header("Content-disposition: attachment;filename=$filename");
	       print "County Code,County Name,From Date (MM/YYYY),To Date (MM/YYYY),Number of police who have been trained to respond and investigate cases of SGBV,,,,,,,,,,,,,,,\n";
           print ",,,,Attorney General,,Solicitor General,,Director of Public prosecutions,,Assistant director of Public prosecutions,,Senior principal state counsel,,Senior state counsel,,State counsel one,,State counsel Two\n";
           print ",,,,Male,Female,Male,Female,Male,Female,Male,Female,Male,Female,Male,Female,Male,Female,Male,Female\n";
           
           //indicator 15
           $result = mysql_query("select counties.county_id, counties.county_name, ranks.id as rank_id, ranks.rank,
sum(prosecution_aggregates.aggregate) as aggregate, prosecution_aggregates.sex from prosecution_aggregates
join ranks on ranks.id=prosecution_aggregates.rank
join counties on prosecution_aggregates.county_id=counties.county_id
where indicator_id=15 and prosecution_aggregates.date BETWEEN '" . $start_date_new . "' AND '" . $end_date_new . "'
group by prosecution_aggregates.sex, ranks.rank, counties.county_id
order by counties.county_id, prosecution_aggregates.sex, ranks.id");
           //output: county_id, county_name, cadre_id, cadre, aggreagte, sex
           // !!!! rank ordered by id, the same way as in "ranks" table, suppose that Excel has the same rank order
           $data=$db->processRowSet($result);
           foreach ( $data as $row ) {
               $print_data[$row['county_id']]['15'][strtoupper($row['sex'])][$row['rank_id']] = $row['aggregate'];
               $print_data[$row['county_id']]['dates']= $start_date . "," . $end_date;
           }
           foreach ( $print_data as $row ) {
               print $row['county_id_name'] .  "," . $row['dates']  . "," . implode(",", $row['15']['MALE']) . "," . implode(",", $row['15']['FEMALE']) ."\n";
           }
            
           readfile($filename);
	    
	    }else if($indicator === '6.2'){
 	       $filename="Prosecution_indicator_6.2_SGBVIS_data_export_sheet.csv";
 	       header("Content-disposition: attachment;filename=$filename");
	       print "County Code,County Name,From Date (MM/YYYY),To Date (MM/YYYY),Total number of SGBV cases reported to the police in the same time period,Number of SGBV cases that were prosecuted during the specified time period\n";
	       //indicator 16, 17
	       $indicators = array('16', '17');
	       for($i=0; $i<count($indicators); $i++){
	           $result = mysql_query("select counties.county_id, counties.county_name,
sum(prosecution_aggregates.aggregate) as aggregate from prosecution_aggregates
join counties on prosecution_aggregates.county_id=counties.county_id
where indicator_id=" . $indicators[$i] . " and prosecution_aggregates.date BETWEEN '" . $start_date_new . "' AND '" . $end_date_new . "'
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
	           "," . $row['16'] .   "," . $row['17'] .  "\n";
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