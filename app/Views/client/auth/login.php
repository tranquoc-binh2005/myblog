<div class="container">
    <form action="xu-ly-dang-nhap" method="POST" class="login-form">
        <div class="pb-10 mb-20">
            <h1 class="pb-20">Xin chào</h1>
            <span>Bạn chưa có tài khoản?&nbsp;</span><a class="highlight-text text-decoration-underline" href="dang-ky">đăng ký tại đây</a>
        </div>
        <div class="mb-20 col-12">
            <div class="col-12">
                <label for="email" class="text-size-18">Email</label>
                <input placeholder="Email" value="<?=$data['email'] ? $data['email'] : ''?>" type="email" id="email" name="email">
                <?php if(isset($errors['email'])){
                    echo '<div class="text-danger">- '.$errors['email'].'*</div>';
                }?>
            </div>
        </div>

        <div class="mb-20 col-12">
            <div class="col-12">
                <label for="password" class="text-size-18">Mật khẩu</label>
                <input placeholder="Mật khẩu" type="password" id="password" name="password" class="password">
                <?php if(isset($errors['password'])){
                    echo '<div class="text-danger">- '.$errors['password'].'*</div>';
                }?>
            </div>
        </div>

        <div class="col-20 mb-20">
            <input type="checkbox" name="" id="">&nbsp; Ghi nhớ tôi
        </div>

        <div class="col-20 mb-20 text-center">
            <button type="submit" class="btn-cart">Đăng nhập</button> <br>
            <a href="" class="highlight-text mt-20">Quên mật khẩu?</a>
        </div>
    </form>
</div>