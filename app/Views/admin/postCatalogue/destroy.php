<div class="card-body row">
    <div class="col-md-6">
        <h4 class="header-title"><?= $sub['postCatalogue']['title']['delete'] ?></h4>
        <p class="text-muted font-13">Bạn có muốn xoá nhóm bài viết <span class="text-danger"><?=$data['postCatalogue']['name']?></span> này không?</p>
        <p class="text-danger">Lưu ý: Đây là hành động không thể hoàn tác!!!</p>
    </div>

    <form action="xoa-nhom-bai-viet/<?=$data['postCatalogue']['id']?>" method="POST" class="col-md-6">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="" class="col-form-label">Tên nhóm bài viết</label>
                <input 
                    type="text" 
                    name="name" 
                    class="form-control" 
                    readonly
                    value="<?=$data['postCatalogue']['name']?>"
                >
            </div>
            <div class="form-group col-md-6">
                <label for="" class="col-form-label">Đường dẫn</label>
                <input 
                    type="text" 
                    name="email" 
                    class="form-control" 
                    readonly
                    value="<?=$data['postCatalogue']['canonical']?>.html"
                >
            </div>
        </div>

        <div class="form-group text-right mb-0">
            <button type="submit" class="btn btn-danger waves-effect waves-light">Xoá nhóm bài viết</button>
        </div>

    </form>

</div>