<?php

class DB {
 
    protected $db_name = 'gbvis';
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
 
    //takes a mysql row set and returns an associative array, where the keys
    //in the array are the column names in the row set. If singleRow is set to
    //true, then it will return a single row instead of an array of rows.
    public function processRowSet($rowSet, $singleRow = false)
    {
        $resultArray = array();
        while($row = mysql_fetch_assoc($rowSet))
        {
            array_push($resultArray, $row);
        }
 
        if($singleRow == true){
            return $resultArray[0];
            
            
          }
        return $resultArray;
    }
     public function processRowSet1($rowSet, $singleRow = false)
    {
        $resultArray = array();
        while($row = mysql_fetch_assoc($rowSet))
        {
            array_push($resultArray, $row);
        }
 
        if($singleRow == true){
            //return $resultArray[0];
            return $resultArray;
            
          }
        return $resultArray;
    }
    
    public function processRowSetData($rowSet, $singleRow = false)
         {
         $resultArray = array();
         while($row = mysql_fetch_assoc($rowSet))
         {
            array_push($resultArray, $row);
         }
 
        if($singleRow == true){
            return  $resultArray;
          }
        return $resultArray;
    }
    //Select rows from the database.
    //returns a full row or rows from $table using $where as the where clause.
    //return value is an associative array with column names as keys.
    public function select($table, $where) {
    
        $sql = "SELECT * FROM $table WHERE $where";
        $result = mysql_query($sql);
        if(mysql_num_rows($result) == 1)
            return $this->processRowSet($result, true);
 
        return $this->processRowSet($result);
    }
    
       public function selectData($table, $where) {
       
        $sql = "SELECT * FROM $table WHERE $where";
        $result = mysql_query($sql);
        if(mysql_num_rows($result) == 1)
            return $this->processRowSetData($result, true);
 
        return $this->processRowSetData($result);
    }
       public function selectViewtbl($table) {
        $sql = "SELECT * from $table";
        $result = mysql_query($sql);
        if(mysql_num_rows($result) == 1)
            return $this->processRowSetAsRow($result, true);
 
        return $this->processRowSetAsRow($result);
    }
    
    
    
   public function selectAll() {
	   
        $sql = "SELECT * FROM viewprosecutionsummary";
        $result = mysql_query($sql);
        if(mysql_num_rows($result) == 1)
            return $this->processRowSet1($result, true);
 
        return $this->processRowSet1($result);
    }
    
 
    //Updates a current row in the database.
    //takes an array of data, where the keys in the array are the column names
    //and the values are the data that will be inserted into those columns.
    //$table is the name of the table and $where is the sql where clause.
    public function update($data, $table, $where) {
        foreach ($data as $column => $value) {
            $sql = "UPDATE $table SET $column = $value WHERE $where";
            mysql_query($sql) or die(mysql_error());
        }
        return true;
    }
 
    //Inserts a new row into the database.
    //takes an array of data, where the keys in the array are the column names
    //and the values are the data that will be inserted into those columns.
    //$table is the name of the table.
    public function insert($data, $table) {
 
        $columns = "";
        $values = "";
 
        foreach ($data as $column => $value) {
            $columns .= ($columns == "") ? "" : ", ";
            $columns .= $column;
            $values .= ($values == "") ? "" : ", ";
            $values .= $value;
        }
 
        $sql = "insert IGNORE into $table ($columns) values ($values)";
 
        mysql_query($sql) or die(mysql_error());
 
        //return the ID of the user in the database.
        return mysql_insert_id();
 
    }
      public function insertData($data, $table) {
 
        $columns = "";
        $values = "";
 
        foreach ($data as $column => $value) {
            $columns .= ($columns == "") ? "" : ", ";
            $columns .= $column;
            $values .= ($values == "") ? "" : ", ";
            $values .= $value;
        }
 
        $sql = "insert IGNORE  into $table ($columns) values ($values)";
 
        mysql_query($sql) or die(mysql_error());
 
        //return the ID of the user in the database.
        return true;
 
    }
     public function resultQueryCount($table,$where)

      {
        $sql = "SELECT * FROM $table WHERE $where";

        $result = mysql_query($sql);

      if(mysql_num_rows($result) == 1)

            return $this->processRowSetCount($result, true);

      
        return $this->processRowSetCount($result);

 
        
    }
 
 // Return result set count 
 
 public function processRowSetCount($rowSet,$singleRow=false)

     {
        $this->rowcount=0;
  
        if($singleRow === true){
   
        $this->rowcount=1;
           return $this->rowcount;
          }
  
        while($row = mysql_fetch_assoc($rowSet))
        {
            
        $this->rowcount++;
        }
 
       
         return $this->rowcount;
      }
 
    	 
    public function selectR()
	   {
        $sql = "select a.county_id,c.county_name AS county,i.indicator AS indicator,a.aggregate as percentage,i.indicator_id,i.sector_id from indicators i inner join judiciary_aggregates a On i.indicator_id=a.indicator_id inner join counties c on c.county_id=a.county_id";
        $result = mysql_query($sql);
        if(mysql_num_rows($result) == 1)
            return $this->processRowSetR($result, true);
 
        return $this->processRowSetR($result);
   		 
   	 }
	public function processRowSetR($rowSet,$singleRow = false)
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
       
 //---------------------   Reports Functions sets----------------------------------------------------------------//
 
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
        $res = mysql_query('SELECT indicator,county_name,countyPercentage FROM viewtriedcases');
        if(mysql_num_rows($res) == 1)
        return $this->processRowSet2($res, true);
 
        return $this->processRowSet2($res);
   		 }
	
	
	  public function selectView() {
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
