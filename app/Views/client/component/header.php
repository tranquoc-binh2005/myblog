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
                <div class="dropdown">
                    <span class="dropdown-btn" id="serviceMenu">Dịch vụ <i class="fa-solid fa-caret-down"></i></span>
                    <div class="dropdown-content">
                        <div><a href="#">Thiết kế website</a></div>
                        <div><a href="#">Thiết kế website</a></div>
                        <div><a href="#">Thiết kế website</a></div>
                        <div><a href="#">Thiết kế website</a></div>
                    </div>
                </div>
                <a href="source.html">Source code</a>
                <a href="blog.html">Blog</a>
                <a href="#">Liên Hệ</a>
            </nav>
            <div class="menuBox clear-both">
                <a href="dang-nhap" class="btn-login">Đăng nhập</a>
                <a href="cart.html" class="btn-cart"><i class="fa-solid fa-cart-shopping"></i> <span class="sz-s">Giỏ hàng</span> (0)</a>
            </div>
        </dialog>
        <div class="container-header-box">
            <div class="dropdown cl-box">
                <a>Dịch vụ</a>
                <ul class="dropdown-items">
                    <li><a href="">Thiết kế website</a></li>
                    <li><a href="">Bài tập lớn</a></li>
                    <li><a href="">Hỗ trợ 1:1</a></li>
                </ul>
            </div>
            <div class="cl-box"><a href="source.html">Source</a></div>
            <div class="cl-box"><a href="blog.html">Blog</a></div>
            <div class="cl-box"><a href="contact.html">Contact</a></div>
        </div>
        <div class="container-header-box gap-10">
            <a href="dang-nhap" class="btn-login">Đăng nhập</a>
            <a href="cart.html" class="btn-cart"><i class="fa-solid fa-cart-shopping"></i> Giỏ hàng (0)</a>
        </div>
    </div>
</header>