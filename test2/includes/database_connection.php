<?php
/*********************************************************************
* This script has been released with the aim that it will be useful.
* Written by Vasplus Programming Blog
* Website: www.vasplus.info
* Email: info@vasplus.info
* All Copy Rights Reserved by Vasplus Programming Blog
***********************************************************************/


//Database Connection Settings
//define ('localhost','localhost'); //Your server name or host name goes in here
//define ('root',''); // Your database username goes in here
//define ('',''); // Your database password goes in here
//define ('access',''); // Your database name goes in here

//global $connection;
//$connection = @mysql_connect(localhost,root) or die('Connection could not be made to the SQL Server. Please report this system error at <font color="blue">info@servername.com</font>');
//@mysql_select_db(access,$connection) or die('Connection could not be made to the database. Please report this system error at <font color="blue">info@servername.com</font>');	

$hostname = 'localhost';      
$dbname   = 'oop';
$username = 'root';          
$password = '1234';               
// error_reporting(E_ALL);
// ini_set('display_errors', '1');
	

      
// Let's connect to host
mysql_connect($hostname, $username, $password) or DIE('Connection to host is failed, perhaps the service is down!');
// Select the database
mysql_select_db($dbname) or DIE(mysql_error().'Database name is not available!');
?>
