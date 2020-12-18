<?php 
    require_once "./back-end/DbServices.php";
    class Admin extends DbServices{
        function signInAdmin($name,$pass){
            $query = "SELECT count(*) as 'match' FROM tn_admin WHERE admin_name=:name AND admin_password=:pass";
            $rows = $this->executeQuery($query, [":name"=>$name,":pass"=>$pass]);
            return count($rows)>0?$rows[0]['match']:0;
        }
    }
?>