<div class="card-body row">
    <div class="col-md-6">
        <h4 class="header-title"><?= $sub['roles']['title']['create'] ?></h4>
        <p class="text-muted font-13">
            Lưu ý: Các truờng <span class="text-danger">*</span> là bắt buộc
        </p>
        <?php
        if(isset($errors) && (count($errors) > 0)){
            foreach ($errors as $error) {
                echo '<div class="text-danger">- '.$error.'</div>';
            }
        }
        ?>
    </div>

    <form action="xu-ly-tao-vai-tro" method="POST" class="col-md-6">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="" class="col-form-label">Tên vai trò
                    <span class="text-danger">*</span>
                </label>
                <input type="text" name="name" class="form-control" placeholder="Nhập vai trò" value="">
            </div>
            <div class="form-group col-md-6">
                <label for="" class="col-form-label">Canonical
                    <span class="text-danger">*</span>
                </label>
                <input type="text" name="canonical" class="form-control" placeholder="Nhập tên rút gọn" value="">
            </div>
            <div class="form-group col-md-12">
                <label for="" class="col-form-label">Ghi chú</label>
                <input type="text" name="description" class="form-control" placeholder="Nhập ghi chú" value="">
            </div>
        </div>

        <div class="form-group text-right mb-0">
            <button type="submit" class="btn btn-danger waves-effect waves-light">Tạo vai trò</button>
        </div>
    </form>
</div>
