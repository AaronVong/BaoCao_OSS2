
<?php 
        if(isset($_POST["ustatus"])){
            $oid = $_POST["oid"];
            $status = $_POST["ustatus"];
            $status_id = $_status->getStatusIdByName($status);
            $updated_rows = $_order->updateOrderStatusById($oid,$status_id);
        }

        if(isset($_POST["search-order"])){
            $keyword = $_POST["order-keyword"];
            $orders=$_order->searchOrderByNameAndPhone($keyword);
        }
?>
<h1 class="function-title">Quản lý đơn hàng</h1>
<div class="order">
    <form action="admin.php?fnc=qldh" method="post">
        <div class="control-panel">
            <div class="search-panel">
                <input type="text" value="" placeholder="Tìm hoặc SĐT..." class="input input--text" name="order-keyword">
                <input type="submit" value="Tìm kiếm" name="search-order" class="input">
            </div>
        </div>
    </form>
    <span class="notify__text">
        <?php 
            if(isset($updated_rows)){
                echo "Cập nhật thành công $updated_rows đơn hàng";
            }
        ?>
    </span>
    <table class="data-table">
        <thead>
            <tr>
                <th>Mã đơn hàng</th>
                <th>Tên khách hàng</th>
                <th>Số điện thoại</th>
                <th>Ngày đặt</th>
                <th>Ngày giao</th>
                <th>Địa chỉ Giao</th>
                <th>Trị giá</th>
                <th>Trạng thái</th>
                <th>Chi tiết</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
        <?php
            if(count($orders)==0){
                echo "<tr><td colspan='10'><span class='notify__text'>Không có kết quả phù hợp</span></td></tr>";
            }
            foreach ($orders as $order) {
        ?>
            <tr>
                <td class="single-word"><?php echo $order["order_id"]; ?></td>
                <td><?php echo $order["customer_name"];?></td>
                <td><?php echo $order["customer_phone"]; ?></td>
                <td><?php echo $order["order_created"];?></td>
                <td><?php echo $order["order_deadline"];?></td>
                <td><?php echo $order["order_address"];?></td>
                <td><?php echo "<script>document.write(stringToMoney(".$order["order_worth"]."))</script>"; ?></td>
                <td class="single-word"><?php echo $order["status_name"];?></td>
                <td><a href="admin.php?fnc=qldh&oid=<?php echo $order["order_id"]?>" id="showdetail" class="link">Xem chi tiết</a></td>
                <td id="order-panel">
                <?php 
                    switch ($order["status_name"]) {
                        case 'new':
                            echo "<button class='' type='button' value='approval' oid=".$order["order_id"].">Duyệt</button>
                            <button class='' type='button' value='aborted' oid=".$order["order_id"].">Hủy</button>";
                            break;
                        case 'approval':
                            echo "<button class='' type='button' value='shipping' oid=".$order["order_id"].">Giao hàng</button>
                            <button class='' type='button' value='aborted' oid=".$order["order_id"].">Hủy</button>";
                        break;
                        case 'shipping':
                            echo "<button class='' type='button' value='delivered' oid=".$order["order_id"].">Đã giao cho khách</button>";
                        break;
                        default:
                            echo "No action available";
                            break;
                    }
                ?>
                </td>
            </tr>
        <?php
            }
        ?>
        </tbody>
    </table>
</div>

<div class="detail">
    <table class="data-table">
        <thead>
            <tr>
                <th>Mã đơn hàng</th>
                <th>Tên sản phẩm</th>
                <th>Giá gốc</th>
                <th>Giảm giá</th>
                <th>Số lượng</th>
                <th>Giá bán</th>
            </tr>
        </thead>
        <tbody  >
            <?php
            $amount=0;
            $money=0;
                if(isset($_GET["oid"])){
                    $oid = $_GET["oid"];
                    $detail = $_order->getDetailById($oid);
                    foreach($detail as $info){
            ?>
                <tr>
                    <td class="single-word"><?php echo $oid;?></td>
                    <td><?php echo $info["product_name"];?></td>
                    <td><?php echo "<script>document.write(stringToMoney(".$info["order_detail_originprice"]."))</script>"; ?></td>
                    <td><?php echo "<script>document.write(stringToMoney(".$info["order_detail_saleprice"]."))</script>" ?></td>
                    <td class="single-word"><?php echo $info["order_detail_number"]; $amount+=$info["order_detail_number"];?></td>
                    <td><?php echo "<script>document.write(stringToMoney(".$info["order_detail_worth"]."))</script>"; $money+=$info["order_detail_worth"] ?></td>
                </tr>
            <?php
                    }
                    ?>
                    <tr>
                        <td colspan='4'>
                        </td>
                        <td class="single-word">
                            Tổng số lượng:
                            <?php
                                echo $amount;
                            ?>
                        </td>
                        <td>
                            Tổng tiền:
                            <?php
                                echo "<script>document.write(stringToMoney(".$money."))</script>";
                            ?>
                        </td>
                    </tr>
                    <?php
                }
            ?>
        </tbody>
    </table>
</div>

