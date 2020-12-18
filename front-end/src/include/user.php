<div class="user">
    <button class='btn--user' type="button"><?php echo $_SESSION["user"]["email"]; ?></button>
    <div class="user__menu">
        <button type="button" class="btn--myorders">Đơn hàng</button>
        <button type="button" class="btn--signout">Sign out</button>
    </div>
</div>