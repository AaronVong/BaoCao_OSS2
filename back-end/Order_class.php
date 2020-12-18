<?php 
require_once "./back-end/DbServices.php";
    class Order extends DbServices{
       
         function createOrder($cid,$deadline,$address,$cart=[]){
            $isSuccess=true;
            // đầu tiên tạo đơn hàng
            $this->beginTransactionNow();
            $order_query = "INSERT INTO tn_order(order_deadline,customer_id,order_address) VALUES(:deadline,:cid,:address)";
            // những bột như order_worth cần phải thêm chi tiết đơn hàng rồi mới tính tổng tiền được
            $order_rows=$this->executeChangeDataQuery($order_query,[":deadline"=>$deadline,":cid"=>$cid,"address"=>$address]);
            // bước thêm đơn hàng thành công
            if($order_rows>0){
                $detail_query = "INSERT INTO tn_order_detail(product_id,order_id,order_detail_originprice,order_detail_number,order_detail_worth,order_detail_saleprice) VALUES(:pid,:oid,:originprice,:number,:worth,:saleprice)";
                $order_id = $this->lastIndexInserted();// lấy mã đơn hàng vừa thêm
                $order_worth = 0;
                // duyệt mảng giỏ hàng để thêm chi tiết đơn hàng
                foreach($cart as $pid => $item){
                    $origin_price = (int)$item["price"];
                    $sale_price = (float)$item["sale"]*$origin_price;
                    $number = (int)$item["number"];
                    $detail_worth = ($origin_price*$number)-($sale_price*$number);
                    $order_worth+=$detail_worth;
                    
                    $detail_rows = $this->executeChangeDataQuery($detail_query,[":pid"=>$pid,":oid"=>$order_id,":originprice"=>"$origin_price",":number"=>"$number",":worth"=>"$detail_worth",":saleprice"=>"$sale_price"]);
                    if($detail_rows===0){// nếu thất bại khi thêm, rollback tiến trình
                        $isSuccess=false;
                    break;
                    }
                }
                // sau khi thêm tất cả chi tiết đơn hàng, thì tiến hành cập nhật trị giá đơn hàng
                $update_query = "UPDATE tn_order SET order_worth=:orderworth WHERE order_id=:oid";
                $update_rows=$this->executeChangeDataQuery($update_query,[":orderworth"=>"$order_worth",":oid"=>$order_id]);
                if($update_rows==0){
                    // update đơn hàng thất bại
                    $isSuccess=false;
                }
            }else{
                // thêm đơn hàng thất bại
                $isSuccess=false;
            }
            if($isSuccess===false){
                $this->rollBackNow();
            }
            $this->commitNow();
            return $isSuccess;
        }


}