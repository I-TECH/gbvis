<?php $db_username = 'root'; // Your MYSQL Username.
//$db_password = '1234'; // Your MYSQL Password.
$db_password = '1234'; // //TA:60:DB_PASSWORD
$db_name = 'gbvis'; // Your Database name.
$db_host = 'localhost';
  
$conDB = mysqli_connect($db_host, $db_username, $db_password,$db_name)or die('Error: Could not connect to database.');
?>