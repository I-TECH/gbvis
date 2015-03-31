<?php

class RDB
 {
 
   // protected $db_name = 'reports';
	protected $db_name = 'test';
    protected $db_user = 'root';
    protected $db_pass = '1234';
    protected $db_host = 'localhost';
	
 
    //open a connection to the database. Make sure this is called
    //on every page that needs to use the database.
	
    public function connect() {
        $connection = mysql_connect($this->db_host, $this->db_user, $this->db_pass);
        mysql_select_db($this->db_name);
 
        return true;
    }
 
   
	
	//takes a mysql row set and outputs a CSV set.
	
    public function processRowSet($rowSet,$singleRow = false)
    {
       
		$output="";
		
        while($dataRow = mysql_fetch_assoc($rowSet))
        {
            //array_push($resultArray, $row);
			//Original pie chart
			//$output.=$dataRow['indicator']." ".$dataRow['county']."\t".$dataRow['percentage']."\n";
			
			//piechart that points to test/test2 database
			$output.=$dataRow['indicator']."  ".$dataRow['county']."\t".$dataRow['percentage']."%\n";	
        }
 
       if($singleRow === true){
            return $output;
         }
        return $output;
    }
 
    //Select rows from the database.
    //returns a full row or rows from $table using $where as the where clause.
    //return value is an associative array with column names as keys.
	
   
    
	
	  public function selectAll($table)
	   {
        $sql = "SELECT * FROM $table ";
        $result = mysql_query($sql);
        if(mysql_num_rows($result) == 1)
            return $this->processRowSet($result, true);
 
        return $this->processRowSet($result);
   		 }
		 
		 
		  public function selectR()
	   {
        $sql = "select a.county_id,c.county_name AS county,i.indicator AS indicator,a.aggregate as percentage,i.indicator_id,i.survey_id from indicators i inner join judiciary_aggregates a On i.indicator_id=a.indicator_id inner join counties c on c.county_id=a.county_id";
        $result = mysql_query($sql);
        if(mysql_num_rows($result) == 1)
            return $this->processRowSet($result, true);
 
        return $this->processRowSet($result);
   		 
   		 }
	
	
	
	
	
 
    
 
   
 
}
 
?>