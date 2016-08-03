<?php
//TA:60:4
$page_title = "Export Data | Health Sector | GBV";
$current_page = "home";

require_once 'includes/global.inc.php';

if (isset ( $_SESSION ['logged_in'] )) {
	
	$user = unserialize ( $_SESSION ['user'] );
	

    if( !($userTools->isSuperAdmin($user->user_group) || ($userTools->isAdmin($user->user_group) &&  $user->sector === '2'))){
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
	//'ownerships' table ids
	$ownerships['1'] = "";
	$ownerships['2'] = "";
	$ownerships['3'] = "";
	$ownerships['4'] = "";
	$ownerships['5'] = "";
	$ownerships['6'] = "";
	$ownerships['7'] = "";
	$ownerships['8'] = "";
	$ownerships['9'] = "";
	$ownerships['10'] = "";
	$ownerships['11'] = "";
	$ownerships['12'] = "";
	$ownerships['13'] = "";
	$ownerships['14'] = "";
	$ownerships['15'] = "";
	$ownerships['16'] = "";
	$ownerships['17'] = "";
	$ownerships['18'] = "";
	$ownerships['19'] = "";
	$ownerships['20'] = "";
	$ownerships['21'] = "";
	$ownerships['22'] = "";
	$ownerships['23'] = "";
	
	//'cadres' table ids
	$cadres['1'] = "";
	$cadres['2'] = "";
	$cadres['3'] = "";
	$cadres['15'] = "";
	$cadres['16'] = "";
	
	//age range
	$age_range['0-11'] ="";
	$age_range['12-17'] ="";;
	$age_range['18-49'] ="";;
	$age_range['50+'] ="";;
	
	//prepare output rows for all counties
	$print_data = array();
	if($indicator === '4.1'){
	    foreach ($counties as $urows) {
	        $print_data[$urows['0']] = array('county_id_name' => $urows['0'] . "," . $urows['1'], 'dates'=>',', '37'=>'', '1'=>$ownerships);
	    }
	}else  if($indicator === '4.2'){
	    foreach ($counties as $urows) {
	        $print_data[$urows['0']] = array('county_id_name' => $urows['0'] . "," . $urows['1'], 'dates'=>',', '2'=>array('MALE'=>$cadres, 'FEMALE'=>$cadres));
	    }
	}else  if($indicator === '4.3-4.6'){
	    foreach ($counties as $urows) {
	        $print_data[$urows['0']] = array('county_id_name' => $urows['0'] . "," . $urows['1'], 'dates'=>',', 
	            '3'=>array('MALE'=>$age_range, 'FEMALE'=>$age_range), 
	        '4'=>array('MALE'=>$age_range, 'FEMALE'=>$age_range),
	        '11'=>array('MALE'=>$age_range, 'FEMALE'=>$age_range),
	        '5'=>array('MALE'=>$age_range, 'FEMALE'=>$age_range),
	        '6'=>array('FEMALE'=>$age_range)
	        );
	    }
	}
	
	
	if($mode === 'export_csv'){
	    
	   // print "Under development."; return;
	    
	    if($indicator === '4.1'){ 
	       $filename="Health_indicator_4.1_SGBVIS_data_export_sheet.csv";
	       header("Content-disposition: attachment;filename=$filename");
	       
	       print "County Code,County Name,From Date (MM/YYYY),To Date (MM/YYYY),Total number of health facilities surveyed,Number of health facilities providing comprehensive clinical management services for survivors of sexual violence,,,,,,,,,,,,,,,,,,,,,,\n";
           print ",,,,,Academic, Armed forces, Christian Health Association of Kenya, Community, Community Development Fund, Company Medical Services, Humanitarian agencies, Kenya Episcopal Conference-Catholic Secretariat, Local Authority,  Local authority T fund, Ministry of Health, Non-Governmental Organizations, Other Faith Based, Other Public Institutions, Parastatal, Private Enterprise (Institution), Private Practice -Clinical Officer, Private Practice-General Practitioner, Private Practice - Medical Specialist, Private Practice - Nurse / Midwife, Private Practice-Unspecified, State Corporation, Supreme Council for Kenya Muslims\n"; 
	    
	        //indicator 1
	        $result = mysql_query("select counties.county_id, counties.county_name, health_aggregates.ownership_id, ownerships.ownership, sum(health_aggregates.aggregate) as aggregate from health_aggregates 
	            join ownerships on ownerships.id=health_aggregates.ownership_id join counties on health_aggregates.county_id=counties.county_id where indicator_id=1 
	            and health_aggregates.date BETWEEN '" . $start_date_new . "' AND '" . $end_date_new . "' 
	            group by ownerships.id, counties.county_id order by counties.county_id, ownerships.id");
	        //output: county_id, county_name, aggreagte
	        $data=$db->processRowSet($result);
	        foreach ( $data as $row ) {
	            $print_data[$row['county_id']]['1'][$row['ownership_id']] = $row['aggregate'];
	            $print_data[$row['county_id']]['dates']= $start_date . "," . $end_date;
	        }
	        
           //indicator 37
           $result = mysql_query("select counties.county_id, counties.county_name,
sum(health_aggregates.aggregate) as aggregate from health_aggregates
join counties on health_aggregates.county_id=counties.county_id
where indicator_id=37 and health_aggregates.date BETWEEN '" . $start_date_new . "' AND '" . $end_date_new . "'
group by counties.county_id
order by counties.county_id");
           //output: county_id, county_name, aggreagte
           $data=$db->processRowSet($result);
           foreach ( $data as $row ) {
               $print_data[$row['county_id']]['37'] = $row['aggregate'];
               $print_data[$row['county_id']]['dates']= $start_date . "," . $end_date;
           }
           
           foreach ( $print_data as $row ) {
               print $row['county_id_name'] .  "," . $row['dates']  .
               "," . $row['37'] .   implode(",", $row['1']) . "\n";
           }
            
          readfile($filename);
           
	    }else if($indicator === '4.2'){ 
	        $filename="Health_indicator_4.2_SGBVIS_data_export_sheet.csv";
	        header("Content-disposition: attachment;filename=$filename");
	        
	        print "County Code,County Name,From Date (MM/YYYY),To Date (MM/YYYY),Number of service providers trained on management of SGBV survivors,,,,,,,,,\n";
    print ",,,,Male,,,,,Female,,,,\n";
    print ",,,,Medical Officer,Nursing Officer,Clinical officer,Counsellor,Laboratory technologist,Medical Officer,Nursing Officer,Clinical officer,Counsellor,Laboratory technologist\n";
	        
	        
	        //indicator 2
	        $result = mysql_query("select counties.county_id, counties.county_name, cadres.id as cadre_id, cadres.cadre,
sum(health_aggregates.aggregate) as aggregate, health_aggregates.gender from health_aggregates
join cadres on cadres.id=health_aggregates.cadre_id
join counties on health_aggregates.county_id=counties.county_id
where indicator_id=2 and health_aggregates.date BETWEEN '" . $start_date_new . "' AND '" . $end_date_new . "'
group by health_aggregates.gender, cadres.cadre, counties.county_id
order by counties.county_id, health_aggregates.gender, cadres.id");
	        //output: county_id, county_name, cadre_id, cadre, aggreagte, gender
	        // !!!! cadre ordered by id, the same way as in "cadres" table, suppose that Excel has the same cadre order
	        $data=$db->processRowSet($result);
	        foreach ( $data as $row ) {
	            $print_data[$row['county_id']]['2'][strtoupper($row['gender'])][$row['cadre_id']] = $row['aggregate'];
	            $print_data[$row['county_id']]['dates']= $start_date . "," . $end_date;
	        }
	        
	        foreach ( $print_data as $row ) {
	            print $row['county_id_name'] .  "," . $row['dates']  . "," . implode(",", $row['2']['MALE']) . "," . implode(",", $row['2']['FEMALE']) . "\n";
	        }
	         
	        readfile($filename);
	        
	    }else if($indicator === '4.3-4.6'){ 
	        $filename="Health_indicator_4.3-4.6_SGBVIS_data_export_sheet.csv";
	        header("Content-disposition: attachment;filename=$filename");
	        
	        print "County Code,County Name,From Date (MM/YYYY),To Date (MM/YYYY),Number of rape survivors,,,,,,,,Number  initiated on PEP,,,,,,,,Number  completed PEP,,,,,,,,Number  given STI treatment ,,,,,,,,Number  given emergency contraceptive pill,,,\n";
print ",,,,Male,,,,Female,,,,Male,,,,Female,,,,Male,,,,Female,,,,Male,,,,Female,,,,Female,,,\n";
print ",,,,0-11 yrs,12-17 yrs,18-49 yrs,50+ yrs,0-11 yrs,12-17 yrs,18-49 yrs,50+ yrs,0-11 yrs,12-17 yrs,18-49 yrs,50+ yrs,0-11 yrs,12-17 yrs,18-49 yrs,50+ yrs,0-11 yrs,12-17 yrs,18-49 yrs,50+ yrs,0-11 yrs,12-17 yrs,18-49 yrs,50+ yrs,0-11 yrs,12-17 yrs,18-49 yrs,50+ yrs,0-11 yrs,12-17 yrs,18-49 yrs,50+ yrs,0-11 yrs,12-17 yrs,18-49 yrs,50+ yrs\n";
	       
	        
	        //indicator 3, 4, 11, 5
	        $indicators = array('3', '4', '11', '5', '6');
	        for($i=0; $i<count($indicators); $i++){
	            $result = mysql_query("select counties.county_id, counties.county_name, health_aggregates.age_range, health_aggregates.gender,
sum(health_aggregates.aggregate) as aggregate from health_aggregates
join counties on health_aggregates.county_id=counties.county_id
where indicator_id=" . $indicators[$i] . " and health_aggregates.date BETWEEN '" . $start_date_new . "' AND '" . $end_date_new . "'
group by health_aggregates.gender, health_aggregates.age_range, counties.county_id
order by counties.county_id, health_aggregates.gender");
	            
	            //output: county_id, county_name, aggreagte
	            $data=$db->processRowSet($result);
	            foreach ( $data as $row ) {
	                $print_data[$row['county_id']][$indicators[$i]][strtoupper($row['gender'])][$row['age_range']] = $row['aggregate'];
	                $print_data[$row['county_id']]['dates']= $start_date . "," . $end_date;
	            }
	        }
	        
	        foreach ( $print_data as $row ) {
	            print $row['county_id_name'] .  "," . $row['dates']  . "," . implode(",", $row['3']['MALE']) . "," . implode(",", $row['3']['FEMALE']) . 
	            "," . implode(",", $row['4']['MALE']) . "," . implode(",", $row['4']['FEMALE']) .
	            "," . implode(",", $row['11']['MALE']) . "," . implode(",", $row['11']['FEMALE']) .
	            "," . implode(",", $row['5']['MALE']) . "," . implode(",", $row['5']['FEMALE']) .
	            "," . implode(",", $row['6']['FEMALE']) ."\n";
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