<div class="card-body row">
    <div class="col-md-4">
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
    <form class="col-md-8" action="xu-ly-tao-thanh-vien" method="POST">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="" class="col-form-label">Name
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
                <label for="" class="col-form-label">Email
                    <span class="text-danger">*</span>
                </label>
                <input type="email" class="form-control" name="email" value="" placeholder="Email">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="" class="col-form-label">Password
                    <span class="text-danger">*</span>
                </label>
                <input type="password" class="form-control" name="password" placeholder="Password">
            </div>
            <div class="form-group col-md-6">
                <label for="" class="col-form-label">Re_Password
                    <span class="text-danger">*</span>
                </label>
                <input type="password" class="form-control" name="re_password" placeholder="Re_Password">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="" class="col-form-label">Địa chỉ</label>
                <input type="text" class="form-control" value="" name="address">
            </div>
            <div class="form-group col-md-3">
                <label for="" class="col-form-label">Số điện thoại</label>
                <input type="number" min="0" value="" class="form-control" name="phone">
            </div>
            <div class="form-group col-md-3">
                <label for="" class="col-form-label">Vai trò
                    <span class="text-danger">*</span>
                </label>
                <select name="userCatalogue_id" class="form-control">
                    <option value="">Chọn vai trò</option>
                        <?php  
                            foreach ($data['userCatalogues'] as $key => $userCatalogue) {
                        ?>
                        <option value="<?=$userCatalogue['id']?>"><?=$userCatalogue['name']?></option>
                        <?php }?>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="" class="col-form-label">Ghi chú</label>
            <input type="text" value="" class="form-control" name="description" placeholder="Đôi nét về bạn...">
        </div>

        <div class="form-group">
            <label for="" class="col-form-label">Avata</label>
            <input type="text" id="ckAvata" value="" class="form-control upload-image" data-type="Images" name="image" placeholder="Đôi nét về bạn...">
        </div>      

        <div class="form-group text-right mb-0">
            <button type="submit" class="btn btn-danger waves-effect waves-light">Tạo người dùng</button>
        </div>

    </form>

</div>