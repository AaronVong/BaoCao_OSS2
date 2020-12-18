<?php 
        $_product = new Product();
        $_category = new Category();
?>

<section class="section product-shefl">
<div class="homeproducts__highlight">
    <?php 
        $catid =  $_category->getCategoryByName("phone");
        $products= $_product->getHighlightProducts($catid[0]["category_id"]);
    ?>
    <div class="homeproducts__header">
    <h3 class="title title--products">điện thoại nổi bật</h3>
    <a href="category.php?catid=<?php echo $catid[0]["category_id"];?>" class="links links--showmore" name="phone">
        Xem tất cả
    </a>
    </div>
   <?php 
        include "./front-end/src/include/products.php"; 
   ?>
</div>
<div class="homeproducts__highlight">
    <?php 
        $products = $_product->getAllHeadphoneAndPortableCharger();
    ?>
    <div class="homeproducts__header">
    <h3 class="title title--products">phụ kiện nổi bật</h3>
    <a href="category.php?catid=else" class="links links--showmore" name="else">
        Xem tất cả
    </a>
    </div>
   <?php 
        include "./front-end/src/include/productsCarousel.php";
    ?>
</div>
<div class="homeproducts__highlight">
    <?php 
        $catid =  $_category->getCategoryByName("laptop");
        $products= $_product->getHighlightProducts($catid[0]["category_id"]);
    ?>
    <div class="homeproducts__header">
    <h3 class="title title--products">laptop nổi bật</h3>
    <a href="category.php?catid=<?php echo $catid[0]["category_id"];?>" class="links links--showmore" name="laptop">
        Xem tất cả
    </a>
    </div>
   <?php 
        include "./front-end/src/include/products.php"; 
   ?>
</div>
<div class="homeproducts__highlight">
    <?php 
        $catid =  $_category->getCategoryByName("tablet");
        $products= $_product->getHighlightProducts($catid[0]["category_id"]);
    ?>
    <div class="homeproducts__header">
    <h3 class="title title--products">tablet nổi bật</h3>
    <a href="category.php?catid=<?php echo $catid[0]["category_id"];?>" class="links links--showmore" name="tablet">
        Xem tất cả
    </a>
    </div>
   <?php 
   include "./front-end/src/include/products.php"; 
   ?>
</div>
</section>