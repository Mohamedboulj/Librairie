<?php 
function checkField(string $fieldName,string $fieldValue, int $nbreChar = -1){
    $value = trim($fieldValue);
    if(strlen($value) > $nbreChar){
       return $value;
    }else{
        throw new Exception( "$fieldName field is required", 406);
    }
}
?>
