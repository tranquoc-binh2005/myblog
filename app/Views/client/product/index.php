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

    <?php
    $currentPage = $data['products']['current_page'];
    $totalPages = $data['products']['total_pages'];
    ?>
    <ul class="pagination right-0">
        <li class="page-item <?= $currentPage == 1 ? 'disabled' : '' ?>">
            <a class="page-link" href="source-code?page=<?= $currentPage - 1 ?>&keyword=<?=$data['keyword']?>" aria-label="Previous">
                <span aria-hidden="true">«</span>
                <span class="sr-only">Previous</span>
            </a>
        </li>

        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <li class="page-item <?= $i == $currentPage ? 'active' : '' ?>">
            <a class="page-link" href="source-code?page=<?= $i ?>&keyword=<?=$data['keyword']?>"><?= $i ?></a>
        </li>
        <?php endfor; ?>

            <a class="page-link" href="source-code?page=<?= $currentPage + 1 ?>&keyword=<?=$data['keyword']?>" aria-label="Next">
                <span aria-hidden="true">»</span>
                <span class="sr-only">Next</span>
            </a>
        </li>
    </ul>
</section>