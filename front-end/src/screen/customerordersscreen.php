<div class="ordered">
<?php 
foreach($customer_orders as $order){
?>
        <div class="ordered__info">
        <ul class="info__owner">
            <li class="info">
                <label class="label">Mã đơn hàng:</label><span class="info__text"><?php echo $order["order_id"]?></span>
            </li>
            <li class="info">
                <label class="label">Họ tên:</label><span class="info__text"><?php echo $order["customer_name"];?></span>
            </li>
            <li class="info">
                <label class="label">Số điện thoại:</label><span class="info__text"><?php echo $order["customer_phone"]?></span>
            </li>
            <li class="info">
                <label class="label">Địa chỉ nhận hàng:</label><span class="info__text"><?php echo $order["order_address"]=="store"?"Tại của hàng TechNow":$order["order_address"];?></span>
            </li>
            <li class="info">
                <label class="label">Trị giá:</label><span class="info__text"><?php echo "<script>document.write(stringToMoney(".$order["order_worth"]."))</script>";?></span>
            </li>
            <li class="info">
                <label class="label">Trạng thái đơn hàng:</label> <span class="info__text"><?php echo $order["status_name"];?> </span>
            </li>
            <li>
                <?php 
                    if($order["status_name"]=="delivered"){
                        echo "<label class='label'>Bạn đã nhận hàng? xác nhận ngay bây giờ</label><button type='button'
                        value='confirmed' class=\"btn user-action\" oid=".$order["order_id"].">Xác nhận</button>";
                    }
                    if($order["status_name"]=="new"||$order["status_name"]=="approval"){
                        echo "<label class='label'>Hủy đơn hàng:</label><button type='button' class=\"btn user-action\"
                        value='aborted' oid=".$order["order_id"].">Hủy đơn hàng</button>";
                    }
                ?>
            </li>
        </ul>
        <div class="ordered_detail">
            <?php 
                $order_detail = $_order->getDetailById($order["order_id"]);
                foreach($order_detail as $detail){
            ?>
                <ul class="info__detail">
                    <li class="info">
                        <label class="label">Tên sản phẩm:</label><span class="info__text"><?php echo $detail["product_name"];?></span>
                    </li>
                    <li class="info">
                        <label class="label">Giá gốc:</label><span class="info__text"><?php echo "<script>document.write(stringToMoney(".$detail["order_detail_originprice"]."))</script>";?></span>
                    </li>
                    <li class="info">
                        <label class="label">Được giảm:</label><span class="info__text">-<?php echo "<script>document.write(stringToMoney(".$detail["order_detail_saleprice"]."))</script>";?></span>
                    </li>
                    <li class="info">
                        <label class="label">Số lượng:</label><span class="info__text"><?php echo $detail["order_detail_number"];?></span>
                    </li>
                    <li class="info">
                        <label class="label">Giá thanh toán:</label><span class="info__text"><?php echo "<script>document.write(stringToMoney(".$detail["order_detail_worth"]."))</script>";?></span>
                    </li>
                </ul>
            <?php
                }
            ?>
        </div>
    </div>
<?php
}
?>
</div>
