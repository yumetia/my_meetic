<?php 


class InsertRow extends GenericModel
{
    public function filterShowTables($assocArray){
        // filtering the assocArray given

        $tables = $this->showColumns($assocArray["table"]);
        $filteredArray = [];

        if (is_array($assocArray)){
            foreach($assocArray as $k=>$v){
                if (in_array($k,$tables)){
                    $filteredArray[$k]=$v;
                }
            }
            
            return array_unique($filteredArray);
            
        }
        return false;
        
    }


    public function formatSQL($filteredArray){
        $filteredArray = $this->filterShowTables($filteredArray);
    
        if (!$filteredArray) {
            return false;
        }
    
        $columns = [];
        $values = [];
    
        foreach ($filteredArray as $column => $value) {
            $columns[] = $column; 
            
            if (is_null($value)) {
                $values[] = "NULL";
            } 

            elseif (is_string($value)) {
                $values[] = "'".addslashes($value)."'"; 
            } 
            // number
            else {
                $values[] = $value;
            }
        }
    
        $into = "(".implode(", ", $columns).")";
        $values = "(".implode(", ", $values).")";
    
        return [$into, $values];
    }
    



    public function addRow($formatRequest){
        $table = $formatRequest["table"];
        $formatRequest = $this->formatSQL($formatRequest);
        
        if ($formatRequest){
            list($columns, $values) = $formatRequest;
    
            $request = "INSERT INTO $table $columns VALUES $values;";
    
            try {
                $stmt = $this->database->prepare($request);
                $stmt->execute();
                echo "Success";
            } catch(Exception $e){
                echo "Message : ".$e->getMessage();
            }
        }
    }
    

}