<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./front-end/css/style.css">
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
        $_products=new Product();
    ?>
    <div class="container container--biggest">
        <header id="header">
            <?php include "./front-end/src/include/navbar.php" ?>
        </header>
        <main id="main">
            <?php
                if(isset($_GET["search"])){
                    $key = $_GET["search"];
                    $products = $_products->searchProductsByName($key);
                    $resultNumber = count($products);
                    if($resultNumber>0){
                        echo "<h1 class='search-result'>Kết quả cho từ khóa <span>$key</span>, tìm thấy <span>$resultNumber</span> kết quả</h1>";
                        include "./front-end/src/include/products.php";
                    }else{
                        echo "<h1 class='search-result'>Không có kết quả nào cho từ khóa <span>$key</span></h1>";
                    }
                }
            ?>
        </main>
        <?php 
            include "./front-end/src/include/footer.php";
        ?>
    </div>
    <script src="./front-end/js/cartEvents.js"></script>
    <script src="./front-end/js/search.js"></script>
</body>
</html>