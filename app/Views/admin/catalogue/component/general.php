<div class="col-md-12">
    <div class="form-row">
        <div class="form-group col-md-12">
            <label for="" class="col-form-label">Tiêu đề bài viết
                <span class="text-danger">*</span>
            </label>
            <input 
                type="text" 
                class="form-control" 
                name="name" 
                placeholder="Nhập tiêu đề"
                value="<?=(isset($data['catalogue']['name'])) ? $data['catalogue']['name'] : $data['name']?>"
            >
        </div>
    </div>
</div>