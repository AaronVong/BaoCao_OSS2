<?php 
  $perpage = 12;
  $page = 1;
?>
<ul class="products">
    <?php
      foreach ($products as $product){
    ?>
      <li class="product">
        <a class="links links--product" href="detail.php?pid=<?php echo $product["product_id"]; ?>">
          <img class="product__images" src="<?php echo "./front-end/images/products/".$product["producer_name"]."/".$product["category_name"]."s/".$product["product_thumb"];  ?>" alt="product-image">
          <span class="product__installment">trả góp <strong>0%</strong></span>
          <span class="product__name"><?php echo $product["product_name"]; ?></span>
          <?php
          $sale=$product["product_sale"]; 
            if($sale>0){
          ?>
            <div>
              <span class="product__price--old"><?php echo "<script>document.write(stringToMoney(".$product["product_originprice"]."));</script>";?></span>
              <span class="product__sale"><?php echo ($product["product_sale"]*100*-1)."%";?></span>
            </div>
          <?php 
            }
          ?>
          <span class="product__price">
            <?php echo "<script>document.write(stringToMoney(".$product["product_originprice"]*(1-$sale)."));</script>"; ?>
          </span>
        </a>
          <div class="box3d">
            <button pid ="<?php echo $product["product_id"];?>"type="button" class="pay-btn links btn" name="buyNow">
                <i class="fas fa-cash-register"></i>
            </button>
            <button type="button" class="cart-btn links btn" name="addToCart" pid="<?php echo $product["product_id"];?>">
                <i class="cart__icon fas fa-shopping-cart"></i>
            </button>
          </div>
      </li>
    <?php
      }
    ?>
</ul>

