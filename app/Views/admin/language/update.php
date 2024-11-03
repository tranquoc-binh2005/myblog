<div class="card-body row">
    <div class="col-md-6">
        <h4 class="header-title"><?= $sub['language']['title']['update'] ?></h4>
        <p class="text-muted font-13">
        Các truờng <span class="text-danger">*</span> là bắt buộc
        </p>
        <?php
        if(isset($errors) && (count($errors) > 0)){
            foreach ($errors as $error) {
                echo '<div class="text-danger">- '.$error.'</div>';
            }
        }
        ?>    

    </div>

    <form action="sua-ngon-ngu/<?=$data['language']['id']?>" method="POST" class="col-md-6">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="" class="col-form-label">Tên vai trò
                    <span class="text-danger">*</span>
                </label>
                <input 
                    type="text" 
                    name="name" 
                    class="form-control" 
                    id="" placeholder="Nhập vai trò"
                    value="<?=$data['language']['name']?>"
                >
            </div>
            <div class="form-group col-md-6">
                <label for="" class="col-form-label">Canonical
                    <span class="text-danger">*</span>
                </label>
                <input 
                    type="text" 
                    name="canonical" 
                    class="form-control" 
                    id="" 
                    placeholder="Nhập tên rút gọn" 
                    value="<?=$data['language']['canonical']?>"
                >
            </div>
            <div class="form-group col-md-12">
                <label for="" class="col-form-label">Hình ảnh</label>
                <input 
                    type="text" 
                    name="image" 
                    class="form-control" 
                    id="" 
                    placeholder="Nhập ghi chú" 
                    value="<?=$data['language']['image']?>"
                >
            </div>
        </div>

        <div class="form-group text-right mb-0">
            <button type="submit" class="btn btn-danger waves-effect waves-light">Cập nhật vai trò</button>
        </div>

    </form>

</div>