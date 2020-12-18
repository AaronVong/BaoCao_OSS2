<?php 
    if(isset($_POST["search-customer"])){
        $key = $_POST["customer-keyword"];
        $customers = $_customer->searchCustomersByKey($key);
    }
?>

<h1 class="function-title">Quản lý khách hàng<h1>
<form action="admin.php?fnc=qlkh" method="post">
    <div class="control-panel">
        <div class="search-panel">
            <input type="text" value="" placeholder="Tìm tên hoặc sđt..." class="input input--text" name="customer-keyword">
            <input type="submit" value="Tìm kiếm" name="search-customer" class="input">
        </div>
    </div>
</form>
<table class="data-table">
    <thead>
        <tr>
            <th>Mã khách hàng</th>
            <th>Tên khách hàng</th>
            <th>Số điện thoại</th>
            <th>Địa chỉ</th>
            <th>Email</th>
        </tr>
    </thead>
    <tbody>
    <?php
        if(isset($customers)){
            foreach ($customers as $customer) {
    ?>
        <tr>
            <td class="single-word"><?php echo $customer["customer_id"]; ?></td>
            <td><?php echo $customer["customer_name"]; ?></td>
            <td><?php echo $customer["customer_phone"]; ?></td>
            <td><?php echo $customer["customer_address"]; ?></td>
            <td><?php echo $customer["customer_email"]; ?></td>
        </tr>
    <?php
            }
        }
    ?>
    </tbody>
</table>