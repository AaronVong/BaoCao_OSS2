<div id="fakebody">
<div id="container--signin">
    <div class="form-container sign-in-container">
        <form action="admin.php" method="POST">
            <h1>Sign in</h1>
            <span>or use your account</span>
            <input type="text" placeholder="Name" name="adminname" value="" />
            <input type="password" placeholder="Password" name="password" />
            <button type="submit" name="admin-signin">Sign In</button>
            <span class="text--error"><?php echo isset($signin)?!$signin? "Tài khoản hoặc mật khẩu không tồn tại":"":"";?></span>
        </form>
    </div>
    <div class="overlay-container">
        <div class="overlay">
            <div class="overlay-panel overlay-right">
                <h1>TechNow Admin</h1>
                <p>You Need Account To Access This Page!</p>
            </div>
        </div>
    </div>
</div>
</div>