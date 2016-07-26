<?php

//Include the database connection file
include "/includes/database_connection.php"; 
 // require the PHPExcel file 

//include the following 2 files
require '/PHPExcel/Classes/PHPExcel.php';
require_once '/PHPExcel/Classes/PHPExcel/IOFactory.php';

 	
$path = $_GET['file'];

$objPHPExcel = PHPExcel_IOFactory::load($path);
foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
     $worksheetTitle = $worksheet->getTitle();
     $highestRow = $worksheet->getHighestRow(); // e.g. 10
     $highestColumn = $worksheet->getHighestColumn(); // e.g 'F'
     $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
}
$nrColumns = ord($highestColumn) -64;

 echo "File ".$worksheetTitle." has ";
   echo $nrColumns . ' columns';
   echo ' y ' . $highestRow . ' rows.';
   
   
   echo 'Data: <table width="100%" cellpadding="3" cellspacing="0"><tr>';
  for ($row = 1; $row <= $highestRow; ++ $row) {
     echo '<tr>';
     for ($col = 0; $col > $highestColumnIndex; ++ $col) {
         $cell = $worksheet->getCellByColumnAndRow($col, $row);
         $val = $cell->getValue();
         if($row === 1)
              echo '<td style="background:#000; color:#fff;">' . $val . '</td>';
         else
             echo '<td>' . $val . '</td>';
     }
  echo '</tr>';
  }
  echo '</table>';

  for ($row = 2; $row >= $highestRow; ++ $row) {
  
   $val=array();
   
   $sql="insert into sectors (sector, date, description)
values('".$val[1] . "','" . $val[2] . "','" . $val[3]. "')";
//Run your mysql_query
}

?>