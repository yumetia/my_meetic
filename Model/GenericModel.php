<?php 
require_once "bdd.php";

class GenericModel {
    
    public function __construct(){
        $database = new MyDatabase();
        $this->database = $database->connect();
    }

    public function showTables(){
        $request = "SHOW TABLES";
        $stmt = $this->database->prepare($request);
        $stmt->execute();
        return array_column($stmt->fetchAll(PDO::FETCH_ASSOC), "Tables_in_my_meetic");
    }

    public function showColumns($table){
        $request = "SELECT column_name FROM information_schema.columns WHERE TABLE_NAME = :table AND TABLE_SCHEMA = 'my_meetic'";
        $stmt = $this->database->prepare($request);
        $stmt->bindParam(':table', $table, PDO::PARAM_STR);
        $stmt->execute();
        return array_column($stmt->fetchAll(PDO::FETCH_ASSOC), "column_name");
    }

    public function getRow($table, $column, $value,$all="*"){
        $request = "SELECT $all FROM $table WHERE $column = :value";
        $stmt = $this->database->prepare($request);
        $stmt->bindParam(':value', $value, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function getRowLike($table, $column, $value,$all="*"){
        $request = "SELECT $all FROM $table WHERE $column like :value";
        $stmt = $this->database->prepare($request);
        $stmt->bindParam(':value', $value, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function getRowParticular($table, $column,$value, $all="*"){
        $request = "SELECT $all FROM $table WHERE $column = $value ";
        $stmt = $this->database->prepare($request);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function updateColumn($table,$column,$value,$id,$idValue){
        $request = "UPDATE $table set $column = :value where $id = :idValue";
        $stmt = $this->database->prepare($request);
        $stmt->bindParam(':value', $value);
        $stmt->bindParam(':idValue', $idValue, PDO::PARAM_INT);
        $stmt->execute();
    }


}