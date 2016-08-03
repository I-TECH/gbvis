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
    
    $aaa = '[{"value": 438,"code": "CO"},{"value": 387.35,"code": "NY"}]';
    
    print $aaa; return;
    
    $data = array();
    
    if($fromdate === $todate){
       $date_title =  $fromdate;
    }else{
        $date_title = $fromdate . " to " . $todate;
    }
    
    //print $sector_type_id ."," . $county_id  ."," . $report_id ."," . $time_period ."," . $fromdate ."," . $todate;
    
    $db = new DB();
    $sector_type_name = $db->select("sectors", " sector_id=$sector_type_id")['sector'];
    //$indicator_name = ucfirst($db->select("indicators", " indicator_id=$indicator_id")['indicator']);
    if($county_id === 'all'){
        $county_name = "National";
    }else{
        $county_name = ucfirst($db->select("counties", " county_id=$county_id")['county_name']);
    }
    
    if($sector_type_id == 1){
        // date format in database 0000-00-00
        $fromdate_arr = explode("/", $fromdate);
        $fromdate_new = $fromdate_arr[1] ."-" .  $fromdate_arr[0] . "-01";
        $todate_arr = explode("/", $todate);
        $todate_new = $todate_arr[1] ."-" .  $todate_arr[0] . "-31";
        
        if($report_id === '1'){
            $sql = "select sex, cadres.cadre, date, sum(aggregate) as aggregate from judiciary_aggregates join cadres on judiciary_aggregates.cadre=cadres.id where indicator_id in (28) group by date order by date";
            if($county_id != "all"){
                $sql = "select sex, cadres.cadre, date, sum(aggregate) as aggregate from judiciary_aggregates join cadres on judiciary_aggregates.cadre=cadres.id where indicator_id in (28) and county_id=" . $county_id . " group by date order by date";
                        }
            $result = mysql_query($sql);
            $data=$db->processRowSet($result);
        }else if($report_id === '4'){
            $sql = "select date, sum(aggregate) as aggregate from judiciary_aggregates where indicator_id in (10) group by date order by date";
            if($county_id != "all"){
                $sql = "select date, sum(aggregate) as aggregate from judiciary_aggregates where indicator_id in (10) and county_id=" . $county_id . " group by date order by date";
                        }
            $result = mysql_query($sql);
            $data=$db->processRowSet($result);
        }else if($report_id === '2'){ //8/7 
            $sql = "select date, sum(aggregate) as aggregate from judiciary_aggregates where indicator_id in (8) group by date order by date";
            if($county_id != "all"){
                $sql = "select date, sum(aggregate) as aggregate from judiciary_aggregates where indicator_id in (8)  and county_id=" . $county_id . " group by date order by date";
            }
            $result = mysql_query($sql);
            $data_all_N=$db->processRowSet($result);
            
            $sql = "select date, sum(aggregate) as aggregate from judiciary_aggregates where indicator_id in (7) group by date order by date";
            if($county_id != "all"){
                $sql = "select date, sum(aggregate) as aggregate from judiciary_aggregates where indicator_id in (7)  and county_id=" . $county_id . " group by date order by date";
            }
            $result = mysql_query($sql);
            $data_all_D=$db->processRowSet($result);
            
            foreach ( $data_all_N as $urows4 ) {
                foreach ( $data_all_D as $urows3 ){
                     if($urows4 ['date'] === $urows3['date']){
                           $urows4 ['aggregate'] = round($urows4 ['aggregate']/$urows3 ['aggregate']);
                                unset($urows3);
                                array_push($data, $urows4);
                           }
                     }
                }
        }else if($report_id === '3'){ //8/7 
            $sql = "select date, sum(aggregate) as aggregate from judiciary_aggregates where indicator_id in (9) group by date order by date";
            if($county_id != "all"){
                $sql = "select date, sum(aggregate) as aggregate from judiciary_aggregates where indicator_id in (9)  and county_id=" . $county_id . " group by date order by date";
            }
            $result = mysql_query($sql);
            $data_all_N=$db->processRowSet($result);
            
            $sql = "select date, sum(aggregate) as aggregate from judiciary_aggregates where indicator_id in (7) group by date order by date";
            if($county_id != "all"){
                $sql = "select date, sum(aggregate) as aggregate from judiciary_aggregates where indicator_id in (7)  and county_id=" . $county_id . " group by date order by date";
            }
            $result = mysql_query($sql);
            $data_all_D=$db->processRowSet($result);
            
            foreach ( $data_all_N as $urows4 ) {
                foreach ( $data_all_D as $urows3 ){
                     if($urows4 ['date'] === $urows3['date']){
                           $urows4 ['aggregate'] = round($urows4 ['aggregate']/$urows3 ['aggregate']);
                                unset($urows3);
                                array_push($data, $urows4);
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

function pdf_report(){  

	var doc = new jsPDF('p', 'pt', 'a4', false);
	
	doc.setFontType("bold");
	doc.setFontSize(14);
	doc.text(200, 30, 'Judiciary sector report');
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

	doc.save("JudiciarySecotorReport.pdf");
}

function csv_report(text) {
	var blob = new Blob([text], {type: "text/plain;charset=utf-8"});
	saveAs(blob, "JudiciarySecotorReport.csv");
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
    return csv_out;
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
			 if($report_id === '1' || $report_id === '2' || $report_id === '3' || $report_id === '4'){ 
			     echo "drawDateAggregateGraph();"; 
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

		//just simple graph
		function drawDateAggregateGraph(){

			$("#progress_bar").html("");
	        $("#report_title").html("<h2 class='page-title-section-gray'><?php echo $sector_type_name;?> sector report</h2>");
	        $("#pdf_report").html("<a href='#' onclick='pdf_report();' style='font-style: italic; text-decoration-color: gray;'><font color='gray'style='font-family: \"Open Sans\", Tahoma, Arial sans-serif;'>PDF report</font></a>");
	        $("#png_chart").html("<a href='#' onclick='javascript:grChartImg.ShowImage(\"chart_div\", true);' style='font-style: italic; text-decoration-color: gray;'><font color='gray'style='font-family: \"Open Sans\", Tahoma, Arial sans-serif;'>Print chart</font></a>");
	        $("#chart_title").html("<h2 id='chart_title_1' class='page-title-section'><?php echo $report_name . "</h2><h2 id='chart_title_2' class='page-title-section'>(" . $county_name . ") " . $date_title . "</h2>";?>");

			//draw table
	       	 var data_table = new google.visualization.DataTable();
	       	 
	       	 <?php if($report_id === '2' || $report_id === '3' || $report_id === '4'){?>
	        	data_table.addColumn('string', 'Date');
	        	data_table.addColumn('number', 'Number');
	        	data_table.addRows([
	        	<?php foreach ( $data as $urows ) {
	        	    $date = explode("-", $urows ['date']);
	        	    echo "[{v: '" . $date[1] . "/" . $date[2] . "/" . $date[0] . "'},  {v:" . $urows ['aggregate'] . "}],";
	        	}?>
	         ]);
	        <?php }else if($report_id === '1'){?>
        	data_table.addColumn('string', 'Date');
        	data_table.addColumn('string', 'Sex');
        	data_table.addColumn('string', 'Cadre');
        	data_table.addColumn('number', 'Number');
        	data_table.addRows([
        	<?php foreach ( $data as $urows ) {
        	    $date = explode("-", $urows ['date']);
        	    echo "[{v: '" . $date[1] . "/" . $date[2] . "/" . $date[0] . "'},  {v:'" . $urows ['sex'] . "'}, {v:'" . $urows ['cadre'] . "'},{v:" . $urows ['aggregate'] . "}],";
        	}?>
         ]);
        <?php }?>
	        
	          var table = new google.visualization.Table(document.getElementById('table_div'));      
	         table.draw(data_table, {allowHtml: true, showRowNumber: false, width: '100%', height: '100%'});
	         <?php if($user->user_group === '1' || $user->user_group === '2' || $user->user_group === '2' ){?> //only for admin and super admin
	              $("#table1_csv").html(dataTableToCSV(data_table)); 
	              $("#table_div_csv").html("<a href='#' onclick='csv_report(\"" + $("#table1_csv").html() + "\");' style='font-style: italic; text-decoration-color: gray;'><font color='gray'style='font-family: \"Open Sans\", Tahoma, Arial sans-serif; font-size;7px'>CSV report</font></a>");
	         <?php }?>

			//draw chart
			var chart_data = [];
			 <?php if($report_id === '1' || $report_id === '2' || $report_id === '3' || $report_id === '4'){?>
			chart_data.push(['Date', 'Number']);
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
          		  vAxis: {minValue:0, maxValue: 5, format: '0'}
            };
  			chart = new google.visualization.LineChart(document.getElementById('chart_div'));
  			google.visualization.events.addListener(chart, 'ready', function () {
    			  var content = '<img src="' + chart.getImageURI() + '">';
    			  $('#image1').append(content);
    			}); 
  			chart.draw(data_chart, options);   
		}

      </script>

<div id="main-content_with_side_bar">

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

		<table border=0>
			<tr>
				<td colspan=2 align='center'><div id='chart_title'></div></td>
			</tr>
			<tr>
				<td valign='top'><div id="table_div"></div><div id='table_div_csv' align='right' style='margin-top:-8px;'></div></td>
				<td valign='top'><div id="chart_div"
						style="width: 650px; height: 500px;"></div><div id='png_chart' align='right' style='margin-top:-9px;'></div></td>
			</tr>
			<tr>
				<td colspan=2 align='center'><div id='detailed_title'></div></td>
			</tr>
			<tr>
				<td colspan=2><div id='detailed_report_table'></div><div id='detailed_table_div_csv' align='right' style='margin-top:-8px;'></div></td>
			</tr>
			<tr>
				<td colspan=2><br><div id='detailed_report_chart'
						style="width: 100%; height: 500px;"></div><div id='png_chart_detailed' align='right' style='margin-top:-9px;'></div></td>
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