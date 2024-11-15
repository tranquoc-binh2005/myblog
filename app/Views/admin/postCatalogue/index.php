<div class="card-box">
    <h4 class="header-title"><?= $sub['postCatalogue']['title']['index'] ?></h4>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
        <li class="breadcrumb-item active"><?= $sub['postCatalogue']['title']['index'] ?></li>
    </ol>
    <div class="tools-box col bg-danger mb-4">
        <div class="ul right-0 position">
            <li>
                <?=$payload['flag'] == 0 ? '<p class="dropdown-toggle btn btn-outline-secondary"><i class="fe-settings noti-icon"></i> Tùy chọn</p>' : ''?>
                <ul class="dropdown-menu">
                    <li>
                        <a class="publishAll" data-field="post_catalogues" data-column="publish" data-value="2"
                            href="#">Xuất bản</a>
                    </li>
                    <li>
                        <a class="publishAll" data-field="post_catalogues" data-column="publish" data-value="1"
                            href="#">Huỷ
                            xuất bản</a>
                    </li>
                </ul>
            </li>
        </div>
    </div>
    <form action="" method="GET">
        <div class="filter-box">
            <a class="btn btn-info" href="tao-nhom-bai-viet"><?= $sub['postCatalogue']['title']['create'] ?> </a>
            <div class="app-search-box bg-light mr-2">
                <div class="input-group">
                    <input type="text" name="keyword" class="form-control" placeholder="Search..."
                        value="<?= $data['keyword'] ?>">
                    <div class="input-group-append">
                        <button class="btn" type="submit">
                            <i class="fe-search"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="mr-2">
                <select name="status" class="form-control">
                    <option value="-1" <?= $data['publish'] == -1 ? 'selected' : '' ?>>Chọn trạng thái bản ghi
                    </option>
                    <option value="1" <?= $data['publish'] == 1 ? 'selected' : '' ?>>Publish</option>
                    <option value="2" <?= $data['publish'] == 2 ? 'selected' : '' ?>>UnPublish</option>
                </select>
            </div>
            <div class="mr-2">
                <select name="flag" class="form-control" onchange="this.form.submit()">
                    <option value="1" <?= $data['flag'] == 1 ? 'selected' : '' ?>>Bản ghi hiện tại</option>
                    <option value="2" <?= $data['flag'] == 2 ? 'selected' : '' ?>>Bản ghi đã xoá</option>
                </select>
            </div>
            <div class="entries right-0 col-2">
                <select name="perpage" class="form-control" onchange="this.form.submit();">
                    <?php for ($i = 10; $i < 100; $i += 10): ?>
                    <option value="<?= $i ?>" <?= $data['perPage'] == $i ? 'selected' : '' ?>><?= $i ?> entries</option>
                    <?php endfor; ?>
                </select>
            </div>

        </div>
    </form>


    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>
                        <input type="checkbox" name="checkAll" id="checkAll">
                    </th>
                    <th>Tên</th>
                    <th>Đường dẫn</th>
                    <th>Hình ảnh</th>
                    <th>Trạng thái</th>
                    <th>#</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($data['dropDowns'] as $key => $val) {
                    $depth = intval($val['depth']) - 1;
                    if($depth >= 0){
                        $prefix = str_repeat('|--', $depth);
                    }
                ?>
                <tr>
                    <th width="50px" scope="row">
                        <input type="checkbox" data-id="<?= $val['id'] ?>" class="inputCheck" name="checked"
                            id="checked">
                    </th>
                    <td><?= $prefix . $val['name'] ?></td>
                    <td><?=$config['rootPath'] . $val['canonical'] . '.html' ?></td>
                    <td width="200px"><img width="100px" src="<?=$val['image']?>" alt="<?=$val['name']?>"></td>
                    <th width="100px">
                        <input type="checkbox" <?= $val['publish'] == 1 ? 'checked' : '' ?> data-plugin="switchery"
                            data-color="#64b0f2" data-size="small" data-switchery="true" style="display: none;"
                            class="changeStatusPublish location-<?= $val['id'] ?>" data-filed="post_catalogues"
                            data-column="publish" data-id="<?= $val['id'] ?>" data-value="<?= $val['publish'] ?>">

                    </th>
                    <?php
                    if($data['flag'] == 1){
                    ?>
                    <th width="50px">
                        <a style="font-size: 20px;" href="sua-nhom-bai-viet/<?= $val['id'] ?>"><i class="fe-edit"></i> </a>
                        <a style="font-size: 20px; color:rgb(241, 55, 55);" href="xoa-nhom-bai-viet/<?= $val['id'] ?>"><i
                                class="fe-trash"></i></a>
                    </th>
                    <?php } else {?>
                    <th width="50px">
                        <a style="font-size: 20px;" title="Đưa trở lại" href="hoan-tac-nhom-bai-viet/<?= $val['id'] ?>">
                            <i class="fe-rotate-ccw"></i>
                        </a>
                        <a style="font-size: 20px; color:rgb(241, 55, 55);" title="Xoá vĩnh viễn"
                            href="xoa-nhom-bai-viet-vinh-vien/<?= $val['id'] ?>">
                            <i class="fe-trash"></i>
                        </a>

                    </th>
                    <?php }?>
                </tr>
                <?php }?>
                <?php
                if(empty($data['dropDowns'])){
                ?>
                <tr class="text-center">
                    <td colspan="8">Không tìm thấy nhóm bài viết nào.</td>
                </tr>
                <?php }?>
            </tbody>
        </table>
    </div>
</div>
<?php
$currentPage = $data['current_page'];
$totalPages = $data['total_pages'];
?>
<ul class="pagination">
    <li class="page-item <?= $currentPage == 1 ? 'disabled' : '' ?>">
        <a class="page-link" href="nhom-bai-viet?page=<?= $currentPage - 1 ?>&keyword=<?=$data['keyword']?>&status=<?=$data['publish']?>&flag=<?=$data['flag']?>" aria-label="Previous">
            <span aria-hidden="true">«</span>
            <span class="sr-only">Previous</span>
        </a>
    </li>

    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
    <li class="page-item <?= $i == $currentPage ? 'active' : '' ?>">
        <a class="page-link" href="nhom-bai-viet?page=<?= $i ?>&keyword=<?=$data['keyword']?>&status=<?=$data['publish']?>&flag=<?=$data['flag']?>"><?= $i ?></a>
    </li>
    <?php endfor; ?>

    <li class="page-item <?= $currentPage == $totalPages ? 'disabled' : '' ?>">
        <a class="page-link" href="nhom-bai-viet?page=<?= $currentPage + 1 ?>&keyword=<?=$data['keyword']?>&status=<?=$data['publish']?>&flag=<?=$data['flag']?>" aria-label="Next">
            <span aria-hidden="true">»</span>
            <span class="sr-only">Next</span>
        </a>
    </li>
</ul>
