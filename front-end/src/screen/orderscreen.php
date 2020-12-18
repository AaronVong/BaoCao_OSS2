<div class="cart-screen">
    <?php 
        include "./front-end/src/include/orderDetail.php";
    ?>
    <div class="payment">
        <div class="payment__row">
            <span>
                Tổng giá trị ban đầu:
            </span>
            <span class="price-preview">
                <?php echo "<script>document.write(stringToMoney(".$priceTotal."));</script>"; ?>
            </span>
        </div>
        <div class="payment__row">
            <span>VAT:</span>
            <span>
             10% cho đơn hàng: <?php 
                echo "<script>document.write(stringToMoney(".(((int)$priceTotal-(int)$saleTotal) * 0.1)."));</script>";
                ?>
            </span>
        </div>
        <div class="payment__row">
            <span>
                Giảm giá:
            </span>
            <span class="price-sale">
               - <?php echo "<script>document.write(stringToMoney(".$saleTotal."));</script>"; ?>
            </span>
        </div>
        <div class="payment__row">
            <span>
                Phải trả:
            </span>
            <span class="price-preview">
                <?php echo "<script>document.write(stringToMoney(".(((int)$priceTotal-(int)$saleTotal)*(1+0.1))."));</script>"; ?>
            </span>
        </div>
    </div>
    <?php 
        if(isset($err)){
            echo count($err)>0?"<span style='color:red;font-size:20px;padding:0.5em'>Đặt hàng thất bại</span><br>":"";
            foreach($err as $text){
                echo "<span style='color:red; font-size 18px;padding:0.5em'>$text</span><br>";
            }
        }
    ?>
    <div class="showform"><button class="btn btn--showform" type="button">Mua bây giờ</button></div>
    <form action="order.php" method="post" class="order__form">
        <h3>Thông tin khách hang</h3>
        <div class="input-group">
            <label class="label">Địa chỉ nhận:</label>
            <label class="label">
                <span>Tại của hàng</span>
                <input type="radio" name="location[]" value="store" checked>
            </label>
            <label class="label">
                <span>Khác</span>
                <input type="radio" name="location[]" id="otherlocation" value="other">
            </label>
            <label class="label">
                <span>Địa chỉ của tôi</span>
                <input type="radio" name="location[]" value="<?php echo isset($_SESSION["user"])?$_customer->getColumnByEmail("address",$_SESSION["user"]["email"]):"";?>">
            </label>
        </div>
        <div class="input-group" id="address" style="display:none">
            <label for="customer_address" class="label">Địa chỉ nhận:</label>
            <input type="text" name="customer_address" id="customer_address" value="">
        </div>
        <div class="input-group">
            <label for="order_deadline" class="label">Ngày nhận hàng:</label>
            <input type="date" id="order_deadline" name="order_deadline" value="">
        </div>
        <div class="input-group">
            <label for="payments" class="label">Hình thức thanh toán:</label>
            <label for="payment--cod" class="label">
                <span>COD:</span>
                <input type="radio" name="payments" id="payments" value="cod" checked>
            </label>
        </div>

        <div class="input-group">
            <?php
                if(isset($_SESSION["user"])){
            ?>
                <button type="submit" value="buying" name="buying" class="btn btn--buying">Đặt hàng</button>
            <?php
                }
                else echo "<a href='login.php' class='links'>Đăng nhập</a> Để có thể đặt hàng";
            ?>
        </div>
    </form>
</div>
