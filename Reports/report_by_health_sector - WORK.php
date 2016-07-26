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
    
    //for report 3
    $male_age_under_18 = 0;
    $male_age_above_18 = 0;
    $female_age_under_18 = 0;
    $female_age_above_18 = 0;
    
    //for report 4
    $male_less18_total_N = 0;
    $female_less18_total_N = 0;
    $male_more18_total_N = 0;
    $female_more18_total_N = 0;
    $male_less18_total_D = 0;
    $female_less18_total_D = 0;
    $male_more18_total_D = 0;
    $female_more18_total_D = 0;
    
    $data = array();
    
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
    
    if($sector_type_id == 2){
        // date format in database 0000-00-00
        $fromdate_arr = explode("/", $fromdate);
        $fromdate_new = $fromdate_arr[1] ."-" .  $fromdate_arr[0] . "-01";
        $todate_arr = explode("/", $todate);
        $todate_new = $todate_arr[1] ."-" .  $todate_arr[0] . "-31";
        
        if($report_id === '1'){ //1/37*100
            // get for indicator 1
            
            $sql = "select ownerships.ownership, sum(aggregate) as aggregate from health_aggregates
                    join ownerships on health_aggregates.ownership_id=ownerships.id
                    where indicator_id in (1) and county_id=" . $county_id . " and date between '" .
                            $fromdate_new . "' and '" . $todate_new . "' group by ownerships.ownership";
            if($county_id === "all"){
                $sql = "select ownerships.ownership, sum(aggregate) as aggregate from health_aggregates
                    join ownerships on health_aggregates.ownership_id=ownerships.id
                    where indicator_id in (1) and date between '" .
                            $fromdate_new . "' and '" . $todate_new . "' group by ownerships.ownership";
            }else if($county_id === "across"){
                $sql = "select counties.county_name, sum(aggregate) as aggregate from health_aggregates 
                    join counties on counties.county_id=health_aggregates.county_id " .
                    " where indicator_id in (1) and date between '" .
                    $fromdate_new . "' and '" . $todate_new . "' group by health_aggregates.county_id order by counties.county_id";
            }
            if($debug){
                   print $sql . "<br>";
            }
            $result = mysql_query($sql);
            $data_all_N=$db->processRowSet($result);
            
            // get for indicator 37
            $sql = "select sum(aggregate) as aggregate from health_aggregates  
                where indicator_id in (37) and county_id=" . $county_id . " and date between '" .
                $fromdate_new . "' and '" . $todate_new . "'";
            if($county_id === "all"){
                $sql = "select sum(aggregate) as aggregate from health_aggregates
                where indicator_id in (37) and date between '" .
                                $fromdate_new . "' and '" . $todate_new . "'";
            }else if($county_id === "across"){
                $sql = "select counties.county_name, sum(aggregate) as aggregate from health_aggregates 
                    join counties on counties.county_id=health_aggregates.county_id " .
                    " where indicator_id in (37) and date between '" .
                    $fromdate_new . "' and '" . $todate_new . "' group by health_aggregates.county_id order by counties.county_id";
            }
            if($debug){
                print $sql . "<br>";
            }
            $result2 = mysql_query($sql);
            $data_all_D=$db->processRowSet($result2);
            
            if($county_id === "across"){
            //create data with all counties for cross county report
                foreach ( $counties as $urows ) {
                    $data_hash2[str_replace("'", "", $urows ['1'])]['N'] = 0;
                    $data_hash2[str_replace("'", "", $urows ['1'])]['D'] = 0;
                    $data_hash2[str_replace("'", "", $urows ['1'])]['N/D'] = 0;
                }
                 //add recieved data to array
            //add recieved data to array
                foreach ( $data_all_D as $urows3 ) {
                    $data_hash2[str_replace("'", "", $urows3['county_name'])]['D'] = $urows3['aggregate'];
                    array_push($data, $urows3); // do not display message "No data"
                    foreach ( $data_all_N as $urows4 ){
                        if($urows4 ['county_name'] === $urows3['county_name']){
                            $data_hash2[str_replace("'", "", $urows4['county_name'])]['N'] = $urows4['aggregate'];
                            if($urows3 ['aggregate'] >0){
                                $data_hash2[str_replace("'", "", $urows4['county_name'])]['N/D'] = round(($urows4 ['aggregate']/$urows3 ['aggregate'])*100,2);
                            }
                            unset($urows4);
                        }
                    }
                }
                if($debug){
                 print_r($data_hash2);
                }
            }else{
            $total_facilities = 0;
                $total_ownerships = 0;
                $total_proportion = 0;
                foreach ( $data_all_D as $urows3 ){
                    $total_facilities = $urows3 ['aggregate'];
                }
                if($total_facilities != 0){
                    foreach ( $data_all_N as $urows4 ) {
                        array_push($data, $urows4); // do not display message "No data"
                        $data_hash['ownership'][$urows4['ownership']]['total'] = $urows4['aggregate'];
                        $total_ownerships = $total_ownerships + $urows4['aggregate'];
                        $proportion = round($urows4['aggregate']/$total_facilities,2)*100;
                        $data_hash['ownership'][$urows4['ownership']]['proportion'] = $proportion;
                        $total_proportion = $total_proportion + $proportion;
                    }
                }
                if($debug){
                    print_r($data_all_N); print "<br><br>";
                    print_r($data_all_D); print "<br><br>";
                    print_r($data_hash); print "<br><br>";
                }
            }            
        }else if($report_id === '2'){
            $sql = "select health_aggregates.gender, cadres.cadre, sum(aggregate) as aggregate from health_aggregates 
                join cadres on health_aggregates.cadre_id=cadres.id 
                where indicator_id in (2) and county_id=" . $county_id . " and date between '" .
                $fromdate_new . "' and '" . $todate_new . "' group by cadre, health_aggregates.gender order by cadre, health_aggregates.gender";
            if($county_id === "all"){
                $sql = "select health_aggregates.gender, cadres.cadre, sum(aggregate) as aggregate from health_aggregates
                join cadres on health_aggregates.cadre_id=cadres.id
                where indicator_id in (2) and date between '" .
                $fromdate_new . "' and '" . $todate_new . "' group by cadre_id, health_aggregates.gender order by cadre_id, health_aggregates.gender";
                
            }else if($county_id === "across"){
                $sql = "select gender, counties.county_name, sum(aggregate) as aggregate from health_aggregates 
                    join counties on counties.county_id=health_aggregates.county_id " .
                    " where indicator_id in (2) and date between '" .
                    $fromdate_new . "' and '" . $todate_new . "' group by gender, health_aggregates.county_id order by counties.county_id";
            }
            if($debug){
                print $sql . "<br>";
            }
            $result = mysql_query($sql);
            $data=$db->processRowSet($result);
            
            if($county_id === "across"){
                //create data with all counties for cross county report
                foreach ( $counties as $urows ) {
                    $data_hash_across_2[str_replace("'", "", $urows ['1'])]['MALE'] = 0;
                    $data_hash_across_2[str_replace("'", "", $urows ['1'])]['FEMALE'] = 0;
                }
                //add recieved data to array
                foreach ( $data as $urows4 ) {
                    $data_hash_across_2[str_replace("'", "", $urows4['county_name'])][strtoupper($urows4['gender'])] = $urows4['aggregate'];
                }
                if($debug){
                    print_r($data); print "<br><br>";
                    print_r($data_hash_across_2);
                }      
            }else{
                foreach ( $data as $urows4 ) {
                    $data_hash[$urows4['cadre']][strtoupper($urows4['gender'])] = $urows4['aggregate'];
                }
            }
        }else if($report_id === '3'){//3
            if($county_id === "all"){
                $sql = "select age_range, gender, sum(aggregate) as aggregate from health_aggregates
                where indicator_id in (3) and date between '" .
                                $fromdate_new . "' and '" . $todate_new . "' group by gender, age_range order by date, age_range, gender";
                $result = mysql_query($sql);
                $data=$db->processRowSet($result);
            }else if($county_id === "across"){
                $sql = "select age_range, gender, counties.county_name, sum(aggregate) as aggregate from health_aggregates 
                join counties on counties.county_id=health_aggregates.county_id 
                    where indicator_id in (3) and date between '" .
                $fromdate_new . "' and '" . $todate_new . "' group by gender, age_range, health_aggregates.county_id;";
                $result = mysql_query($sql);
                $data=$db->processRowSet($result);  
            }else{
                $sql = "select age_range, gender, sum(aggregate) as aggregate from health_aggregates
                where indicator_id in (3) and county_id=" . $county_id . " and date between '" .
                                $fromdate_new . "' and '" . $todate_new . "' group by gender, age_range order by date, age_range, gender";
                $result = mysql_query($sql);
                $data=$db->processRowSet($result);
            } 
            if($debug){
                print $sql . "<br>";
            } 
            //print $sql . "<br>";       
            if($county_id !== "across"){               
                foreach ( $data as $urows ) {
                    $age = strtoupper($urows ['age_range']);
                    $gender = strtoupper($urows ['gender']);
                    if($gender === "MALE"){
                        if($age === "0-11" || $age === "12-17"){
                            $male_age_under_18 += $urows ['aggregate'];
                        }else{
                            $male_age_above_18 += $urows ['aggregate'];
                        }
                    }else if($gender === "FEMALE"){
                        if($age === "0-11" || $age === "12-17"){
                            $female_age_under_18 += $urows ['aggregate'];
                        }else{
                            $female_age_above_18 += $urows ['aggregate'];
                        }
                    }
                }               //print_r($data);
            }else{
                //create data with all counties for cross county report
                foreach ( $counties as $urows ) {
                    $data_hash_across_3[str_replace("'", "", $urows ['1'])]['MALE_LESS18'] = 0;
                    $data_hash_across_3[str_replace("'", "", $urows ['1'])]['MALE_MORE18'] = 0;
                    $data_hash_across_3[str_replace("'", "", $urows ['1'])]['FEMALE_LESS18'] = 0;
                    $data_hash_across_3[str_replace("'", "", $urows ['1'])]['FEMALE_MORE18'] = 0;
                }
                //add recieved data to array
                foreach ( $data as $urows4 ) {
                    $age = strtoupper($urows4['age_range']);
                    $gender = strtoupper($urows4['gender']);
                    if($gender === "MALE"){
                        if($age === "0-11" || $age === "12-17"){
                            $data_hash_across_3[str_replace("'", "", $urows4['county_name'])]['MALE_LESS18'] += $urows4['aggregate'];
                        }else{
                            $data_hash_across_3[str_replace("'", "", $urows4['county_name'])]['MALE_MORE18'] += $urows4['aggregate'];
                        }
                    }else if($gender === "FEMALE"){
                        if($age === "0-11" || $age === "12-17"){
                            $data_hash_across_3[str_replace("'", "", $urows4['county_name'])]['FEMALE_LESS18'] += $urows4['aggregate'];
                        }else{
                            $data_hash_across_3[str_replace("'", "", $urows4['county_name'])]['FEMALE_MORE18'] += $urows4['aggregate'];
                        }
                    }
                }
                if($debug){
                    print_r($data); print "<br><br>";
                    print_r($data_hash_across_3);
                }
            }
        }else if($report_id === '4' || $report_id === '5' || $report_id === '6'){ 
            // for report 4: (4/38)*100; for report 5: (11/4)*100; for report 6: ((4+5+6+39)/3)*100
            // for cross 4: 4/38 by age and gender
            //report 4
            $indicator_query_N = 4;
            $indicator_query_D = 38;
            if($report_id === '5'){
                $indicator_query_N = 11;
                $indicator_query_D = 4;
            }else if($report_id === '6'){
                $indicator_query_N = '4,5,6,39';
                $indicator_query_D = 3;
            }
             $sql = "select age_range, gender, sum(aggregate) as aggregate from health_aggregates
                where indicator_id in (" . $indicator_query_N . ") and county_id=" . $county_id . " and date between '" .
                                $fromdate_new . "' and '" . $todate_new . "' group by gender, age_range";
            if($county_id === "all"){
                 $sql = "select age_range, gender, sum(aggregate) as aggregate from health_aggregates
                where indicator_id in (" . $indicator_query_N . ") and date between '" .
                                $fromdate_new . "' and '" . $todate_new . "' group by gender, age_range";
            }else if($county_id === "across"){
                $sql = "select age_range, gender, counties.county_name, sum(aggregate) as aggregate from health_aggregates join counties on counties.county_id=health_aggregates.county_id " .
                    " where indicator_id in (" . $indicator_query_N . ") and date between '" .
                    $fromdate_new . "' and '" . $todate_new . "' group by gender, age_range, health_aggregates.county_id";
            }
        if($debug){
                   print $sql . "<br>";
            }
            $result = mysql_query($sql);
            $data_all_N=$db->processRowSet($result);
            
            $sql = "select age_range, gender, sum(aggregate) as aggregate from health_aggregates
                where indicator_id in (" . $indicator_query_D . ") and county_id=" . $county_id . " and date between '" .
                            $fromdate_new . "' and '" . $todate_new . "' group by gender, age_range";
            if($county_id === "all"){
                $sql = "select age_range, gender, sum(aggregate) as aggregate from health_aggregates
                where indicator_id in (" . $indicator_query_D . ") and date between '" .
                            $fromdate_new . "' and '" . $todate_new . "' group by gender, age_range";
            }else if($county_id === "across"){
                $sql = "select gender, age_range, counties.county_name, sum(aggregate) as aggregate from health_aggregates join counties on counties.county_id=health_aggregates.county_id " .
                    " where indicator_id in (" . $indicator_query_D . ") and date between '" .
                    $fromdate_new . "' and '" . $todate_new . "' group by gender, age_range, health_aggregates.county_id";
            }
            if($debug){
                print $sql . "<br>";
            }
            $result2 = mysql_query($sql);
            $data_all_D=$db->processRowSet($result2);
            
            if($county_id === "across"){
                //create data with all counties for cross county report
                foreach ( $counties as $urows ) {
                    $data_hash_across_4[str_replace("'", "", $urows ['1'])]['MALE_LESS18_N'] = 0;
                    $data_hash_across_4[str_replace("'", "", $urows ['1'])]['MALE_LESS18_D'] = 0;
                    $data_hash_across_4[str_replace("'", "", $urows ['1'])]['MALE_MORE18_N'] = 0;
                    $data_hash_across_4[str_replace("'", "", $urows ['1'])]['MALE_MORE18_D'] = 0;
                    $data_hash_across_4[str_replace("'", "", $urows ['1'])]['FEMALE_LESS18_N'] = 0;
                    $data_hash_across_4[str_replace("'", "", $urows ['1'])]['FEMALE_LESS18_D'] = 0;
                    $data_hash_across_4[str_replace("'", "", $urows ['1'])]['FEMALE_MORE18_N'] = 0;
                    $data_hash_across_4[str_replace("'", "", $urows ['1'])]['FEMALE_MORE18_D'] = 0;
                }
                foreach ( $data_all_D as $urows3 ) {
                    array_push($data, $urows3); //do not show "No data" message
                    if(strtoupper($urows3 ['gender']) === "MALE"){
                        if($urows3 ['age_range'] === "0-11" || $urows3 ['age_range'] === "12-17"){
                            $data_hash_across_4[str_replace("'", "", $urows3['county_name'])]['MALE_LESS18_D'] += $urows3['aggregate'];
                        }else{
                            $data_hash_across_4[str_replace("'", "", $urows3['county_name'])]['MALE_MORE18_D'] += $urows3['aggregate'];
                        }
                    }else if(strtoupper($urows3 ['gender']) === "FEMALE"){
                        if($urows3 ['age_range'] === "0-11" || $urows3 ['age_range'] === "12-17"){
                            $data_hash_across_4[str_replace("'", "", $urows3['county_name'])]['FEMALE_LESS18_D'] += $urows3['aggregate'];
                        }else{
                            $data_hash_across_4[str_replace("'", "", $urows3['county_name'])]['FEMALE_MORE18_D'] += $urows3['aggregate'];
                        }
                    }
                    foreach ( $data_all_N as $urows4 ){
                        if($urows4 ['county_name'] === $urows3['county_name'] && 
                            $urows4 ['age_range'] === $urows3['age_range'] &&
                            strtoupper($urows4 ['gender']) === strtoupper($urows3['gender'])){
                                if(strtoupper($urows4 ['gender']) === "MALE"){
                                    if($urows4 ['age_range'] === "0-11" || $urows4 ['age_range'] === "12-17"){
                                        $data_hash_across_4[str_replace("'", "", $urows4['county_name'])]['MALE_LESS18_N'] += $urows4['aggregate'];
                                    }else{
                                        $data_hash_across_4[str_replace("'", "", $urows4['county_name'])]['MALE_MORE18_N'] += $urows4['aggregate'];
                                    }
                                }else if(strtoupper($urows4 ['gender']) === "FEMALE"){
                                    if($urows4 ['age_range'] === "0-11" || $urows4 ['age_range'] === "12-17"){
                                        $data_hash_across_4[str_replace("'", "", $urows4['county_name'])]['FEMALE_LESS18_N'] += $urows4['aggregate'];
                                    }else{
                                        $data_hash_across_4[str_replace("'", "", $urows4['county_name'])]['FEMALE_MORE18_N'] += $urows4['aggregate'];
                                    }
                               }
                              unset($urows4);
                        }
                    }
                }
                if($debug){
                    foreach ( $data_all_N as $urows4 ) {
                        print_r($urows4);print "<br>";
                    }
                    print "<br>";
                    foreach ( $data_all_D as $urows4 ) {
                        print_r($urows4);print "<br>";
                    }
                    print "<br>";
                    print_r($data_hash_across_4);
                }
            }else{       
                foreach ( $data_all_N as $urows4 ) {
                    array_push($data, $urows4); //do not show "No data" message
                    if($urows4['age_range'] === '0-11' || $urows4['age_range'] === '12-17' ){
                        if(strtoupper($urows4['gender']) === 'MALE'){
                            $male_less18_total_N += $urows4['aggregate'];
                        }else{
                            $female_less18_total_N += $urows4['aggregate'];
                        }
                     }else{
                        if(strtoupper($urows4['gender']) === 'MALE'){
                            $male_more18_total_N += $urows4['aggregate'];
                        }else{
                            $female_more18_total_N += $urows4['aggregate'];
                        }
                    }
                }
               foreach ( $data_all_D as $urows4 ) {
                    array_push($data, $urows4); //do not show "No data" message
                    if($urows4['age_range'] === '0-11' || $urows4['age_range'] === '12-17' ){
                        if(strtoupper($urows4['gender']) === 'MALE'){
                            $male_less18_total_D += $urows4['aggregate'];
                        }else{
                            $female_less18_total_D += $urows4['aggregate'];
                        }
                     }else{
                        if(strtoupper($urows4['gender']) === 'MALE'){
                            $male_more18_total_D += $urows4['aggregate'];
                        }else{
                            $female_more18_total_D += $urows4['aggregate'];
                        }
                    }
                }
                if($debug){
                    print_r($data_all_N); print "<br><br>";
                    print_r($data_all_D); print "<br><br>";
                    print "N: M<18, F<18, M>18, F>18 =" . $male_less18_total_N . "," . $female_less18_total_N . "," . $male_more18_total_N . "," . $female_more18_total_N . "<br>";
                    print "D: M<18, F<18, M>18, F>18 =" . $male_less18_total_D . "," . $female_less18_total_D . "," . $male_more18_total_D . "," . $female_more18_total_D . "<br>";          
                }
            }
        }
    
    }
    
  // print_r($data);
   
    ?>
    
    <!-- libs to upload chart as PNG-->
    <script type="text/javascript" src="../UI/js/rgbcolor.js"></script> 
<script type="text/javascript" src="../UI/js/canvg.js"></script>
<script type="text/javascript" src="../UI/js/grChartImg.js"></script>


<script type="text/javascript">

function pdf_across_report6(){
	var doc = new jsPDF('p', 'pt', 'a4', false);
		
		doc.setFontType("bold");
		doc.setFontSize(14);
		doc.text(200, 30, 'Health sector report');
		doc.setFontType("normal");
		doc.setFontSize(12);
		doc.text(60, 60, 'Proportion of sexual violence survivors who received ');
		doc.text(60, 80, 'comprehensive care');
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
	     doc.addImage(image1[0], 'png', 40, 450, 500, 250); 
	      }catch (e) {
	     doc.text(120, 120, 'Cannot print chart report');
	 }
	      doc.addPage();

		    //add table report 2
			var res2 = doc.autoTableHtmlToJson(document.getElementById('table_div2').getElementsByTagName('table')[0]);
			try{
				doc.autoTable(res2.columns, res2.data, {
				    startY: 60,
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
				      7: {columnWidth: 'auto'}
				    }
				  });
			}catch (e) {
			     doc.text(120, 100, 'Cannot print table report');
			}
	 var image2 = $('#image2 img');
	if(image2.length > 0){
		//doc.addPage();
		try {
		    doc.addImage(image2[0], 'png', 40, 400, 500, 250);
		}catch (e) {
		    doc.text(120, 520, 'Cannot print chart  report');
		}
	}

	 doc.save("HealthSecotorReport.pdf");
		
	}

function pdf_across_report5(){
	var doc = new jsPDF('p', 'pt', 'a4', false);
		
		doc.setFontType("bold");
		doc.setFontSize(14);
		doc.text(200, 30, 'Health sector report');
		doc.setFontType("normal");
		doc.setFontSize(12);
		doc.text(60, 60, 'Proportion of sexual violence survivors who have completed');
		doc.text(60, 80, 'post‐exposure prophylaxis');
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
	     doc.addImage(image1[0], 'png', 40, 470, 500, 250); 
	      }catch (e) {
	     doc.text(120, 120, 'Cannot print chart report');
	 }
	      doc.addPage();

		    //add table report 2
			var res2 = doc.autoTableHtmlToJson(document.getElementById('table_div2').getElementsByTagName('table')[0]);
			try{
				doc.autoTable(res2.columns, res2.data, {
				    startY: 60,
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
				      7: {columnWidth: 'auto'}
				    }
				  });
			}catch (e) {
			     doc.text(120, 100, 'Cannot print table report');
			}
	 var image2 = $('#image2 img');
	if(image2.length > 0){
		//doc.addPage();
		try {
		    doc.addImage(image2[0], 'png', 40, 470, 500, 250);
		}catch (e) {
		    doc.text(120, 520, 'Cannot print chart  report');
		}
	}

	 doc.save("HealthSecotorReport.pdf");
		
	}

function pdf_across_report4(){
	var doc = new jsPDF('p', 'pt', 'a4', false);
		
		doc.setFontType("bold");
		doc.setFontSize(14);
		doc.text(200, 30, 'Health sector report');
		doc.setFontType("normal");
		doc.setFontSize(12);
		doc.text(60, 60, 'Proportion of eligible sexual violence survivors initiated on ');
		doc.text(60, 80, 'post‐exposure prophylaxis for HIV');
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
	     doc.addImage(image1[0], 'png', 40, 470, 500, 250); 
	      }catch (e) {
	     doc.text(120, 120, 'Cannot print chart report');
	 }
	      doc.addPage();

		    //add table report 2
			var res2 = doc.autoTableHtmlToJson(document.getElementById('table_div2').getElementsByTagName('table')[0]);
			try{
				doc.autoTable(res2.columns, res2.data, {
				    startY: 60,
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
				      7: {columnWidth: 'auto'}
				    }
				  });
			}catch (e) {
			     doc.text(120, 100, 'Cannot print table report');
			}
	 var image2 = $('#image2 img');
	if(image2.length > 0){
		//doc.addPage();
		try {
		    doc.addImage(image2[0], 'png', 40, 400, 500, 250);
		}catch (e) {
		    doc.text(120, 520, 'Cannot print chart  report');
		}
	}

	 doc.save("HealthSecotorReport.pdf");
		
	}

function pdf_across_report3(){
var doc = new jsPDF('p', 'pt', 'a4', false);
	
	doc.setFontType("bold");
	doc.setFontSize(14);
	doc.text(200, 30, 'Health sector report');
	doc.setFontType("normal");
	doc.setFontSize(12);
	doc.text(60, 60, $('#chart_title_1').text());
	doc.text(60, 80, $('#chart_title_2').text());

	//add table 1 report
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
		      5: {columnWidth: 'auto'}
		    }
		  });
	}catch (e) {
	     doc.text(120, 100, 'Cannot print table report');
	}

	//add chart report 
	var image1 = $('#image1 img')
	try {
     doc.addImage(image1[0], 'png', 40, 400, 500, 250); 
      }catch (e) {
     doc.text(120, 120, 'Cannot print chart report');
 }

      doc.addPage();

      //add table 2 report
    	var res = doc.autoTableHtmlToJson(document.getElementById('table_div2').getElementsByTagName('table')[0]);
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
    		      5: {columnWidth: 'auto'}
    		    }
    		  });
    	}catch (e) {
    	     doc.text(120, 100, 'Cannot print table report');
    	}
//add detailed report
 var image2 = $('#image2 img');
if(image2.length > 0){
	//doc.addPage();
	try {
	    doc.addImage(image2[0], 'png', 40, 400, 500, 250);
	}catch (e) {
	    doc.text(120, 520, 'Cannot print chart  report');
	}
}

 doc.save("HealthSecotorReport.pdf");
	
}

function pdf_across_report2(){  

	var doc = new jsPDF('p', 'pt', 'a4', false);
		
		doc.setFontType("bold");
		doc.setFontSize(14);
		doc.text(200, 30, 'Health sector report');
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

		doc.save("HealthSecotorReport.pdf");
	}


function pdf_across_report1(){  

	var doc = new jsPDF('p', 'pt', 'a4', false);
	
	doc.setFontType("bold");
	doc.setFontSize(14);
	doc.text(200, 30, 'Health sector report');
	doc.setFontType("normal");
	doc.setFontSize(12);
	doc.text(60, 60, 'Proportion of health facilities providing comprehensive clinical management ');
	doc.text(60, 80, 'services for survivors of sexual violence');
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
		      3: {columnWidth: 'auto'}
		    }
		  });
	}catch (e) {
	     doc.text(120, 100, 'Cannot print table report');
	}

	//add chart report 
	var image1 = $('#image1 img')
	try {
     doc.addImage(image1[0], 'png', 40, 450, 530, 300, undefined, 'none');
 }catch (e) {
     doc.text(120, 120, 'Cannot print chart report');
 }

	doc.save("HealthSecotorReport.pdf");
}

function pdf_report1(rows){ 

	var doc = new jsPDF('p', 'pt', 'a4', false);
	
	doc.setFontType("bold");
	doc.setFontSize(14);
	doc.text(200, 30, 'Health sector report');
	doc.setFontType("normal");
	doc.setFontSize(12);
	doc.text(60, 60, 'Proportion of health facilities providing comprehensive clinical management ');
	doc.text(60, 80, 'services for survivors of sexual violence');
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
		      3: {columnWidth: 'auto'}
		    }
		  });
	}catch (e) {
	     doc.text(120, 100, 'Cannot print table report');
	}

	//add chart report 
	var image1 = $('#image1 img')
	try {
     doc.addImage(image1[0], 'png', 40, (120+rows*80), 500, 250); 
 }catch (e) {
     doc.text(120, 120, 'Cannot print chart report');
 }

 doc.save("HealthSecotorReport.pdf");
}

function pdf_report3(){  
	var doc = new jsPDF('p', 'pt', 'a4', false);	
	doc.setFontType("bold");
	doc.setFontSize(14);
	doc.text(200, 30, 'Health sector report');
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
     doc.addImage(image1[0], 'png', 40, 200, 500, 280); 
 }catch (e) {
     doc.text(120, 120, 'Cannot print chart report');
 }

 doc.save("HealthSecotorReport.pdf");
}

function pdf_report4(){  
	var doc = new jsPDF('p', 'pt', 'a4', false);	
	doc.setFontType("bold");
	doc.setFontSize(14);
	doc.text(200, 30, 'Health sector report'); 
	doc.setFontType("normal");
	doc.setFontSize(12);
	doc.text(60, 60, 'Proportion of eligible sexual violence survivors ');
	doc.text(60, 80, 'initiated on post ‐exposure prophylaxis for HIV');
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
		      6: {columnWidth: 'auto'},
		      7: {columnWidth: 'auto'},
		      8: {columnWidth: 'auto'}
		    }
		  });
	}catch (e) {
	     doc.text(120, 100, 'Cannot print table report');
	}
	//add chart report 
	var image1 = $('#image1 img')
	try {
     doc.addImage(image1[0], 'png', 40, 300, 550, 300); 
 }catch (e) {
     doc.text(120, 120, 'Cannot print chart report');
 }

 doc.save("HealthSecotorReport.pdf");
}

function pdf_report6(){  
	var doc = new jsPDF('p', 'pt', 'a4', false);	
	doc.setFontType("bold");
	doc.setFontSize(14);
	doc.text(200, 30, 'Health sector report'); 
	doc.setFontType("normal");
	doc.setFontSize(12);
	doc.text(60, 60, 'Proportion of sexual violence survivors who received  ');
	doc.text(60, 80, 'comprehensive care');
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
		      6: {columnWidth: 'auto'},
		      7: {columnWidth: 'auto'},
		      8: {columnWidth: 'auto'}
		    }
		  });
	}catch (e) {
	     doc.text(120, 100, 'Cannot print table report');
	}
	//add chart report 
	var image1 = $('#image1 img')
	try {
     doc.addImage(image1[0], 'png', 40, 300, 600, 300); 
 }catch (e) {
     doc.text(120, 120, 'Cannot print chart report');
 }

 doc.save("HealthSecotorReport.pdf");
}

function pdf_report5(){  
	var doc = new jsPDF('p', 'pt', 'a4', false);	
	doc.setFontType("bold");
	doc.setFontSize(14);
	doc.text(200, 30, 'Health sector report'); 
	doc.setFontType("normal");
	doc.setFontSize(12);
	doc.text(60, 60, 'Proportion of sexual violence survivors who have completed ');
	doc.text(60, 80, 'post‐exposure prophylaxis');
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
		      6: {columnWidth: 'auto'},
		      7: {columnWidth: 'auto'},
		      8: {columnWidth: 'auto'}
		    }
		  });
	}catch (e) {
	     doc.text(120, 100, 'Cannot print table report');
	}
	//add chart report 
	var image1 = $('#image1 img')
	try {
     doc.addImage(image1[0], 'png', 40, 300, 400, 200); 
 }catch (e) {
     doc.text(120, 120, 'Cannot print chart report');
 }

 doc.save("HealthSecotorReport.pdf");
}


function pdf_report2(rows){ 

	var doc = new jsPDF('p', 'pt', 'a4', false);
	
	doc.setFontType("bold");
	doc.setFontSize(14);
	doc.text(200, 30, 'Health sector report');
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
     doc.addImage(image1[0], 'png', 40, (120+rows*40), 500, 250); 
 }catch (e) {
     doc.text(120, 120, 'Cannot print chart report');
 }

 doc.save("HealthSecotorReport.pdf");
}


function csv_report(text) {
	var blob = new Blob([text], {type: "text/plain;charset=utf-8"});
	saveAs(blob, "HealthSecotorReport.csv");
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
    return "Health sector report\\n" + $('#chart_title_1').text() + "\\n" + $('#chart_title_2').text() + "\\n" + csv_out;
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
			    if($county_id === "across"){
			        //TA:100
			        if($report_id === '1'){
			            echo "drawAcrossGraph_Report1();";
			        }else if($report_id === '2'){
			            echo "drawAcrossGraph_report2();"; 
			        }else if($report_id === '3'){
			            echo "drawAcrossGraph_report3();"; 
			        }else if($report_id === '4'){
			            echo "drawAcrossGraph_report4();"; 
			        }else if($report_id === '5'){
			            echo "drawAcrossGraph_report5();"; 
			        }else if($report_id === '6'){
			            echo "drawAcrossGraph_report6();"; 
			        }
			    }else{
			        if($report_id === '3'){
			            echo "drawGraph_report3();";
			         }else if($report_id === '6'){ 
			             echo "drawGraph_report6();";
			         }else if($report_id === '1'){
			             echo "drawGraph_report1();";
			         }else if($report_id === '2'){
			             echo "drawGraph_report2();";
			         }else if($report_id === '4'){
			             echo "drawGraph_report4();";
			         }else if($report_id === '5'){
			             echo "drawGraph_report5();";
			         }
			    }
			}
			?>
		}

		function drawAcrossGraph_report6(){

			$("#progress_bar").html("");
	        $("#report_title").html("<h2 class='page-title-section-gray'><?php echo $sector_type_name;?> sector report</h2>");
	        $("#pdf_report").html("<a href='#' onclick='pdf_across_report6();' style='font-style: italic; text-decoration-color: gray;'><font color='gray'style='font-family: \"Open Sans\", Tahoma, Arial sans-serif;'>PDF report</font></a>");
	        $("#png_chart").html("<a href='#' onclick='javascript:grChartImg.ShowImage(\"chart_div\", true);' style='font-style: italic; text-decoration-color: gray;'><font color='gray'style='font-family: \"Open Sans\", Tahoma, Arial sans-serif;'>Print chart</font></a>");
	        $("#chart_title").html("<h2 id='chart_title_1' class='page-title-section'><?php echo $report_name . "</h2><h2 id='chart_title_2' class='page-title-section'>" . $date_title . "</h2>";?>");

		      //draw table
	       	 var data_table = new google.visualization.DataTable();
		       	data_table.addColumn('string', 'County name');
		       	data_table.addColumn('number', 'Male <br>SGBV cases <br>reported <br>(<18 yrs)');
		       	data_table.addColumn('number', 'Male <br>total SGBV cases <br>given comprehensive <br>care <br>(<18 yrs)');
		       	data_table.addColumn('number', 'Male <br>proportion of <br>sexual violence <br>survivors who <br>received <br>comprehensive care <br>(<18 yrs)');
		       	data_table.addColumn('number', 'Female <br>SGBV cases <br>reported <br>(<18 yrs)');
		       	data_table.addColumn('number', 'Female <br>total SGBV cases <br>given <br>comprehensive <br>care <br>(<18 yrs)');
		       	data_table.addColumn('number', 'Female <br>proportion of <br>sexual violence <br>survivors who <br>received <br>comprehensive care <br>(<18 yrs)');
	        	data_table.addRows([
	        	<?php foreach ( $data_hash_across_4 as $key=>$urows) {
	        	    $total = $urows['MALE_LESS18_D'] + $urows['FEMALE_LESS18_D'];
	        	    $male = 0;
	        	    if($urows['MALE_LESS18_D'] >0){
	        	        $male = round(($urows['MALE_LESS18_N']/$urows['MALE_LESS18_D'])*100,2);
	        	    }
	        	    $female = 0;
	        	    if($urows['FEMALE_LESS18_D'] >0){
	        	        $female = round(($urows['FEMALE_LESS18_N']/$urows['FEMALE_LESS18_D'])*100,2);
	        	    }
echo "[{v:'" . $key . "'}, {v:" . $urows['MALE_LESS18_D'] . "}, {v:" . $urows['MALE_LESS18_N'] . "}, {v:" . $male . "}, {v:" . 
    $urows['FEMALE_LESS18_D'] . "}, {v:" . $urows['FEMALE_LESS18_N'] . "}, {v:" . $female . "}],";
	        	    	        	}?>
	        	    	  ]);
	          var table = new google.visualization.Table(document.getElementById('table_div'));      
	         table.draw(data_table, {allowHtml: true, showRowNumber: false, width: '900px', height: '100%'});
	         <?php if($user->user_group === '1' || $user->user_group === '2'){?> //only for admin and super admin
	              $("#table1_csv").html(dataTableToCSV(data_table)); 
	              $("#table_div_csv").html("<a href='#' onclick='csv_report(\"" + $("#table1_csv").html() + "\");' style='font-style: italic; text-decoration-color: gray;'><font color='gray'style='font-family: \"Open Sans\", Tahoma, Arial sans-serif; font-size;7px'>CSV report</font></a>");
	         <?php }?>

			//draw chart 1
	         data_chart = new google.visualization.DataTable();
	        	data_chart.addColumn('string', 'County name');
	        	data_chart.addColumn('number', 'Male');
	        	data_chart.addColumn('number', 'Female');        
	        	data_chart.addRows([
	        	<?php 
	        	foreach ( $data_hash_across_4 as $key=>$urows ) {
	        	    $male = 0;
	        	    if($urows['MALE_LESS18_D'] >0){
	        	        $male = round(($urows['MALE_LESS18_N']/$urows['MALE_LESS18_D'])*100,2);
	        	    }
	        	    $female = 0;
	        	    if($urows['FEMALE_LESS18_D'] >0){
	        	        $female = round(($urows['FEMALE_LESS18_N']/$urows['FEMALE_LESS18_D'])*100,2);
	        	    }
          echo "[ '" . $key . "', {v:" . $male . "}, {v:" . $female . "}],";
	        	 }?>
	        ]);

          var options = {
        		  "title": "Proportion of sexual violence survivors (<18 yrs) who received comprehensive care for period <?php echo $date_title;?>",
          		//"legend":"none",
          		"width":1000,
          		"height":500,
          	 hAxis: {title:'County', slantedText:true, slantedTextAngle:90,showTextEvery:1 }, //lebel vertical view and show all
        		  vAxis: {title:'Percent received comprehensive care', minValue:0, maxValue: 100, format: '0'},
          		bar: {groupWidth: 20},
          		chartArea : { left: 60, top: 40, right:120, height: '57%'} // do not cut off labels
          };
          
			chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
			google.visualization.events.addListener(chart, 'ready', function () {
  			  var content = '<img src="' + chart.getImageURI() + '">';
  			  $('#image1').append(content);
  			}); 
			chart.draw(data_chart, options);

			 //draw table 2
	       	 var data_table2 = new google.visualization.DataTable();
		       	data_table2.addColumn('string', 'County name');
		       	data_table2.addColumn('number', 'Male <br>SGBV cases <br>reported <br>(>18 yrs)');
		       	data_table2.addColumn('number', 'Male <br>total SGBV cases <br>given comprehensive <br>care <br>(>18 yrs)');
		       	data_table2.addColumn('number', 'Male <br>proportion of <br>sexual violence <br>survivors who <br>received <br>comprehensive care <br>(>18 yrs)');
		       	data_table2.addColumn('number', 'Female <br>SGBV cases <br>reported <br>(>18 yrs)');
		       	data_table2.addColumn('number', 'Female <br>total SGBV cases <br>given <br>comprehensive <br>care <br>(>18 yrs)');
		       	data_table2.addColumn('number', 'Female <br>proportion of <br>sexual violence <br>survivors who <br>received <br>comprehensive care <br>(>18 yrs)');
	        	data_table2.addRows([
	        	<?php foreach ( $data_hash_across_4 as $key=>$urows) {
	        	    $total = $urows['MALE_MORE18_D'] + $urows['FEMALE_MORE18_D'];
	        	    $male = 0;
	        	    if($urows['MALE_MORE18_D'] >0){
	        	        $male = round(($urows['MALE_MORE18_N']/$urows['MALE_MORE18_D'])*100,2);
	        	    }
	        	    $female = 0;
	        	    if($urows['FEMALE_MORE18_D'] >0){
	        	        $female = round(($urows['FEMALE_MORE18_N']/$urows['FEMALE_MORE18_D'])*100,2);
	        	    }
echo "[{v:'" . $key . "'}, {v:" . $urows['MALE_MORE18_D'] . "}, {v:" . $urows['MALE_MORE18_N'] . "}, {v:" . $male . "}, {v:" . 
  $urows['FEMALE_MORE18_D'] . "}, {v:" . $urows['FEMALE_MORE18_N'] . "}, {v:" . $female . "}],";
	        	    	        	}?>
	        	    	  ]);
	          var table2 = new google.visualization.Table(document.getElementById('table_div2'));      
	         table2.draw(data_table2, {allowHtml: true, showRowNumber: false, width: '900px', height: '100%'});
	         <?php if($user->user_group === '1' || $user->user_group === '2'){?> //only for admin and super admin
             $("#table1_csv2").html(dataTableToCSV(data_table2)); 
             $("#table_div_csv2").html("<a href='#' onclick='csv_report(\"" + $("#table1_csv2").html() + "\");' style='font-style: italic; text-decoration-color: gray;'><font color='gray'style='font-family: \"Open Sans\", Tahoma, Arial sans-serif; font-size;7px'>CSV report</font></a>");
        <?php }?>

			//draw chart 2
			$("#png_chart2").html("<a href='#' onclick='javascript:grChartImg.ShowImage(\"chart_div2\", true);' style='font-style: italic; text-decoration-color: gray;'><font color='gray'style='font-family: \"Open Sans\", Tahoma, Arial sans-serif;'>Print chart</font></a>");
	         data_chart2 = new google.visualization.DataTable();
	        	data_chart2.addColumn('string', 'County name');
	        	data_chart2.addColumn('number', 'Male');
	        	data_chart2.addColumn('number', 'Female');        
	        	data_chart2.addRows([
	        	<?php 
	        	foreach ( $data_hash_across_4 as $key=>$urows ) {
        $male = 0;
	        	    if($urows['MALE_MORE18_D'] >0){
	        	        $male = round(($urows['MALE_MORE18_N']/$urows['MALE_MORE18_D'])*100,2);
	        	    }
	        	    $female = 0;
	        	    if($urows['FEMALE_MORE18_D'] >0){
	        	        $female = round(($urows['FEMALE_MORE18_N']/$urows['FEMALE_MORE18_D'])*100,2);
	        	    }
          echo "[ '" . $key . "', {v:" . $male . "}, {v:" . $female . "}],";
	        	 }?>
	        ]);

        var options2 = {
                "title": "Proportion of sexual violence survivors (>18 yrs) who received comprehensive care for period <?php echo $date_title;?>",
        		//"legend":"none",
        		"width":1000,
        		"height":500,
        	 hAxis: {title:'County', slantedText:true, slantedTextAngle:90,showTextEvery:1 }, //lebel vertical view and show all
      		  vAxis: {title:'Percent received comprehensive care', minValue:0, maxValue: 100, format: '0'},
        		bar: {groupWidth: 20},
        		chartArea : { left: 60, top: 40, right:120, height: '57%'} // do not cut off labels
        };
        
			chart2 = new google.visualization.ColumnChart(document.getElementById('chart_div2'));
			google.visualization.events.addListener(chart2, 'ready', function () {
			  var content = '<img src="' + chart2.getImageURI() + '">';
			  $('#image2').append(content);
			}); 
			chart2.draw(data_chart2, options2); 
	       
		}

		function drawAcrossGraph_report5(){

			$("#progress_bar").html("");
	        $("#report_title").html("<h2 class='page-title-section-gray'><?php echo $sector_type_name;?> sector report</h2>");
	        $("#pdf_report").html("<a href='#' onclick='pdf_across_report5();' style='font-style: italic; text-decoration-color: gray;'><font color='gray'style='font-family: \"Open Sans\", Tahoma, Arial sans-serif;'>PDF report</font></a>");
	        $("#png_chart").html("<a href='#' onclick='javascript:grChartImg.ShowImage(\"chart_div\", true);' style='font-style: italic; text-decoration-color: gray;'><font color='gray'style='font-family: \"Open Sans\", Tahoma, Arial sans-serif;'>Print chart</font></a>");
	        $("#chart_title").html("<h2 id='chart_title_1' class='page-title-section'><?php echo $report_name . "</h2><h2 id='chart_title_2' class='page-title-section'>" . $date_title . "</h2>";?>");

		      //draw table
	       	 var data_table = new google.visualization.DataTable();
		       	data_table.addColumn('string', 'County name');
		       	data_table.addColumn('number', 'Male <br>SGBV cases <br>(<18 yrs)');
	        	data_table.addColumn('number', 'Male <br>SGBV cases <br>completed PEP <br>(<18 yrs)');
	        	data_table.addColumn('number', 'Male <br>proportion of <br>sexual violence <br>survivors completed<br> on PEP for HIV <br>(<18 yrs)');
	        	data_table.addColumn('number', 'Female <br>SGBV cases <br>(<18 yrs)');
	        	data_table.addColumn('number', 'Female <br>SGBV cases <br>completed PEP <br>(<18 yrs)');
	        	data_table.addColumn('number', 'Female <br>proportion of <br>sexual violence <br>survivors completed<br> on PEP for HIV <br>(<18 yrs)');
	        	data_table.addColumn('number', 'Total <br>SGBV cases <br>(<18 yrs)');
	        	data_table.addRows([
	        	<?php foreach ( $data_hash_across_4 as $key=>$urows) {
	        	    $total = $urows['MALE_LESS18_D'] + $urows['FEMALE_LESS18_D'];
	        	    $male = 0;
	        	    if($total >0){
	        	        $male = round(($urows['MALE_LESS18_N']/$urows['MALE_LESS18_D'])*100,2);
	        	    }
	        	    $female = 0;
	        	    if($urows['FEMALE_LESS18_D'] >0){
	        	        $female = round(($urows['FEMALE_LESS18_N']/$urows['FEMALE_LESS18_D'])*100,2);
	        	    }
echo "[{v:'" . $key . "'}, {v:" . $urows['MALE_LESS18_D'] . "}, {v:" . $urows['MALE_LESS18_N'] . "}, {v:" . $male . "}, {v:" . 
    $urows['FEMALE_LESS18_D'] . "}, {v:" . $urows['FEMALE_LESS18_N'] . "}, {v:" . $female . "}, {v:" . $total . "}],";
	        	    	        	}?>
	        	    	  ]);
	          var table = new google.visualization.Table(document.getElementById('table_div'));      
	         table.draw(data_table, {allowHtml: true, showRowNumber: false, width: '900px', height: '100%'});
	         <?php if($user->user_group === '1' || $user->user_group === '2'){?> //only for admin and super admin
	              $("#table1_csv").html(dataTableToCSV(data_table)); 
	              $("#table_div_csv").html("<a href='#' onclick='csv_report(\"" + $("#table1_csv").html() + "\");' style='font-style: italic; text-decoration-color: gray;'><font color='gray'style='font-family: \"Open Sans\", Tahoma, Arial sans-serif; font-size;7px'>CSV report</font></a>");
	         <?php }?>

			//draw chart 1
	         data_chart = new google.visualization.DataTable();
	        	data_chart.addColumn('string', 'County name');
	        	data_chart.addColumn('number', 'Male');
	        	data_chart.addColumn('number', 'Female');        
	        	data_chart.addRows([
	        	<?php 
	        	foreach ( $data_hash_across_4 as $key=>$urows ) {
	        	    $male = 0;
	        	    if($urows['MALE_LESS18_D'] >0){
	        	        $male = round(($urows['MALE_LESS18_N']/$urows['MALE_LESS18_D'])*100,2);
	        	    }
	        	    $female = 0;
	        	    if($urows['FEMALE_LESS18_D'] >0){
	        	        $female = round(($urows['FEMALE_LESS18_N']/$urows['FEMALE_LESS18_D'])*100,2);
	        	    }
          echo "[ '" . $key . "', {v:" . $male . "}, {v:" . $female . "}],";
	        	 }?>
	        ]);

          var options = {
        		  "title": "Proportion of sexual violence survivors (<18 yrs) completed post-exposure prophylaxis for HIV \nfor period <?php echo $date_title;?>",
          		//"legend":"none",
          		"width":1000,
          		"height":500,
          	 hAxis: {title:'County', slantedText:true, slantedTextAngle:90,showTextEvery:1 }, //lebel vertical view and show all
        		  vAxis: {title:'Percent completed PEP', minValue:0, maxValue: 100, format: '0'},
          		bar: {groupWidth: 20},
          		chartArea : { left: 60, top: 40, right:120, height: '57%'} // do not cut off labels
          };
          
			chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
			google.visualization.events.addListener(chart, 'ready', function () {
  			  var content = '<img src="' + chart.getImageURI() + '">';
  			  $('#image1').append(content);
  			}); 
			chart.draw(data_chart, options);

			 //draw table 2
	       	 var data_table2 = new google.visualization.DataTable();
		       	data_table2.addColumn('string', 'County name');
		       	data_table2.addColumn('number', 'Male <br>SGBV cases <br>(>18 yrs)');
	        	data_table2.addColumn('number', 'Male <br>SGBV cases <br>completed PEP <br>(>18 yrs)');
	        	data_table2.addColumn('number', 'Male <br>proportion of <br>sexual violence <br>survivors completed<br> on PEP for HIV <br>(>18 yrs)');
	        	data_table2.addColumn('number', 'Female <br>SGBV cases <br>(>18 yrs)');
	        	data_table2.addColumn('number', 'Female <br>SGBV cases <br>completed PEP <br>(>18 yrs)');
	        	data_table2.addColumn('number', 'Female <br>proportion of <br>sexual violence <br>survivors completed<br> on PEP for HIV <br>(>18 yrs)');
	        	data_table2.addColumn('number', 'Total <br>SGBV cases <br>(>18 yrs)');
	        	data_table2.addRows([
	        	<?php foreach ( $data_hash_across_4 as $key=>$urows) {
	        	    $total = $urows['MALE_MORE18_D'] + $urows['FEMALE_MORE18_D'];
	        	    $male = 0;
	        	    if($urows['MALE_MORE18_D'] >0){
	        	        $male = round(($urows['MALE_MORE18_N']/$urows['MALE_MORE18_D'])*100,2);
	        	    }
	        	    $female = 0;
	        	    if($urows['FEMALE_MORE18_D'] >0){
	        	        $female = round(($urows['FEMALE_MORE18_N']/$urows['FEMALE_MORE18_D'])*100,2);
	        	    }
echo "[{v:'" . $key . "'}, {v:" . $urows['MALE_MORE18_D'] . "}, {v:" . $urows['MALE_MORE18_N'] . "}, {v:" . $male . "}, {v:" . 
  $urows['FEMALE_MORE18_D'] . "}, {v:" . $urows['FEMALE_MORE18_N'] . "}, {v:" . $female . "}, {v:" . $total . "}],";
	        	    	        	}?>
	        	    	  ]);
	          var table2 = new google.visualization.Table(document.getElementById('table_div2'));      
	         table2.draw(data_table2, {allowHtml: true, showRowNumber: false, width: '900px', height: '100%'});
	         <?php if($user->user_group === '1' || $user->user_group === '2'){?> //only for admin and super admin
             $("#table1_csv2").html(dataTableToCSV(data_table2)); 
             $("#table_div_csv2").html("<a href='#' onclick='csv_report(\"" + $("#table1_csv2").html() + "\");' style='font-style: italic; text-decoration-color: gray;'><font color='gray'style='font-family: \"Open Sans\", Tahoma, Arial sans-serif; font-size;7px'>CSV report</font></a>");
        <?php }?>

			//draw chart 2
			$("#png_chart2").html("<a href='#' onclick='javascript:grChartImg.ShowImage(\"chart_div2\", true);' style='font-style: italic; text-decoration-color: gray;'><font color='gray'style='font-family: \"Open Sans\", Tahoma, Arial sans-serif;'>Print chart</font></a>");
	         data_chart2 = new google.visualization.DataTable();
	        	data_chart2.addColumn('string', 'County name');
	        	data_chart2.addColumn('number', 'Male');
	        	data_chart2.addColumn('number', 'Female');        
	        	data_chart2.addRows([
	        	<?php 
	        	foreach ( $data_hash_across_4 as $key=>$urows ) {
        $male = 0;
	        	    if($urows['MALE_MORE18_D'] >0){
	        	        $male = round(($urows['MALE_MORE18_N']/$urows['MALE_MORE18_D'])*100,2);
	        	    }
	        	    $female = 0;
	        	    if($urows['FEMALE_MORE18_D'] >0){
	        	        $female = round(($urows['FEMALE_MORE18_N']/$urows['FEMALE_MORE18_D'])*100,2);
	        	    }
          echo "[ '" . $key . "', {v:" . $male . "}, {v:" . $female . "}],";
	        	 }?>
	        ]);

        var options2 = {
                "title": "Proportion of sexual violence survivors (>18 yrs) completed post-exposure prophylaxis for HIV \nfor period <?php echo $date_title;?>",
        		//"legend":"none",
        		"width":1000,
        		"height":500,
        	 hAxis: {title:'County', slantedText:true, slantedTextAngle:90,showTextEvery:1 }, //lebel vertical view and show all
      		  vAxis: {title:'Percent completed PEP', minValue:0, maxValue: 100, format: '0'},
        		bar: {groupWidth: 20},
        		chartArea : { left: 60, top: 40, right:120, height: '57%'} // do not cut off labels
        };
        
			chart2 = new google.visualization.ColumnChart(document.getElementById('chart_div2'));
			google.visualization.events.addListener(chart2, 'ready', function () {
			  var content = '<img src="' + chart2.getImageURI() + '">';
			  $('#image2').append(content);
			}); 
			chart2.draw(data_chart2, options2); 
	       
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
		       	data_table.addColumn('number', 'Male <br>SGBV cases <br>presenting <br>within 72 hours<br>(<18 yrs)');
	        	data_table.addColumn('number', 'Male <br>SGBV cases <br>initiated on PEP <br>(<18 yrs)');
	        	data_table.addColumn('number', 'Male <br>proportion of <br>sexual violence <br>survivors initiated<br> on PEP for HIV <br>(<18 yrs)');
	        	data_table.addColumn('number', 'Female <br>SGBV cases <br>presenting <br>within 72 hours<br>(<18 yrs)');
	        	data_table.addColumn('number', 'Female <br>SGBV cases <br>initiated on PEP <br>(<18 yrs)');
	        	data_table.addColumn('number', 'Female <br>proportion of <br>sexual violence <br>survivors initiated<br> on PEP for HIV <br>(<18 yrs)');
	        	data_table.addColumn('number', 'Total <br>SGBV cases <br>(<18 yrs)');
	        	data_table.addRows([
	        	<?php foreach ( $data_hash_across_4 as $key=>$urows) {
	        	    $total = $urows['MALE_LESS18_D'] + $urows['FEMALE_LESS18_D'];
	        	    $male = 0;
	        	    if($urows['MALE_LESS18_D'] >0){
	        	        $male = round(($urows['MALE_LESS18_N']/$urows['MALE_LESS18_D'])*100,2);
	        	    }
	        	    $female = 0;
	        	    if($urows['FEMALE_LESS18_D'] >0){
	        	        $female = round(($urows['FEMALE_LESS18_N']/$urows['FEMALE_LESS18_D'])*100,2);
	        	    }
echo "[{v:'" . $key . "'}, {v:" . $urows['MALE_LESS18_D'] . "}, {v:" . $urows['MALE_LESS18_N'] . "}, {v:" . $male . "}, {v:" . 
    $urows['FEMALE_LESS18_D'] . "}, {v:" . $urows['FEMALE_LESS18_N'] . "}, {v:" . $female . "}, {v:" . $total . "}],";
	        	    	        	}?>
	        	    	  ]);
	          var table = new google.visualization.Table(document.getElementById('table_div'));      
	         table.draw(data_table, {allowHtml: true, showRowNumber: false, width: '900px', height: '100%'});
	         <?php if($user->user_group === '1' || $user->user_group === '2'){?> //only for admin and super admin
	              $("#table1_csv").html(dataTableToCSV(data_table)); 
	              $("#table_div_csv").html("<a href='#' onclick='csv_report(\"" + $("#table1_csv").html() + "\");' style='font-style: italic; text-decoration-color: gray;'><font color='gray'style='font-family: \"Open Sans\", Tahoma, Arial sans-serif; font-size;7px'>CSV report</font></a>");
	         <?php }?>

			//draw chart 1
	         data_chart = new google.visualization.DataTable();
	        	data_chart.addColumn('string', 'County name');
	        	data_chart.addColumn('number', 'Male');
	        	data_chart.addColumn('number', 'Female');        
	        	data_chart.addRows([
	        	<?php 
	        	foreach ( $data_hash_across_4 as $key=>$urows ) {
	        	    $male = 0;
	        	    if($urows['MALE_LESS18_D'] >0){
	        	        $male = round(($urows['MALE_LESS18_N']/$urows['MALE_LESS18_D'])*100,2);
	        	    }
	        	    $female = 0;
	        	    if($urows['FEMALE_LESS18_D'] >0){
	        	        $female = round(($urows['FEMALE_LESS18_N']/$urows['FEMALE_LESS18_D'])*100,2);
	        	    }
          echo "[ '" . $key . "', {v:" . $male . "}, {v:" . $female . "}],";
	        	 }?>
	        ]);

          var options = {
        		  "title": "Proportion of sexual violence survivors (<18 yrs) initiated on post-exposure prophylaxis for HIV for period <?php echo $date_title;?>",
          		//"legend":"none",
          		"width":1000,
          		"height":500,
          	 hAxis: {title:'County', slantedText:true, slantedTextAngle:90,showTextEvery:1 }, //lebel vertical view and show all
        		  vAxis: {title:'Percent initiated on PEP', minValue:0, maxValue: 100, format: '0'},
          		bar: {groupWidth: 20},
          		chartArea : { left: 60, top: 40, right:120, height: '57%'} // do not cut off labels
          };
          
			chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
			google.visualization.events.addListener(chart, 'ready', function () {
  			  var content = '<img src="' + chart.getImageURI() + '">';
  			  $('#image1').append(content);
  			}); 
			chart.draw(data_chart, options);

			 //draw table 2
	       	 var data_table2 = new google.visualization.DataTable();
		       	data_table2.addColumn('string', 'County name');
		       	data_table2.addColumn('number', 'Male <br>SGBV cases <br>presenting <br>within 72 hours<br>(>18 yrs)');
	        	data_table2.addColumn('number', 'Male <br>SGBV cases <br>initiated on PEP <br>(>18 yrs)');
	        	data_table2.addColumn('number', 'Male <br>proportion of <br>sexual violence <br>survivors initiated<br> on PEP for HIV <br>(>18 yrs)');
	        	data_table2.addColumn('number', 'Female <br>SGBV cases <br>presenting <br>within 72 hours<br>(>18 yrs)');
	        	data_table2.addColumn('number', 'Female <br>SGBV cases <br>initiated on PEP <br>(>18 yrs)');
	        	data_table2.addColumn('number', 'Female <br>proportion of <br>sexual violence <br>survivors initiated<br> on PEP for HIV <br>(>18 yrs)');
	        	data_table2.addColumn('number', 'Total <br>SGBV cases <br>(>18 yrs)');
	        	data_table2.addRows([
	        	<?php foreach ( $data_hash_across_4 as $key=>$urows) {
	        	    $total = $urows['MALE_MORE18_D'] + $urows['FEMALE_MORE18_D'];
	        	    $male = 0;
	        	    if($urows['MALE_MORE18_D'] >0){
	        	        $male = round(($urows['MALE_MORE18_N']/$urows['MALE_MORE18_D'])*100,2);
	        	    }
	        	    $female = 0;
	        	    if($urows['FEMALE_MORE18_D'] >0){
	        	        $female = round(($urows['FEMALE_MORE18_N']/$urows['FEMALE_MORE18_D'])*100,2);
	        	    }
echo "[{v:'" . $key . "'}, {v:" . $urows['MALE_MORE18_D'] . "}, {v:" . $urows['MALE_MORE18_N'] . "}, {v:" . $male . "}, {v:" . 
  $urows['FEMALE_MORE18_D'] . "}, {v:" . $urows['FEMALE_MORE18_N'] . "}, {v:" . $female . "}, {v:" . $total . "}],";
	        	    	        	}?>
	        	    	  ]);
	          var table2 = new google.visualization.Table(document.getElementById('table_div2'));      
	         table2.draw(data_table2, {allowHtml: true, showRowNumber: false, width: '900px', height: '100%'});
	         <?php if($user->user_group === '1' || $user->user_group === '2'){?> //only for admin and super admin
             $("#table1_csv2").html(dataTableToCSV(data_table2)); 
             $("#table_div_csv2").html("<a href='#' onclick='csv_report(\"" + $("#table1_csv2").html() + "\");' style='font-style: italic; text-decoration-color: gray;'><font color='gray'style='font-family: \"Open Sans\", Tahoma, Arial sans-serif; font-size;7px'>CSV report</font></a>");
        <?php }?>

			//draw chart 2
			$("#png_chart2").html("<a href='#' onclick='javascript:grChartImg.ShowImage(\"chart_div2\", true);' style='font-style: italic; text-decoration-color: gray;'><font color='gray'style='font-family: \"Open Sans\", Tahoma, Arial sans-serif;'>Print chart</font></a>");
	         data_chart2 = new google.visualization.DataTable();
	        	data_chart2.addColumn('string', 'County name');
	        	data_chart2.addColumn('number', 'Male');
	        	data_chart2.addColumn('number', 'Female');        
	        	data_chart2.addRows([
	        	<?php 
	        	foreach ( $data_hash_across_4 as $key=>$urows ) {
        $male = 0;
	        	    if($urows['MALE_MORE18_D'] >0){
	        	        $male = round(($urows['MALE_MORE18_N']/$urows['MALE_MORE18_D'])*100,2);
	        	    }
	        	    $female = 0;
	        	    if($urows['FEMALE_MORE18_D'] >0){
	        	        $female = round(($urows['FEMALE_MORE18_N']/$urows['FEMALE_MORE18_D'])*100,2);
	        	    }
          echo "[ '" . $key . "', {v:" . $male . "}, {v:" . $female . "}],";
	        	 }?>
	        ]);

        var options2 = {
                "title": "Proportion of sexual violence survivors (>18 yrs) initiated on post-exposure prophylaxis for HIV for period <?php echo $date_title;?>",
        		//"legend":"none",
        		"width":1000,
        		"height":500,
        	 hAxis: {title:'County',slantedText:true, slantedTextAngle:90,showTextEvery:1 }, //lebel vertical view and show all
      		  vAxis: {title:'Percent initiated on PEP', minValue:0, maxValue: 100, format: '0'},
        		bar: {groupWidth: 20},
        		chartArea : { left: 60, top: 40, right:120, height: '57%'} // do not cut off labels
        };
        
			chart2 = new google.visualization.ColumnChart(document.getElementById('chart_div2'));
			google.visualization.events.addListener(chart2, 'ready', function () {
			  var content = '<img src="' + chart2.getImageURI() + '">';
			  $('#image2').append(content);
			}); 
			chart2.draw(data_chart2, options2); 
	       
		}

		function drawAcrossGraph_report3(){

			$("#progress_bar").html("");
	        $("#report_title").html("<h2 class='page-title-section-gray'><?php echo $sector_type_name;?> sector report</h2>");
	        $("#pdf_report").html("<a href='#' onclick='pdf_across_report3();' style='font-style: italic; text-decoration-color: gray;'><font color='gray'style='font-family: \"Open Sans\", Tahoma, Arial sans-serif;'>PDF report</font></a>");
	        $("#png_chart").html("<a href='#' onclick='javascript:grChartImg.ShowImage(\"chart_div\", true);' style='font-style: italic; text-decoration-color: gray;'><font color='gray'style='font-family: \"Open Sans\", Tahoma, Arial sans-serif;'>Print chart</font></a>");
	        $("#chart_title").html("<h2 id='chart_title_1' class='page-title-section'><?php echo $report_name . "</h2><h2 id='chart_title_2' class='page-title-section'>" . $date_title . "</h2>";?>");

		      //draw table 1
	       	 var data_table = new google.visualization.DataTable();
		       	data_table.addColumn('string', 'County name');
		       	data_table.addColumn('number', 'Male (<18 yrs)');
	        	data_table.addColumn('number', 'Female (<18 yrs)');
	        	data_table.addColumn('number', 'Total SGBV cases <br>(<18 yrs)');
	        	data_table.addColumn('number', 'Total SGBV cases<br> (all ages) reported<br> to health facility');
	        	data_table.addRows([
	        	<?php foreach ( $data_hash_across_3 as $key=>$urows) {
	        	    $total = $urows['MALE_LESS18'] + $urows['FEMALE_LESS18'] + $urows['MALE_MORE18'] +  $urows['FEMALE_MORE18'];
echo "[{v:'" . $key . "'}, {v:" . $urows['MALE_LESS18'] . "}, {v:" . $urows['FEMALE_LESS18'] . 
    "}, {v:" . ($urows['MALE_LESS18']+$urows['FEMALE_LESS18']) . "}, {v:" . $total . "}],";
	        	    	        	}?>
	        	    	  ]);
	          var table = new google.visualization.Table(document.getElementById('table_div'));      
	         table.draw(data_table, {allowHtml: true, showRowNumber: false, width: '700px', height: '100%'});
	         <?php if($user->user_group === '1' || $user->user_group === '2'){?> //only for admin and super admin
	              $("#table1_csv").html(dataTableToCSV(data_table)); 
	              $("#table_div_csv").html("<a href='#' onclick='csv_report(\"" + $("#table1_csv").html() + "\");' style='font-style: italic; text-decoration-color: gray;'><font color='gray'style='font-family: \"Open Sans\", Tahoma, Arial sans-serif; font-size;7px'>CSV report</font></a>");
	         <?php }?>

			//draw chart 1
	         data_chart = new google.visualization.DataTable();
	        	data_chart.addColumn('string', 'County name');
	        	data_chart.addColumn('number', 'Male');
	        	data_chart.addColumn('number', 'Female');        
	        	data_chart.addRows([
	        	<?php 
	        	foreach ( $data_hash_across_3 as $key=>$urows ) {
          echo "[ '" . $key . "', {v:" . $urows['MALE_LESS18'] . "}, {v:" . $urows['FEMALE_LESS18'] . "}],";
	        	 }?>
	        ]);

          var options = {
        		  "title": "Number of SGBV cases (<18 yrs) reported to health facilities for period <?php echo $date_title;?>",
          		//"legend":"none",
          		"width":1000,
          		"height":500,
          	 hAxis: {title:'County', slantedText:true, slantedTextAngle:90,showTextEvery:1 }, //lebel vertical view and show all
        		  vAxis: {title:'Number reported', minValue:0, maxValue: 5, format: '0'},
          		bar: {groupWidth: 20},
          		chartArea : { left: 40, top: 40, right:120, height: '57%'} // do not cut off labels
          };
          
			chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
			google.visualization.events.addListener(chart, 'ready', function () {
  			  var content = '<img src="' + chart.getImageURI() + '">';
  			  $('#image1').append(content);
  			}); 
			chart.draw(data_chart, options);

			//draw table 2
	       	 var data_table2 = new google.visualization.DataTable();
		       	data_table2.addColumn('string', 'County name');
		       	data_table2.addColumn('number', 'Male (>18 yrs)');
	        	data_table2.addColumn('number', 'Female (>18 yrs)');
	        	data_table2.addColumn('number', 'Total SGBV cases <br>(>18 yrs)');
	        	data_table2.addColumn('number', 'Total SGBV cases<br> (all ages) reported<br> to health facility');
	        	data_table2.addRows([
	        	<?php foreach ( $data_hash_across_3 as $key=>$urows) {
	        	    $total = $urows['MALE_LESS18'] + $urows['FEMALE_LESS18'] + $urows['MALE_MORE18'] +  $urows['FEMALE_MORE18'];
echo "[{v:'" . $key . "'}, {v:" . $urows['MALE_MORE18'] . "}, {v:" . $urows['FEMALE_MORE18'] . 
  "}, {v:" . ($urows['MALE_MORE18']+$urows['FEMALE_MORE18']) . "}, {v:" . $total . "}],";
	        	    	        	}?>
	        	    	  ]);
	          var table2 = new google.visualization.Table(document.getElementById('table_div2'));      
	         table2.draw(data_table2, {allowHtml: true, showRowNumber: false, width: '700px', height: '100%'});
	         <?php if($user->user_group === '1' || $user->user_group === '2'){?> //only for admin and super admin
	              $("#table1_csv2").html(dataTableToCSV(data_table2)); 
	              $("#table_div_csv2").html("<a href='#' onclick='csv_report(\"" + $("#table1_csv2").html() + "\");' style='font-style: italic; text-decoration-color: gray;'><font color='gray'style='font-family: \"Open Sans\", Tahoma, Arial sans-serif; font-size;7px'>CSV report</font></a>");
	         <?php }?>

			//draw chart 2
			$("#png_chart2").html("<a href='#' onclick='javascript:grChartImg.ShowImage(\"chart_div2\", true);' style='font-style: italic; text-decoration-color: gray;'><font color='gray'style='font-family: \"Open Sans\", Tahoma, Arial sans-serif;'>Print chart</font></a>");
	         data_chart2 = new google.visualization.DataTable();
	        	data_chart2.addColumn('string', 'County name');
	        	data_chart2.addColumn('number', 'Male');
	        	data_chart2.addColumn('number', 'Female');        
	        	data_chart2.addRows([
	        	<?php 
	        	foreach ( $data_hash_across_3 as $key=>$urows ) {
        echo "[ '" . $key . "', {v:" . $urows['MALE_MORE18'] . "}, {v:" . $urows['FEMALE_MORE18'] . "}],";
	        	 }?>
	        ]);

        var options2 = {
                "title": "Number of SGBV cases (>18 yrs) reported to health facilities for period <?php echo $date_title;?>",
        		//"legend":"none",
        		"width":1000,
        		"height":500,
        	 hAxis: {title:'County', slantedText:true, slantedTextAngle:90,showTextEvery:1 }, //lebel vertical view and show all
      		  vAxis: {title:'Number reported', minValue:0, maxValue: 5, format: '0'},
        		bar: {groupWidth: 20},
        		chartArea : { left: 40, top: 40, right:120, height: '57%'} // do not cut off labels
        };
        
			chart2 = new google.visualization.ColumnChart(document.getElementById('chart_div2'));
			google.visualization.events.addListener(chart2, 'ready', function () {
			  var content = '<img src="' + chart2.getImageURI() + '">';
			  $('#image2').append(content);
			}); 
			chart2.draw(data_chart2, options2); 
	       
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
		       	data_table.addColumn('number', 'Male');
	        	data_table.addColumn('number', 'Female');
	        	data_table.addColumn('number', 'Total');
	        	data_table.addRows([
	        	<?php foreach ( $data_hash_across_2 as $key=>$urows) {
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
	        	foreach ( $data_hash_across_2 as $key=>$urows ) {
           $male = $urows['MALE']?$urows['MALE']:0;
	        	    $female = $urows['FEMALE']?$urows['FEMALE']:0;
          echo "[ '" . $key . "', {v:" . $male . "}, {v:" . $female . "}],";
	        	 }?>
	        ]);

          var options = {
        		  "title": "<?php echo $report_name . ' between period ' . $date_title; ?>",
          		"width":1000,
          		"height":500,
          	 hAxis: {title: 'County', slantedText:true, slantedTextAngle:90,showTextEvery:1 }, //lebel vertical view and show all
        		  vAxis: {title: 'Number trained', minValue:0, maxValue: 5, format: '0'},
          		bar: {groupWidth: 20},
          		chartArea : { left: 60, top: 40, right:120, width:'60%', height: '57%'} // do not cut off labels
          };
          
			chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
			google.visualization.events.addListener(chart, 'ready', function () {
  			  var content = '<img src="' + chart.getImageURI() + '">';
  			  $('#image1').append(content);
  			}); 
			chart.draw(data_chart, options);
	       
		}

		function drawAcrossGraph_Report1(){
			$("#progress_bar").html("");
	        $("#report_title").html("<h2 class='page-title-section-gray'><?php echo $sector_type_name;?> sector report</h2>");
	        $("#pdf_report").html("<a href='#' onclick='pdf_across_report1();' style='font-style: italic; text-decoration-color: gray;'><font color='gray'style='font-family: \"Open Sans\", Tahoma, Arial sans-serif;'>PDF report</font></a>");
	        $("#png_chart").html("<a href='#' onclick='javascript:grChartImg.ShowImage(\"chart_div\", true);' style='font-style: italic; text-decoration-color: gray;'><font color='gray'style='font-family: \"Open Sans\", Tahoma, Arial sans-serif;'>Print chart</font></a>");
	        $("#chart_title").html("<h2 id='chart_title_1' class='page-title-section'><?php echo $report_name . "</h2><h2 id='chart_title_2' class='page-title-section'>" . $date_title . "</h2>";?>");

	        //draw table
	       	 var data_table = new google.visualization.DataTable();
		       	data_table.addColumn('string', 'County name');
		       	data_table.addColumn('number', 'Number of facilities <br>surveyed');
	        	data_table.addColumn('number', 'Number of facilities <br>providing comprehensive <br>services');
	        	data_table.addColumn('number', 'Proportion of facilites <br>providing clinical <br>management services <br>for survivors of <br>sexual violence');
	        	data_table.addRows([
	        	<?php foreach ( $data_hash2 as $key=>$urows) {
	        	    	        	    echo "[{v:'" . $key . "'}, {v:" . $urows['D'] . "}, {v:" . $urows['N'] . "}, {v:" . $urows['N/D'] . "}],";
	        	    	        	}?>
	        	    	  ]);
	          var table = new google.visualization.Table(document.getElementById('table_div'));      
	         table.draw(data_table, {allowHtml: true, showRowNumber: false, width: '700px', height: '100%'});
	         <?php if($user->user_group === '1' || $user->user_group === '2' || $user->user_group === '2' ){?> //only for admin and super admin
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
                    "title": "<?php echo $report_name . ' between period ' . $date_title; ?>",
            		"legend":"none",
            		"width":1000,
            		"height":500,
            	 hAxis: {title: 'County', slantedText:true, slantedTextAngle:90,showTextEvery:1 }, //lebel vertical view and show all
          		  vAxis: {title: 'Percent providing clinical management services', minValue:0, maxValue: 100, format: '0'},
            		bar: {groupWidth: 20},
            		chartArea : { left: 80, top: 40, right:20, height: '57%'} // do not cut off labels
            };
            
  			chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
  			google.visualization.events.addListener(chart, 'ready', function () {
    			  var content = '<img src="' + chart.getImageURI() + '">';
    			  $('#image1').append(content);
    			}); 
  			chart.draw(data_chart, options);
		}

		function drawGraph_report6() {
			 $("#progress_bar").html("");
		        $("#report_title").html("<h2 class='page-title-section-gray'><?php echo $sector_type_name;?> sector report</h2>");
		        $("#pdf_report").html("<a href='#' onclick='pdf_report6();' style='font-style: italic; text-decoration-color: gray;'><font color='gray'style='font-family: \"Open Sans\", Tahoma, Arial sans-serif;'>PDF report</font></a>"); 
		        $("#png_chart").html("<a href='#' onclick='javascript:grChartImg.ShowImage(\"chart_div\", true);' style='font-style: italic; text-decoration-color: gray;'><font color='gray'style='font-family: \"Open Sans\", Tahoma, Arial sans-serif;'>Print chart</font></a>");
		        $("#chart_title").html("<h2 id='chart_title_1' class='page-title-section'><?php echo $report_name . "</h2><h2 id='chart_title_2' class='page-title-section'>(" . $county_name . ") " . $date_title . "</h2>";?>");

			      //draw table
	         	 var data_table = new google.visualization.DataTable();
	          	data_table.addColumn('string', '');
	          	data_table.addColumn('number', 'Male survivors <br>who received <br>comprehensive <br>care');
	          	data_table.addColumn('number', 'Female survivors <br>who received <br>comprehensive <br>care');
	          	data_table.addColumn('number', 'Total survivors <br>who received <br>comprehensive <br>care');
	          	data_table.addColumn('number', 'Total SGBV cases <br>reported to the health <br>facility');
	          	data_table.addColumn('number', 'Proportion <br>of male survivors <br>who received <br>comprehensive <br>care');
	          	data_table.addColumn('number', 'Proportion <br>of female survivors <br>who received <br>comprehensive <br>care');
	          	<?php
	          	$less_total_D = $male_less18_total_D+$female_less18_total_D;
	          	$male_less18_proportion = 0;
	          	$female_less18_proportion = 0;
	          	if($less_total_D > 0){
	          	    $male_less18_proportion = round(($male_less18_total_N/$less_total_D)*100,2);
	          	    $female_less18_proportion = round(($female_less18_total_N/$less_total_D)*100,2);
	          	}
	          	$more_total_D = $male_more18_total_D+$female_more18_total_D;
	          	$male_more18_proportion = 0;
	          	$female_more18_proportion = 0;
	          	if($less_total_D > 0){
	          	    $male_more18_proportion = round(($male_more18_total_N/$more_total_D)*100,2);
	          	    $female_more18_proportion = round(($female_more18_total_N/$more_total_D)*100,2);
	          	}
	          	$total_D = $less_total_D + $more_total_D;
	          	$male_total_proportion = 0;
	          	$female_total_proportion = 0;
	          	if($total_D > 0){
	          	    $male_total_proportion = round((($male_less18_total_N+$male_more18_total_N)/$total_D)*100,2);
	          	    $female_total_proportion = round((($female_less18_total_N+$female_more18_total_N)/$total_D)*100,2);
	          	}
	          	?>
	          	data_table.addRows([
	             [{v: '< 18 years', p: {'style': 'font-weight: bold;'}},  
		             {v: <?php echo $male_less18_total_N;?>}, {v: <?php echo $female_less18_total_N;?>}, {v: <?php echo ($male_less18_total_N+$female_less18_total_N);?>}, 
		             {v: <?php echo ($male_less18_total_D+$female_less18_total_D);?>},
		             {v: <?php echo $male_less18_proportion;?>}, 
		             {v: <?php echo $female_less18_proportion;?>}],
		         [{v: '> 18 years', p: {'style': 'font-weight: bold;'}},  
		              {v: <?php echo $male_more18_total_N;?>}, {v: <?php echo $female_more18_total_N;?>},{v: <?php echo ($male_more18_total_N+$female_more18_total_N);?>}, 
		              {v: <?php echo ($male_more18_total_D+$female_more18_total_D);?>},
		              {v: <?php echo $male_more18_proportion;?>}, 
			          {v: <?php echo $female_more18_proportion;?>}],
			          [{v: 'Total', p: {'style': 'font-weight: bold;'}},  
		               {v: <?php echo ($male_less18_total_N+$male_more18_total_N);?>}, 
		               {v: <?php echo ($female_less18_total_N+$female_more18_total_N);?>},
		               {v: <?php echo ($male_less18_total_N+$male_more18_total_N+$female_less18_total_N+$female_more18_total_N);?>}, 
		               {v: <?php echo ($male_less18_total_D+$male_more18_total_D+$female_less18_total_D+$female_more18_total_D);?>}, 
		               {v: <?php echo $male_total_proportion;?>},
		               {v: <?php echo $female_total_proportion;?>}],
	           ]);
	            var table = new google.visualization.Table(document.getElementById('table_div'));      
	           table.draw(data_table, {allowHtml: true, showRowNumber: false, width: '900px', height: '100%'});
	           <?php if($user->user_group === '1' || $user->user_group === '2'){?> //only for admin and super admin
	                $("#table1_csv").html(dataTableToCSV(data_table)); 
	                $("#table_div_csv").html("<a href='#' onclick='csv_report(\"" + $("#table1_csv").html() + "\");' style='font-style: italic; text-decoration-color: gray;'><font color='gray'style='font-family: \"Open Sans\", Tahoma, Arial sans-serif; font-size;7px'>CSV report</font></a>");
	           <?php }?>  

	           //draw chart
		       	 data_chart = new google.visualization.DataTable();
		        	data_chart.addColumn('string', '');
		        	data_chart.addColumn('number', 'Male');
		        	data_chart.addColumn('number', 'Female');
		        	data_chart.addRows([
		           ['<18 years',   {v: <?php echo ($male_less18_proportion);?>}, {v:<?php echo ($female_less18_proportion)?>}],
		           ['>18 years', {v: <?php echo ($male_more18_proportion);?>}, {v: <?php echo ($female_more18_proportion);?>}],
		         ]);
		         
		          <?php $max_value = max(array($male_less18_proportion, $female_less18_proportion, $male_more18_proportion, $female_more18_proportion));
		          if($max_value < 5){
		              $max_value = 5;
		          }
		          ?>
		          var options = {
		        		  "title": "<?php echo $report_name . ' between period ' . $date_title . ' in ' . $county_name; ?>",
		        		  "width":1000,
		            		"height":500,
		        		  vAxis: {title:'Percent received comprehensive care', minValue:0, maxValue: 100, format: '0'},
		        		  hAxis: {title:'Age and sex of survivor'},
		        		  chartArea : { left: 60}
		          };
		          chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));	

				  google.visualization.events.addListener(chart, 'ready', function () {
					  var content = '<img src="' + chart.getImageURI() + '">';
					  $('#image1').append(content);
					}); 
						
		          chart.draw(data_chart, options);  
		}

		function drawGraph_report5() {
			 $("#progress_bar").html("");
		        $("#report_title").html("<h2 class='page-title-section-gray'><?php echo $sector_type_name;?> sector report</h2>");
		        $("#pdf_report").html("<a href='#' onclick='pdf_report5();' style='font-style: italic; text-decoration-color: gray;'><font color='gray'style='font-family: \"Open Sans\", Tahoma, Arial sans-serif;'>PDF report</font></a>"); 
		        $("#png_chart").html("<a href='#' onclick='javascript:grChartImg.ShowImage(\"chart_div\", true);' style='font-style: italic; text-decoration-color: gray;'><font color='gray'style='font-family: \"Open Sans\", Tahoma, Arial sans-serif;'>Print chart</font></a>");
		        $("#chart_title").html("<h2 id='chart_title_1' class='page-title-section'><?php echo $report_name . "</h2><h2 id='chart_title_2' class='page-title-section'>(" . $county_name . ") " . $date_title . "</h2>";?>");

			      //draw table
	         	 var data_table = new google.visualization.DataTable();
	          	data_table.addColumn('string', '');
	          	data_table.addColumn('number', 'Males <br>completed PEP');
	          	data_table.addColumn('number', 'Females <br>completed PEP');
	          	data_table.addColumn('number', 'Total <br>completed PEP');
	          	data_table.addColumn('number', 'Males <br>initiated PEP');
	          	data_table.addColumn('number', 'Females <br>initiated PEP');
	          	data_table.addColumn('number', 'Total <br>initiated on PEP');
	          	data_table.addColumn('number', 'Proportion <br>of male <br>sexual violence <br>survivors who <br>completed PEP');
	          	data_table.addColumn('number', 'Proportion <br>of female <br>sexual violence <br>survivors who <br>completed PEP');
	          	<?php
	          	$total_less18_D = $male_less18_total_D+$female_less18_total_D;
	          	if($total_less18_D > 0){
	          	    $male_less18_proportion = round($male_less18_total_N/$total_less18_D, 2);
	          	    $female_less18_proportion = round($female_less18_total_N/$total_less18_D, 2);
	          	}
	          	$total_more18_D = $male_more18_total_D+$female_more18_total_D;
	          	if($total_more18_D > 0){
	          	    $male_more18_proportion = round($male_more18_total_N/$total_more18_D, 2);
	          	    $female_more18_proportion = round($female_more18_total_N/$total_more18_D, 2);
	          	} 
	          	?>
	          	data_table.addRows([
	             [{v: '< 18 years', p: {'style': 'font-weight: bold;'}},  
		             {v: <?php echo $male_less18_total_N;?>}, {v: <?php echo $female_less18_total_N;?>}, {v: <?php echo ($male_less18_total_N+$female_less18_total_N);?>}, 
		             {v: <?php echo $male_less18_total_D;?>}, {v: <?php echo $female_less18_total_D;?>},{v: <?php echo ($male_less18_total_D+$female_less18_total_D);?>},
		             {v: <?php echo $male_less18_proportion;?>}, 
		             {v: <?php echo $female_less18_proportion;?>}],
		         [{v: '> 18 years', p: {'style': 'font-weight: bold;'}},  
		              {v: <?php echo $male_more18_total_N;?>}, {v: <?php echo $female_more18_total_N;?>},{v: <?php echo ($male_more18_total_N+$female_more18_total_N);?>}, 
		              {v: <?php echo $male_more18_total_D;?>}, {v: <?php echo $female_more18_total_D;?>},{v: <?php echo ($male_more18_total_D+$female_more18_total_D);?>},
		              {v: <?php echo $male_more18_proportion;?>}, 
			          {v: <?php echo $female_more18_proportion;?>}],
			          [{v: 'Total', p: {'style': 'font-weight: bold;'}},  
		               {v: <?php echo ($male_less18_total_N+$male_more18_total_N);?>}, 
		               {v: <?php echo ($female_less18_total_N+$female_more18_total_N);?>},
		               {v: <?php echo ($male_less18_total_N+$male_more18_total_N+$female_less18_total_N+$female_more18_total_N);?>}, 
		               {v: <?php echo ($male_less18_total_D+$male_more18_total_D);?>}, 
		               {v: <?php echo ($female_less18_total_D+$female_more18_total_D);?>},
		               {v: <?php echo ($male_less18_total_D+$male_more18_total_D+$female_less18_total_D+$female_more18_total_D);?>}, 
		               {v: <?php echo ($male_less18_proportion+$male_more18_proportion);?>},
		               {v: <?php echo ($female_less18_proportion+$female_more18_proportion);?>}],
	           ]);
	            var table = new google.visualization.Table(document.getElementById('table_div'));      
	           table.draw(data_table, {allowHtml: true, showRowNumber: false, width: '950px', height: '100%'});
	           <?php if($user->user_group === '1' || $user->user_group === '2'){?> //only for admin and super admin
	                $("#table1_csv").html(dataTableToCSV(data_table)); 
	                $("#table_div_csv").html("<a href='#' onclick='csv_report(\"" + $("#table1_csv").html() + "\");' style='font-style: italic; text-decoration-color: gray;'><font color='gray'style='font-family: \"Open Sans\", Tahoma, Arial sans-serif; font-size;7px'>CSV report</font></a>");
	           <?php }?> 

		         //draw chart
		       	 data_chart = new google.visualization.DataTable();
		        	data_chart.addColumn('string', '');
		        	data_chart.addColumn('number', 'Male');
		        	data_chart.addColumn('number', 'Female');
		        	data_chart.addRows([
		           ['<18 years',   {v: <?php echo ($male_less18_proportion*100);?>}, {v:<?php echo ($female_less18_proportion*100)?>}],
		           ['>18 years', {v: <?php echo ($male_more18_proportion*100);?>}, {v: <?php echo ($female_more18_proportion*100);?>}],
		         ]);
		         
		          <?php $max_value = max(array($male_less18_proportion, $female_less18_proportion, $male_more18_proportion, $female_more18_proportion));
		          if($max_value < 5){
		              $max_value = 5;
		          }
		          ?>
		          var options = {
		        		  "title": "<?php echo $report_name . ' between period ' . $date_title . ' in ' . $county_name; ?>",
		        		  "width":1000,
		            		"height":500,
		        		  vAxis: {title:'Percent completed on PEP', minValue:0, maxValue: 100, format: '0'},
		        		  hAxis: {title:'Age and sex of survivor'},
		        		  chartArea : { left: 50}
		          };
		          chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));	

				  google.visualization.events.addListener(chart, 'ready', function () {
					  var content = '<img src="' + chart.getImageURI() + '">';
					  $('#image1').append(content);
					}); 
						
		          chart.draw(data_chart, options); 
			      
		}

		function drawGraph_report4() {
			 $("#progress_bar").html("");
		        $("#report_title").html("<h2 class='page-title-section-gray'><?php echo $sector_type_name;?> sector report</h2>");
		        $("#pdf_report").html("<a href='#' onclick='pdf_report4();' style='font-style: italic; text-decoration-color: gray;'><font color='gray'style='font-family: \"Open Sans\", Tahoma, Arial sans-serif;'>PDF report</font></a>"); 
		        $("#png_chart").html("<a href='#' onclick='javascript:grChartImg.ShowImage(\"chart_div\", true);' style='font-style: italic; text-decoration-color: gray;'><font color='gray'style='font-family: \"Open Sans\", Tahoma, Arial sans-serif;'>Print chart</font></a>");
		        $("#chart_title").html("<h2 id='chart_title_1' class='page-title-section'><?php echo $report_name . "</h2><h2 id='chart_title_2' class='page-title-section'>(" . $county_name . ") " . $date_title . "</h2>";?>");

			      //draw table
	         	 var data_table = new google.visualization.DataTable();
	          	data_table.addColumn('string', '');
	          	data_table.addColumn('number', 'Males <br>initiated <br>on PEP');
	          	data_table.addColumn('number', 'Females <br>initiated <br>on PEP');
	          	data_table.addColumn('number', 'Total <br>initiated <br>on PEP');
	          	data_table.addColumn('number', 'Total male <br>SGBV cases <br>reporting within <br>72 hours');
	          	data_table.addColumn('number', 'Total female <br>SGBV cases <br>reporting within <br>72 hours');
	          	data_table.addColumn('number', 'Total SGBV <br>cases <br>reporting within <br>72 hours');
	          	data_table.addColumn('number', 'Proportion <br>of male sexual <br>violence <br>survivors <br>initiated on PEP');
	          	data_table.addColumn('number', 'Proportion <br>of female sexual <br>violence <br>survivors <br>initiated on PEP');
	          	<?php
	          	$total_D = $male_less18_total_D+$female_less18_total_D+$male_more18_total_D+$female_more18_total_D;
	          	if($total_D > 0){
	          	    $male_less18_proportion = round($male_less18_total_N/$total_D, 2);
	          	    $female_less18_proportion = round($female_less18_total_N/$total_D, 2);
	          	    $male_more18_proportion = round($male_more18_total_N/$total_D, 2);
	          	    $female_more18_proportion = round($female_more18_total_N/$total_D, 2);
	          	}
	          	$male_total_D = $male_less18_total_D+$male_more18_total_D;
	          	if($male_total_D > 0 ){
	          	    $male_total_proportion = round(($male_less18_total_N+$male_more18_total_N)/$male_total_D,2);
	          	}
	          	$female_total_D = $female_less18_total_D+$female_more18_total_D;
	          	if($female_total_D > 0 ){
	          	    $female_total_proportion = round(($female_less18_total_N+$female_more18_total_N)/$female_total_D,2);
	          	} 
	          	?>
	          	data_table.addRows([
	             [{v: '< 18 years', p: {'style': 'font-weight: bold;'}},  
		             {v: <?php echo $male_less18_total_N;?>}, {v: <?php echo $female_less18_total_N;?>}, {v: <?php echo ($male_less18_total_N+$female_less18_total_N);?>}, 
		             {v: <?php echo $male_less18_total_D;?>}, {v: <?php echo $female_less18_total_D;?>},{v: <?php echo ($male_less18_total_D+$female_less18_total_D);?>},
		             {v: <?php echo $male_less18_proportion;?>}, 
		             {v: <?php echo $female_less18_proportion;?>}],
		         [{v: '> 18 years', p: {'style': 'font-weight: bold;'}},  
		              {v: <?php echo $male_more18_total_N;?>}, {v: <?php echo $female_more18_total_N;?>},{v: <?php echo ($male_more18_total_N+$female_more18_total_N);?>}, 
		              {v: <?php echo $male_more18_total_D;?>}, {v: <?php echo $female_more18_total_D;?>},{v: <?php echo ($male_more18_total_D+$female_more18_total_D);?>},
		              {v: <?php echo $male_more18_proportion;?>}, 
			          {v: <?php echo $female_more18_proportion;?>}],
			          [{v: 'Total', p: {'style': 'font-weight: bold;'}},  
		               {v: <?php echo ($male_less18_total_N+$male_more18_total_N);?>}, 
		               {v: <?php echo ($female_less18_total_N+$female_more18_total_N);?>},
		               {v: <?php echo ($male_less18_total_N+$male_more18_total_N+$female_less18_total_N+$female_more18_total_N);?>}, 
		               {v: <?php echo ($male_less18_total_D+$male_more18_total_D);?>}, 
		               {v: <?php echo ($female_less18_total_D+$female_more18_total_D);?>},
		               {v: <?php echo ($male_less18_total_D+$male_more18_total_D+$female_less18_total_D+$female_more18_total_D);?>}, 
		               {v: <?php echo $male_total_proportion;?>},
		               {v: <?php echo $female_total_proportion;?>}],
	           ]);
	            var table = new google.visualization.Table(document.getElementById('table_div'));      
	           table.draw(data_table, {allowHtml: true, showRowNumber: false, width: '900px', height: '100%'});
	           <?php if($user->user_group === '1' || $user->user_group === '2'){?> //only for admin and super admin
	                $("#table1_csv").html(dataTableToCSV(data_table)); 
	                $("#table_div_csv").html("<a href='#' onclick='csv_report(\"" + $("#table1_csv").html() + "\");' style='font-style: italic; text-decoration-color: gray;'><font color='gray'style='font-family: \"Open Sans\", Tahoma, Arial sans-serif; font-size;7px'>CSV report</font></a>");
	           <?php }?> 

		         //draw chart
		       	 data_chart = new google.visualization.DataTable();
		        	data_chart.addColumn('string', '');
		        	data_chart.addColumn('number', 'Male');
		        	data_chart.addColumn('number', 'Female');
		        	data_chart.addRows([
		           ['<18 years',   {v: <?php echo ($male_less18_proportion*100);?>}, {v:<?php echo ($female_less18_proportion*100)?>}],
		           ['>18 years', {v: <?php echo ($male_more18_proportion*100);?>}, {v: <?php echo ($female_more18_proportion*100);?>}],
		         ]);
		         
		          <?php $max_value = max(array($male_less18_proportion, $female_less18_proportion, $male_more18_proportion, $female_more18_proportion));
		          if($max_value < 5){
		              $max_value = 5;
		          }
		          ?>
		          var options = {
		        		  "title": "<?php echo $report_name . ' between period ' . $date_title . ' in ' . $county_name; ?>",
		        		  "width":1000,
		            		"height":500,
		        		  vAxis: {title:'Percent initiated on PEP', minValue:0, maxValue: 100, format: '0'},
		        		  hAxis: {title:'Age and sex of survivor'},
		        		  chartArea : { left: 50}
		          };
		          chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));	

				  google.visualization.events.addListener(chart, 'ready', function () {
					  var content = '<img src="' + chart.getImageURI() + '">';
					  $('#image1').append(content);
					}); 
						
		          chart.draw(data_chart, options);  
		}

		function drawGraph_report3() {
			 $("#progress_bar").html("");
		        $("#report_title").html("<h2 class='page-title-section-gray'><?php echo $sector_type_name;?> sector report</h2>");
		        $("#pdf_report").html("<a href='#' onclick='pdf_report3();' style='font-style: italic; text-decoration-color: gray;'><font color='gray'style='font-family: \"Open Sans\", Tahoma, Arial sans-serif;'>PDF report</font></a>"); 
		        $("#png_chart").html("<a href='#' onclick='javascript:grChartImg.ShowImage(\"chart_div\", true);' style='font-style: italic; text-decoration-color: gray;'><font color='gray'style='font-family: \"Open Sans\", Tahoma, Arial sans-serif;'>Print chart</font></a>");
		        $("#chart_title").html("<h2 id='chart_title_1' class='page-title-section'><?php echo $report_name . "</h2><h2 id='chart_title_2' class='page-title-section'>(" . $county_name . ") " . $date_title . "</h2>";?>");

		         //draw table
		       	 var data_table = new google.visualization.DataTable();
		        	data_table.addColumn('string', 'Age range');
		        	data_table.addColumn('number', 'Male');
		        	data_table.addColumn('number', 'Female');
		        	data_table.addColumn('number', 'Total');
		        	data_table.addRows([
		           [{v: '< 18 years', p: {'style': 'font-weight: bold;'}},  {v: <?php echo $male_age_under_18;?>}, {v: <?php echo $female_age_under_18;?>},{v: <?php echo ($male_age_under_18+$female_age_under_18);?>}],
		           [{v: '> 18 years', p: {'style': 'font-weight: bold;'}},   {v:<?php echo $male_age_above_18;?>},  {v: <?php echo $female_age_above_18;?>},  {v: <?php echo ($male_age_above_18+$female_age_above_18);?>}],
		           [{v: 'Total', p: {'style': 'font-weight: bold;'}}, {v: <?php echo ($male_age_under_18+$male_age_above_18);?>}, {v:<?php echo ($female_age_under_18+$female_age_above_18);?>}, {v:<?php echo ($male_age_under_18+$male_age_above_18+$female_age_under_18+$female_age_above_18);?>}],
		         ]);
		          var table = new google.visualization.Table(document.getElementById('table_div'));      
		         table.draw(data_table, {allowHtml: true, showRowNumber: false, width: '500px', height: '100%'});
		         <?php if($user->user_group === '1' || $user->user_group === '2'){?> //only for admin and super admin
		              $("#table1_csv").html(dataTableToCSV(data_table)); 
		              $("#table_div_csv").html("<a href='#' onclick='csv_report(\"" + $("#table1_csv").html() + "\");' style='font-style: italic; text-decoration-color: gray;'><font color='gray'style='font-family: \"Open Sans\", Tahoma, Arial sans-serif; font-size;7px'>CSV report</font></a>");
		         <?php }?>
		        	
		          //draw chart
		       	 data_chart = new google.visualization.DataTable();
		        	data_chart.addColumn('string', '');
		        	data_chart.addColumn('number', 'Male');
		        	data_chart.addColumn('number', 'Female');
		        	data_chart.addRows([
		           ['<18 years',   {v: <?php echo $male_age_under_18;?>}, {v:<?php echo $female_age_under_18;?>}],
		           ['>18 years', {v: <?php echo $male_age_above_18;?>}, {v: <?php echo $female_age_above_18;?>}],
		         ]);
		         
		          <?php $max_value = max(array($male_age_under_18, $male_age_above_18, $female_age_under_18, $female_age_above_18));
		          if($max_value < 5){
		              $max_value = 5;
		          }
		          ?>
		          var options = {
		        		  "title": "<?php echo $report_name . ' between period ' . $date_title . ' in ' . $county_name; ?>",
		        		  "width":1000,
		            		"height":500,
		        		  vAxis: {title:'Number reported', minValue:0, maxValue: 5, format: '0'},
		        		  hAxis: {title:'Age and sex of survivor'},
		        		  chartArea : { left: 50}
		          };
		          chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));	

				  google.visualization.events.addListener(chart, 'ready', function () {
					  var content = '<img src="' + chart.getImageURI() + '">';
					  $('#image1').append(content);
					}); 
						
		          chart.draw(data_chart, options);   
	        }

		function drawGraph_report2() {

	        $("#progress_bar").html("");
	        $("#report_title").html("<h2 class='page-title-section-gray'><?php echo $sector_type_name;?> sector report</h2>");
	        $("#pdf_report").html("<a href='#' onclick='pdf_report2(<?php echo count($data_hash);?>);' style='font-style: italic; text-decoration-color: gray;'><font color='gray'style='font-family: \"Open Sans\", Tahoma, Arial sans-serif;'>PDF report</font></a>");
	        $("#png_chart").html("<a href='#' onclick='javascript:grChartImg.ShowImage(\"chart_div\", true);' style='font-style: italic; text-decoration-color: gray;'><font color='gray'style='font-family: \"Open Sans\", Tahoma, Arial sans-serif;'>Print chart</font></a>");
	        $("#chart_title").html("<h2 id='chart_title_1' class='page-title-section'><?php echo $report_name . "</h2><h2 id='chart_title_2' class='page-title-section'>(" . $county_name . ") " . $date_title . "</h2>";?>");


	         //draw table
	       	 var data_table = new google.visualization.DataTable();
		       	data_table.addColumn('string', 'Cadre');
		       	data_table.addColumn('number', 'Male');
	        	data_table.addColumn('number', 'Female');
	        	data_table.addColumn('number', 'Total');
	        	data_table.addRows([
	        	<?php 
	        	$male_total = 0;
	        	$female_total = 0;
	        	  foreach ( $data_hash as $key=>$urows) {
	        	    $male = $urows['MALE']?$urows['MALE']:0;
	        	    $male_total = $male_total + $male;
	        	    $female = $urows['FEMALE']?$urows['FEMALE']:0;
	        	    $female_total = $female_total + $female;
	        	    	        	    echo "[{v:'" . $key . "'}, {v:" . $male . "}, {v:" . $female . "}, {v:" . ($female+$male) . "}],";
	        	    	        	}
	        	   echo "[{v:'Total', p: {'style': 'font-weight: bold;'}}, {v:" . $male_total . "}, {v:" . $female_total . "}, {v:" . ($female_total+$male_total) . "}],";
	        	    	        	?>
	        	    	  ]);
	        	
	          var table = new google.visualization.Table(document.getElementById('table_div'));      
	         table.draw(data_table, {allowHtml: true, showRowNumber: false, width: '500px', height: '100%'});
	         <?php if($user->user_group === '1' || $user->user_group === '2'){?> //only for admin and super admin
	              $("#table1_csv").html(dataTableToCSV(data_table)); 
	              $("#table_div_csv").html("<a href='#' onclick='csv_report(\"" + $("#table1_csv").html() + "\");' style='font-style: italic; text-decoration-color: gray;'><font color='gray'style='font-family: \"Open Sans\", Tahoma, Arial sans-serif; font-size;7px'>CSV report</font></a>");
	         <?php }?>
	        	
	          //draw chart
	       	 data_chart = new google.visualization.DataTable();
	        	data_chart.addColumn('string', '');
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
	        		  "title": "<?php echo $report_name . ' between period ' . $date_title . ' in ' . $county_name; ?>",
	        		  "width":1000,
	            		"height":500,
	        		  vAxis: {title: 'Number trained', minValue:0, maxValue: 5, format: '0'},
	        		  hAxis: {title: 'Cadre and sex', slantedText:true, slantedTextAngle:45,showTextEvery:1 }, //lebel vertical view and show all
	        		  chartArea : { left: 60, top: 40, right:120, width:'60%', height: '57%'}, // do not cut off labels
	        		//  bar: {groupWidth: 30},
	          };
	          chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
	          
			  google.visualization.events.addListener(chart, 'ready', function () {
				  var content = '<img src="' + chart.getImageURI() + '">';
				  $('#image1').append(content);
				}); 
					
	          chart.draw(data_chart, options);   
	        }

        
		function drawGraph_report1(){
			$("#progress_bar").html("");
	        $("#report_title").html("<h2 class='page-title-section-gray'><?php echo $sector_type_name;?> sector report</h2>");
	        $("#pdf_report").html("<a href='#' onclick='pdf_report1(<?php echo count($data_hash['ownership']);?>);' style='font-style: italic; text-decoration-color: gray;'><font color='gray'style='font-family: \"Open Sans\", Tahoma, Arial sans-serif;'>PDF report</font></a>");
	        $("#png_chart").html("<a href='#' onclick='javascript:grChartImg.ShowImage(\"chart_div\", true);' style='font-style: italic; text-decoration-color: gray;'><font color='gray'style='font-family: \"Open Sans\", Tahoma, Arial sans-serif;'>Print chart</font></a>");
	        $("#chart_title").html("<h2 id='chart_title_1' class='page-title-section'><?php echo $report_name . "</h2><h2 id='chart_title_2' class='page-title-section'>(" . $county_name . ") " . $date_title . "</h2>";?>");

			//draw table
	       	 var data_table = new google.visualization.DataTable();
	       	 
	        	data_table.addColumn('string', 'Ownership');
	        	data_table.addColumn('string', 'Number of facilities <br>providing comprehensive <br>services by ownership');
	        	data_table.addColumn('string', 'Total facilities <br>surveyed');
	        	data_table.addColumn('string', 'Proportion of health <br>facilities providing <br>comprehensive services <br>(percent)');
 	        	data_table.addRows([
	        	<?php foreach ( $data_hash['ownership'] as $key=>$urows) {
  	        	    echo "[{v: '" . $key . "'}, {v:'" . $urows ['total'] . "'}, {v:''}, {v:'" . $urows ['proportion'] . "'}],";
 	        	}
 	        	echo "[{v: 'Total', p: {'style': 'font-weight: bold;'}}, {v:'" . $total_ownerships . "'}, {v:'" . $total_facilities . "'}, {v:'" . $total_proportion . "'}],";
 	        	?>
 	         ]);
	        
	          var table = new google.visualization.Table(document.getElementById('table_div'));      
	         table.draw(data_table, {allowHtml: true, showRowNumber: false, width: '700px', height: '100%'});
	         <?php if($user->user_group === '1' || $user->user_group === '2'){?> //only for admin and super admin
	              $("#table1_csv").html(dataTableToCSV(data_table)); 
	              $("#table_div_csv").html("<a href='#' onclick='csv_report(\"" + $("#table1_csv").html() + "\");' style='font-style: italic; text-decoration-color: gray;'><font color='gray'style='font-family: \"Open Sans\", Tahoma, Arial sans-serif; font-size;7px'>CSV report</font></a>");
	         <?php }?>

		       //draw chart
				var chart_data = [];
				chart_data = [
	 			              ['', 'Proportion'],
		 			             <?php foreach ( $data_hash['ownership'] as $key=>$urows ) {
		 			                 $male = $urows['male']?$urows['male']:0;
		 			                 $female = $urows['female']?$urows['female']:0;
				              echo "['" . $key . "'," . $urows['proportion'] . "],";
		 			             }
		 			             echo "['Total'," . $total_proportion . "],";
		 			             ?>
	 			           ];

	            data_chart = google.visualization.arrayToDataTable(chart_data);
	            var options = {
	    	            "title": "Proportion of health facilities providing comprehensive clinical management services for survivors of sexual violence between <?php echo $date_title;?> in <?php echo $county_name;?>",
	             		"legend":"none",
	             		"width":1000,
	             		"height":500,
	             		hAxis: {title: 'Percent Providing Comprehensive Services'},
	             		vAxis: {title: 'Health facility ownership'},
	            		  // no way to rotate only hAxis   vAxis: {slantedText:true, slantedTextAngle:45,showTextEvery:1},
	              		chartArea : { left: 400, height: '60%'} // do not cut off labels
	             };
	  			chart = new google.visualization.BarChart(document.getElementById('chart_div'));
	  		  
	  			google.visualization.events.addListener(chart, 'ready', function () {
	    			  var content = '<img src="' + chart.getImageURI() + '">';
	    			  $('#image1').append(content);
	    			}); 
	  			chart.draw(data_chart, options);
		}

		function noDataMessage(){
			$("#progress_bar").html("");
	        $("#report_title").html("<h2 class='page-title-section-gray'><?php echo $sector_type_name;?> sector report</h2>");
	        $("#pdf_report").html("<a href='#' onclick='pdf_report();' style='font-style: italic; text-decoration-color: gray;'><font color='gray'style='font-family: \"Open Sans\", Tahoma, Arial sans-serif;'>PDF report</font></a>");
	        $("#chart_title").html("<h2 id='chart_title_1' class='page-title-section'><?php echo $report_name . "</h2><h2 id='chart_title_2' class='page-title-section'>(" . $county_name . ") " . $date_title . "</h2><br><br>No data";?>");
			
		}

		function testMessage(){
			$("#progress_bar").html("");
	        $("#report_title").html("<h2 class='page-title-section-gray'><?php echo $sector_type_name;?> sector report</h2>");
	        $("#pdf_report").html("<a href='#' onclick='pdf_report();' style='font-style: italic; text-decoration-color: gray;'><font color='gray'style='font-family: \"Open Sans\", Tahoma, Arial sans-serif;'>PDF report</font></a>");
	        $("#chart_title").html("<h2 id='chart_title_1' class='page-title-section'><?php echo $report_name . "</h2><h2 id='chart_title_2' class='page-title-section'>(" . $county_name . ") " . $date_title . "</h2><br><br>TEST";?>");
			
		}
		
	

      </script>

<div id="main-content">

    <div id='table1_csv' style='display: none'></div>
    <div id='table1_csv1' style='display: none'></div>
    <div id='table1_csv2' style='display: none'></div>
    
	<div id='image1' style='display: none'></div>
	<div id='table2_csv' style='display: none'></div>
	<div id='image2' style='display: none'></div>
	
	<div id='image3' style='display: none'></div>
	<div id='image4' style='display: none'></div>

	<div id='progress_bar' align='center'><br><br><img src='../UI/images/page_loading_animation.gif' width=130 height=160/></div>
	<div id="report_content">

		<table width=100% border=0>
		<caption align="bottom" ><div id='pdf_report' align='right' style='margin-top:-9px;'></div></caption>
		<tr><td><div id='report_title'></div></td></tr>
		</table>

		<table border=0>
			<tr>
				<td colspan=2 align='center'><div id='chart_title'></div></td>
			</tr>
			<tr>
				<td valign='top'><div id="table_div"></div>
				<div id='table_div_csv' align='left' style='margin-top:-8px;'></div></td>
				</tr>
				<tr>
				<td valign='top'><div id="chart_div"style="width: 650px;"></div><div id='png_chart' align='left' style='margin-top:-9px;'></div></td>
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
				<td colspan=2><div id='detailed_report_table'></div><div id='detailed_table_div_csv' align='left' style='margin-top:-8px;'></div></td>
			</tr>
			<tr>
				<td colspan=2><br><div id='detailed_report_chart'
						style="width: 100%;"></div><div id='png_chart_detailed' align='left' style='margin-top:-9px;'></div></td>
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