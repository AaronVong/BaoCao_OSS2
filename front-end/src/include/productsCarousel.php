<div class="products-carousel">
    <?php 
        foreach ($products as $product) {
    ?>
    <div class="products-carousel__items">   
        <a class="links links--product" href="detail.php?pid=<?php echo $product["product_id"];?>">
            <img class="product__images" src="<?php echo "./front-end/images/products/".$product["producer_name"]."/".$product["category_name"]."s/".$product["product_thumb"]; ;?>">          
            <span class="product__installment">trả góp <strong>0%</strong></span>
            <span class="product__name"><?php echo $product["product_name"]; ?></span>
            <?php
            $sale=$product["product_sale"]; 
                if($sale>0){
            ?>
                <div>
                <span class="product__price--old"><?php echo "<script>document.write(stringToMoney(".$product["product_originprice"]."));</script>";?></span>
                <span class="product__sale">-<?php echo (float)$sale*100;?>%</span>
                </div>
            <?php 
                }
            ?>
            <span class="product__price">
                <?php echo "<script>document.write(stringToMoney(".$product["product_originprice"]*(1-$sale)."));</script>"; ?>
            </span>
        </a>
    </div>

    <?php
        }
    ?>
</div>
