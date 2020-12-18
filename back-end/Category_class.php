<?php 
    require_once "./back-end/DbServices.php";
    class Category extends DbServices{
        function getAllCategories(){
            $query = "SELECT * FROM tn_category";
            return $this->executeQuery($query);
        }

        function getCategoryByName($name){
            $query = "SELECT * FROM tn_category WHERE category_name=:name";
            $result = $this->executeQuery($query,[":name"=>$name]);
            return $result;
        }
    }
?>