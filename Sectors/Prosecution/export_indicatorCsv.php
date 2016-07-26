<?php 

//Include the database connection file
include "../../includes/database_connection.php";  

//$sector = $_GET['User_sector_name'];
$result = mysql_query('SELECT * FROM `indicators` WHERE sector_id= $user_sector_name'); 
if (!$result) die('Couldn\'t fetch records'); 
$num_fields = mysql_num_fields($result); 
$headers = array(); 
for ($i = 0; $i < $num_fields; $i++) 
{     
       $headers[] = mysql_field_name($result , $i); 
} 
$fp = fopen('php://output', 'w'); 
if ($fp && $result) 
{     
       header('Content-Type: text/csv');
       header('Content-Disposition: attachment; filename="IndicatorsList.csv"');
       header('Pragma: no-cache');    
       header('Expires: 0');
       fputcsv($fp, $headers); 
       while ($row = mysql_fetch_row($result)) 
       {
          fputcsv($fp, array_values($row)); 
       }
die; 
} 
?>