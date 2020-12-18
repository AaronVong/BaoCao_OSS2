<?php     
    $services = new DbServices();
    if(isset($_POST["add_product"]) || isset($_POST["confirm_edit_product"])){
        $error=[];
        $pname = $_POST["product_name"];
        if(strlen($pname)<10){
            $error["name"]="Cần ít nhất 10 ký tự";
        }
        $pthumb = $_FILES["product_thumb"];
        if($pthumb["name"]!==""){
            if($services->isLargerThen5Mb($pthumb["size"])){
                $error["image"]["error"][]="Dung lượng quá lớn, > 5MB";
            }

            if($services->checkImageFormat(strtolower(pathinfo($pthumb["name"],PATHINFO_EXTENSION)))!=true){
                $error["image"]["error"][]="Chỉ chấp nhận .png, .jpg, .jpeg, .gif";
            }

            if($services->isImageFile($pthumb["tmp_name"])!=true){
                $error["image"]["error"][]="File không phải là hình ảnh";
            }
        }

        $pprice = $_POST["product_originprice"];
        if($services->isValidNumber($pprice)==false){
            $error["price"]="Sai định dạng";
        }

        $psale = $_POST["product_sale"];
        if($services->isValidNumber($psale)==false||$psale==1||$psale==100){
            $error["sale"]="Phần trăm không hợp lệ";
        }else{
            if(1-$psale < 0){
                (float)$psale/=100;
                $psale.="";
            }
        }
        $pstock = $_POST["product_instock"];
        if($services->isValidNumber($pstock)==false){
            $error["instock"]="Sai định dạng";
        }
        $phighlight = isset($_POST["product_highlight"])?$_POST["product_highlight"]:'0';
        $producerid = $_POST["producer_id"];
        $categoryid = $_POST["category_id"];
        $statusid=$_POST["status_id"];


        if(isset($_POST["add_product"])){
            if(count($error)===0){
                $count = $_product->addNewProduct($pname, $pthumb,$pprice,$psale,$pstock,$phighlight,$producerid,$categoryid,$statusid);
            }
        }

        if(isset($_POST["confirm_edit_product"])){
            if(count($error)===0){
                $pid = $_POST["product_id"];
                $updateCount = $_product->updateProduct($pid,$pname, $pthumb,$pprice,$psale,$pstock,$phighlight,$producerid,$categoryid,$statusid);
                if($updateCount>0) header("admin.php?fnc=qlsp");
            }
        }
    }

    if(isset($_GET["delete"])){
        $id = $_GET["delete"];
        var_dump($id);
        if($_product->deleteProductById($id)>0){
            echo "<h1 class='notify__text'>xóa thành công</h1>";
            echo "<script>setTimeout(()=>{window.location.reload();},1000)</script>";
        }
    }

    if(isset($_POST["search_product"])){
        $key = $_POST["search_product_key"];
        $products = $_product->searchProductsByName($key);
        $resultNumber = count($products);
    }
?>

<h1 class="function-title">Quán Lý Sản Phẩm</h1>
<?php echo isset($_GET["editproduct"])?"<h1 class='notify__text'>Cập nhật sản phẩm có mã: ".$_GET["editproduct"]."</h1>":""?>
    <form action="admin.php?fnc=qlsp" method="post" class="admin-panel" enctype="multipart/form-data">
        <div class="control-group">
            <label class="label" for="product_id">Mã Sản Phẩm</label>
            <input type="text" name="product_id" value="<?php echo isset($_GET["editproduct"])?$_GET["editproduct"]:'';?>" id="product_id" class="input input--text" readonly>
        </div>
        <div class="control-group">
            <label class="label" for="product_name">Tên Sản Phẩm</label>
            <input type="text" name="product_name" value="" id="product_name" class="input input--text">
            <span class="notify__text"><?php echo isset($error["name"])?$error["name"]:""?></span>
        </div>
        <div class="control-group">
            <label class="label" for="product_thumb">Ảnh Đại Diện</label>
            <input type="file" name="product_thumb" id="product_thumb" class="input input--file">
            <span class="notify__text">
                <?php echo isset($error["image"]["error"])?implode("<br>",$error["image"]["error"]):""?>
            </span>
        </div>
        <div class="control-group">
            <label class="label" for="product_originprice">Giá Gốc Sản Phẩm</label>
            <input type="text" name="product_originprice" value="0" id="product_originprice" class="input input--text">
            <span class="notify__text"><?php echo isset($error["price"])?$error["price"]:""?></span>
        </div>
        <div class="control-group">
            <label class="label" for="product_sale">Khuyến mãi (%)</label>
            <input type="text" name="product_sale" value="0" id="product_sale" class="input input--text">
            <span class="notify__text"><?php echo isset($error["sale"])?$error["sale"]:""?></span>
        </div>
        <div class="control-group">
            <label class="label" for="product_instock">Số Lượng Sản Phẩm</label>
            <input type="text" name="product_instock" value="0" id="product_instock" class="input input--text">
            <span class="notify__text"><?php echo isset($error["instock"])?$error["instock"]:""?></span>
        </div>
        <div class="control-group control-group--checkbox">
            <label class="label">Nổi Bật</label>
            <div class="checkbox-container">
                <label class="label--checkbox">
                    <input type="checkbox" name="product_highlight" value="1" class="input input--checkbox">
                    <span class="label__text">Có</span>
                </label>
            </div>
        </div>
        <div class="control-group">
            <label class="label">Trạng Thái</label>
            <select class="select" name="status_id">
                <?php 
                    foreach($statuses as $status){
                ?>
                <option class="select__options" value="<?php echo $status["status_id"]; ?>"><?php echo $status["status_name"];?></option>
                <?php
                    }
                ?>
            </select>
        </div>
        <div class="control-group">
            <label class="label">Nhà Sản Xuất</label>
            <select class="select" name="producer_id">
                <?php 
                    foreach($producers as $producer){
                ?>
                <option class="select__options" value="<?php echo $producer["producer_id"]; ?>" ><?php echo $producer["producer_name"];?></option>
                <?php
                    }
                ?>
            </select>
        </div>
        <div class="control-group">
            <label class="label">Loại Sản Phẩm</label>
            <select class="select" name="category_id">
                <?php 
                    foreach ($categories as $category) {
                ?>
                <option class="select__options" value="<?php echo $category["category_id"]; ?>"><?php echo $category["category_name"];?></option>
                <?php
                    }
                ?>
            </select>
        </div>
        <div class="control-panel">
            <input type="submit" name="add_product" class="" value="Thêm sản phẩm">
            <button type='submit' name='confirm_edit_product' <?php echo !isset($_GET["editproduct"])?'disabled':"";?> >Xác nhận sửa</button>
            <div class="search-panel" style="margin-left: auto;">
                <input type="text" name="search_product_key" value="" placeholder="Tìm tên sản phẩm..." class="input input--text">
                <input type="submit" class="btn--search" name="search_product" value="Tìm kiếm sản phẩm">
                <span class='notify__text' style="display:block;"> <?php echo isset($_POST["search_product"])?$resultNumber." kết quả tìm được cho từ khóa ".$_POST["search_product_key"]:"";?></span>
            </div>
        </div>
    </form>
    <div class="notify">
        <span class="notify__text">
            <?php 
                if(isset($count)){
                    if($count>0){
                        echo "Đã thêm $count sản phẩm";
                    }else if($count<0){
                        echo "Lỗi file hình ảnh";
                    }else echo "Thêm thất bại";
                }
            ?>
        </span>
        <span class="notify__text">
            <?php 
                echo isset($_POST["confirm_edit_product"])?$updateCount>0?"Cập nhật thành công sản phẩm có mã: $pid":"Cập nhật sản phẩm thất bại":"";
            ?>
        </span>
    </div>

<form action="admin.php?fnc=qlsp" method="GET">
    <table class="data-table">
        <thead>
        <tr>
            <th>Mã Sản Phẩm</th>
            <th>Tên Sản Phẩm</th>
            <th>Ảnh Đại Diện</th>
            <th>Giá Gốc</th>
            <th>Giảm Giá</th>
            <th>Giá Bán</th>
            <th>Tồn Kho</th>
            <th>Nổi Bật</th>
            <th>Trạng Thái</th>
            <th>Nhà Sản Xuất</th>
            <th>Loại Sản Phẩm</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php 
            foreach($products as $product){
        ?>
        <tr>
            <td class="single-word"><?php echo $product["product_id"];?></td>
            <td><?php echo $product["product_name"];?></td>
            <td><span class="long-text"><?php echo $product["product_thumb"];?></span><img class="image-thumb" src="<?php echo "./front-end/images/products/".$product["producer_name"]."/".$product["category_name"]."s/".$product["product_thumb"] ?>"></td>
            <td><?php echo "<script>document.write(stringToMoney(".$product["product_originprice"]."))</script>";?></td>
            <td class="single-word"><?php echo $product["product_sale"]*100;?>%</td>
            <td><?php echo "<script>document.write(stringToMoney(".$product["product_originprice"]*(1-$product["product_sale"])."))</script>";?></td>
            <td class="single-word"><?php echo $product["product_instock"];?></td>
            <td class="single-word"><?php echo $product["product_ishighlight"]?"O":"X";?></td>
            <td><?php echo $product["status_name"];?></td>
            <td><?php echo $product["producer_name"];?></td>
            <td><?php echo $product["category_name"];?></td>
            <td>
                <a href="<?php echo "admin.php?fnc=qlsp&delete=".$product["product_id"]?>" type="submit" name="delete">Delete</a>
                <a href="<?php echo "admin.php?fnc=qlsp&editproduct=".$product["product_id"]?>" name='edit_product'>Sửa</a>
            </td>
        </tr>
        <?php
            }
        ?>
        </tbody>
    </table>
</form>