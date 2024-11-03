<div class="card-body row">
    <div class="col-md-6">
        <h4 class="header-title"><?= $sub['roles']['title']['delete'] ?></h4>
        <p class="text-muted font-13">Bạn có muốn xoá thành viên <span class="text-danger"><?=$data['user']['name']?></span> này không?</p>
        <p class="text-danger">Lưu ý: Đây là hành động không thể hoàn tác!!!</p>
    </div>

    <form action="xoa-thanh-vien/<?=$data['user']['id']?>" method="POST" class="col-md-6">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="" class="col-form-label">Tên thành viên</label>
                <input 
                    type="text" 
                    name="name" 
                    class="form-control" 
                    readonly
                    value="<?=$data['user']['name']?>"
                >
            </div>
            <div class="form-group col-md-6">
                <label for="" class="col-form-label">Email</label>
                <input 
                    type="text" 
                    name="email" 
                    class="form-control" 
                    readonly
                    value="<?=$data['user']['email']?>"
                >
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="" class="col-form-label">Chức vụ thành viên</label>
                <input 
                    type="text" 
                    name="userCatalogue_name" 
                    class="form-control" 
                    readonly
                    value="<?=$data['user']['userCatalogue_name']?>"
                >
            </div>
        </div>

        <div class="form-group text-right mb-0">
            <button type="submit" class="btn btn-danger waves-effect waves-light">Xoá thành viên</button>
        </div>

    </form>

</div>