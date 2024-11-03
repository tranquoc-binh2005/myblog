<div class="card-body row">
    <div class="col-md-4">
        <h4 class="header-title"><?= $sub['language']['title']['create'] ?></h4>
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
    <form class="col-md-8" action="xu-ly-tao-ngon-ngu" method="POST">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="" class="col-form-label">Ngôn ngữ
                    <span class="text-danger">*</span>
                </label>
                <input 
                    type="text" 
                    class="form-control" 
                    name="name" 
                    placeholder="Name"
                    value=""
                >
            </div>
            <div class="form-group col-md-6">
                <label for="" class="col-form-label">Canonical
                    <span class="text-danger">*</span>
                </label>
                <input type="text" class="form-control" name="canonical" value="" placeholder="canonical">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="" class="col-form-label">Hình ảnh
                    <span class="text-danger">*</span>
                </label>
                <input type="text" class="form-control" name="image" placeholder="image">
            </div>
        </div>

        <div class="form-group text-right mb-0">
            <button type="submit" class="btn btn-danger waves-effect waves-light">Tạo bản ghi</button>
        </div>

    </form>

</div>