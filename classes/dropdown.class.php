<?php

require_once('DB.class.php');


class dropdown
 {
 
    
	
 
    //open a connection to the database. Make sure this is called
    //on every page that needs to use the database.
	
    public function __construct()
	{
	
	  $this->db = new DB();
	  //$this->db->connect();
      
    }
 
   	//takes a mysql row set and outputs a populated drop down list
	
    public function processUserGroupsSelect($rowSet,$singleRow = false)
    {
       
		 	echo '<select name="user_group"  required class="gbvis_select" />';
    		echo '<option value="">Select User Group</option>';
    		while($getgroup = mysql_fetch_assoc($rowSet))
    		{
       		 echo '<option value="'.$getgroup ['id'].'">'.$getgroup ['group_name'].'</option>';
    		}
    		echo '</select>';
	
 
       if($singleRow === true){
            return true;
         }
        return true;
    }
	
	
	//takes a mysql row set and outputs a populated drop down list
	
    public function processAgeRangesSelect($rowSet,$singleRow = false)
    {
       
		 	echo '<select name="age_range"  required class="gbvis_select" />';
    		echo '<option value="">Select Age Range</option>';
    		while($getage = mysql_fetch_assoc($rowSet))
    		{
       		 echo '<option value="'.$getage ['age_range_id'].'">'.$getage ['age_range'].'</option>';
    		}
    		echo '</select>';
	
 
       if($singleRow === true){
            return true;
         }
        return true;
    }
     public function processSectorsSelect($rowSet,$singleRow = false)
    {
       
		 	echo '<select name="sector"  required class="gbvis_select" />';
    		echo '<option value="">Select Sector</option>';
    		while($getsector = mysql_fetch_assoc($rowSet))
    		{
       		 echo '<option value="'.$getsector ['sector_id'].'">'.$getsector ['sector'].'</option>';
    		}
    		echo '</select>';
	
 
       if($singleRow === true){
            return true;
         }
        return true;
    }
	
	
	//takes a mysql row set and outputs a populated drop down list
	
    public function processIndicatorsSelect($rowSet,$singleRow = false)
    {
       
		 	echo '<select name="indicator" class="gbvis_select" required />';
    		echo '<option value="">Select Indicator</option>';
    		while($getindicator = mysql_fetch_assoc($rowSet))
    		{
       		 echo '<option value="'.$getindicator ['indicator_id'].'">'.$getindicator ['indicator'].'</option>';
    		}
    		echo '</select>';
	
 
       if($singleRow === true)
	   {
            return true;
         }
        return true;
    }
	
	//takes a mysql row set and outputs a populated drop down list
	
    public function processCountiesSelect($rowSet,$singleRow = false)
    {
       
		 	echo '<select name="county" class="gbvis_select" required />';
    		echo '<option value="">Select County</option>';
    		while($getcounty = mysql_fetch_assoc($rowSet))
    		{
       		 echo '<option value="'.$getcounty ['county_id'].'">'.$getcounty ['county_name'].'</option>';
    		}
    		echo '</select>';
	
 
       if($singleRow === true)
	   {
            return true;
         }
        return true;
    }
    public function processSurveySelect($rowSet,$singleRow = false)
    {
       
		 	echo '<select name="survey" class="gbvis_select" required />';
    		echo '<option value="">Select Survey Period</option>';
    		while($getsurvey = mysql_fetch_assoc($rowSet))
    		{
       		 echo '<option value="'.$getsurvey ['survey_id'].'">'.$getsurvey ['survey'].'</option>';
    		}
    		echo '</select>';
	
 
       if($singleRow === true)
	   {
            return true;
         }
        return true;
    }
 
    //Select rows from the database.
    //returns a full row or rows from $table using $where as the where clause.
    //return value is an associative array with column names as keys.
	
   
    
	
	  public function dropdown($table)
	   {
        $sql = "SELECT * FROM $table";
        $result = mysql_query($sql);
		
		
		 
		 switch ($table)
		 {
		 case "user_groups":
		if(mysql_num_rows($result) == 1)
		{
                return $this->processUserGroupsSelect($result, true);
                 }
		else
		{
                return $this->processUserGroupsSelect($result);
   		 }
   		 break;
		case "age_range":
		if(mysql_num_rows($result) == 1)
		{
                return $this->processAgeRangesSelect($result, true);
                 }
		else
		{
                return $this->processAgeRangesSelect($result);
   		 }
		break;
		case "sectors":
		if(mysql_num_rows($result) == 1)
		{
                return $this->processSectorsSelect($result, true);
                 }
		else
		{
                return $this->processSectorsSelect($result);
   		 }
		break;
		case "surveys":
		if(mysql_num_rows($result) == 1)
		{
                 return $this->processSurveySelect($result, true);
                 }
		else
		{
                return $this->processSurveySelect($result);
   		 }
		break;
		
		case "indicators":
		if(mysql_num_rows($result) == 1)
		{
            return $this->processIndicatorsSelect($result, true);
		}
		else
		{
 
        return $this->processIndicatorsSelect($result);
		}
   		 
		break;
		
		case "counties":
		if(mysql_num_rows($result) == 1)
		{
            return $this->processCountiesSelect($result, true);
		}
		else
		{
 
              return $this->processCountiesSelect($result);
		
   		 }
		break;
		}
		
		
}
		 
		 
   
 
}
 
?>
