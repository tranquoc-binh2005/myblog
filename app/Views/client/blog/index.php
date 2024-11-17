<section class="container mt-20 pd-20">
    <form action="" method="GET">
        <div class="breckbrumb mt-20 mb-20">
            <a href="">Home</a> > blog
        </div>
        <section class="">
            <div class="col col-mb col-12 mb-20">
                <h1 class="col-4 align-center">Blog</h1>
                
                <?php include 'catalogue.php'?>

                <div class="col-4 pl-5 pl-5-mb">
                    <input placeholder="Tìm kiếm..." type="text" id="keyword" name="keyword" value="<?=$data['keyword']?>">
                </div>
            </div>
        </section>
        <?php include 'post.php'?>
    </form>
</section>
