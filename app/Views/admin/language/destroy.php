<div class="card-body row">
    <div class="col-md-6">
        <h4 class="header-title"><?= $sub['roles']['title']['delete'] ?></h4>
        <p class="text-muted font-13">Bạn có muốn xoá ngôn ngữ <span class="text-danger"><?=$data['language']['name']?></span> này không?</p>
        <p class="text-danger">Lưu ý: Đây là hành động không thể hoàn tác!!!</p>
    </div>

    <form action="xoa-ngon-ngu/<?=$data['language']['id']?>" method="POST" class="col-md-6">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="" class="col-form-label">Tên ngôn ngữ</label>
                <input 
                    type="text" 
                    name="name" 
                    class="form-control" 
                    readonly
                    value="<?=$data['language']['name']?>"
                >
            </div>
            <div class="form-group col-md-6">
                <label for="" class="col-form-label">Canonical</label>
                <input 
                    type="text" 
                    name="canonical" 
                    class="form-control" 
                    readonly
                    value="<?=$data['language']['canonical']?>"
                >
            </div>
        </div>

        <div class="form-group text-right mb-0">
            <button type="submit" class="btn btn-danger waves-effect waves-light">Xoá ngôn ngữ</button>
        </div>

    </form>

</div>