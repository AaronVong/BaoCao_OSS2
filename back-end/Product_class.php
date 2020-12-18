<?php
    require_once "./back-end/DbServices.php";
    class Product extends DbServices{
        function getAllProducts(){
            $query = "SELECT product_id,product_name,product_thumb,product_originprice,product_sale,producer_name,category_name, status_name,product_ishighlight,product_instock FROM tn_product
            INNER JOIN tn_producer ON tn_product.producer_id = tn_producer.producer_id
            INNER JOIN tn_category ON tn_product.category_id = tn_category.category_id
            INNER JOIN tn_status ON tn_status.status_id = tn_product.status_id
            WHERE product_instock > 0";
            $result = $this->executeQuery($query);
            return $result;
        }

        function getHighlightProducts($catid, $number=5){
            $query = "SELECT product_id,product_name,product_thumb,product_originprice,product_sale,producer_name,category_name FROM tn_product
            INNER JOIN tn_producer ON tn_product.producer_id = tn_producer.producer_id
            INNER JOIN tn_category ON tn_product.category_id = tn_category.category_id
            WHERE tn_product.status_id = 1 AND tn_product.product_ishighlight = 1 AND tn_product.category_id = :catid AND product_instock > 0
            LIMIT 0,:number";
            
            // because the param (:number) is a number, so it have to using prepareQuery() from the DbServices class
            // and then use method bindValue() like normal
            $stament = $this->prepareQuery($query);
            $stament->bindValue(':number',$number,PDO::PARAM_INT);
            $stament->bindValue(":catid",$catid,PDO::PARAM_INT);
            $result = $stament->execute()?$stament->fetchAll():null;
            // if($result===null){
            //     die("Lỗi khi thực hiện câu truy vấn");
            // }
            return $result;
        }

        function getProductsByCategoryId($categoryId){
            $query = "SELECT product_id,product_name,product_thumb,product_originprice,product_sale,producer_name,category_name, tn_product.category_id FROM tn_product
            INNER JOIN tn_producer ON tn_product.producer_id = tn_producer.producer_id
            INNER JOIN tn_category ON tn_product.category_id = tn_category.category_id
            WHERE tn_product.category_id=? AND product_instock>0";

            $result = $this->executeQuery($query,[$categoryId]);

            // if($result===null){
            //     die("Lỗi khi thực hiện câu truy vấn");
            // }
            return $result;
        }

        function getProductsByCategoryIdAndProducerId($categoryId, $producerId){
            $query = "SELECT product_id,product_name,product_thumb,product_originprice,product_sale,producer_name,category_name, tn_product.category_id, tn_product.producer_id FROM tn_product
            INNER JOIN tn_producer ON tn_product.producer_id = tn_producer.producer_id
            INNER JOIN tn_category ON tn_product.category_id = tn_category.category_id
            WHERE tn_product.category_id=:catid AND tn_product.producer_id=:producerid AND product_instock>0";

            $result = $this->executeQuery($query,[":catid"=>$categoryId, ":producerid"=>$producerId]);

            // if($result===null){
            //     die("Lỗi khi thực hiện câu truy vấn");
            // }
            return $result;
        }
        function getProductbyId($id){
            $query = "SELECT product_id,product_name,product_thumb,product_originprice,product_sale,producer_name,category_name,tn_product.category_id,tn_product.producer_id FROM tn_product
            INNER JOIN tn_producer ON tn_product.producer_id = tn_producer.producer_id
            INNER JOIN tn_category ON tn_product.category_id = tn_category.category_id
            WHERE product_id=:id AND product_instock>0";
            
            $result = $this->executeQuery($query, ["id"=>$id]);
            return $result;
        }

        function addNewProduct($pname, $pthumb, $pprice,$psale,$pstock,$phighlight,$producerid,$categoryid,$statusid){
            $isSuccess=true;
            $query = "INSERT INTO tn_product(product_name,product_thumb,product_originprice,product_sale,product_instock,product_ishighlight,producer_id,category_id,status_id)
            VALUES(:pname,:pthumb,:pprice,:psale,:pstock,:phighlight,:producerid,:catid,:statusid)";
            if(strlen($pname)<=0)return 0;
            $this->beginTransactionNow();
            $rows = $this->executeChangeDataQuery($query, [":pname"=>$pname,":pthumb"=> $pthumb["name"],":pprice"=>$pprice,":psale"=>$psale,":pstock"=>$pstock,":phighlight"=>$phighlight,":producerid"=>$producerid,":catid"=>$categoryid,":statusid"=>$statusid]);
            if($rows>0){
                $pid = $this->lastIndexInserted();
                try{
                    $this->uploadImage($pthumb,$pid);
                }catch(ErrorException $err){
                    echo "<span class='notify__text'>".$err->getMessage()."</span>";
                    $isSuccess=false;
                }
            }else{
                $isSuccess=false;
            }

            if($isSuccess==false){
                $this->rollbackNow();
                $rows=$isSuccess;
                return $rows;
            }
            $this->commitNow();
            return $rows;
        }

        function uploadImage($image, $pid){
            $isSuccess=true;
            if($image["tmp_name"]===''){
                return 0;
            }
            $query = "SELECT producer_name,category_name FROM tn_product
            JOIN tn_producer ON tn_product.producer_id = tn_producer.producer_id
            JOIN tn_category ON tn_product.category_id = tn_category.category_id 
            WHERE product_id=:pid";
            $rs = $this->executeQuery($query,[":pid"=>$pid]);
            if(count($rs)>0){
                $target_dir = "front-end/images/products/".$rs[0]["producer_name"]."/".$rs[0]["category_name"]."s/";
                if(!is_dir($target_dir)){
                    if(!mkdir($target_dir)){
                        echo "Không thể tạo thực mục, chứa hình ảnh<br>Thêm sản phẩm thất bại";
                    }
                }
                $target_file = $target_dir . basename($image["name"]);
                if($this->isImageExist($target_file)){
                    return $isSuccess;
                }
                if(!move_uploaded_file($image["tmp_name"], $target_file)){
                    $isSuccess=false;
                    throw new ErrorExeception("Không thể upload hình ảnh");
                }
            }else{
                $isSuccess=false;
            }

            return $isSuccess;
        }

        function deleteProductById($id){
            $query = "DELETE FROM tn_product WHERE product_id=:id";
            // $stament = $this->prepareQuery($query);
            // $stament->bindValue(":id",$id);
            // if($this->beginTransactionNow()){
            //     echo "transaction begined";
            // }else return;
            // if($stament->execute()){
            //     $this->commitNow();
            // }else{
            //     $this->rollbackNow();
            // }
            // return $stament->rowCount();
            $deletedRows = $this->executeChangeDataQuery($query,[":id"=>"$id"]);
            return $deletedRows;
        }

        function getAllHeadphoneAndPortableCharger(){
            $query = "SELECT product_id,product_name,product_thumb,product_originprice,product_sale,producer_name,category_name, status_name,product_ishighlight,product_instock FROM tn_product
            INNER JOIN tn_producer ON tn_product.producer_id = tn_producer.producer_id
            INNER JOIN tn_category ON tn_product.category_id = tn_category.category_id
            INNER JOIN tn_status ON tn_status.status_id = tn_product.status_id
            WHERE category_name NOT LIKE 'laptop' and category_name NOT LIKE 'phone' AND category_name NOT LIKE 'tablet' AND product_instock>0
            ";
            $result = $this->executeQuery($query);
            return $result;
        }

        function getAllHeadphoneAndPortableChargerIsHighlight(){
            $query = "SELECT product_id,product_name,product_thumb,product_originprice,product_sale,producer_name,category_name, status_name,product_ishighlight,product_instock FROM tn_product
            INNER JOIN tn_producer ON tn_product.producer_id = tn_producer.producer_id
            INNER JOIN tn_category ON tn_product.category_id = tn_category.category_id
            INNER JOIN tn_status ON tn_status.status_id = tn_product.status_id
            WHERE category_name NOT LIKE 'laptop' and category_name NOT LIKE 'phone' AND category_name NOT LIKE 'tablet' AND product_ishighlight=1 AND product_instock>0";
            $result = $this->executeQuery($query);
            return $result;
        }

        function searchProductsByName($key){
            if($key===""){
                return $this->getAllProducts();
            }
            $query = "SELECT product_id,product_name,product_thumb,product_originprice,product_sale,producer_name,category_name, status_name,product_ishighlight,product_instock FROM tn_product
            INNER JOIN tn_producer ON tn_product.producer_id = tn_producer.producer_id
            INNER JOIN tn_category ON tn_product.category_id = tn_category.category_id
            INNER JOIN tn_status ON tn_status.status_id = tn_product.status_id
            WHERE product_name LIKE :key OR producer_name LIKE :key OR category_name LIKE :key AND product_instock>0";

            $result = $this->executeQuery($query,["key"=>"%".$key."%"]);
            return $result;
        }

        function updateProduct($pid='0',$pname="", $pthumb="",$pprice="",$psale="",$pstock="",$phighlight="",$producerid="",$categoryid="",$statusid=""){
            $query = "UPDATE tn_product SET ";
            $params=[];
            if($pname!=""){
                $query.="product_name=:pname,";
                $params[":pname"]=$pname;
            }
            if($pthumb["name"]!=""){
                $query.="product_thumb=:pthumb,";
                $params[":pthumb"]=$pthumb;
            }
            if($pprice!=""){
                $query.="product_originprice=:pprice,";
                $params[":pprice"]=$pprice;
            }
            if($psale!=""){
                $query.="product_sale=:psale,";
                $params[":psale"]=$psale;
            }
            if($pstock!=""){
                $query.="product_instock=:pstock,";
                $params[":pstock"]=$pstock;
            }
            if($phighlight!=""){
                $query.="product_ishighlight=:phighlight,";
                $params[":phighlight"]=$phighlight;
            }
            if($producerid!=""){
                $query.="producer_id=:producerid,";
                $params[":producerid"]=$producerid;
            }
            if($categoryid!=""){
                $query.="category_id=:categoryid,";
                $params[":categoryid"]=$categoryid;
            }
            if($statusid!=""){
                $query.="status_id=:statusid,";
                $params[":statusid"]=$statusid;
            }
            $finalQuery=substr_replace($query,"",strlen($query)-1);
            $finalQuery.=" WHERE product_id=$pid";
            // var_dump($finalQuery);
            // var_dump($params);
            $count =  $this->executeChangeDataQuery($finalQuery,$params);
            return $count;
        }

        function getProductInStock($pid){
            $sql = "SELECT product_instock FROM tn_product WHERE product_id =:pid";
            $rs = $this->executeQuery($sql, [":pid"=>$pid]);
            return count($rs)>0?$rs[0]["product_instock"]:null;
        }
    }
?>