<?php 
    require_once "./back-end/DbServices.php";

    class Customer extends DbServices{
     
        function getCIdByEmail($email){
            $query = "SELECT customer_id FROM tn_customer WHERE customer_email = :email";
            $customer = $this->executeQuery($query,[":email"=>$email]);
            return count($customer) > 0 ? $customer[0]["customer_id"]:0;
        }

        function getColumnByEmail($column, $email){
            $query ="SELECT customer_$column FROM tn_customer WHERE customer_email=:email";
            $customer = $this->executeQuery($query,[":email"=>$email]);
            return count($customer) > 0 ? $customer[0]["customer_".$column]:0;
        }

        function getColumnById($column, $id){
            $query ="SELECT customer_".$column." FROM tn_customer WHERE customer_id=:id";
            $customer = $this->executeQuery($query,[":id"=>$id]);
            return count($customer) > 0 ? $customer[0]["customer_".$column]:0;
        }

        function getAllCustomers(){
            $rs = $this->executeQuery("SELECT * FROM tn_customer");
            return $rs;
        }

        function searchCustomersByKey($key){
            $rs = $this->executeQuery("SELECT * FROM tn_customer WHERE customer_name LIKE :key OR customer_phone LIKE :key",[":key"=>'%'.$key.'%']);
            return $rs;
        }
        function signUp($name, $email, $address, $phone,$password){
            $uid=0;
            $query = "INSERT INTO tn_customer(customer_name,customer_email,customer_address,customer_phone,customer_password) VALUES(:name,:email,:address,:phone,:password)";

            $rows = $this->executeChangeDataQuery($query, [":name"=>$name,":phone"=>$phone,":address"=>$address,":email"=>$email,":password"=>md5($password)]);
            if($rows>0){
                $uid = $this->lastIndexInserted();
            }

           return $uid;
        }
    }
?>