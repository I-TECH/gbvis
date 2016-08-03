<?php

class Report
 {
 
   // protected $db_name = 'reports';
    protected $db_name = 'test';
    protected $db_user = 'root';
    protected $db_pass = '1234';
    protected $db_host = 'localhost';
	
 
    //open a connection to the database. Make sure this is called
    //on every page that needs to use the database.
	
    public function connect() {
        $connection = mysql_connect($this->db_host, $this->db_user, $this->db_pass,false,65536);
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
			//$output.=$dataRow['indicator']."  ".$dataRow['county']."\t".$dataRow['countyTotal']."\n";	
        }
 
       if($singleRow === true){
            return $output;
         }
        return $output;
      }
	
	
	//takes a mysql row set and outputs a CSV set.
	
    public function processRowSet2($rowSet,$singleRow = false)
      {
       
		$output="";
		
        while($dataRow = mysql_fetch_row($rowSet))
        {
            //array_push($resultArray, $row);
			//Original pie chart
			//$output.=$dataRow['indicator']." ".$dataRow['county']."\t".$dataRow['percentage']."\n";
			
			//piechart that points to test/test2 database
			$output.=$dataRow[0]."  ".$dataRow[1]."\t".$dataRow[2]."%\n";	
        }
 
       if($singleRow === true){
            return $output;
         }
        return $output;
      }
	
   public function processRowSet3($rowSet,$singleRow = false)
        {
       
		$output="";
		
        while($dataRow = mysql_fetch_row($rowSet))
        {
            //array_push($resultArray, $row);
			//Original pie chart
			//$output.=$dataRow['indicator']." ".$dataRow['county']."\t".$dataRow['percentage']."\n";
			
			//piechart that points to test/test2 database
				
			$output.=$dataRow[1];
			return $output;
			//echo 1;
        }
 
       //if($singleRow === true)
	   //{
           // return $output;
         //}
        //return $output;
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
		 
		 
      public function nationalPoliceAggregates()
	   {
         $res = mysql_query('CALL nationalPoliceAggregates()');
        $result = mysql_query($sql);
        if(mysql_num_rows($result) == 1)
            return $this->processRowSet3($result, true);
 
        return $this->processRowSet3($result);
   		 }
		 
       public function countyPoliceAggregates()
	    {
        $res = mysql_query('CALL countyPoliceAggregates()');
        if(mysql_num_rows($res) == 1)
        return $this->processRowSet2($res, true);
 
        return $this->processRowSet2($res);
   		 }
		 
      public function countyProsecutionAggregates()
	      {
        $res = mysql_query('CALL countyProsecutionAggregates4()');
        if(mysql_num_rows($res) == 1)
        return $this->processRowSet2($res, true);
 
        return $this->processRowSet2($res);
   		 }
		 
		 public function countyJudiciaryAggregates()
	    {
        $res = mysql_query('SELECT indicator,county_name,countyPercentage FROM viewjudiciaryaggregates');
        if(mysql_num_rows($res) == 1)
        return $this->processRowSet2($res, true);
 
        return $this->processRowSet2($res);
   		 }
	
	
      public function selectView() 
        {
        $sql = "SELECT county_name,countyAggregate,nationalAggregate,countyPercentage FROM viewconvictedcases";
        $result = mysql_query($sql);
        if(mysql_num_rows($result) == 1)
            return $this->processRowSetAsRow($result, true);
 
        return $this->processRowSetAsRow($result);
         }
	
	//takes a mysql row set and returns an associative array, where the keys
    //in the array are the column names in the row set. If singleRow is set to
    //true, then it will return a single row instead of an array of rows.
	
     public function processRowSetAsRow($rowSet,$singleRow = false)
        {
        $resultArray = array();
        while($row = mysql_fetch_row($rowSet))
        {
            array_push($resultArray, $row);
        }
 
        if($singleRow === true){
            return $resultArray;
          }
        return $resultArray;
        }
	

}
 
?>