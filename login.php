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
     <div class="container <?php echo count($signuperror)>0?'right-panel-active':''?>" id="container">
        <div class="form-container sign-up-container">
            <form action="login.php" method="POST">
                <h1>Create Account</h1>
                <div class="social-container">
                    <a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social"><i class="fab fa-google-plus-g"></i></a>
                    <a href="#" class="social"><i class="fab fa-linkedin-in"></i></a>
                </div>
                <span>or use your email for registration</span>
                <input type="text" placeholder="Name" name="name" value="<?php echo $name; ?>"/>
                <span class="text--error"><?php echo isset($signuperror["name"])?$signuperror["name"]:""; ?></span>

                <input type="text" placeholder="Email" name="email" value="<?php echo $email; ?>"/>
                <span class="text--error"><?php echo isset($signuperror["email"])?$signuperror["email"]:""; ?></span>

                <input type="text" placeholder="Phone Number" name="phone" value="<?php echo $phone; ?>"/>
                <span class="text--error"><?php echo isset($signuperror["phone"])?$signuperror["phone"]:""; ?></span>

                <input type="password" placeholder="Password" name="password">
                <span class="text--error"><?php echo isset($signuperror["password"])?$signuperror["password"]:""; ?></span>

                <input type="password" placeholder="Verify Your Password" name="repassword" />
                <span class="text--error"><?php echo isset($signuperror["repassword"])?$signuperror["repassword"]:""; ?></span>

                <input type="text" placeholder="Address" name="address" value="<?php echo $address; ?>"/>
                <span class="text--error"><?php echo isset($signuperror["address"])?$signuperror["address"]:""; ?></span>
                <button type="submit" name="signup">Sign Up</button>
                <span class="text--error"><?php echo isset($signuperror["signup"])?$signuperror["signup"]:""; ?></span>
            </form>
        </div>
        <div class="form-container sign-in-container">
            <form action="login.php" method="POST">
                <h1>Sign in</h1>
                <div class="social-container">
                    <a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social"><i class="fab fa-google-plus-g"></i></a>
                    <a href="#" class="social"><i class="fab fa-linkedin-in"></i></a>
                </div>
                <span>or use your account</span>
                <input type="text" placeholder="Email" name="email" value="<?php echo $email; ?>"/>
                <span class="text--error"><?php echo isset($signinerror["email"])?$signinerror["email"]:""; ?></span>
                <input type="password" placeholder="Password" name="password" />
                <span class="text--error"><?php echo isset($signinerror["password"])?$signinerror["password"]:""; ?></span>
                <a href="#">Forgot your password?</a>
                <button type="submit" name="signin">Sign In</button>
                <span class="text--error"><?php echo isset($signinerror["signin"])?$signinerror["signin"]:"";?></span>
                <span class="text--notify"><?php echo $uid!==0?"Đăng ký thành công! Hãy đăng nhập bằng tài khoản của bạn.":"";?></span>
            </form>
        </div>
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1>Welcome Back!</h1>
                    <p>To keep connected with us please login with your personal info</p>
                    <button class="ghost" id="signIn">Sign In</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1>Hello!</h1>
                    <p>Enter your personal details and start shopping with us</p>
                    <button class="ghost" id="signUp">Sign Up</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        const signUpButton = document.getElementById('signUp');
        const signInButton = document.getElementById('signIn');
        const container = document.getElementById('container');
        signUpButton.addEventListener('click', () => {
            container.classList.add("right-panel-active");
        });

        signInButton.addEventListener('click', () => {
            container.classList.remove("right-panel-active");
        });
        
    </script>
</body>

</html>