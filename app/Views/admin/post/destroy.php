<div class="card-body row">
    <div class="col-md-6">
        <h4 class="header-title"><?= $sub['post']['title']['delete'] ?></h4>
        <p class="text-muted font-13">Bạn có muốn xoá bài viết <span class="text-danger"><?=$data['post']['name']?></span> này không?</p>
        <p class="text-danger">Lưu ý: Đây là hành động không thể hoàn tác!!!</p>
    </div>

    <form action="xoa-bai-viet/<?=$data['post']['id']?>" method="POST" class="col-md-6">
        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="" class="col-form-label">Tên bài viết</label>
                <input 
                    type="text" 
                    name="name" 
                    class="form-control" 
                    readonly
                    value="<?=$data['post']['name']?>"
                >
            </div>
            <div class="form-group col-md-12">
                <label for="" class="col-form-label">Danh mục cha</label>
                <input 
                    type="text" 
                    name="email" 
                    class="form-control" 
                    readonly
                    value="<?=$data['post']['catalogue']?>"
                >
            </div>
        </div>

        <div class="form-group text-right mb-0">
            <button type="submit" class="btn btn-danger waves-effect waves-light">Xoá bài viết</button>
        </div>

    </form>

</div>