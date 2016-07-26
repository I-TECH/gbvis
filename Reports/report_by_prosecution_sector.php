<?php
// TA:60:3 report table and graph
$page_title = "Home | GBV";
$current_page = "home";

require_once 'includes/global.inc.php';

// check to see if they're logged in
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
    
    if($sector_type_id == 4){
        // date format in database 0000-00-00
        $fromdate_arr = explode("/", $fromdate);
        $fromdate_new = $fromdate_arr[1] ."-" .  $fromdate_arr[0] . "-01";
        $todate_arr = explode("/", $todate);
        $todate_new = $todate_arr[1] ."-" .  $todate_arr[0] . "-31";
        
        if($report_id === '1'){//15
            $sql = "select sex, ranks.rank, sum(aggregate) as aggregate from prosecution_aggregates join ranks on prosecution_aggregates.rank=ranks.id where 
            indicator_id in (15) and county_id=" . $county_id . " and date between '" .
                $fromdate_new . "' and '" . $todate_new . "' group by sex, ranks.rank";
            if($county_id === "all"){
                $sql = "select sex, ranks.rank, sum(aggregate) as aggregate from prosecution_aggregates join ranks on prosecution_aggregates.rank=ranks.id where
            indicator_id in (15) and date between '" .
                $fromdate_new . "' and '" . $todate_new . "' group by sex, ranks.rank";
            }else if($county_id === "across"){
                $sql = "select sex, counties.county_name, sum(aggregate) as aggregate from prosecution_aggregates join counties on counties.county_id=prosecution_aggregates.county_id " .
                    " where indicator_id in (15) and date between '" .
                    $fromdate_new . "' and '" . $todate_new . "' group by sex, prosecution_aggregates.county_id order by counties.county_id";
            }
            //print $sql;
            $result = mysql_query($sql);
            $data=$db->processRowSet($result);
            if($county_id === "across"){
                //create data with all counties for cross county report
                foreach ( $counties as $urows ) {
                    $data_hash[str_replace("'", "", $urows ['1'])]['MALE'] = 0;
                    $data_hash[str_replace("'", "", $urows ['1'])]['FEMALE'] = 0;
                }
                //add recieved data to array
                foreach ( $data as $urows4 ) {
                    $data_hash[str_replace("'", "", $urows4['county_name'])][strtoupper($urows4['sex'])] = $urows4['aggregate'];
                }
            }else{
                foreach ( $data as $urows4 ) {
                    $data_hash[$urows4['rank']][strtoupper($urows4['sex'])] = $urows4['aggregate'];
                }
            }
           // print_r($data_hash);
        }else if($report_id === '2'){ // // show proprtions in %: 17/16 and (16-17)/16
            $sql = "select sum(aggregate) as aggregate from prosecution_aggregates where indicator_id in (17)  and county_id=" . $county_id . " and date between '" .
                $fromdate_new . "' and '" . $todate_new . "'";
            if($county_id === "all"){
                $sql = "select sum(aggregate) as aggregate from prosecution_aggregates where indicator_id in (17)  and date between '" .
                    $fromdate_new . "' and '" . $todate_new . "'";
            }else if($county_id === "across"){
                $sql = "select counties.county_name, sum(aggregate) as aggregate from prosecution_aggregates join counties on counties.county_id=prosecution_aggregates.county_id " .
                    " where indicator_id in (17) and date between '" .
                    $fromdate_new . "' and '" . $todate_new . "' group by prosecution_aggregates.county_id order by counties.county_id";
            }
            $result = mysql_query($sql);
            $data_all_N=$db->processRowSet($result);
            
        $sql = "select sum(aggregate) as aggregate from prosecution_aggregates where indicator_id in (16)  and county_id=" . $county_id . " and date between '" .
                $fromdate_new . "' and '" . $todate_new . "'";
            if($county_id === "all"){
                $sql = "select sum(aggregate) as aggregate from prosecution_aggregates where indicator_id in (16)  and date between '" .
                    $fromdate_new . "' and '" . $todate_new . "'";
            }else if($county_id === "across"){
                $sql = "select counties.county_name, sum(aggregate) as aggregate from prosecution_aggregates join counties on counties.county_id=prosecution_aggregates.county_id " .
                    " where indicator_id in (16) and date between '" .
                    $fromdate_new . "' and '" . $todate_new . "' group by prosecution_aggregates.county_id order by counties.county_id";
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
               //print_r($data_hash);
            }else{
                $total_cases = 0;
                $cases_investigated = 0;
                $cases_notinvestigated = 0;
                foreach ( $data_all_D as $urows3 ){
                    if($urows3['aggregate']){
                        $total_cases = $urows3['aggregate'];
                        array_push($data, $urows3); // do not display message "No data"
                    }
                }
                foreach ( $data_all_N as $urows4 ) {
                    if($urows4['aggregate']){
                        $cases_investigated = $urows4['aggregate'];;
                        array_push($data, $urows4); // do not display message "No data"
                    }
                }
                $cases_notinvestigated = $total_cases-$cases_investigated;
//                                  print_r($data_all_N); print "<br>";
//                                  print_r($data_all_D); print "<br>";
//                                  print $total_cases . "-" . $cases_investigated . "=" . $cases_notinvestigated . "<br>";
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

function pdf_report_simple(){  

	var doc = new jsPDF('p', 'pt', 'a4', false);
	
	doc.setFontType("bold");
	doc.setFontSize(14);
	doc.text(200, 30, 'Prosecution sector report');
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
     doc.addImage(image1[0], 'png', 40, 200, 600, 300); 
 }catch (e) {
     doc.text(120, 120, 'Cannot print chart report');
 }

 doc.save("ProsecutionSecotorReport.pdf");
}

function pdf_across_report1(){  

	var doc = new jsPDF('p', 'pt', 'a4', false);
	
	doc.setFontType("bold");
	doc.setFontSize(14);
	doc.text(200, 30, 'Prosecution sector report');
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

	doc.save("ProsecutionSecotorReport.pdf");
}

function pdf_across_report2(){  

	var doc = new jsPDF('p', 'pt', 'a4', false);
	
	doc.setFontType("bold");
	doc.setFontSize(14);
	doc.text(200, 30, 'Prosecution sector report');
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

	doc.save("ProsecutionSecotorReport.pdf");
}

function pdf_report_1(rows){  

	var doc = new jsPDF('p', 'pt', 'a4', false);
	
	doc.setFontType("bold");
	doc.setFontSize(14);
	doc.text(200, 30, 'Prosecution sector report');
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
     doc.addImage(image1[0], 'png', 40, (130+rows*40), 500, 300);
 }catch (e) {
     doc.text(120, 120, 'Cannot print chart report');
 }

 doc.save("ProsecutionSecotorReport.pdf");
}

function pdf_report(){  

	var doc = new jsPDF('p', 'pt', 'a4', false);
	
	doc.setFontType("bold");
	doc.setFontSize(14);
	doc.text(200, 30, 'Prosecution sector report');
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
     doc.addImage(image1[0], 'png', 180, 90, 500, 200, undefined, 'none');
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

	doc.save("ProsecutionSecotorReport.pdf");
}

function csv_report(text) {
	var blob = new Blob([text], {type: "text/plain;charset=utf-8"});
	saveAs(blob, "ProsecutionSecotorReport.csv");
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
    return "Prosecution sector report\\n" + $('#chart_title_1').text() + "\\n" + $('#chart_title_2').text() + "\\n" + csv_out;
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
			        if($report_id === '1'){ //TA
			            echo "drawAcrossDateAggregateGraph_Report1();";
			        }else if($report_id === '2'){
			            echo "drawAcrossDateAggregateGraph_Report2();";
			        }
			    }else{ 
			        if($report_id === '1'){
			          echo "drawDateAggregateGraph_report1();";
			         }else{
			         echo "drawDateAggregateGraph_report2();";
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

		function drawAcrossDateAggregateGraph_Report1(){
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
	        	<?php foreach ( $data_hash as $key=>$urows) {
 	        	    $male = $urows['MALE']?$urows['MALE']:0;
 	        	    $female = $urows['FEMALE']?$urows['FEMALE']:0;
	        	    	        	    echo "[{v:'" . $key . "'}, {v:" . $male . "}, {v:" . $female . "}, {v:" . ($female+$male) . "}],";
	        	    	        	}?>
	        	    	  ]);
	          var table = new google.visualization.Table(document.getElementById('table_div'));      
	         table.draw(data_table, {allowHtml: true, showRowNumber: false, width: '300px', height: '100%'});
	         <?php if($user->user_group === '1' || $user->user_group === '2' || $user->user_group === '2' ){?> //only for admin and super admin
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

		function drawAcrossDateAggregateGraph_Report2(){
			$("#progress_bar").html("");
	        $("#report_title").html("<h2 class='page-title-section-gray'><?php echo $sector_type_name;?> sector report</h2>");
	        $("#pdf_report").html("<a href='#' onclick='pdf_across_report2();' style='font-style: italic; text-decoration-color: gray;'><font color='gray'style='font-family: \"Open Sans\", Tahoma, Arial sans-serif;'>PDF report</font></a>");
	        $("#png_chart").html("<a href='#' onclick='javascript:grChartImg.ShowImage(\"chart_div\", true);' style='font-style: italic; text-decoration-color: gray;'><font color='gray'style='font-family: \"Open Sans\", Tahoma, Arial sans-serif;'>Print chart</font></a>");
	        $("#chart_title").html("<h2 id='chart_title_1' class='page-title-section'><?php echo $report_name . "</h2><h2 id='chart_title_2' class='page-title-section'>" . $date_title . "</h2>";?>");

	        //draw table
	       	 var data_table = new google.visualization.DataTable();
		       	data_table.addColumn('string', 'County name');
		       	data_table.addColumn('number', 'Total number of SGBV cases<br> reported to the police');
	        	data_table.addColumn('number', 'Number of SGBV cases<br> that were prosecuted');
	        	data_table.addColumn('number', 'Proportion of SGBV cases<br> that were prosecuted by law');
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
	        	data_chart.addColumn('number', 'Percent');      
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
          		  vAxis: {title:'Percent cases prosecuted', minValue:0, maxValue: 100, format: '0'},
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

		function drawDateAggregateGraph_report1(){
			$("#progress_bar").html("");
	        $("#report_title").html("<h2 class='page-title-section-gray'><?php echo $sector_type_name;?> sector report</h2>");
	        $("#pdf_report").html("<a href='#' onclick='pdf_report_1(<?php echo count($data_hash);?>);' style='font-style: italic; text-decoration-color: gray;'><font color='gray'style='font-family: \"Open Sans\", Tahoma, Arial sans-serif;'>PDF report</font></a>");
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
	        	    	        	$male_total =0;
	        	    	        	$female_total =0;
	        	    	        	foreach ( $data_hash as $key=>$urows) {
	        	    	        	    $male = $urows['MALE']?$urows['MALE']:0;
	        	    	        	    $male_total+=$male;
	        	    	        	    $female_total+=$female;
	        	    	        	    $female = $urows['FEMALE']?$urows['FEMALE']:0;
	        	    	        	    	        	    echo "[{v:'" . $key . "'}, {v:" . $male . "}, {v:" . $female . "}, {v:" . ($female+$male) . "}],";
	        	    	        	    	        	}
	        	    	        	  echo "[{v:'Total',p: {'style': 'font-weight: bold;'}}, {v:" . $male_total . "}, {v:" . $female_total . "}, {v:" . ($female_total+$male_total) . "}],";
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
	        	<?php 
	        	$data_ready = array();
	        	foreach ( $data as $urows ) {
	        	    $cadre = $urows ['rank'];
	        	    $gender = $urows ['sex'];
	        	    $data_ready[$cadre][$gender] = $urows ['aggregate'];   
	        	}
	        	//print_r($data_ready);
	        	?>
	            
	            
	        	data_chart.addRows([
	        	<?php 
	        	foreach ( $data_ready as $key=>$urows ) {
                  $male_number = $urows['Male'];
                  $female_number = $urows['Female'];
                  if(!$male_number){
                      $male_number = 0;
                  }
                  if(!$female_number){
                      $female_number = 0;
                  }
                  echo "[ '" . $key . "', {v:" . $male_number . "}, {v:" . $female_number . "}],";
	        	 }?>
	        ]);

	        	     
	          var options = {
	        		  "title": "<?php echo $report_name . ' \nbetween period ' . $date_title . ' in ' . $county_name; ?>",
	        		  "width":1000,
	            		"height":500,
	            		hAxis: {title:'Sex and cadre', slantedText:true, slantedTextAngle:45,showTextEvery:1},
	        		  vAxis: {title:'Number trained', minValue:0, maxValue: 5, format: '0'},
	        		  chartArea : { left: 60, top:40, right:120, bottom:200, height: '57%'}
	          };
	          chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
	          google.visualization.events.addListener(chart, 'ready', function () {
  			  var content = '<img src="' + chart.getImageURI() + '">';
  			  $('#image1').append(content);
  			}); 
					
	          chart.draw(data_chart, options);
		}

		function drawDateAggregateGraph_report2(){

			$("#progress_bar").html("");
	        $("#report_title").html("<h2 class='page-title-section-gray'><?php echo $sector_type_name;?> sector report</h2>");
	        $("#pdf_report").html("<a href='#' onclick='pdf_report_simple();' style='font-style: italic; text-decoration-color: gray;'><font color='gray'style='font-family: \"Open Sans\", Tahoma, Arial sans-serif;'>PDF report</font></a>");
	        $("#png_chart").html("<a href='#' onclick='javascript:grChartImg.ShowImage(\"chart_div\", true);' style='font-style: italic; text-decoration-color: gray;'><font color='gray'style='font-family: \"Open Sans\", Tahoma, Arial sans-serif;'>Print chart</font></a>");
	        $("#chart_title").html("<h2 id='chart_title_1' class='page-title-section'><?php echo $report_name . "</h2><h2 id='chart_title_2' class='page-title-section'>(" . $county_name . ") " . $date_title . "</h2>";?>");

			//draw table
	       	 var data_table = new google.visualization.DataTable();

		    data_table.addColumn('string', '');
        	data_table.addColumn('number', 'Total cases reported');
        	data_table.addColumn('number', 'Cases prosecuted');
        	data_table.addColumn('number', 'Cases not prosecuted');
        	data_table.addColumn('number', 'Proportion of cases investigated');
        	<?php 
        	$proportion = 0;
        	if($total_cases>0){
        	   $proportion = round( ($cases_investigated/$total_cases)*100,2);
        	}
        	?>
        	data_table.addRows([[{v: 'Total', p: {'style': 'font-weight: bold;'}},<?php echo $total_cases;?>,<?php echo $cases_investigated ;?>,<?php echo $cases_notinvestigated ;?>,<?php echo $proportion ;?>] ]);
	        
	          var table = new google.visualization.Table(document.getElementById('table_div'));      
	         table.draw(data_table, {allowHtml: true, showRowNumber: false, width: '700px', height: '100%'});
	         <?php if($user->user_group === '1' || $user->user_group === '2'){?> //only for admin and super admin
	              $("#table1_csv").html(dataTableToCSV(data_table)); 
	              $("#table_div_csv").html("<a href='#' onclick='csv_report(\"" + $("#table1_csv").html() + "\");' style='font-style: italic; text-decoration-color: gray;'><font color='gray'style='font-family: \"Open Sans\", Tahoma, Arial sans-serif; font-size;7px'>CSV report</font></a>");
	         <?php }?>

			//draw chart
			chart_data = [
			              ['Name', 'Proportion'],
			              ['Cases prosecuted',<?php echo $cases_investigated  ;?>],
			              ['Cases not prosecuted',<?php echo $cases_notinvestigated  ;?>]
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

	

		//just simple graph
		function drawDateAggregateGraphOldREmove(){

			$("#progress_bar").html("");
	        $("#report_title").html("<h2 class='page-title-section-gray'><?php echo $sector_type_name;?> sector report</h2>");
	        $("#pdf_report").html("<a href='#' onclick='pdf_report();' style='font-style: italic; text-decoration-color: gray;'><font color='gray'style='font-family: \"Open Sans\", Tahoma, Arial sans-serif;'>PDF report</font></a>");
	        $("#png_chart").html("<a href='#' onclick='javascript:grChartImg.ShowImage(\"chart_div\", true);' style='font-style: italic; text-decoration-color: gray;'><font color='gray'style='font-family: \"Open Sans\", Tahoma, Arial sans-serif;'>Print chart</font></a>");
	        $("#chart_title").html("<h2 id='chart_title_1' class='page-title-section'><?php echo $report_name . "</h2><h2 id='chart_title_2' class='page-title-section'>(" . $county_name . ") " . $date_title . "</h2>";?>");

			//draw table
	       	 var data_table = new google.visualization.DataTable();
	       	 
	       	 <?php if($report_id === '2'){?>
	        	data_table.addColumn('string', 'Date');
	        	data_table.addColumn('number', 'Aggregates');
	        	data_table.addRows([
	        	<?php foreach ( $data as $urows ) {
	        	    $date = explode("-", $urows ['date']);
	        	    echo "[{v: '" . $date[1] . "/" . $date[2] . "/" . $date[0] . "'},  {v:" . $urows ['aggregate'] . "}],";
	        	}?>
	         ]);
	        <?php }else if($report_id === '1'){?>
        	data_table.addColumn('string', 'Date');
        	data_table.addColumn('string', 'Sex');
        	data_table.addColumn('string', 'Rank');
        	data_table.addColumn('number', 'Aggregates');
        	data_table.addRows([
        	<?php foreach ( $data as $urows ) {
        	    $date = explode("-", $urows ['date']);
        	    echo "[{v: '" . $date[1] . "/" . $date[2] . "/" . $date[0] . "'},  {v:'" . $urows ['sex'] . "'}, {v:'" . $urows ['rank'] . "'},{v:" . $urows ['aggregate'] . "}],";
        	}?>
         ]);
        <?php }?>
	        
	          var table = new google.visualization.Table(document.getElementById('table_div'));      
	         table.draw(data_table, {allowHtml: true, showRowNumber: false, width: '500px', height: '100%'});
	         <?php if($user->user_group === '1' || $user->user_group === '2'){?> //only for admin and super admin
	              $("#table1_csv").html(dataTableToCSV(data_table)); 
	              $("#table_div_csv").html("<a href='#' onclick='csv_report(\"" + $("#table1_csv").html() + "\");' style='font-style: italic; text-decoration-color: gray;'><font color='gray'style='font-family: \"Open Sans\", Tahoma, Arial sans-serif; font-size;7px'>CSV report</font></a>");
	         <?php }?>

			//draw chart
			var chart_data = [];
			 <?php if($report_id === '1' || $report_id === '2'){?>
			chart_data.push(['Date', 'Aggregates']);
			chart_data.push(
			<?php
			$count = 0;
			foreach ( $data as $urows ) {
			    $date = explode("-", $urows ['date']);
                if($count !== 0){
                    echo ",";
                }
			   echo "['" . $date[1] . "/" . $date[2] . "/" . $date[0] . "'," . $urows ['aggregate'] . "]";
			    $count++;
			}
			?>
			);
			<?php }?>
            data_chart = google.visualization.arrayToDataTable(chart_data);
            var options = {
            		"title": "<?php echo $report_name . ' \nbetween period ' . $date_title; ?>",
            		"legend":"none",
            		"width":1000,
            		"height":500,
            	 hAxis: {slantedText:true, slantedTextAngle:90,showTextEvery:1 }, //lebel vertical view and show all
           		  vAxis: {minValue:0, maxValue: 5, format: '0'},
             		bar: {groupWidth: 20},
             		chartArea : { left: 40, top: 40, right:20, bottom: 90, height: '60%'} // do not cut off labels
            };
  			chart = new google.visualization.LineChart(document.getElementById('chart_div'));
  			google.visualization.events.addListener(chart, 'ready', function () {
    			  var content = '<img src="' + chart.getImageURI() + '">';
    			  $('#image1').append(content);
    			}); 
  			chart.draw(data_chart, options);   
		}

      </script>

<div id="main-content">

    <div id='table1_csv' style='display: none'></div>
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