<?php 
    require_once "./back-end/DbServices.php";
    class Status extends DbServices{
        function getAllStatuses(){
            $query = "SELECT * FROM tn_status";
            $rs=$this->executeQuery($query);

            return $rs;
        }

        function getStatusIdByName($name){
            $query = "SELECT status_id from tn_status WHERE status_name=:name";
            $rs = $this->executeQuery($query,[":name"=>$name]);
            return count($rs)>0?$rs[0]["status_id"]:null;
        }
    }
?>