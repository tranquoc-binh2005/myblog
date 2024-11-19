<section class="container mt-20 pd-20">
    <form action="" method="GET">
        <div class="breckbrumb mt-20 mb-20">
            <a href="">Home</a> > source
            <h1>Source chat luong</h1>
        </div>
        <section class="d-flex gap-20 overflow-auto source-container">
            <div class="col col-3 mb-20 source-container-search">
                <div class="col-12">
                    <input placeholder="Tìm kiếm..." type="text" name="keyword" value="<?=$data['keyword']?>"> <br>

                    <?php include 'catalogue.php';?>
                </div>
            </div>
            <?php include 'prod.php';?>
        </section>
    </form>
</section>