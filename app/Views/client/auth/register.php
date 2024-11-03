<div class="container">
    <form action="" class="login-form">
        <div class="pb-10 mb-20">
            <h1 class="pb-20">Tạo tài khoản</h1>
            <span>Bạn đã có tài khoản?&nbsp;</span><a class="highlight-text text-decoration-underline" href="dang-nhap">đăng nhập tại đây</a>
        </div>
        <div class="mb-20 col-12">
            <div class="col-12">
                <label for="name" class="text-size-18">Họ tên</label> <span class="text-danger">*</span>
                <input placeholder="Họ tên" type="text" id="name" required="">
            </div>
        </div>

        <div class="col mb-20">
            <div class="col-6 pr-5">
                <label for="mail" class="">Email</label> <span class="text-danger">*</span>
                <input placeholder="Email" type="email" id="mail" required="">
            </div>

            <div class="col-6 pl-5">
                <label for="phone" class="">Số điện thoại</label> <span class="text-danger">*</span>
                <input placeholder="Số điện thoại" type="number" id="phone" required="">
            </div>
        </div>

        <div class="mb-20 col-12">
            <div class="col-12">
                <label for="password" class="text-size-18">Mật khẩu</label> <span class="text-danger">*</span>
                <input placeholder="Mật khẩu" type="password" id="password" required="">
            </div>
        </div>

        <div class="mb-20 col-12">
            <div class="col-12">
                <label for="re_password" class="text-size-18">Nhập lại mật khẩu</label> <span class="text-danger">*</span>
                <input placeholder="Nhập lại mật khẩu" type="password" id="re_password" required="">
            </div>
        </div>


        <div class="col mb-20">
            <div class="col-6 pr-5">
                <label for="province" class="">Thành phố</label>
                <select name="province" id="province">
                    <option value="">Chọn thành phố</option>
                </select>
            </div>

            <div class="col-6 pr-5">
                <label for="district" class="">Quận/Huyện</label>
                <select name="district" id="district">
                    <option value="">Chọn Quận/Huyện</option>
                </select>
            </div>
        </div>

        <div class="col mb-20">
            <div class="col-6 pr-5">
                <label for="wards" class="">Xã/Phường</label>
                <select name="wards" id="wards">
                    <option value="">Chọn Xã/Phường</option>
                </select>
            </div>

            <div class="col-6 pl-5">
                <label for="description" class="">Ghi chú</label>
                <input placeholder="Ghi chú" type="text" id="description">
            </div>
        </div>

        <div class="col-20 mb-20 text-center">
            <button type="submit" class="btn-cart">Tạo tài khoản</button> <br>
        </div>
        <div class="col-20 mb-20">
            <p>Lưu ý: Các trường <span class="text-danger">*</span> là bắt buộc</p>
        </div>
    </form>
</div>