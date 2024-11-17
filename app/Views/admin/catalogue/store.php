<?php
// print_r($data);
?>
<form class="" action="<?= $data['method'] ?>" method="POST">
    <h4 class="header-title"><?= $sub['catalogue']['title']['create'] ?></h4>
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
                    <select name="parent_id" class="form-control">
                        <option value="-1">Chọn danh mục cha</option>
                        <?php
                        foreach ($data['dropDowns'] as $key => $dropDown) {
                            $depth = intval($dropDown['depth']) - 1;
                            if($depth >= 0){
                                $prefix = str_repeat('|--', $depth);
                            }
                            $selected = $data['catalogue']['parent_id'] == $dropDown['id'] ? 'selected' : '';
                            echo '<option value="' . $dropDown['id'] . '" ' . $selected . '>' . $prefix . htmlspecialchars($dropDown['name']) . '</option>';
                        }
                        ?>
                    </select>
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
