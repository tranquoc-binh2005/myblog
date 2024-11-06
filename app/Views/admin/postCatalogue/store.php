<form class="" action="xu-ly-tao-nhom-bai-viet" method="POST">
    <h4 class="header-title"><?= $sub['postCatalogue']['title']['create'] ?></h4>
    <div class="d-flex gap-10">
        <div class="col-md-10 border-right">
            <div class="ibox col-md-12">
                <h5 class="title">Thông tin chung</h5>
                <hr>
                <?php
                if(isset($errors) && (count($errors) > 0)){
                    foreach ($errors as $error) {
                        echo '<div class="text-danger">- '.$error.'</div>';
                    }
                }
                ?>
                <div class="ibox-content">
                    <?php include 'component/general.php'?>
                </div>
            </div>
            <div class="ibox col-md-12 mt-2">
                <h5 class="title">Cấu hình SEO</h5>
                <hr>
                <?php include 'component/seo.php'?>
            </div>
        </div>

        <div class="col-md-2">
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="" class="col-form-label">Chọn danh mục cha
                        <span class="text-danger">*</span> <br>
                        <span class="text-danger notion">Chọn root nếu không có danh mục cha!</span>
                    </label>
                    <select name="parent_id" class="form-control">
                        <option value="0">Root</option>
                        <?php
                        foreach ($categories as $key => $categories) {
                            # code...
                        }
                        ?>
                        @foreach ($categories as $categories)
                            @php
                                $prefix = str_repeat('|-- ', $item['depth']);
                            @endphp
                            @foreach ($item['category']->postCatalogueLanguages as $val)
                                <option value="{{ $val->post_catalogue_id }}">{{ $prefix . $val->name }}</option>
                            @endforeach
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-row">
                <label for="" class="col-form-label">Avata</label> <br>
                <div class="form-group col-md-12 bg-light text-center">
                    <span class="image img-cover">
                        <img id="ckAvataImg" width="150px" class="image-target"
                            src="serve/assets/images/no_image.jpg"
                            alt="no images">
                    </span>
                    <input type="hidden" id="ckAvata" class="ck-target" name="image" value="{{ old('image') }}">
                </div>
            </div>

            <div class="form-row">
                <?php include 'component/aside.php'?>
            </div>
        </div>
    </div>
    <div class="col-md-12 text-right mb-0">
        <button type="submit" class="btn btn-outline-danger waves-effect waves-light">Tạo nhóm bài viết</button>
    </div>
</form>
