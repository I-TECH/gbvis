<?php
  $page_title = "Data Export | GBV";
    $current_page = "Data Export";
	
//Include the database connection file
include "includes/database_connection.php"; 
 // require the PHPExcel file 
require 'Upload_excel/Classes/PHPExcel.php'; 

// simple query 

$query = "SELECT indicator_name, country,county,sub_county,sector,tally,date FROM indicators ORDER by id DESC"; 
$headings = array('Indicator','Country','County','Sub county','Sector','Aggregates','Date'); 

if ($result = mysql_query($query) or die(mysql_error())) { 
    // Create a new PHPExcel object 
    $objPHPExcel = new PHPExcel(); 
    $objPHPExcel->getActiveSheet()->setTitle('Judiciary Indicators List '); 

    $rowNumber = 1; 
    $col = 'A'; 
    foreach($headings as $heading) { 
       $objPHPExcel->getActiveSheet()->setCellValue($col.$rowNumber,$heading); 
       $col++; 
    } 

    // Loop through the result set 
    $rowNumber = 2; 
    while ($row = mysql_fetch_row($result)) { 
       $col = 'A'; 
       foreach($row as $cell) { 
          $objPHPExcel->getActiveSheet()->setCellValue($col.$rowNumber,$cell); 
          $col++; 
       } 
       $rowNumber++; 
    } 

    // Freeze pane so that the heading line won't scroll 
    $objPHPExcel->getActiveSheet()->freezePane('A2'); 

    // Save as an Excel BIFF (xls) file 
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 

   header('Content-Type: application/vnd.ms-excel'); 
   header('Content-Disposition: attachment;filename="SectorsList.xls"'); 
   header('Cache-Control: max-age=0'); 

   $objWriter->save('php://output'); 
   exit(); 
} 
echo 'a problem has occurred... no data retrieved from the database'; 

?>