<?php
// TA:60:3 report table and graph
$page_title = "Home | GBV";
$current_page = "home";
$debug = false;

require_once 'includes/global.inc.php';

// check to see if they're logged in to the system
if (isset($_SESSION['logged_in'])) {
    
    // get the user object from the session
    $user = unserialize($_SESSION['user']);
    
    $sector_type_id = $_GET['sector_type_id'];
    $county_id = $_GET['county_id'];
    $report_id = $_GET['report_id'];
    $report_name = $_GET['report_name'];
    $fromdate = $_GET['fromdate'];
    $todate = $_GET['todate'];
    
    $data = array();
    
    //for report 8.2
    $private_D = 0;
    $public_D = 0;
    $total_D = 0;
    $private_N = 0;
    $public_N = 0;
    $private_percent = 0;
    $public_percent = 0;
    
    //for report 8.3
    $male_report3_N = 0;
    $female_report3_N = 0;
    $male_report3_D = 0;
    $female_report3_D = 0;
    
    if($fromdate === $todate){
       $date_title =  $fromdate;
    }else{
        $date_title = $fromdate . " to " . $todate;
    }
    
    //print $sector_type_id ."," . $county_id  ."," . $report_id ."," . $time_period ."," . $fromdate ."," . $todate;
    
    $db = new DB();
    $sector_type_name = $db->select("sectors", " sector_id=$sector_type_id")['sector'];
//create data with all counties for cross county report
    if($county_id === "across"){
         $counties = $db->selectAllOrdered("counties", "county_id");
    }
    if($county_id === 'all'){
        $county_name = "National";
    }else{
        $county_name = ucfirst($db->select("counties", " county_id=$county_id")['county_name']);
    }
    
    if($sector_type_id == 5){
        // date format in database 0000-00-00
        $fromdate_arr = explode("/", $fromdate);
        $fromdate_new = $fromdate_arr[1] ."-" .  $fromdate_arr[0] . "-01";
        $todate_arr = explode("/", $todate);
        $todate_new = $todate_arr[1] ."-" .  $todate_arr[0] . "-31";
        
        if($report_id === '1'){
            //8.1 Number of teachers or MoE staff trained in SGBV = number of teachers and secretariat staff trained in SGBV (36) + number of MOEST staff trained in SGBV (33)
            $sql = "select indicator_id, sex, sum(aggregate) as aggregate from education_aggregates where indicator_id in (33, 36) and county_id=" . $county_id . " and
                    date between '" . $fromdate_new . "' and '" . $todate_new . "' group by indicator_id, sex order by sex desc, indicator_id";
            if($county_id === "all"){
                $sql = "select indicator_id, sex, sum(aggregate) as aggregate from education_aggregates where indicator_id in (33, 36) and 
                    date between '" . $fromdate_new . "' and '" . $todate_new . "' group by indicator_id, sex order by sex desc, indicator_id";
            }else if($county_id === "across"){
                $sql = "select sex, counties.county_name, sum(aggregate) as aggregate from education_aggregates join counties on counties.county_id=education_aggregates.county_id " .
                " where indicator_id in (33, 36) and date between '" . 
                $fromdate_new . "' and '" . $todate_new . "' group by sex, education_aggregates.county_id order by counties.county_id";
             }
            $result = mysql_query($sql);
            $data=$db->processRowSet($result);
            
            if($county_id !== "across"){
                //prepare data for graph
                $male_33 = 0;
                $male_36 = 0;
             $female_33 = 0;
                $female_36 = 0;
                foreach ( $data as $urows ) {
                    if($urows ['sex'] === 'male' && $urows ['indicator_id'] === '33'){
                        $male_33 = $urows ['aggregate'];
                    }else if($urows ['sex'] === 'male' && $urows ['indicator_id'] === '36'){
                        $male_36 = $urows ['aggregate'];
                    }else if($urows ['sex'] === 'female' && $urows ['indicator_id'] === '33'){
                        $female_33 = $urows ['aggregate'];
                    }else if($urows ['sex'] === 'female' && $urows ['indicator_id'] === '36'){
                        $female_36 = $urows ['aggregate'];
                    }
                }
            }else{
                //create data with all counties for cross county report
                foreach ( $counties as $urows ) {
                    $data_hash1[str_replace("'", "", $urows ['1'])]['MALE'] = 0;
                    $data_hash1[str_replace("'", "", $urows ['1'])]['FEMALE'] = 0;
                }
                //add recieved data to array
                foreach ( $data as $urows4 ) {
                    $data_hash1[str_replace("'", "", $urows4['county_name'])][strtoupper($urows4['sex'])] = $urows4['aggregate'];
                }
                if($debug){
                    print_r($data_hash1);
                }
            }
        }else if($report_id === '2'){ //29/30; for across: (29/30)*100 
            $sql = "select ownerships.ownership, sum(aggregate) as aggregate from education_aggregates
join ownerships on ownerships.id=education_aggregates.ownership
where indicator_id in (29) and county_id=" . $county_id . " and date between '" .$fromdate_new . "' and '" . $todate_new . "' group by education_aggregates.ownership";
            if($county_id === "all"){
                $sql = "select ownerships.ownership, sum(aggregate) as aggregate from education_aggregates
join ownerships on ownerships.id=education_aggregates.ownership
where indicator_id in (29) and date between '" .$fromdate_new . "' and '" . $todate_new . "' group by education_aggregates.ownership";
            }else if($county_id === "across"){   
                $sql = "select counties.county_name, sum(aggregate) as aggregate from education_aggregates join counties on counties.county_id=education_aggregates.county_id " .
                    " where indicator_id in (29) and date between '" .
                    $fromdate_new . "' and '" . $todate_new . "' group by education_aggregates.county_id order by counties.county_id";
            }
            $result = mysql_query($sql);
            $data_all_N=$db->processRowSet($result);
            
            $sql = "select ownerships.ownership, sum(aggregate) as aggregate from education_aggregates
join ownerships on ownerships.id=education_aggregates.ownership
where indicator_id in (30) and county_id=" . $county_id . " and date between '" .$fromdate_new . "' and '" . $todate_new . "' group by education_aggregates.ownership";
            if($county_id === "all"){
                $sql = "select ownerships.ownership, sum(aggregate) as aggregate from education_aggregates
join ownerships on ownerships.id=education_aggregates.ownership
where indicator_id in (30) and date between '" .$fromdate_new . "' and '" . $todate_new . "' group by education_aggregates.ownership";;
            }else if($county_id === "across"){
                $sql = "select counties.county_name, sum(aggregate) as aggregate from education_aggregates join counties on counties.county_id=education_aggregates.county_id " .
                    " where indicator_id in (30) and date between '" .
                    $fromdate_new . "' and '" . $todate_new . "' group by education_aggregates.county_id order by counties.county_id";
            }
            $result = mysql_query($sql);
            $data_all_D=$db->processRowSet($result);
            
            if($county_id === "across"){
            //create data with all counties for cross county report
                foreach ( $counties as $urows ) {
                    $data_hash2[str_replace("'", "", $urows ['1'])]['N'] = 0;
                    $data_hash2[str_replace("'", "", $urows ['1'])]['D'] = 0;
                    $data_hash2[str_replace("'", "", $urows ['1'])]['N/D'] = 0;
                }
                 //add recieved data to array
                $key = "county_name";
                foreach ( $data_all_N as $urows4 ) {
                    array_push($data, $urows4); // do not display message "No data"
                    foreach ( $data_all_D as $urows3 ){
                        if($urows4 [$key] === $urows3[$key]){
                            $data_hash2[str_replace("'", "", $urows4['county_name'])]['N'] = $urows4['aggregate'];
                            $data_hash2[str_replace("'", "", $urows4['county_name'])]['D'] = $urows3['aggregate'];
                            if($urows3 ['aggregate'] >0){
                                $data_hash2[str_replace("'", "", $urows4['county_name'])]['N/D'] = 
                                round(($urows4 ['aggregate']/$urows3 ['aggregate'])*100,2);
                            }
                            unset($urows3);
                        }
                    }
                }
                if($debug){
                 print_r($data_hash2);
                }
            }else{
                foreach ( $data_all_D as $urows3 ){
                    array_push($data, $urows3); // do not display message "No data"
                    if(strtoupper($urows3['ownership']) === 'PRIVATE'){
                        $private_D = $urows3['aggregate'];
                    }else if(strtoupper($urows3['ownership']) === 'PUBLIC'){
                        $public_D = $urows3['aggregate'];
                    }    
                }
                $total_D = $private_D + $public_D;
                foreach ( $data_all_N as $urows3 ){
                    array_push($data, $urows3); // do not display message "No data"
                    if(strtoupper($urows3['ownership']) === 'PRIVATE'){
                        $private_N = $urows3['aggregate'];
                    }else if(strtoupper($urows3['ownership']) === 'PUBLIC'){
                        $public_N = $urows3['aggregate'];
                    }
                }
                if($total_D > 0){
                    $private_percent = round(($private_N/$total_D)*100,2);
                    $public_percent = round(($public_N/$total_D)*100,2);
                }
            }
//             print $private_D . "<br>";
//     print $public_D . "<br>";
//     print $total_D . "<br>";
//     print $private_N . "<br>";
//     print $public_N . "<br>";
//     print $private_percent . "<br>";
//     print $public_percent . "<br>";
        }else if($report_id === '3'){ //32/31 
                        //sex proportion = 32 by sex / 31 by all
            $sql = "select sex, sum(aggregate) as aggregate from education_aggregates 
where indicator_id in (32) and county_id=" . $county_id . " and date between '" . $fromdate_new . "' and '" . $todate_new . "' group by sex";
            if($county_id === "all"){
                $sql = "select sex, sum(aggregate) as aggregate from education_aggregates 
where indicator_id in (32) and date between '" . $fromdate_new . "' and '" . $todate_new . "' group by sex";
            }else if($county_id === "across"){
                $sql = "select sex, counties.county_name, sum(aggregate) as aggregate from education_aggregates join counties on counties.county_id=education_aggregates.county_id " .
                    " where indicator_id in (32) and date between '" .
                    $fromdate_new . "' and '" . $todate_new . "' group by sex, education_aggregates.county_id order by counties.county_id";
            }
            $result = mysql_query($sql);
            $data_all_N=$db->processRowSet($result);
            
        $sql = "select sex,sum(aggregate) as aggregate from education_aggregates 
where indicator_id in (31) and county_id=" . $county_id . " and date between '" . $fromdate_new . "' and '" . $todate_new . "' group by sex";
            if($county_id === "all"){
                $sql = "select sex,sum(aggregate) as aggregate from education_aggregates 
where indicator_id in (31) and date between '" . $fromdate_new . "' and '" . $todate_new . "' group by sex";
            }else if($county_id === "across"){
                $sql = "select sex, counties.county_name, sum(aggregate) as aggregate from education_aggregates join counties on counties.county_id=education_aggregates.county_id " .
                    " where indicator_id in (31) and date between '" .
                    $fromdate_new . "' and '" . $todate_new . "' group by sex, education_aggregates.county_id order by counties.county_id";
            }
            $result = mysql_query($sql);
            $data_all_D=$db->processRowSet($result);
            
            if($county_id === "across"){
            //create data with all counties for cross county report
                foreach ( $counties as $urows ) {
                    $data_hash[str_replace("'", "", $urows ['1'])]['MALE_D'] = 0;
                    $data_hash[str_replace("'", "", $urows ['1'])]['MALE_N'] = 0;
                    $data_hash[str_replace("'", "", $urows ['1'])]['MALE'] = 0;
                    $data_hash[str_replace("'", "", $urows ['1'])]['FEMALE_D'] = 0;
                    $data_hash[str_replace("'", "", $urows ['1'])]['FEMALE_N'] = 0;
                    $data_hash[str_replace("'", "", $urows ['1'])]['FEMALE'] = 0;
                }
                foreach ( $data_all_D as $urows3 ) {
                    $data_hash[str_replace("'", "", $urows3['county_name'])][strtoupper($urows3['sex'])."_D"] = $urows3 ['aggregate'];
                    array_push($data, $urows3); // do not display message "No data"
                    foreach ( $data_all_N as $urows4 ){
                        if($urows4 ['county_name'] === $urows3['county_name'] && $urows4 ['sex'] === $urows3['sex']){
                            $data_hash[str_replace("'", "", $urows4['county_name'])][strtoupper($urows4['sex'])."_N"] = $urows4 ['aggregate'];
                            if($urows3 ['aggregate'] >0){
                                $data_hash[str_replace("'", "", $urows4['county_name'])][strtoupper($urows4['sex'])] = 
                                round(($urows4 ['aggregate']/$urows3 ['aggregate'])*100,2);
                            }
                            unset($urows4);
                        }
                    }
                }
                if($debug){
                    print_r($data_all_N);print "<br><br>";
                    print_r($data_all_D);print "<br><br>";
                    print_r($data_hash);
                }
            }else{
                //prepare data for graph
                $male_report3_N = 0;
                $female_report3_N = 0;
                $male_report3_D = 0;
                $female_report3_D = 0;
                foreach ( $data_all_D as $urows3 ){
                if($urows3['sex'] === 'male'){
                            $male_report3_D += $urows3['aggregate'];
                        }else  if($urows3['sex'] === 'female'){
                             $female_report3_D += $urows3['aggregate'];
                        }
                }
                    foreach ( $data_all_N as $urows4 ) {
                        if($urows4['sex'] === 'male'){
                            $male_report3_N += $urows4['aggregate'];
                            array_push($data, $urows4); // do not display message "No data"
                        }else  if($urows4['sex'] === 'female'){
                             $female_report3_N += $urows4['aggregate'];
                            array_push($data, $urows4); // do not display message "No data"
                        }
                    } 
            }
            if($debug){
                 print_r($data_all_N); print "<br>";
                 print_r($data_all_D); print "<br>";
                 print $male_report3_N . "," . $female_report3_N . "," . $male_report3_D . "," . $female_report3_D . "<br>";
            }
        }else if($report_id === '4'){ //34 by sex/31 all 
            $sql = "select sex, violence_types.violence_type, identity_of_perpetrator.identity, place_of_victimization.place, 
sum(aggregate) as aggregate 
from education_aggregates
join violence_types on education_aggregates.violence_type=violence_types.id
join identity_of_perpetrator on education_aggregates.identity_of_perpetrator=identity_of_perpetrator.id
join place_of_victimization on education_aggregates.place_of_victimization=place_of_victimization.id
where indicator_id in (34) and county_id=" . $county_id . " and date between '" . $fromdate_new . "' and '" . $todate_new . "'
group by violence_type, identity_of_perpetrator, place_of_victimization, sex";     
            if($county_id === "all"){
                $sql = "select sex, violence_types.violence_type, identity_of_perpetrator.identity, place_of_victimization.place, 
sum(aggregate) as aggregate 
from education_aggregates
join violence_types on education_aggregates.violence_type=violence_types.id
join identity_of_perpetrator on education_aggregates.identity_of_perpetrator=identity_of_perpetrator.id
join place_of_victimization on education_aggregates.place_of_victimization=place_of_victimization.id
where indicator_id in (34) and date between '" . $fromdate_new . "' and '" . $todate_new . "'
group by violence_type, identity_of_perpetrator, place_of_victimization, sex";
            }else if($county_id === "across"){
                $sql = "select sex, counties.county_name, sum(aggregate) as aggregate from education_aggregates join counties on counties.county_id=education_aggregates.county_id " .
                    " where indicator_id in (34) and date between '" .
                    $fromdate_new . "' and '" . $todate_new . "' group by sex, education_aggregates.county_id order by counties.county_id";
            }
            $result = mysql_query($sql);
            $data_all_N=$db->processRowSet($result);

            $sql = "select sex, sum(aggregate) as aggregate from education_aggregates
where indicator_id in (31) and county_id=" . $county_id . " and date between '" . $fromdate_new . "' and '" . $todate_new . "'";
            if($county_id === "all"){
                 $sql = "select sum(aggregate) as aggregate from education_aggregates
where indicator_id in (31) and date between '" . $fromdate_new . "' and '" . $todate_new . "'";
            }else if($county_id === "across"){
                $sql = "select sex, counties.county_name, sum(aggregate) as aggregate from education_aggregates join counties on counties.county_id=education_aggregates.county_id " .
                    " where indicator_id in (31) and date between '" .
                    $fromdate_new . "' and '" . $todate_new . "' group by sex, education_aggregates.county_id order by counties.county_id";
            }
            $result = mysql_query($sql);
            $data_all_D=$db->processRowSet($result);
            
            if($county_id === "across"){
            //create data with all counties for cross county report
                foreach ( $counties as $urows ) {
                    $data_hash[str_replace("'", "", $urows ['1'])]['MALE_D'] = 0;
                    $data_hash[str_replace("'", "", $urows ['1'])]['MALE_N'] = 0;
                    $data_hash[str_replace("'", "", $urows ['1'])]['MALE'] = 0;
                    $data_hash[str_replace("'", "", $urows ['1'])]['FEMALE_D'] = 0;
                    $data_hash[str_replace("'", "", $urows ['1'])]['FEMALE_N'] = 0;
                    $data_hash[str_replace("'", "", $urows ['1'])]['FEMALE'] = 0;
                }
            foreach ( $data_all_D as $urows3 ) {
                    $data_hash[str_replace("'", "", $urows3['county_name'])][strtoupper($urows3['sex'])."_D"] = $urows3 ['aggregate'];
                    array_push($data, $urows3); // do not display message "No data"
                    foreach ( $data_all_N as $urows4 ){
                        if($urows4 ['county_name'] === $urows3['county_name'] && $urows4 ['sex'] === $urows3['sex']){
                            $data_hash[str_replace("'", "", $urows4['county_name'])][strtoupper($urows4['sex'])."_N"] = $urows4 ['aggregate'];
                            if($urows3 ['aggregate'] >0){
                                $data_hash[str_replace("'", "", $urows4['county_name'])][strtoupper($urows4['sex'])] = 
                                round(($urows4 ['aggregate']/$urows3 ['aggregate'])*100,2);
                            }
                            unset($urows4);
                        }
                    }
                }
                if($debug){
                    print_r($data_all_N);print "<br><br>";
                    print_r($data_all_D);print "<br><br>";
                    print_r($data_hash);
                }
            }else{
                $total_in_sample = 0;
                foreach ( $data_all_D as $urows3 ){
                    $total_in_sample = $urows3 ['aggregate'];
                }
                 if($total_in_sample != 0){
                     $data_hash4['sample'] = $total_in_sample;
                     foreach ( $data_all_N as $urows4 ) {
                         array_push($data, $urows4); // do not display message "No data"
                         $data_hash4['violence_type'][$urows4['violence_type']][$urows4['sex'] . "_total"] = $urows4['aggregate'];
                         $data_hash4['violence_type'][$urows4['violence_type']][$urows4['sex']] = round(($urows4['aggregate']/$total_in_sample)*100,2);
                         $data_hash4['identity'][$urows4['identity']][$urows4['sex']."_total"] = $urows4['aggregate'];
                         $data_hash4['identity'][$urows4['identity']][$urows4['sex']] = round(($urows4['aggregate']/$total_in_sample)*100,2);
                     }
                     foreach ( $data_hash4['violence_type'] as $key => $value) {
                         $data_hash4['violence_type'][$key]['total'] = $value['male_total'] + $value['female_total'];
                     }
                     foreach ( $data_hash4['identity'] as $key => $value) {
                         $data_hash4['identity'][$key]['total'] = $value['male_total'] + $value['female_total'];
                     }
                 }
                 if($debug){
                                   print_r($data_all_N); print "<br><br>";
                                  print_r($data_all_D); print "<br><br>";
                                  print_r($data_hash4); print "<br><br>";  
                                  foreach ( $data_hash4['violence_type'] as $key => $value) {
                                      print $key . "=>" . $value['male'] . "," . $value['female'] . "<br>";
                                  }
                                  print "<br><br>";
                                  foreach ( $data_hash4['identity'] as $key => $value) {
                                      print $key . "=>" . $value['male'] . "," . $value['female'] . "<br>";
                                  }
                 }                      
            }
            
        }
        
    }
    
  //  print_r($data);
    
    ?>
    
     <!-- libs to upload chart as PNG-->
    <script type="text/javascript" src="../UI/js/rgbcolor.js"></script> 
<script type="text/javascript" src="../UI/js/canvg.js"></script>
<script type="text/javascript" src="../UI/js/grChartImg.js"></script>

<script type="text/javascript">

function pdf_report3(){  

	var doc = new jsPDF('p', 'pt', 'a4', false);
	
	doc.setFontType("bold");
	doc.setFontSize(14);
	doc.text(200, 30, 'Education sector report');
	doc.setFontType("normal");
	doc.setFontSize(12);
	doc.text(60, 60, $('#chart_title_1').text());
	doc.text(60, 80, $('#chart_title_2').text());

	//add table report
	var res = doc.autoTableHtmlToJson(document.getElementById('table_div').getElementsByTagName('table')[0]);
	try{
		doc.autoTable(res.columns, res.data, {
		    startY: 100,
		    styles: {
		      overflow: 'linebreak',
		      fontSize: 10,
		      //rowHeight: 20,
		      columnWidth: 'wrap'
		    },
		    columnStyles: {
		      0: {fontStyle: 'bold'},
		      1: {columnWidth: 'auto'},
		      2: {columnWidth: 'auto'},
		      3: {columnWidth: 'auto'},
		      4: {columnWidth: 'auto'},
		      5: {columnWidth: 'auto'},
		      6: {columnWidth: 'auto'},
		      7: {columnWidth: 'auto'},
		      8: {columnWidth: 'auto'},
		      9: {columnWidth: 'auto'}
		    }
		  });
	}catch (e) {
	     doc.text(120, 100, 'Cannot print table report');
	}

	//add chart report 
	var image1 = $('#image1 img')
	try {
     doc.addImage(image1[0], 'png', 40, 200, 400, 200); 
 }catch (e) {
     doc.text(120, 120, 'Cannot print chart report');
 }

 doc.save("EducationSecotorReport.pdf");
}

function pdf_report_simple(){  

	var doc = new jsPDF('p', 'pt', 'a4', false);
	
	doc.setFontType("bold");
	doc.setFontSize(14);
	doc.text(200, 30, 'Education sector report');
	doc.setFontType("normal");
	doc.setFontSize(12);
	doc.text(60, 60, $('#chart_title_1').text());
	doc.text(60, 80, $('#chart_title_2').text());

	//add table report
	var res = doc.autoTableHtmlToJson(document.getElementById('table_div').getElementsByTagName('table')[0]);
	try{
		doc.autoTable(res.columns, res.data, {
		    startY: 100,
		    styles: {
		      overflow: 'linebreak',
		      fontSize: 10,
		      //rowHeight: 20,
		      columnWidth: 'wrap'
		    },
		    columnStyles: {
		      0: {fontStyle: 'bold'}
		    }
		  });
	}catch (e) {
	     doc.text(120, 100, 'Cannot print table report');
	}

	//add chart report 
	var image1 = $('#image1 img')
	try {
     doc.addImage(image1[0], 'png', 40, 200, 400, 200); 
 }catch (e) {
     doc.text(120, 120, 'Cannot print chart report');
 }

 doc.save("EducationSecotorReport.pdf");
}

function pdf_report_report4(rows){ 

	var doc = new jsPDF('p', 'pt', 'a4', false);
	
	doc.setFontType("bold");
	doc.setFontSize(14);
	doc.text(200, 30, 'Education sector report');
	doc.setFontType("normal");
	doc.setFontSize(12);
	doc.text(60, 60, "Proportion of children who have indicated via self reports that they have violated");
	doc.text(60, 80, "at home/school in the last 12 months");
	doc.text(60, 100, $('#chart_title_2').text());

	//add table report
	var res = doc.autoTableHtmlToJson(document.getElementById('table_div').getElementsByTagName('table')[0]);
	try{
		doc.autoTable(res.columns, res.data, {
		    startY: 110,
		    styles: {
		      overflow: 'linebreak',
		      fontSize: 10,
		      //rowHeight: 20,
		      columnWidth: 'wrap'
		    },
		    columnStyles: {
		      0: {fontStyle: 'bold'},
		      1: {columnWidth: 'auto'},
		      2: {columnWidth: 'auto'},
		      3: {columnWidth: 'auto'},
		      4: {columnWidth: 'auto'},
		      5: {columnWidth: 'auto'},
		      6: {columnWidth: 'auto'}
		    }
		  });
	}catch (e) {
	     doc.text(120, 100, 'Cannot print table report');
	}

	//add chart report 
	var image1 = $('#image1 img')
	try {
     doc.addImage(image1[0], 'png', 40, (120+rows*40), 500, 250); 
      }catch (e) {
     doc.text(120, 120, 'Cannot print chart report');
 }

//add detailed report
 var image2 = $('#image2 img');
if(image2.length > 0){
	doc.addPage();
	//add table report
	res = doc.autoTableHtmlToJson(document.getElementById('table_div2').getElementsByTagName('table')[0]);
	try{
		doc.autoTable(res.columns, res.data, {
		    startY: 30,
		    styles: {
		      overflow: 'linebreak',
		      fontSize: 10,
		      //rowHeight: 20,
		      columnWidth: 'wrap'
		    },
		    columnStyles: {
		      0: {fontStyle: 'bold'},
		      1: {columnWidth: 'auto'},
		      2: {columnWidth: 'auto'},
		      3: {columnWidth: 'auto'},
		      4: {columnWidth: 'auto'},
		      5: {columnWidth: 'auto'},
		      6: {columnWidth: 'auto'}
		    }
		  });
	}catch (e) {
	     doc.text(120, 440, 'Cannot print table detailed report');
	}
	try {
	    doc.addImage(image2[0], 'png', 40, (120+rows*40), 500, 250);
	}catch (e) {
	    doc.text(120, 520, 'Cannot print chart detailed report');
	}
}

 doc.save("EducationSecotorReport.pdf");
}

function pdf_report(){  

	var doc = new jsPDF('p', 'pt', 'a4', false);
	
	doc.setFontType("bold");
	doc.setFontSize(14);
	doc.text(200, 30, 'Education sector report');
	doc.setFontType("normal");
	doc.setFontSize(12);
	doc.text(60, 60, $('#chart_title_1').text());
	doc.text(60, 80, $('#chart_title_2').text());

	//add table report
	var res = doc.autoTableHtmlToJson(document.getElementById('table_div').getElementsByTagName('table')[0]);
	try{
		doc.autoTable(res.columns, res.data, {
		    startY: 100,
		    styles: {
		      overflow: 'linebreak',
		      fontSize: 10,
		      //rowHeight: 20,
		      columnWidth: 'wrap'
		    },
		    columnStyles: {
		      0: {fontStyle: 'bold'}
		    }
		  });
	}catch (e) {
	     doc.text(120, 100, 'Cannot print table report');
	}

	//add chart report 
	var image1 = $('#image1 img')
	try {
     doc.addImage(image1[0], 'png', 180, 90, 370, 300, undefined, 'none');
 }catch (e) {
     doc.text(120, 120, 'Cannot print chart report');
 }

 //add detailed report
  var image2 = $('#image2 img');
 if(image2.length > 0){
	//doc.addPage();
	doc.text(60, 400, $('#detailed_title_1').text());
	doc.text(60, 420, $('#detailed_title_2').text());
	//add table report
	res = doc.autoTableHtmlToJson(document.getElementById('detailed_report_table').getElementsByTagName('table')[0]);
	try{
		doc.autoTable(res.columns, res.data, {
		    startY: 440,
		    styles: {
		      overflow: 'linebreak',
		      fontSize: 10,
		      //rowHeight: 20,
		      columnWidth: 'wrap'
		    },
		    columnStyles: {
		      0: {fontStyle: 'bold'}
		    }
		  });
	}catch (e) {
	     doc.text(120, 440, 'Cannot print table detailed report');
	}
	try {
	    doc.addImage(image2[0], 'png', 40, 520, 530, 330, undefined, 'none');
	}catch (e) {
	    doc.text(120, 520, 'Cannot print chart detailed report');
	}
 }

	doc.save("EducationSecotorReport.pdf");
}

function pdf_across_report(){  

	var doc = new jsPDF('p', 'pt', 'a4', false);
	
	doc.setFontType("bold");
	doc.setFontSize(14);
	doc.text(200, 30, 'Education sector report');
	doc.setFontType("normal");
	doc.setFontSize(12);
	doc.text(60, 60, $('#chart_title_1').text());
	doc.text(60, 80, $('#chart_title_2').text());

	//add table report
	var res = doc.autoTableHtmlToJson(document.getElementById('table_div').getElementsByTagName('table')[0]);
	try{
		doc.autoTable(res.columns, res.data, {
		    startY: 100,
		    styles: {
		      overflow: 'linebreak',
		      fontSize: 10,
		      //rowHeight: 20,
		      columnWidth: 'wrap'
		    },
		    columnStyles: {
		      0: {fontStyle: 'bold'}
		    }
		  });
	}catch (e) {
	     doc.text(120, 100, 'Cannot print table report');
	}

	//add chart report 
	var image1 = $('#image1 img')
	try {
     doc.addImage(image1[0], 'png', 40, 400, 530, 300, undefined, 'none');
 }catch (e) {
     doc.text(120, 120, 'Cannot print chart report');
 }

	doc.save("EducationSecotorReport.pdf");
}

function pdf_across_report4(){  

	var doc = new jsPDF('p', 'pt', 'a4', false);
		
		doc.setFontType("bold");
		doc.setFontSize(14);
		doc.text(200, 30, 'Education sector report');
		doc.setFontType("normal");
		doc.setFontSize(12);
		doc.text(60, 60, 'Proportion of children who have indicated via self reports that they have violated ');
		doc.text(60, 80, 'at home/school in the last 12 months');
		doc.text(60, 100, $('#chart_title_2').text());

		//add table report
		var res = doc.autoTableHtmlToJson(document.getElementById('table_div').getElementsByTagName('table')[0]);
		try{
			doc.autoTable(res.columns, res.data, {
			    startY: 120,
			    styles: {
			      overflow: 'linebreak',
			      fontSize: 10,
			      //rowHeight: 20,
			      columnWidth: 'wrap'
			    },
			    columnStyles: {
			      0: {fontStyle: 'bold'},
			      1: {columnWidth: 'auto'},
			      2: {columnWidth: 'auto'},
			      3: {columnWidth: 'auto'},
			      4: {columnWidth: 'auto'},
			      5: {columnWidth: 'auto'},
			      6: {columnWidth: 'auto'}      
			    }
			  });
		}catch (e) {
		     doc.text(120, 100, 'Cannot print table report');
		}

		//add chart report 
		var image1 = $('#image1 img')
		try {
	     doc.addImage(image1[0], 'png', 40, 400, 530, 300, undefined, 'none');
	 }catch (e) {
	     doc.text(120, 120, 'Cannot print chart report');
	 }

		doc.save("EducationSecotorReport.pdf");
	}

function pdf_across_report3(){  

	var doc = new jsPDF('p', 'pt', 'a4', false);
		
		doc.setFontType("bold");
		doc.setFontSize(14);
		doc.text(200, 30, 'Education sector report');
		doc.setFontType("normal");
		doc.setFontSize(12);
		doc.text(60, 60, $('#chart_title_1').text());
		doc.text(60, 80, $('#chart_title_2').text());

		//add table report
		var res = doc.autoTableHtmlToJson(document.getElementById('table_div').getElementsByTagName('table')[0]);
		try{
			doc.autoTable(res.columns, res.data, {
			    startY: 100,
			    styles: {
			      overflow: 'linebreak',
			      fontSize: 10,
			      //rowHeight: 20,
			      columnWidth: 'wrap'
			    },
			    columnStyles: {
			      0: {fontStyle: 'bold',columnWidth: 'auto'},
			      1: {columnWidth: 'auto'},
			      2: {columnWidth: 'auto'},
			      3: {columnWidth: 'auto'},
			      4: {columnWidth: 'auto'},
			      5: {columnWidth: 'auto'},
			      6: {columnWidth: 'auto'},
			      7: {columnWidth: 'auto'}
			    }
			  });
		}catch (e) {
		     doc.text(120, 100, 'Cannot print table report');
		}

		//add chart report 
		var image1 = $('#image1 img')
		try {
	     doc.addImage(image1[0], 'png', 40, 400, 530, 300, undefined, 'none');
	 }catch (e) {
	     doc.text(120, 120, 'Cannot print chart report');
	 }

		doc.save("EducationSecotorReport.pdf");
	}

function pdf_across_report2(){  

	var doc = new jsPDF('p', 'pt', 'a4', false);
		
		doc.setFontType("bold");
		doc.setFontSize(14);
		doc.text(200, 30, 'Education sector report');
		doc.setFontType("normal");
		doc.setFontSize(12);
		doc.text(60, 60, $('#chart_title_1').text());
		doc.text(60, 80, $('#chart_title_2').text());

		//add table report
		var res = doc.autoTableHtmlToJson(document.getElementById('table_div').getElementsByTagName('table')[0]);
		try{
			doc.autoTable(res.columns, res.data, {
			    startY: 100,
			    styles: {
			      overflow: 'linebreak',
			      fontSize: 10,
			      //rowHeight: 20,
			      columnWidth: 'wrap'
			    },
			    columnStyles: {
			      0: {fontStyle: 'bold'},
			      1: {columnWidth: 'auto'},
			      2: {columnWidth: 'auto'},
			      3: {columnWidth: 'auto'}
			    }
			  });
		}catch (e) {
		     doc.text(120, 100, 'Cannot print table report');
		}

		//add chart report 
		var image1 = $('#image1 img')
		try {
	     doc.addImage(image1[0], 'png', 40, 400, 530, 300, undefined, 'none');
	 }catch (e) {
	     doc.text(120, 120, 'Cannot print chart report');
	 }

		doc.save("EducationSecotorReport.pdf");
	}

function pdf_across_report1(){  

var doc = new jsPDF('p', 'pt', 'a4', false);
	
	doc.setFontType("bold");
	doc.setFontSize(14);
	doc.text(200, 30, 'Education sector report');
	doc.setFontType("normal");
	doc.setFontSize(12);
	doc.text(60, 60, $('#chart_title_1').text());
	doc.text(60, 80, $('#chart_title_2').text());

	//add table report
	var res = doc.autoTableHtmlToJson(document.getElementById('table_div').getElementsByTagName('table')[0]);
	try{
		doc.autoTable(res.columns, res.data, {
		    startY: 100,
		    styles: {
		      overflow: 'linebreak',
		      fontSize: 10,
		      //rowHeight: 20,
		      columnWidth: 'wrap'
		    },
		    columnStyles: {
		      0: {fontStyle: 'bold'}
		    }
		  });
	}catch (e) {
	     doc.text(120, 100, 'Cannot print table report');
	}

	//add chart report 
	var image1 = $('#image1 img')
	try {
     doc.addImage(image1[0], 'png', 40, 400, 530, 300, undefined, 'none');
 }catch (e) {
     doc.text(120, 120, 'Cannot print chart report');
 }

	doc.save("EducationSecotorReport.pdf");
}

function csv_report(text) {
	var blob = new Blob([text], {type: "text/plain;charset=utf-8"});
	saveAs(blob, "EducationSecotorReport.csv");
}

function dataTableToCSV(dataTable_arg) {
	
    var dt_cols = dataTable_arg.getNumberOfColumns();
    var dt_rows = dataTable_arg.getNumberOfRows();
    
    var csv_cols = [];
    var csv_out;
    
    // Iterate columns
    for (var i=0; i<dt_cols; i++) {
        // Replace any commas in column labels
        csv_cols.push(dataTable_arg.getColumnLabel(i).replace(/,/g,""));
    }
    
    // Create column row of CSV
    csv_out = csv_cols.join(",")+"\\n";
    
    // Iterate rows
    for (i=0; i<dt_rows; i++) {
        var raw_col = [];
        for (var j=0; j<dt_cols; j++) {
            // Replace any commas in row values
            raw_col.push(dataTable_arg.getFormattedValue(i, j, 'label').replace(/,/g,""));
        }
        // Add row to CSV text
        csv_out += raw_col.join(",")+"\\n";
    }
    return "Education sector report\\n" + $('#chart_title_1').text() + "\\n" + $('#chart_title_2').text() + "\\n" + csv_out;
}



</script>

<script type="text/javascript">
        //google.charts.load('current', {packages: ['bar']}); this loaded in Reports/index.php before load()
        //google.charts.setOnLoadCallback(drawChart);

        google.load('visualization', '1.0', {packages:['corechart', 'table', 'line'], callback: drawChart});

        var chart;
		var data_chart;

		function drawChart(){
			<?php 
			if(count($data) === 0){
			    echo "noDataMessage();";
			}else{
			    if($county_id === "across"){//TA
			        if($report_id === '1'){
			            echo "drawAcrossGraph_report1();";
			        }else if($report_id === '2'){
			            echo "drawAcrossGraph_report2();";
			        }else if($report_id === '3'){
			            echo "drawAcrossGraph_report3();";
			        }else{
			            echo "drawAcrossGraph_report4();";
			        }
			    }else{
			        if($report_id === '1'){
			            echo "drawAggregateGraph_report1();";
			        }else if($report_id === '2'){
			            echo "drawAggregateGraph_report2();";
			        }else if($report_id === '3'){
			            echo "drawAggregateGraph_report3();";
			        }else if($report_id === '4'){
			             echo "drawAggregateGraph_report4_violence();";
			             echo "drawAggregateGraph_report4_identity();";
			        }
			    }
			}
			?>
		}

		function noDataMessage(){
			$("#progress_bar").html("");
	        $("#report_title").html("<h2 class='page-title-section-gray'><?php echo $sector_type_name;?> sector report</h2>");
	        $("#pdf_report").html("<a href='#' onclick='pdf_report();' style='font-style: italic; text-decoration-color: gray;'><font color='gray'style='font-family: \"Open Sans\", Tahoma, Arial sans-serif;'>PDF report</font></a>");
	        $("#chart_title").html("<h2 id='chart_title_1' class='page-title-section'><?php echo $report_name . "</h2><h2 id='chart_title_2' class='page-title-section'>(" . $county_name . ") " . $date_title . "</h2><br><br>No data";?>");
			
		}

		function drawAcrossGraph_report2(){
			$("#progress_bar").html("");
	        $("#report_title").html("<h2 class='page-title-section-gray'><?php echo $sector_type_name;?> sector report</h2>");
	        $("#pdf_report").html("<a href='#' onclick='pdf_across_report2();' style='font-style: italic; text-decoration-color: gray;'><font color='gray'style='font-family: \"Open Sans\", Tahoma, Arial sans-serif;'>PDF report</font></a>");
	        $("#png_chart").html("<a href='#' onclick='javascript:grChartImg.ShowImage(\"chart_div\", true);' style='font-style: italic; text-decoration-color: gray;'><font color='gray'style='font-family: \"Open Sans\", Tahoma, Arial sans-serif;'>Print chart</font></a>");
	        $("#chart_title").html("<h2 id='chart_title_1' class='page-title-section'><?php echo $report_name . "</h2><h2 id='chart_title_2' class='page-title-section'>" . $date_title . "</h2>";?>");

	        //draw table
	       	 var data_table = new google.visualization.DataTable();
		       	data_table.addColumn('string', 'County name');
		       	data_table.addColumn('number', 'Total number <br>of schools surveyed');
	        	data_table.addColumn('number', 'Number of schools <br>implementing life skills <br>curriculum that teaches <br>students on what <br>to do in case <br>of victimization');
	        	data_table.addColumn('number', 'Percent of schools <br>implementing life skills <br>curriculum that teaches <br>students on what <br>to do in case <br>of violation');
	        	data_table.addRows([
	        	<?php foreach ( $data_hash2 as $key=>$urows) {
	        	    	        	    echo "[{v:'" . $key . "'}, {v:" . $urows['D'] . "}, {v:" . $urows['N'] . "}, {v:" . $urows['N/D'] . "}],";
	        	    	        	}?>
	        	    	  ]);
	          var table = new google.visualization.Table(document.getElementById('table_div'));      
	         table.draw(data_table, {allowHtml: true, showRowNumber: false, width: '700px', height: '100%'});
	         <?php if($user->user_group === '1' || $user->user_group === '2'){?> //only for admin and super admin
	              $("#table1_csv").html(dataTableToCSV(data_table)); 
	              $("#table_div_csv").html("<a href='#' onclick='csv_report(\"" + $("#table1_csv").html() + "\");' style='font-style: italic; text-decoration-color: gray;'><font color='gray'style='font-family: \"Open Sans\", Tahoma, Arial sans-serif; font-size;7px'>CSV report</font></a>");
	         <?php }?>

		       //draw chart
	         data_chart = new google.visualization.DataTable();
	        	data_chart.addColumn('string', 'County name');
	        	data_chart.addColumn('number', 'Proportion');      
	        	data_chart.addRows([
	        	<?php 
	        	foreach ( $data_hash2 as $key=>$urows ) {
	        	   echo "['" . $key . "', {v:" . $urows['N/D'] . "}],";
	        	    }?>
	        ]);

            var options = {
            		"title": "<?php echo $report_name . ' \nbetween period ' . $date_title; ?>",
            		"legend":"none",
            		"width":1000,
            		"height":500,
            	 hAxis: {title:'County', slantedText:true, slantedTextAngle:90,showTextEvery:1 }, //lebel vertical view and show all
          		  vAxis: {title:'Percent of schools implementing life skills curriculum', minValue:0, maxValue: 100, format: '0'},
            		bar: {groupWidth: 20},
            		chartArea : { left: 60, top: 40, right:20, height: '57%'} // do not cut off labels

            };
            
  			chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
  			google.visualization.events.addListener(chart, 'ready', function () {
    			  var content = '<img src="' + chart.getImageURI() + '">';
    			  $('#image1').append(content);
    			}); 
  			chart.draw(data_chart, options);
		}

		function drawAcrossGraph_report1(){

			$("#progress_bar").html("");
	        $("#report_title").html("<h2 class='page-title-section-gray'><?php echo $sector_type_name;?> sector report</h2>");
	        $("#pdf_report").html("<a href='#' onclick='pdf_across_report1();' style='font-style: italic; text-decoration-color: gray;'><font color='gray'style='font-family: \"Open Sans\", Tahoma, Arial sans-serif;'>PDF report</font></a>");
	        $("#png_chart").html("<a href='#' onclick='javascript:grChartImg.ShowImage(\"chart_div\", true);' style='font-style: italic; text-decoration-color: gray;'><font color='gray'style='font-family: \"Open Sans\", Tahoma, Arial sans-serif;'>Print chart</font></a>");
	        $("#chart_title").html("<h2 id='chart_title_1' class='page-title-section'><?php echo $report_name . "</h2><h2 id='chart_title_2' class='page-title-section'>" . $date_title . "</h2>";?>");

	        //draw table
	       	 var data_table = new google.visualization.DataTable();
		       	data_table.addColumn('string', 'County name');
		       	data_table.addColumn('number', 'Male');
	        	data_table.addColumn('number', 'Female');
	        	data_table.addColumn('number', 'Total');
	        	data_table.addRows([
	        	<?php foreach ( $data_hash1 as $key=>$urows) {
 	        	    $male = $urows['MALE']?$urows['MALE']:0;
 	        	    $female = $urows['FEMALE']?$urows['FEMALE']:0;
	        	    	        	    echo "[{v:'" . $key . "'}, {v:" . $male . "}, {v:" . $female . "}, {v:" . ($female+$male) . "}],";
	        	    	        	}?>
	        	    	  ]);
	          var table = new google.visualization.Table(document.getElementById('table_div'));      
	         table.draw(data_table, {allowHtml: true, showRowNumber: false, width: '300px', height: '100%'});
	         <?php if($user->user_group === '1' || $user->user_group === '2'){?> //only for admin and super admin
	              $("#table1_csv").html(dataTableToCSV(data_table)); 
	              $("#table_div_csv").html("<a href='#' onclick='csv_report(\"" + $("#table1_csv").html() + "\");' style='font-style: italic; text-decoration-color: gray;'><font color='gray'style='font-family: \"Open Sans\", Tahoma, Arial sans-serif; font-size;7px'>CSV report</font></a>");
	         <?php }?>

			//draw chart
	         data_chart = new google.visualization.DataTable();
	        	data_chart.addColumn('string', 'County name');
	        	data_chart.addColumn('number', 'Male');
	        	data_chart.addColumn('number', 'Female');        
	        	data_chart.addRows([
	        	<?php 
	        	foreach ( $data_hash1 as $key=>$urows ) {
             $male = $urows['MALE']?$urows['MALE']:0;
 	        	    $female = $urows['FEMALE']?$urows['FEMALE']:0;
            echo "[ '" . $key . "', {v:" . $male . "}, {v:" . $female . "}],";
	        	 }?>
	        ]);

            var options = {
            		"title": "<?php echo $report_name . ' \nbetween period ' . $date_title; ?>",
            		//"legend":"none",
            		"width":1000,
            		"height":500,
            	 hAxis: {title:'County', slantedText:true, slantedTextAngle:90,showTextEvery:1 }, //lebel vertical view and show all
          		  vAxis: {title:'Number trained', minValue:0, maxValue: 5, format: '0'},
            		bar: {groupWidth: 20},
            		chartArea : { left: 60, top: 40, right:120, height: '57%'} // do not cut off labels
            };
            
  			chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
  			google.visualization.events.addListener(chart, 'ready', function () {
    			  var content = '<img src="' + chart.getImageURI() + '">';
    			  $('#image1').append(content);
    			}); 
  			chart.draw(data_chart, options);
		}

		function drawAcrossGraph_report3(){

			$("#progress_bar").html("");
	        $("#report_title").html("<h2 class='page-title-section-gray'><?php echo $sector_type_name;?> sector report</h2>");
	        $("#pdf_report").html("<a href='#' onclick='pdf_across_report3();' style='font-style: italic; text-decoration-color: gray;'><font color='gray'style='font-family: \"Open Sans\", Tahoma, Arial sans-serif;'>PDF report</font></a>");
	        $("#png_chart").html("<a href='#' onclick='javascript:grChartImg.ShowImage(\"chart_div\", true);' style='font-style: italic; text-decoration-color: gray;'><font color='gray'style='font-family: \"Open Sans\", Tahoma, Arial sans-serif;'>Print chart</font></a>");
	        $("#chart_title").html("<h2 id='chart_title_1' class='page-title-section'><?php echo $report_name . "</h2><h2 id='chart_title_2' class='page-title-section'>" . $date_title . "</h2>";?>");

	        //draw table
	       	 var data_table = new google.visualization.DataTable();
		       	data_table.addColumn('string', 'County name');
		       	data_table.addColumn('number', 'Total number <br>of male children <br>in the sample');
		       	data_table.addColumn('number', 'Number of <br>male children <br>who possess <br>life skills');
		       	data_table.addColumn('number', 'Proportion of <br>male children <br>who know what <br>to do in case <br>of violation');
		       	data_table.addColumn('number', 'Total number <br>of female children <br>in the sample');
		       	data_table.addColumn('number', 'Number of <br>female children <br>who possess <br>life skills');
	        	data_table.addColumn('number', 'Proportion of <br>female children <br>who know what <br>to do in case <br>of violation');
	        	data_table.addRows([
	        	<?php foreach ( $data_hash as $key=>$urows) {
echo "[{v:'" . $key . "'}, {v:" . $urows['MALE_D'] . "}, {v:" . $urows['MALE_N'] . "},{v:" . $urows['MALE'] . "},{v:" . 
    $urows['FEMALE_D'] . "},{v:" . $urows['FEMALE_N'] . "},{v:" . $urows['FEMALE'] . "}],";
	        	    	        	}?>
	        	    	  ]);
	          var table = new google.visualization.Table(document.getElementById('table_div'));

// 	          //add merge headers "Male" and "Female"// do not use this way because PDF cannot take correct headers.
// 	 	         var divTableChart = document.getElementById('table_div');
// 	          google.visualization.events.addListener(table, 'ready', function () {
// 	        	    var headerRow;
// 	        	    var newRow;
// 	        	    headerRow = divTableChart.getElementsByTagName('THEAD')[0].rows[0];
// 	        	    newRow = headerRow.cloneNode(true);
// 	        	    newRow.deleteCell(newRow.cells.length - 1);
// 	        	    newRow.deleteCell(newRow.cells.length - 1);
// 	        	    newRow.deleteCell(newRow.cells.length - 1);
// 	        	    newRow.deleteCell(newRow.cells.length - 1);
// 	        	    newRow.cells[0].colSpan = 1;
// 	        	    newRow.cells[0].innerHTML = '';
// 	        	    newRow.cells[1].colSpan = 3;
// 	        	    newRow.cells[1].innerHTML = 'Male';
// 	        	    newRow.cells[2].colSpan = 3;
// 	        	    newRow.cells[2].innerHTML = 'Female';
// 	        	    divTableChart.getElementsByTagName('THEAD')[0].insertBefore(newRow, headerRow);
// 	        	  });
	                
	         table.draw(data_table, {allowHtml: true, showRowNumber: false, width: '900px', height: '100%'});
	         <?php if($user->user_group === '1' || $user->user_group === '2'){?> //only for admin and super admin
	              $("#table1_csv").html(dataTableToCSV(data_table)); 
	              $("#table_div_csv").html("<a href='#' onclick='csv_report(\"" + $("#table1_csv").html() + "\");' style='font-style: italic; text-decoration-color: gray;'><font color='gray'style='font-family: \"Open Sans\", Tahoma, Arial sans-serif; font-size;7px'>CSV report</font></a>");
	         <?php }?>

			//draw chart
	         data_chart = new google.visualization.DataTable();
	        	data_chart.addColumn('string', 'County name');
	        	data_chart.addColumn('number', 'Male');
	        	data_chart.addColumn('number', 'Female');        
	        	data_chart.addRows([
	        	<?php 
	        	foreach ( $data_hash as $key=>$urows ) {
             $male = $urows['MALE']?$urows['MALE']:0;
 	        	    $female = $urows['FEMALE']?$urows['FEMALE']:0;
            echo "[ '" . $key . "', {v:" . $male . "}, {v:" . $female . "}],";
	        	 }?>
	        ]);

            var options = {
            		"title": "<?php echo $report_name . ' \nbetween period ' . $date_title; ?>",
            		//"legend":"none",
            		"width":1000,
            		"height":500,
            	 hAxis: {title:'County', slantedText:true, slantedTextAngle:90,showTextEvery:1 }, //lebel vertical view and show all
          		  vAxis: {title:'Percent who possess life skills', minValue:0, maxValue: 100, format: '0'},
            		bar: {groupWidth: 20},
            		chartArea : { left: 60, top: 40, right:120, height: '57%'} // do not cut off labels
            };
            
  			chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
  			google.visualization.events.addListener(chart, 'ready', function () {
    			  var content = '<img src="' + chart.getImageURI() + '">';
    			  $('#image1').append(content);
    			}); 
  			chart.draw(data_chart, options);
		}

		function drawAcrossGraph_report4(){

			$("#progress_bar").html("");
	        $("#report_title").html("<h2 class='page-title-section-gray'><?php echo $sector_type_name;?> sector report</h2>");
	        $("#pdf_report").html("<a href='#' onclick='pdf_across_report4();' style='font-style: italic; text-decoration-color: gray;'><font color='gray'style='font-family: \"Open Sans\", Tahoma, Arial sans-serif;'>PDF report</font></a>");
	        $("#png_chart").html("<a href='#' onclick='javascript:grChartImg.ShowImage(\"chart_div\", true);' style='font-style: italic; text-decoration-color: gray;'><font color='gray'style='font-family: \"Open Sans\", Tahoma, Arial sans-serif;'>Print chart</font></a>");
	        $("#chart_title").html("<h2 id='chart_title_1' class='page-title-section'><?php echo $report_name . "</h2><h2 id='chart_title_2' class='page-title-section'>" . $date_title . "</h2>";?>");

	        //draw table
	       	 var data_table = new google.visualization.DataTable();
		       	data_table.addColumn('string', 'County name');
		       	data_table.addColumn('number', 'Total number <br>of male children <br>in the sample');
		       	data_table.addColumn('number', 'Number of <br>male children <br>who report being <br>victims of violence <br>in the last <br>12 months');
		       	data_table.addColumn('number', 'Proportion <br>of male children <br>reporting violation <br>at home/school');
		       	data_table.addColumn('number', 'Total number <br>of female children <br>in the sample (Female)');
		       	data_table.addColumn('number', 'Number of <br>female children <br>who report being <br>victims of violence <br>in the last <br>12 months (Female)');
	        	data_table.addColumn('number', 'Proportion <br>of female children <br>reporting violation <br>at home/school');
	        	data_table.addRows([
	        	<?php foreach ( $data_hash as $key=>$urows) {
	echo "[{v:'" . $key . "'}, {v:" . $urows['MALE_D'] . "}, {v:" . $urows['MALE_N'] . "},{v:" . $urows['MALE'] . "},{v:" . $urows['FEMALE_D'] . "},{v:" . $urows['FEMALE_N'] . "},{v:" . $urows['FEMALE'] . "}],";
	        	    	        	}?>
	        	    	  ]);
	          var table = new google.visualization.Table(document.getElementById('table_div'));      
	         table.draw(data_table, {allowHtml: true, showRowNumber: false, width: '900px', height: '100%'});
	         <?php if($user->user_group === '1' || $user->user_group === '2'){?> //only for admin and super admin
	              $("#table1_csv").html(dataTableToCSV(data_table)); 
	              $("#table_div_csv").html("<a href='#' onclick='csv_report(\"" + $("#table1_csv").html() + "\");' style='font-style: italic; text-decoration-color: gray;'><font color='gray'style='font-family: \"Open Sans\", Tahoma, Arial sans-serif; font-size;7px'>CSV report</font></a>");
	         <?php }?>

			//draw chart
	         data_chart = new google.visualization.DataTable();
	        	data_chart.addColumn('string', 'County name');
	        	data_chart.addColumn('number', 'Male');
	        	data_chart.addColumn('number', 'Female');        
	        	data_chart.addRows([
	        	<?php 
	        	foreach ( $data_hash as $key=>$urows ) {
             $male = $urows['MALE']?$urows['MALE']:0;
 	        	    $female = $urows['FEMALE']?$urows['FEMALE']:0;
            echo "[ '" . $key . "', {v:" . $male . "}, {v:" . $female . "}],";
	        	 }?>
	        ]);

            var options = {
            		"title": "<?php echo $report_name . ' \nbetween period ' . $date_title; ?>",
            		//"legend":"none",
            		"width":1000,
            		"height":500,
            	 hAxis: {title:'County', slantedText:true, slantedTextAngle:90,showTextEvery:1 }, //lebel vertical view and show all
          		  vAxis: {title:'Proportion of children reporting violation at home/school', minValue:0, maxValue: 100, format: '0'},
            		bar: {groupWidth: 20},
            		chartArea : { left: 60, top: 40, right:120, height: '57%'} // do not cut off labels
            };
            
  			chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
  			google.visualization.events.addListener(chart, 'ready', function () {
    			  var content = '<img src="' + chart.getImageURI() + '">';
    			  $('#image1').append(content);
    			}); 
  			chart.draw(data_chart, options);
		}

		function drawAcrossDateAggregateGraph(){

			$("#progress_bar").html("");
	        $("#report_title").html("<h2 class='page-title-section-gray'><?php echo $sector_type_name;?> sector report</h2>");
	        $("#pdf_report").html("<a href='#' onclick='pdf_across_report();' style='font-style: italic; text-decoration-color: gray;'><font color='gray'style='font-family: \"Open Sans\", Tahoma, Arial sans-serif;'>PDF report</font></a>");
	        $("#png_chart").html("<a href='#' onclick='javascript:grChartImg.ShowImage(\"chart_div\", true);' style='font-style: italic; text-decoration-color: gray;'><font color='gray'style='font-family: \"Open Sans\", Tahoma, Arial sans-serif;'>Print chart</font></a>");
	        $("#chart_title").html("<h2 id='chart_title_1' class='page-title-section'><?php echo $report_name . "</h2><h2 id='chart_title_2' class='page-title-section'>" . $date_title . "</h2>";?>");


		      //draw table
	       	 var data_table = new google.visualization.DataTable();
	        	data_table.addColumn('string', 'County name');
	        	data_table.addColumn('number', 'Aggregates');
	        	data_table.addRows([
	        	<?php foreach ( $data as $urows ) {
	        	    echo "[{v: '" . $urows ['county_name'] . "'},  {v:" . $urows ['aggregate'] . "}],";
	        	}?>
	         ]);
	          var table = new google.visualization.Table(document.getElementById('table_div'));      
	         table.draw(data_table, {allowHtml: true, showRowNumber: false, width: '300px', height: '100%'});
	         <?php if($user->user_group === '1' || $user->user_group === '2'){?> //only for admin and super admin
	              $("#table1_csv").html(dataTableToCSV(data_table)); 
	              $("#table_div_csv").html("<a href='#' onclick='csv_report(\"" + $("#table1_csv").html() + "\");' style='font-style: italic; text-decoration-color: gray;'><font color='gray'style='font-family: \"Open Sans\", Tahoma, Arial sans-serif; font-size;7px'>CSV report</font></a>");
	         <?php }?>

			//draw chart
			var chart_data = [];
			 <?php if($report_id === '1' || $report_id === '2' || $report_id === '3' || $report_id === '4'){?>
			chart_data.push(['County', 'Aggregates']);
			chart_data.push(
			<?php
			$count = 0;
			foreach ( $data as $urows ) {
                if($count !== 0){
                    echo ",";
                }
			   echo "['" . $urows ['county_name'] . "'," . $urows ['aggregate'] . "]";
			    $count++;
			}
			?>
			);
			<?php }?>
            data_chart = google.visualization.arrayToDataTable(chart_data);
//             var options = {
//           		  vAxis: {minValue:0, maxValue: 5, format: '0'}
//             };
            var options = {
            		"title": "<?php echo $report_name . ' \nbetween period ' . $date_title; ?>",
            		"legend":"none",
            		"width":1000,
            		"height":500,
            	 hAxis: {slantedText:true, slantedTextAngle:90,showTextEvery:1 }, //lebel vertical view and show all
          		  vAxis: {minValue:0, maxValue: 5, format: '0'},
            		bar: {groupWidth: 20},
            		chartArea : { left: 40, top: 40, right:20, height: '57%'} // do not cut off labels
            };
  			chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
  			google.visualization.events.addListener(chart, 'ready', function () {
    			  var content = '<img src="' + chart.getImageURI() + '">';
    			  $('#image1').append(content);
    			}); 
  			chart.draw(data_chart, options);   
		}

		function drawAggregateGraph_report1(){ 

			$("#progress_bar").html("");
	        $("#report_title").html("<h2 class='page-title-section-gray'><?php echo $sector_type_name;?> sector report</h2>");
	        $("#pdf_report").html("<a href='#' onclick='pdf_report_simple();' style='font-style: italic; text-decoration-color: gray;'><font color='gray'style='font-family: \"Open Sans\", Tahoma, Arial sans-serif;'>PDF report</font></a>");
	        $("#png_chart").html("<a href='#' onclick='javascript:grChartImg.ShowImage(\"chart_div\", true);' style='font-style: italic; text-decoration-color: gray;'><font color='gray'style='font-family: \"Open Sans\", Tahoma, Arial sans-serif;'>Print chart</font></a>");
	        $("#chart_title").html("<h2 id='chart_title_1' class='page-title-section'><?php echo $report_name . "</h2><h2 id='chart_title_2' class='page-title-section'>(" . $county_name . ") " . $date_title . "</h2>";?>");

			//draw table
	       	 var data_table = new google.visualization.DataTable();
        	data_table.addColumn('string', 'Sex');
        	data_table.addColumn('string', 'Teachers and secretariat staff');
        	data_table.addColumn('string', 'MOE staff');
        	data_table.addColumn('string', 'Total');
        	data_table.addRows([['Male', <?php echo "{v:'" . $male_36 . "'}";?>, <?php echo "{v:'" . $male_33 . "'}";?>, <?php echo "{v:'" . ($male_33+$male_36) . "'}";?>], 
        	                	['Female', <?php echo "{v:'" . $female_36 . "'}";?>, <?php echo "{v:'" . $female_33 . "'}";?>, <?php echo "{v:'" . ($female_33+$female_36) . "'}";?>],
        	                	[{v: 'Total', p: {'style': 'font-weight: bold;'}}, <?php echo "{v:'" . ($female_36+$male_36) . "'}";?>, <?php echo "{v:'" . ($female_33+$male_33) . "'}";?>, <?php echo "{v:'" . ($female_33+$female_36+$male_33+$male_36) . "'}";?>]

        	]);
	        
	          var table = new google.visualization.Table(document.getElementById('table_div'));      
	         table.draw(data_table, {allowHtml: true, showRowNumber: false, width: '500px', height: '100%'});
	         <?php if($user->user_group === '1' || $user->user_group === '2'){?> //only for admin and super admin
	              $("#table1_csv").html(dataTableToCSV(data_table)); 
	              $("#table_div_csv").html("<a href='#' onclick='csv_report(\"" + $("#table1_csv").html() + "\");' style='font-style: italic; text-decoration-color: gray;'><font color='gray'style='font-family: \"Open Sans\", Tahoma, Arial sans-serif; font-size;7px'>CSV report</font></a>");
	         <?php }?>

			//draw chart
			var chart_data = [];
			chart_data = [
			              ['', 'Male', 'Female'],
			              ['Teachers and secretariat staff',<?php echo $male_36;?>,<?php echo $female_36;?>],
			              ['MOE staff',<?php echo $male_33;?>,<?php echo $female_33;?>]
			           ];
			
            data_chart = google.visualization.arrayToDataTable(chart_data);
            var options = {
            		"title": "<?php echo $report_name . ' \nbetween period ' . $date_title . ' in ' . $county_name; ?>",
            		"width":1000,
            		"height":500,
           		  vAxis: {title:'Number trained', minValue:0, maxValue: 5},
             		//chartArea : { left: 20, top: 40, bottom: 90, height: '60%'} // do not cut off labels
            };
  			chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
  			google.visualization.events.addListener(chart, 'ready', function () {
    			  var content = '<img src="' + chart.getImageURI() + '">';
    			  $('#image1').append(content);
    			}); 
  			chart.draw(data_chart, options);   
		}

		function drawAggregateGraph_report2(){ 

			$("#progress_bar").html("");
	        $("#report_title").html("<h2 class='page-title-section-gray'><?php echo $sector_type_name;?> sector report</h2>");
	        $("#pdf_report").html("<a href='#' onclick='pdf_report_simple();' style='font-style: italic; text-decoration-color: gray;'><font color='gray'style='font-family: \"Open Sans\", Tahoma, Arial sans-serif;'>PDF report</font></a>");
	        $("#png_chart").html("<a href='#' onclick='javascript:grChartImg.ShowImage(\"chart_div\", true);' style='font-style: italic; text-decoration-color: gray;'><font color='gray'style='font-family: \"Open Sans\", Tahoma, Arial sans-serif;'>Print chart</font></a>");
	        $("#chart_title").html("<h2 id='chart_title_1' class='page-title-section'><?php echo $report_name . "</h2><h2 id='chart_title_2' class='page-title-section'>(" . $county_name . ") " . $date_title . "</h2>";?>");

			//draw table
	       	 var data_table = new google.visualization.DataTable();
        	data_table.addColumn('string', 'Ownership');
        	data_table.addColumn('number', 'Schools surveyed');
        	data_table.addColumn('number', 'Schools implementing life skills');
        	data_table.addColumn('number', 'Percent');
         	data_table.addRows([
                [{v: 'Private'},  {v:<?php echo $private_D;?>}, {v:<?php echo $private_N;?>}, {v:<?php echo $private_percent;?>}],
                [{v: 'Public'},  {v:<?php echo $public_D;?>}, {v:<?php echo $public_N;?>}, {v:<?php echo $public_percent;?>}],
                [{v: 'Total'},  {v:<?php echo ($public_D + $private_D);?>}, {v:<?php echo ($public_N+$private_N);?>}, {v:<?php echo ($public_percent+$private_percent);?>}],	        	
         	    	         ]);
	        
	          var table = new google.visualization.Table(document.getElementById('table_div'));      
	         table.draw(data_table, {allowHtml: true, showRowNumber: false, width: '600px', height: '100%'});
	         <?php if($user->user_group === '1' || $user->user_group === '2'){?> //only for admin and super admin
	              $("#table1_csv").html(dataTableToCSV(data_table)); 
	              $("#table_div_csv").html("<a href='#' onclick='csv_report(\"" + $("#table1_csv").html() + "\");' style='font-style: italic; text-decoration-color: gray;'><font color='gray'style='font-family: \"Open Sans\", Tahoma, Arial sans-serif; font-size;7px'>CSV report</font></a>");
	         <?php }?>

			//draw chart
	         chart_data = [
				              ['Ownership', 'Percent'],
				              ['Private',<?php echo $private_percent ;?>],
				              ['Public',<?php echo $public_percent ;?>]
				           ];
				
	            data_chart = google.visualization.arrayToDataTable(chart_data);
				        var options = {
				        		"title": "<?php echo $report_name . ' \nbetween period ' . $date_title . ' in ' . $county_name; ?>",
					              		"width":1000,
					              		"height":500,
					    
					              };
	  			chart = new google.visualization.PieChart(document.getElementById('chart_div'));
  			google.visualization.events.addListener(chart, 'ready', function () {
    			  var content = '<img src="' + chart.getImageURI() + '">';
    			  $('#image1').append(content);
    			}); 
  			chart.draw(data_chart, options);   
		}

		function drawAggregateGraph_report3(){ 

			$("#progress_bar").html("");
	        $("#report_title").html("<h2 class='page-title-section-gray'><?php echo $sector_type_name;?> sector report</h2>");
	        $("#pdf_report").html("<a href='#' onclick='pdf_report3();' style='font-style: italic; text-decoration-color: gray;'><font color='gray'style='font-family: \"Open Sans\", Tahoma, Arial sans-serif;'>PDF report</font></a>");
	        $("#png_chart").html("<a href='#' onclick='javascript:grChartImg.ShowImage(\"chart_div\", true);' style='font-style: italic; text-decoration-color: gray;'><font color='gray'style='font-family: \"Open Sans\", Tahoma, Arial sans-serif;'>Print chart</font></a>");
	        $("#chart_title").html("<h2 id='chart_title_1' class='page-title-section'><?php echo $report_name . "</h2><h2 id='chart_title_2' class='page-title-section'>(" . $county_name . ") " . $date_title . "</h2>";?>");

			//draw table
	       	 var data_table = new google.visualization.DataTable(); 
		    data_table.addColumn('string', '');
        	data_table.addColumn('number', 'Number of males <br>with skills');
        	data_table.addColumn('number', 'Number of females <br>with skills');
        	data_table.addColumn('number', 'Total children <br>with skills');
        	data_table.addColumn('number', 'Total males <br>surveyed');
        	data_table.addColumn('number', 'Total females <br>surveyed');
        	data_table.addColumn('number', 'Total children <br>surveyed');
        	data_table.addColumn('number', 'Proportion <br>of males <br>with skills');
        	data_table.addColumn('number', 'Proportion <br>of females <br>with skills');
        	data_table.addColumn('number', 'Proportion <br>of children <br>with skills');
        	data_table.addRows([
        	    <?php
        	    $proportion_male = 0;
        	    $proportion_female = 0;
        	    $total_D = $male_report3_D+$female_report3_D;
        	    if($total_D >0){
        	        $proportion_male = round(($male_report3_N/$total_D)*100,2);
        	        $proportion_female = round(($female_report3_N/$total_D)*100,2);
        	    } 
        	    ?>
        	   [{v: 'Total', p: {'style': 'font-weight: bold;'}}, 
        	   <?php echo "{v:" . $male_report3_N . "}";?>, <?php echo "{v:" . $female_report3_N . "}";?>, <?php echo "{v:" . ($male_report3_N+$female_report3_N) . "}";?>,
        	    <?php echo "{v:" . $male_report3_D . "}";?>, <?php echo "{v:" . $female_report3_D . "}";?>, <?php echo "{v:" . $total_D . "}";?>,
        	    <?php echo "{v:" . $proportion_male . "}";?>, <?php echo "{v:" . $proportion_female . "}";?>, <?php echo "{v:" . ($proportion_female+$proportion_male) . "}";?>]

        	]);
	          var table = new google.visualization.Table(document.getElementById('table_div'));      
	         table.draw(data_table, {allowHtml: true, showRowNumber: false, width: '900px', height: '100%'});
	         <?php if($user->user_group === '1' || $user->user_group === '2'){?> //only for admin and super admin
	              $("#table1_csv").html(dataTableToCSV(data_table)); 
	              $("#table_div_csv").html("<a href='#' onclick='csv_report(\"" + $("#table1_csv").html() + "\");' style='font-style: italic; text-decoration-color: gray;'><font color='gray'style='font-family: \"Open Sans\", Tahoma, Arial sans-serif; font-size;7px'>CSV report</font></a>");
	         <?php }?>

			//draw chart
			var chart_data = [];
			chart_data = [
			              ['', 'Proportion'],
			              ['Male',<?php echo $proportion_male?>],
			              ['Female',<?php echo $proportion_female;?>],
			              ['Total',<?php echo ($proportion_female+$proportion_male);?>]
			           ];
			
            data_chart = google.visualization.arrayToDataTable(chart_data);
            var options = {
            		"title": "<?php echo $report_name . ' \nbetween period ' . $date_title . ' in ' . $county_name; ?>",
            		"legend":"none",
            		"width":1000,
            		"height":500,
            		hAxis: {title:'Percent who possess life skills'},
           		  vAxis: {title:'Sex of children', minValue:0, maxValue: 5},
             		//chartArea : { left: 20, top: 40, bottom: 90, height: '60%'} // do not cut off labels
            };
  			chart = new google.visualization.BarChart(document.getElementById('chart_div'));
  			google.visualization.events.addListener(chart, 'ready', function () {
    			  var content = '<img src="' + chart.getImageURI() + '">';
    			  $('#image1').append(content);
    			}); 
  			chart.draw(data_chart, options);   
		}

		function drawAggregateGraph_report4_violence(){
			$("#progress_bar").html("");
	        $("#report_title").html("<h2 class='page-title-section-gray'><?php echo $sector_type_name;?> sector report</h2>");
	        $("#pdf_report").html("<a href='#' onclick='pdf_report_report4(<?php echo count($data_hash4['violence_type']);?>);' style='font-style: italic; text-decoration-color: gray;'><font color='gray'style='font-family: \"Open Sans\", Tahoma, Arial sans-serif;'>PDF report</font></a>");
	        $("#png_chart").html("<a href='#' onclick='javascript:grChartImg.ShowImage(\"chart_div\", true);' style='font-style: italic; text-decoration-color: gray;'><font color='gray'style='font-family: \"Open Sans\", Tahoma, Arial sans-serif;'>Print chart</font></a>");
	        $("#chart_title").html("<h2 id='chart_title_1' class='page-title-section'><?php echo $report_name . "</h2><h2 id='chart_title_2' class='page-title-section'>(" . $county_name . ") " . $date_title . "</h2>";?>");

			//draw table for violence 
	       	 var data_table = new google.visualization.DataTable();
        	data_table.addColumn('string', ' ');
        	data_table.addColumn('number', 'Male<br> (12 month total <br>reporting <br>violation)');
        	data_table.addColumn('number', 'Female<br> (12 month total <br>reporting <br>violation)');
        	data_table.addColumn('number', 'Overall total <br>reporting <br>violation');
        	data_table.addColumn('number', 'Total in <br>sample');
        	data_table.addColumn('number', 'Proportion <br>of reports <br>by males');
        	data_table.addColumn('number', 'Proportion <br>of reports <br>by females');
        	data_table.addRows([
        	                	<?php 
        	                	$sample = $data_hash4['sample']?$data_hash4['sample']:0;
        	                	foreach ( $data_hash4['violence_type'] as $key=>$urows ) {
        	                	    $male = $urows['male']?$urows['male']:0;
        	                	    $female = $urows['female']?$urows['female']:0;
        	                	    $male_total = $urows['male_total']?$urows['male_total']:0;
        	                	    $female_total = $urows['female_total']?$urows['female_total']:0;
        	                	    $total = $urows['total']?$urows['total']:0;
        	               
        	echo "[{v: '" . $key . "'}, {v:" . $male_total . "}, {v:" . $female_total . "}, {v:" . $total . "},{v:" . $sample . "},{v:" . $male . "},{v:" . $female . "},  ],";
        	                	    	        	}?>
        	                	    	         ]);
            
	          var table = new google.visualization.Table(document.getElementById('table_div'));      
	         table.draw(data_table, {allowHtml: true, showRowNumber: false, width: '800px', height: '100%'});
	         <?php if($user->user_group === '1' || $user->user_group === '2'){?> //only for admin and super admin
	              $("#table1_csv").html(dataTableToCSV(data_table)); 
	              $("#table_div_csv").html("<a href='#' onclick='csv_report(\"" + $("#table1_csv").html() + "\");' style='font-style: italic; text-decoration-color: gray;'><font color='gray'style='font-family: \"Open Sans\", Tahoma, Arial sans-serif; font-size;7px'>CSV report</font></a>");
	         <?php }?>

	 			//draw chart for violence
	 			var chart_data = [];
	 			chart_data = [
	 			              ['', 'Male', 'Female'],
		 			             <?php foreach ( $data_hash4['violence_type'] as $key=>$urows ) {
		 			                 $male = $urows['male']?$urows['male']:0;
		 			                 $female = $urows['female']?$urows['female']:0;
				              echo "['" . $key . "'," . $male . "," . $female . "],";
		 			             }?>
	 			           ];
				
	             data_chart = google.visualization.arrayToDataTable(chart_data);
	             var options = {
	            		 "title": "<?php echo $report_name . ' \nbetween period ' . $date_title . ' in ' . $county_name; ?>",
	             		//"legend":"none",
	             		"width":1000,
	             		"height":500,
	             		hAxis: {title:'Percent indicating violation via self-report',minValue:0, maxValue: 100},
	            		  vAxis: {title:'Type of violence'},
	              		chartArea : { left: 200, top: 40, right:120, bottom: 90, height: '60%'} // do not cut off labels
	             };
	   			chart = new google.visualization.BarChart(document.getElementById('chart_div'));
	   			google.visualization.events.addListener(chart, 'ready', function () {
	     			  var content = '<img src="' + chart.getImageURI() + '">';
	     			  $('#image1').append(content);
	     			}); 
	   			chart.draw(data_chart, options); 
		}

		function drawAggregateGraph_report4_identity(){ 
			$("#png_chart2").html("<a href='#' onclick='javascript:grChartImg.ShowImage(\"chart_div2\", true);' style='font-style: italic; text-decoration-color: gray;'><font color='gray'style='font-family: \"Open Sans\", Tahoma, Arial sans-serif;'>Print chart</font></a>");
	        
		      //draw table for identity 
	       	 var data_table = new google.visualization.DataTable();
		       	data_table.addColumn('string', ' ');
	        	data_table.addColumn('number', 'Male<br> (12 month total<br> reporting<br> violation)');
	        	data_table.addColumn('number', 'Female<br> (12 month total<br> reporting<br> violation)');
	        	data_table.addColumn('number', 'Overall total<br> reporting<br> violation');
	        	data_table.addColumn('number', 'Total in<br >sample');
	        	data_table.addColumn('number', 'Proportion <br>of reports <br>by males');
	        	data_table.addColumn('number', 'Proportion <br>of reports <br>by females');
	        	data_table.addRows([
	        	                	<?php  $sample = $data_hash4['sample']?$data_hash4['sample']:0;
	        	                	foreach ( $data_hash4['identity'] as $key=>$urows ) {
	        	                	    $male = $urows['male']?$urows['male']:0;
	        	                	    $female = $urows['female']?$urows['female']:0;
	        	                	    $male_total = $urows['male_total']?$urows['male_total']:0;
	        	                	    $female_total = $urows['female_total']?$urows['female_total']:0;
	        	                	    $total = $urows['total']?$urows['total']:0;
	        	                	
	        	echo "[{v: '" . $key . "'}, {v:" . $male_total . "}, {v:" . $female_total . "}, {v:" . $total . "},{v:" . $sample . "},{v:" . $male . "},{v:" . $female . "},  ],";
	        	                	    	        	}?>
	        	                	    	         ]);
	        	var table = new google.visualization.Table(document.getElementById('table_div2'));      
		         table.draw(data_table, {allowHtml: true, showRowNumber: false, width: '800px', height: '100%'});
		         <?php if($user->user_group === '1' || $user->user_group === '2'){?> //only for admin and super admin
		              $("#table1_csv2").html(dataTableToCSV(data_table)); 
		              $("#table_div_csv2").html("<a href='#' onclick='csv_report(\"" + $("#table1_csv2").html() + "\");' style='font-style: italic; text-decoration-color: gray;'><font color='gray'style='font-family: \"Open Sans\", Tahoma, Arial sans-serif; font-size;7px'>CSV report</font></a>");
		         <?php }?>

			       //draw chart for identity
		 			var chart_data = [];
		 			chart_data = [
		 			              ['', 'Male', 'Female'],
			 			             <?php foreach ( $data_hash4['identity'] as $key=>$urows ) {
			 			                 $male = $urows['male']?$urows['male']:0;
			 			                 $female = $urows['female']?$urows['female']:0;
					              echo "['" . $key . "'," . $male . "," . $female . "],";
			 			             }?>
		 			           ];
					
		             data_chart = google.visualization.arrayToDataTable(chart_data);
		             var options = {
		            		 "title": "<?php echo $report_name . ' \nbetween period ' . $date_title . ' in ' . $county_name; ?>",
		             		//"legend":"none",
		             		"width":1000,
		             		"height":500,
		             		hAxis: {title:'Percent indicating violation via self-report', minValue:0, maxValue: 100},
		            		  vAxis: {title:'Perpetrator'},
		              		chartArea : { left: 200, top: 40, right:120, bottom: 90, height: '60%'} // do not cut off labels
		             };
		   			chart = new google.visualization.BarChart(document.getElementById('chart_div2'));
		   			google.visualization.events.addListener(chart, 'ready', function () {
		     			  var content = '<img src="' + chart.getImageURI() + '">';
		     			  $('#image2').append(content);
		     			}); 
		   			chart.draw(data_chart, options); 
    	
		}

      </script>

<div id="main-content">

    <div id='table1_csv' style='display: none'></div>
    <div id='table1_csv2' style='display: none'></div>
	<div id='image1' style='display: none'></div>
	<div id='table2_csv' style='display: none'></div>
	<div id='image2' style='display: none'></div>

	<div id='progress_bar' align='center'><br><br><img src='../UI/images/page_loading_animation.gif' width=130 height=160/></div>
	<div id="report_content">

		<table width=100% border=0>
		<caption align="bottom" ><div id='pdf_report' align='right' style='margin-top:-9px;'></div></caption>
		<tr><td><div id='report_title'></div></td></tr>
		</table>

		<table width=100% border=0>
			<tr>
				<td colspan=1 align='center'><div id='chart_title'></div></td>
			</tr>
			<tr>
				<td valign='top'><br><div id="table_div"></div>
				<div id='table_div_csv' align='left' style='margin-top:-8px;'></div></td>
			</tr>
			<tr>
				<td valign='top' align='left'><div id="chart_div" align='left'></div>
				<div id='png_chart' align='left' style='margin-top:-9px;'></div></td>
			</tr>
			
			
			<tr>
				<td valign='top'><br><div id="table_div2"></div>
				<div id='table_div_csv2' align='left' style='margin-top:-8px;'></div></td>
			</tr>
			<tr>
				<td valign='top' align='left'><div id="chart_div2" align='left'></div>
				<div id='png_chart2' align='left' style='margin-top:-9px;'></div></td>
			</tr>
			
			
			<tr>
				<td colspan=2 align='center'><div id='detailed_title'></div></td>
			</tr>
			<tr>
				<td colspan=2><div id='detailed_report_table'></div>
				<div id='detailed_table_div_csv' align='left' style='margin-top:-8px;'></div></td>
			</tr>
			<tr>
				<td colspan=2><br>
				<div id='detailed_report_chart' style="width: 100%; height: 500px;"></div>
				<div id='png_chart_detailed' align='left' style='margin-top:-9px;'></div></td>
			</tr>
		</table>
	</div>
</div>
<?php
} else {
    // Redirect user back to login page if there is no valid session created
    header("Location: ../login.php");
}
?>