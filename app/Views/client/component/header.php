<header>
    <div class="container-header">
        <div class="container-header-img">
            <a href="trang-chu"><img src="client/assets/image/logo.png" alt="logo website" title="quocbinh.org"></a>
        </div>
        <div id="menubar" class="menubar hide"><i class="mt-10 fa-solid fa-bars"></i></div>
        <dialog class="dialogMenu" id="dialogMenu">
            <div class="menuBox box-titleMenu">
                <h3>Menu</h3>
                <button class="btn text-bg-light"
                    onclick="document.getElementById('dialogMenu').close()">X</button>
            </div>
            <nav class="menuBox box-mainMenu menu">
                <a href="source-code">Source Code</a>
                <a href="blog">Blog</a>
                <a href="contact">Liên Hệ</a>
            </nav>
            <div class="menuBox clear-both">
                <a href="dang-nhap" class="btn-login">Đăng nhập</a>
                <a href="cart.html" class="btn-cart"><i class="fa-solid fa-cart-shopping"></i> <span class="sz-s">Giỏ hàng</span> (0)</a>
            </div>
        </dialog>
        <div class="container-header-box position-lft">
            <div class="cl-box"><a href="source-code">Source Code</a></div>
            <div class="cl-box"><a href="blog">Blog</a></div>
            <div class="cl-box"><a href="contact">Contact</a></div>
        </div>
        <div class="container-header-box gap-10">
            <?php
                if(isset($_SESSION['user']) && (is_array($_SESSION['user']))){?>
                    <div class="btn-account">
                        <a class="btn-login" href="dang-nhap"> 
                            <i class="fa-solid fa-user"></i>&nbsp;Tài khoản
                        </a>
                        <ul class="dropdown-account">
                            <li><a href="thong-tin">Thông tin</a></li>
                            <li><a href="lich-su-don-hang">Lịch sử đơn hàng</a></li>
                            <li><a href="dang-xuat">Đăng xuất</a></li>
                        </ul>
                    </div>
            <?php } else {?>
                <a href="dang-nhap" class="btn-login">Đăng nhập</a>
            <?php }?>
            <a href="cart.html" class="btn-cart"><i class="fa-solid fa-cart-shopping"></i> Giỏ hàng (0)</a>
        </div>
    </div>
</header>