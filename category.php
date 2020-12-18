<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechNow</title>
    <link rel="stylesheet" href="./front-end/css/style.css">
    <link rel="stylesheet" href="./front-end/slick/slick-theme.css">
    <link rel="stylesheet" href="./front-end/slick/slick.css">
    <script src="./front-end/js/functions.js"></script>
    <script src="./front-end/js/jquery-3.5.0.min.js"></script>
    <script src="https://kit.fontawesome.com/d210984464.js" crossorigin="anonymous"></script>
</head>

<body>
    <?php
        ob_start();
        if(!isset($_SESSION)){session_start();}
        require "./back-end/Product_class.php";
        require "./back-end/Category_class.php";
        require "./back-end/Producer_class.php";
    ?>
    <div class="container container--biggest">
        <header id="header">
            <?php include "./front-end/src/include/navbar.php" ?>
        </header>
        <main id="main">
            <section class="section" id="banner">
                <div class="banner__carousel">
                    <?php include "./front-end/src/include/bannerCarousel.php" ?>
                </div>
                <div class="banner__news">
                    <?php include "./front-end/src/include/news.php"?>
                </div>
            </section>
            <?php 
                if(isset($_GET["catid"])){
                    $catid = $_GET["catid"];
                    $producerid = isset($_GET["producerid"])?$_GET["producerid"]:"";
                    $_product = new Product();
                    if($producerid!=="" && $catid!=="else"){
                        $products = $_product->getProductsByCategoryIdAndProducerId($catid, $producerid);
                    }else if($catid==="else"){
                        $products=$_product->getAllHeadphoneAndPortableCharger();
                    }else{
                        $products = $_product->getProductsByCategoryId($catid);
                    }
                    if(count($products)===0){
                        echo "<h1 class='empty'>Không có sản phẩm nào cả</h1>";
                    }
            ?>

            <?php include "./front-end/src/include/producerNavbar.php"; ?>
            <div class="category">
                <?php include "./front-end/src/include/products.php";?>
            </div>
            <?php
                }else exit("<h1>Trang Không tồn tại!</h1>");
            ?>
        </main>
        <?php 
            include "./front-end/src/include/footer.php";
        ?>
    </div>
    <script src="./front-end/js/slickSetting.js"></script>
    <script src="./front-end/slick/slick.min.js"></script>
    <script src="./front-end/js/cartEvents.js"></script>
    <script src="./front-end/js/navbar.js"></script>
<script src="./front-end/js/search.js"></script>
</body>

</html>