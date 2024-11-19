<div class="container-small">
    <ol class="breadcrumb mb-20 mt-20">
        <li class="">
            <a href="trang-chu"></i>Home</a>\
        </li>
        <li class="">
            <a href="source-code">Source-code</a>\
        </li>
        <li class="active"><?= $data['detail']['canonical'] ?></li>
    </ol>
    <div class="col-lg-12">
        <div class="row mb-4 pb-2">
            <div class="col-lg-6">
                <img class="rounded w-100"
                    src="<?= $data['detail']['image'] ?>"
                    alt="<?= $data['detail']['name'] ?>">
            </div>
            <div class="col-lg-6">
                <h1 class="fs-2 mb-1"><?= $data['detail']['name'] ?></h1>

                <div class="d-flex flex-md-row flex-column align-items-md-center justify-content-md-between mb-4">
                    <div class="d-flex align-items-center flex-wrap text-muted mb-md-0 mb-3 d-none">

                        <div class="fs-sm border-end pe-3 me-3 mb-2"><h1>15-09-2024 23:19:46</h1></div>
                        <div class="d-flex mb-2">
                            <div class="d-none align-items-center me-3">
                                <i class="bx bx-like fs-base me-1"></i>
                                <span class="fs-sm">
                                    0
                                </span>
                            </div>
                            <div class="d-flex align-items-center me-3">
                                <i class="bx bx-comment fs-base me-1"></i>
                                <span class="fs-sm">
                                    0
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="fw-bold fs-4 lh-1 text-dark">
                    <?php
                    $discountedPrice = intval($data['detail']['sale']) > 0 ? $data['detail']['price'] * (1 - $data['detail']['sale'] / 100) : $data['detail']['price'];
                    echo number_format($discountedPrice, 0, ',', '.') . 'đ';
                    ?>
                </div>
                <div class="fs-lg d-flex align-items-center gap-2 mt-2">
                    <?= intval($data['detail']['sale']) > 0 ? '<div class="fw-semibold lh-1 text-decoration-line-through">' . number_format($data['detail']['price'], 0, ',', '.') . 'đ' . '</div> <div class="btn-sale bg-danger"> -' . htmlspecialchars(intval($data['detail']['sale'])) . '%</div>' : '' ?>
                </div>
                <div class="my-3">
                    <?= $data['detail']['description'] ?>
                </div>

                <div class="d-flex align-items-center gap-3">
                    <div class="btn-cart">Mua ngay</div>
                    <div class="btn-cart">Thêm vào giỏ hàng</div>
                </div>
            </div>
        </div>

        <hr class="my-4">

        <div id="article" class="typo-section ql-editor"
            style="max-width: 800px; margin-left:auto; margin-right:auto">
            <?= $data['detail']['content'] ?>
        </div>

        <!-- Tags -->
        <hr class="my-4">
        <div class="d-flex flex-sm-row flex-column pt-2">
            <h6 class="mt-sm-1 mb-sm-2 mb-3 me-2 text-nowrap">Tags sản phẩm:</h6>
            <div>
                <?php foreach ($data['detail']['catalogue'] as $val) {?>
                <a href="" class="btn btn-sm btn-outline-secondary me-2 mb-2"><?= $val['name'] ?></a>
                <?php }?>
            </div>
        </div>
    </div>
</div>
<?php include 'comment.php'; ?>
<?php include 'attr.php'; ?>
