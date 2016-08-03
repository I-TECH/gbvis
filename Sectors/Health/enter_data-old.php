<?php
//TA:60:4
$page_title = "Enter Data | GBV";
$current_page = "home";

require_once 'includes/global.inc.php';

if (isset ( $_SESSION ['logged_in'] )) {
	
	$user = unserialize ( $_SESSION ['user'] );
	
	$mode = $_GET['mode'];
	$county_id = $_GET['county_id'];
	$indicator_id = $_GET['indicator_id'];
	$date = $_GET['date'];
	$date_arr = explode("/", $date);
	$date_new = $date_arr[1] ."-" .  $date_arr[0] . "-" . $date_arr[2] ;
	$male_0_11_amount=$_GET['male_0_11_amount'];
	$male_12_17_amount=$_GET['male_12_17_amount'];
	$male_18_49_amount=$_GET['male_18_49_amount'];
	$male_50_amount=$_GET['male_50_amount'];
	$female_0_11_amount=$_GET['female_0_11_amount'];
	$female_12_17_amount=$_GET['female_12_17_amount'];
	$female_18_49_amount=$_GET['female_18_49_amount'];
	$female_50_amount=$_GET['female_50_amount'];
	
	$county = $db->selectAllOrderedWhere("counties", "county_name", " county_id=" . $county_id)[0][1];
	$indicator = $db->selectAllOrderedWhere("indicators", "indicator", " indicator_id=" . $indicator_id)[0][3];
	
	$db = new DB();
	$message = "";
	
	if($mode === 'add_aggregates'){
	   $data['county_id'] = $county_id;
	   $data['indicator_id'] = $indicator_id;
	   $data['date'] = "'" . $date_new . "'";
	   $data['created_by'] = $user->id;
	   $data['timestamp_created'] = "'" . date("Y-m-d H:i:s") . "'";
	   
	   if($male_0_11_amount > 0){
	       $data['gender'] = "'Male'";
	       $data['age_range'] = "'0-11'";
	       $data['aggregate'] = $male_0_11_amount;
	       if($db->insertData($data, "health_aggregates")){
	           $message .= "Male age range 0-11: " . $male_0_11_amount . " aggregate(s) is inserted.\n";
	       }else{
	           $message .= "Male age range 0-11: " . $male_0_11_amount . " aggregate(s) is NOT inserted.\n";
	       }
	   }
	   if($male_12_17_amount > 0){
	       $data['gender'] = "'Male'";
	       $data['age_range'] = "'12-17'";
	       $data['aggregate'] = $male_12_17_amount;
	       if($db->insertData($data, "health_aggregates")){
	           $message .= "Male age range 12-17: " . $male_12_17_amount . " aggregate(s) is inserted.\n";
	       }else{
	           $message .= "Male age range 12-17: " . $male_12_17_amount . " aggregate(s) is NOT inserted.\n";
	       }
	   }
	   if($male_18_49_amount > 0){
	       $data['gender'] = "'Male'";
	       $data['age_range'] = "'18-49'";
	       $data['aggregate'] = $male_18_49_amount;
	       if($db->insertData($data, "health_aggregates")){
	           $message .= "Male age range 18-49: " . $male_18_49_amount . " aggregate(s) is inserted.\n";
	       }else{
	           $message .= "Male age range 18-49: " . $male_18_49_amount . " aggregate(s) is NOT inserted.\n";
	       }
	   }
	   if($male_50_amount > 0){
	       $data['gender'] = "'Male'";
	       $data['age_range'] = "'50+'";
	       $data['aggregate'] = $male_50_amount;
	       if($db->insertData($data, "health_aggregates")){
	           $message .= "Male age range 50+: " . $male_50_amount . " aggregate(s) is inserted.\n";
	       }else{
	           $message .= "Male age range 50+: " . $male_50_amount . " aggregate(s) is NOT inserted.\n";
	       }
	   }
	   if($female_0_11_amount > 0){
	       $data['gender'] = "'Female'";
	       $data['age_range'] = "'0-11'";
	       $data['aggregate'] = $female_0_11_amount;
	       if($db->insertData($data, "health_aggregates")){
	           $message .= "Female age range 0-11: " . $female_0_11_amount . " aggregate(s) is inserted.\n";
	       }else{
	           $message .= "Female age range 0-11: " . $female_0_11_amount . " aggregate(s) is NOT inserted.\n";
	       }
	   }
	   if($female_12_17_amount > 0){
	       $data['gender'] = "'Female'";
	       $data['age_range'] = "'12-17'";
	       $data['aggregate'] = $female_12_17_amount;
	       if($db->insertData($data, "health_aggregates")){
	           $message .= "Female age range 12-17: " . $female_12_17_amount . " aggregate(s) is inserted.\n";
	       }else{
	           $message .= "Female age range 12-17: " . $female_12_17_amount . " aggregate(s) is NOT inserted.\n";
	       }
	   }
	   if($female_18_49_amount > 0){
	       $data['gender'] = "'Female'";
	       $data['age_range'] = "'18-49'";
	       $data['aggregate'] = $female_18_49_amount;
	       if($db->insertData($data, "health_aggregates")){
	           $message .= "Female age range 18-49: " . $female_18_49_amount . " aggregate(s) is inserted.\n";
	       }else{
	           $message .= "Female age range 18-49: " . $female_18_49_amount . " aggregate(s) is NOT inserted.\n";
	       }
	   }
	   if($female_50_amount > 0){
	       $data['gender'] = "'Female'";
	       $data['age_range'] = "'50+'";
	       $data['aggregate'] = $female_50_amount;
	       if($db->insertData($data, "health_aggregates")){
	           $message .= "Female age range 50+: " . $female_50_amount . " aggregate(s) is inserted.\n";
	       }else{
	           $message .= "Female age range 50+: " . $female_50_amount . " aggregate(s) is NOT inserted.\n";
	       }
	   }

	}else{
	    print "ERROR: No mode is selected.";
	}
	if($message){
	    print "\nReport: " . $indicator . "\nCounty: " . $county . "\nDate: " . $date . "\n\n" . $message;
	}
 
	}else{
	//Redirect user back to login page if there is no valid session created
	header("Location: ../../login.php");
}
?>