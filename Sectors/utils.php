<?php 

//Utils methods to enter data

//date format mm/YYYY
function validateDate($date){
    $date = trim($date);
    $date_arr = explode("/", $date);
    return checkdate ( $date_arr[0] , "01" , $date_arr[1] );

}

function validateAggregate($aggregate){
    $aggregate = trim($aggregate);
    if($aggregate === '' || $aggregate === '0'){
        return true;
    }else if(ctype_digit($aggregate)){
        if($aggregate < 0){
            return false;
        }
        return true;
    }
    return false;
    
}

function isAggregateEmpty($aggregate){
    $aggregate = trim($aggregate);
    if($aggregate === ""){
        return true;
    }else if($aggregate === '0'){
        return true;
    }
    return false;
}

function validate_header($current_value, $value, $column, $row){
    $current_value = str_replace("+", "", $current_value);
    if($current_value !== $value){
        //return "ERROR: Wrong file format. Header (column " . $column . ", row " . $row . ") must be '" . $value . "'=" . $current_value .".\n";
        return "ERROR: Wrong file format. Header (column " . $column . ", row " . $row . ") must be '" . $value . "'.\n";
    }
    return "";
}

?>