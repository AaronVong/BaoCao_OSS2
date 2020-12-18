<?php 
    require_once "./back-end/DbVariables.php";

    class DbServices{
        private $pdo=null;
        function __construct(){
            if($this->pdo==null){
               try{
                    $this->pdo = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME,DB_USER, DB_PASSWORD, PDOATTRS);
               }catch(PDOException $exception){
                    die($exception->getMessage());
               } 
            }
        }

        function encodeString($str){
            return md5($str);
        }
        function lastIndexInserted(){
            return $this->pdo->lastInsertId();
        }
        function executeQuery($query, $params=[], $fetchMode=PDO::FETCH_ASSOC){
            // for SELECT, COUNT,... the staments fetch data from DB
            if($this->pdo===null){
                die("Oops! Không kết nối được với Cơ Sở Dữ Liệu");
            }
            $stament = $this->pdo->prepare($query);
            if($stament->execute($params)){
                return $stament->fetchAll($fetchMode);
            }else{
                print_r($stament->errorInfo());
                die();
            }
            // return Associative Array on SUCCESS or null if FAIL
        }

        function executeChangeDataQuery($query, $params=[], $fetchMode=PDO::FETCH_ASSOC){
            // for INSERT, UPDATE,... the staments that making change to the DB
            if($this->pdo===null){
                die("Oops! Không kết nối được với Cơ Sở Dữ Liệu");
            }
            $stament = $this->pdo->prepare($query);
            if($stament->execute($params)){
                return $stament->rowCount();
            }
            print_r($stament->errorInfo());
            die();
            // 0 for FAIL and POSITIVE number for SUCCESS

        }
        
        function rollBackNow(){
            return $this->pdo->rollBack();
        }

        function commitNow(){
            return $this->pdo->commit();
        }

        function beginTransactionNow(){
            return $this->pdo->beginTransaction();
        }
        function prepareQuery($query){
            // using when the params in the query is a number or the executeQuery() way can't be done
            return $this->pdo->prepare($query);
            // return the stament;
        }

        function isValidNumber($str=""){
            if(!is_numeric($str)){
                return false;
            }

            $reg = "/^[0-9]+\.?[0-9]*?$/";
            if(preg_match($reg,$str)){
                return true;
            }else return false;
        }

        function checkPhone($str){
            if(!is_numeric($str)){
                return false;
            }

            $reg = "/^[0-9]{10,12}$/";
            if(preg_match($reg,$str)){
                return true;
            }
            return false;
        }

        function checkRegularString($str){
            $reg = "/^[a-z\p{L}A-Z\p{L}\s]{5,}$/u";
            if(preg_match($reg,$str)){
                return true;
            }
            return false;
        }

        function checkEmail($str){
            $reg = "/^[a-zA-Z\.?0-9]+(@[a-zA-Z]{2,})(\.[a-zA-Z]+)+$/";
            if(preg_match($reg,$str)){
                return true;
            }return false;
        }

        function checkDate($str){
            if($str=="")return false;
            $time = strtotime($str);
            $input = date('yy-m-d',$time);
            $today = date('yy-m-d');
            
            if($input < $today){
                return false;
            }else{
                return true;
            }
        }

        function checkAddress($str){
            $reg="/^[a-zA-Z0-9\p{L}\s\/,\.]{5,}$/u";
            return preg_match($reg,$str)?true:false;
        }

        function isImageExist($url){
            return file_exists($url)?true:false;
        }

        function isLargerThen5Mb($imageSize){
            return $imageSize > 500000?true:false;
        }

        function checkImageFormat($imageType){
            if($imageType != "jpg" && $imageType != "png" && $imageType != "jpeg" && $imageType != "gif" ) {
                return false;
            }return true;
        }

        function isImageFile($tempUrl){
            $check = getimagesize($tempUrl);
            if($check !== false) {
                return true;
            }return false;
        }

        function translate($str){
            switch ($str) {
                case 'new':
                    return "Mới";
                break;
                case "delivered":
                    return "Đã giao cho khách";
                break;
                case "aborted":
                    return "Đơn hàng bị hủy";
                break;
                case "shipping":
                    return "Trên đường giao hàng";
                break;
                case "available":
                    return "Còn hàng";
                break;
                case "not available":
                    return "Hết hàng";
                break;
                case "pedding":
                    return "Đang chở";
                break;
                case "approval":
                    return "Đã duyệt";
                break;
                default:
                    return $str;
                    break;
            }
        }
    }
?>