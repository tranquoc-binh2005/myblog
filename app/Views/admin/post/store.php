<form class="" action="<?= $data['method'] ?>" method="POST">
    <h4 class="header-title"><?= $sub['post']['title']['create'] ?></h4>
    <div class="d-flex gap-10">
        <div class="col-md-10 border-right">
            <div class="ibox col-md-12">
                <h5 class="title">Thông tin chung</h5>
                <hr>
                <?php
                if (isset($errors) && count($errors) > 0) {
                    foreach ($errors as $error) {
                        echo '<div class="text-danger">- ' . $error . '</div>';
                    }
                }
                ?>
                <div class="ibox-content">
                    <?php include 'component/general.php'; ?>
                </div>
                <div class="ibox-content">
                    <?php include 'component/album.php'; ?>
                </div>
            </div>
            <div class="ibox col-md-12 mt-2">
                <h5 class="title">Cấu hình SEO</h5>
                <hr>
                <?php include 'component/seo.php'; ?>
            </div>
        </div>

        <div class="col-md-2">
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="" class="col-form-label">Chọn danh mục cha
                        <span class="text-danger">*</span> <br>
                        <span class="text-danger notion">Chọn root nếu không có danh mục cha!</span>
                    </label>
                    <select name="post_catalogue_id" class="form-control select-2">
                        <option value="-1">Chọn danh mục cha</option>
                        <?php
                        foreach ($data['dropDowns'] as $key => $dropDown) {
                            $depth = intval($dropDown['depth']) - 1;
                            if ($depth >= 0) {
                                $prefix = str_repeat('|--', $depth);
                            }
                            $selected = $data['post']['parent_id'] == $dropDown['id'] ? 'selected' : '';
                            echo '<option value="' . $dropDown['id'] . '" ' . $selected . '>' . $prefix . htmlspecialchars($dropDown['name']) . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-12">
                    <label for="" class="col-form-label">Chọn danh mục phụ
                        <span class="text-danger">*</span> <br>
                    </label>
                    <select name="catalogue[]" class="form-control select-2" multiple="">
                        <?php
                        if (isset($data['catalogue']) && !empty($data['catalogue'])) {
                            foreach ($data['catalogue'] as $val) {
                                foreach ($data['dropDowns'] as $key => $dropDown) {
                                    $depth = intval($dropDown['depth']) - 1;
                                    $prefix = '';
                                    if ($depth >= 0) {
                                        $prefix = str_repeat('|--', $depth);
                                    }
                                    $selected = $val == $dropDown['id'] ? 'selected' : '';
                                    echo '<option value="' . $dropDown['id'] . '" ' . $selected . '>' . $prefix . htmlspecialchars($dropDown['name']) . '</option>';
                                }
                            }
                        }
                        else {
                            foreach ($data['dropDowns'] as $key => $dropDown) {
                                $depth = intval($dropDown['depth']) - 1;
                                $prefix = '';
                                if ($depth >= 0) {
                                    $prefix = str_repeat('|--', $depth);
                                }
                                echo '<option value="' . $dropDown['id'] . '">' . $prefix . htmlspecialchars($dropDown['name']) . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <label for="" class="col-form-label">Avata</label> <br>
                <div class="form-group col-md-12 bg-light text-center">
                    <span class="image img-cover">
                        <img id="ckAvataImg" width="150px" class="image-target"
                            src="<?= isset($data['post']['image']) && !empty($data['post']['image']) ? $data['post']['image'] : 'serve/assets/images/no_image.jpg' ?>"
                            alt="no images">
                    </span>
                    <input type="hidden" id="ckAvata" class="ck-target" name="image"
                        value="<?= $data['post']['image'] ?>">
                </div>
            </div>

            <div class="form-row">
                <?php include 'component/aside.php'; ?>
            </div>
        </div>
    </div>
    <div class="col-md-12 text-right mb-0">
        <button type="submit" class="btn btn-outline-danger waves-effect waves-light">Lưu lại</button>
    </div>
</form>
