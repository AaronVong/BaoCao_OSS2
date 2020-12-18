<?php 
require_once "./back-end/DbServices.php";
    class Order extends DbServices{
       

        function getAllOrders(){
            $query = "SELECT order_id,tn_order.customer_id,order_created,order_deadline,order_address,order_worth,tn_order.status_id,status_name,customer_name,customer_phone FROM tn_order
            INNER JOIN tn_status on tn_status.status_id=tn_order.status_id
            INNER JOIN tn_customer on tn_customer.customer_id=tn_order.customer_id";
            $rs = $this->executeQuery($query);

            return $rs;
        }

        function getDetailById($id){
            $query = "SELECT order_detail_originprice,order_detail_number,order_detail_worth,order_detail_saleprice,product_name FROM tn_order_detail
            INNER JOIN tn_product on tn_product.product_id = tn_order_detail.product_id
            WHERE order_id=:id";
            return $this->executeQuery($query,[":id"=>$id]);
        }

        function updateOrderStatusById($oid,$statusid){
            $query = "UPDATE tn_order SET status_id=:status WHERE order_id=:oid";
            $rows = $this->executeChangeDataQuery($query,[":status"=>$statusid,":oid"=>$oid]);
            return $rows;
        }

        function searchOrderByNameAndPhone($key){
            $query = "SELECT order_id,tn_order.customer_id,order_created,order_deadline,order_address,order_worth,tn_order.status_id,status_name,customer_name,customer_phone FROM tn_order
            INNER JOIN tn_status on tn_status.status_id=tn_order.status_id
            INNER JOIN tn_customer on tn_customer.customer_id=tn_order.customer_id
            WHERE customer_name LIKE :key OR customer_phone LIKE :key";
            $rs = $this->executeQuery($query, [":key"=>'%'.$key.'%']);

            return $rs;
        }

        function getCustomerOrders($cid){
            $query = "SELECT order_id,tn_order.customer_id,order_created,order_deadline,order_address,order_worth,tn_order.status_id,status_name,customer_name,customer_phone FROM tn_order
            INNER JOIN tn_status on tn_status.status_id=tn_order.status_id
            INNER JOIN tn_customer on tn_customer.customer_id=tn_order.customer_id
            WHERE tn_order.customer_id=:cid";

            $rs = $this->executeQuery($query, [":cid"=>$cid]);

            return $rs;
        }
    }