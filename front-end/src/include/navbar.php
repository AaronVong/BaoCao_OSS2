<?php
  $_category = new Category();
  $cats = $_category->getAllCategories();
?>

<nav class="nav">
 <ul class="navbar navbar--ffloor" id="navbar-ffloor">
    <li class="brand">
      <a href="index.php" class="links--brand links">
        TechNow
      </a>
    </li>
    <li class="searchbar">
      <div class="input-group">
          <input class="input searchbar__input" placeholder="Bạn muốn tìm gì..." value="" name="searchKey" type="text">
      </div>
      <i class="search__icon fas fa-search"></i>
    </li>
    <li class="cart">
      <a href="order.php" class="links links--cart" href="#asd">
        <span>Giỏ hàng</span>
        <i class="cart__icon fas fa-shopping-cart"></i>
      </a>
    </li>
    <li>
    <?php 
      if(isset($_SESSION["user"])){
        include "./front-end/src/include/user.php";
      }else{
        echo "<a href='login.php' class='links links--login'><span>Đăng nhập</span></a>";
      }
    ?>
    </li>
    <button type="button" class="hamburger">
      <i class="fas fa-bars"></i>
    </button>
  </ul>

  <ul class="navbar navbar--sfloor" id="navbar--sfloor">
    <?php 
      foreach ($cats as $cat) {
    ?>
      <li class="items sfloor__items">
        <a href="<?php echo "category.php?catid=".$cat["category_id"] ?>" class="links links--items" name="<?php echo $cat["category_name"];?>">
        <?php 
          switch($cat["category_name"]){
            case "phone":
              echo "điện thoại";
            break;
            case "speaker":
              echo "loa";
            break;
            case "headphone":
              echo "tai nghe";
            break;
            case "charger":
              echo "sạc/cáp sạc";
            break;
            case "portable charger":
              echo "sạc dự phòng";
            break;
            default:
              echo $cat["category_name"];
            break;
          }
        ?>
        </a>
      </li>
  <?php
    }
  ?>
</ul>
</nav>
