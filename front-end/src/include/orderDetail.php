<?php 
    foreach($cartArr as $key=>$item){
    ?>
    <div class="order-detail">
        <button class="btn btn--rmorder" type="button" name="remove-item" value="<?php echo $key; ?>">X</button>
        <h5><?php echo $item["name"]; ?></h5>
        <div class="order">
            <div class="order__thumb">
                <img src="<?php echo "./front-end/images/products/".$item["producer"]."/".$item["category"]."s/".$item["thumbnail"]; ?>">
            </div>
            <div class="order__info">
                <label class="label">
                    Số lượng:
                    <buton type="button"class="btn increment">+</buton>
                        <input type="text" value="<?php echo $item["number"];?>" class="order-number input" forpid="<?php echo $key;?>"readonly>
                    <button class="decrement btn" type="button">-</button>
                </label>
                <span style="display:block;color:red;"><?php echo $item["number"]==4?"Đạt số lượng tối đa cho phép":""; ?></span>
                <span class="order__price"><?php echo "<script>document.write(stringToMoney(".$item["price"]."));</script>"; ?></span>
                <?php 
                   if($item["sale"]>0){
                        $saleTotal+=(int)$item["price"]*(float)$item["sale"]*(int)$item["number"];
                        echo "<span class='order__sale'>Giảm ".((float)$item["sale"]*100)."% Cho mỗi sản phẩm</span>";
                    }
                    $priceTotal += (int)$item["price"]*(int)$item["number"];
                ?>
            </div>
        </div>
    </div>
<?php
    }
?>