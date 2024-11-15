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
                value="<?=(isset($data['postCatalogue']['name'])) ? $data['postCatalogue']['name'] : $data['name']?>"
            >
        </div>
    </div>
</div>

<div class="col-md-12">
    <div class="form-row">
        <div class="form-group col-md-12">
            <label for="" class="col-form-label">Mô tả ngắn</label>
            <textarea
                type="text" 
                class="form-control ck-editor"
                id="description" 
                name="description" 
                placeholder="Nhập mô tả..."
                value="{{ old('description') }}"
                data-height=""
            ><?=(isset($data['postCatalogue']['description'])) ? $data['postCatalogue']['description'] : $data['description']?></textarea>
        </div>
    </div>
</div>

<div class="col-md-12">
    <div class="form-row">
        <div class="form-group col-md-12">
            <label for="" class="col-form-label">Nội dung</label>
            <textarea 
                type="text" 
                class="form-control ck-editor" 
                name="content" 
                placeholder="Nhập nội dung..."
                value="{{ old('content') }}"
                data-height="500"
            ><?=(isset($data['postCatalogue']['content'])) ? $data['postCatalogue']['content'] : $data['content']?></textarea>
        </div>
    </div>
</div>