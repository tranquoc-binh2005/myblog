<section style="max-width: 970px;" class="container mt-4 pt-lg-2 pb-3">
    <h1 class="font-size-30"><?= $data['detail']['name'] ?></h1>
    <div class="d-flex flex-md-row flex-column align-items-md-center justify-content-md-between">
        <div class="d-flex align-items-center flex-wrap text-muted">
            <a href="blog?cat=<?=$data['detail']['post_catalogue_id']?>" class="fs-xs border-end pe-3 me-3 mb-2">
                <span class="badge bg-faded-primary text-primary fs-base">
                    <?= $data['detail']['nameCatalogue'] ?>
                </span>
            </a>
            <div class="fs-sm border-end pe-3 me-3 mb-2">
                <?= date('H:i d-m-Y', strtotime($data['detail']['updated_at'])) ?>
            </div>
            <!--chuc nang tong so comment-->
            <!-- <div class="d-flex mb-2">
                <div class="d-none align-items-center me-3">
                    <i class="bx bx-like fs-base me-1"></i>
                    <span class="fs-sm">0</span>
                </div>
                <div class="d-flex align-items-center me-3">
                    <i class="bx bx-comment fs-base me-1"></i>
                    <span class="fs-sm">0</span>
                </div>
            </div> -->
        </div>
    </div>
</section>
<section class="container mb-5 pb-2 py-mg-4" style="max-width: 970px;">
    <div class="row gy-4">
        <div class="col-lg-12">

            <?php include 'contentDetail.php'; ?>

            <!-- Tags -->
            <hr class="my-4">
            <div class="d-flex flex-sm-row flex-column pt-2">
                <h6 class="mt-sm-1 mb-sm-2 mb-3 me-2 text-nowrap">Tags Bài viết:</h6>
                <div>
                    <?php foreach ($data['detail']['catalogue'] as $val) {?>
                    <a wire:key="1" href=""
                        class="btn btn-sm btn-outline-secondary me-2 mb-2"><?= $val['name'] ?></a>
                    <?php }?>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="card p-md-5 p-4 border-0 bg-secondary">
    <div class="card-body w-100 mx-auto px-0" style="max-width: 746px;">
        <h2 class="mb-4 pb-3">Để lại bình luận</h2>

        <form id="commentForm" class="row gy-4" wire:submit.prevent="sendComment">
            <div class="col-sm-6 col-12">
                <label for="fn" class="form-label fs-base">Họ tên</label>
                <input wire:model="comment_name" placeholder="Họ tên" type="text"
                    class="form-control form-control-lg " id="fn" required="">
            </div>
            <div class="col-sm-6 col-12">
                <label for="comment_email" class="form-label fs-base">Email</label>
                <input wire:model="comment_email" placeholder="Email" type="email"
                    class="form-control form-control-lg " id="comment_email">
            </div>
            <div class="col-12">
                <label for="comment_text" class="form-label fs-base">Bình luận</label>
                <textarea wire:model="comment_text" placeholder="Nội dung bình luận..." class="form-control form-control-lg "
                    id="comment_text" rows="3" required=""></textarea>
            </div>


            <div class="col-12">
                <button type="submit" class="btn btn-lg btn-primary w-sm-auto w-100 mt-2">Gửi bình luận</button>
            </div>
        </form>
    </div>
</div>

<?php include 'attr.php'; ?>