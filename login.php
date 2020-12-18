<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechNow | Đăng nhập</title>
    <link rel="stylesheet" href="front-end/css/signinform.css">
    <script src="front-end/js/jquery-3.5.0.min.js"></script>
    <script src="https://kit.fontawesome.com/d210984464.js" crossorigin="anonymous"></script>
</head>

<body>
    <?php
 ob_start();
 if(!isset($_SESSION)){session_start();}
 require_once "back-end/DbServices.php";
 require "back-end/Customer_class.php";
 $_customer= new Customer();
 $services = new DbServices();
     if(!isset($_SESSION)){
         session_start();
     }
 
     $name=$email=$password=$repassword=$address=$phone="";
     $errorExists=false;
     $uid=0;
     $signuperror = [];
     $signinerror=[];
     if(isset($_POST["signin"])){
         $email = $_POST["email"];
         $password = $_POST["password"];
         
         if(!$services->checkEmail($email)){
             $signinerror["email"]="Email không hợp lệ!";
             $errorExists=true;
         }

         if(strlen($password)===0 || strlen($password)<8){
             $signinerror["password"]="Mật khẩu phái có tối thiểu 8 ký tự!";
             $errorExists=true;
         }

         if(!$errorExists){
             $success = $_customer->signIn($email,$password);
             if($success==1||$success=='1'){
                 header("Location: index.php");
             }
             else{
                 $signinerror["signin"]="Mật khẩu hoặc email không đúng!";
             }
         }
     }

     if(isset($_POST["signup"])){
         $name=$_POST["name"];
         $email = $_POST["email"];
         $password = $_POST["password"];
         $repassword = $_POST["repassword"];
         $phone = $_POST["phone"];
         $address = $_POST["address"];

         if(!$services->checkRegularString($name)){
             $signuperror["name"]="Tên phải có ít nhất 5 ký tự và không được chứa ký tự đặc biệt và số!";
             $errorExists=true;
         }

         if(!$services->checkEmail($email)){
             $signuperror["email"]="Email không hợp lệ!";
             $errorExists=true;
         }else{
             if($_customer->isEmailExist($email)){
                 $signuperror["email"]="Email đã được đăng ký!";
                 $errorExists=true;
             }
         }

         if(strlen($password)===0 || strlen($password)<8){
             $signuperror["password"]="Mật khẩu phái có tối thiểu 8 ký tự!";
             $errorExists=true;
         }

         if($repassword!==$password){
             $signuperror["repassword"]="Mật khẩu không trùng khớp!";
             $errorExists=true;
         }

         if(!$services->checkAddress($address)){
             $signuperror["address"]="Địa chỉ không được để trống và không được chứa ký tự đặc biệt!";
             $errorExists=true;
         }

         if(!$services->checkPhone($phone)){
             $signuperror["phone"]="Số điện thoại không hợp lệ!";
             $errorExists=true;
         }

         if(!$errorExists){
             $uid=$_customer->signUp($name, $email,$address,$phone,$password);
             if(!$uid){
                  $signuperror["signup"]="Đăng ký thất bại, hãy thử lại!";
             }
         }
     }
    ?>
</body>

</html>