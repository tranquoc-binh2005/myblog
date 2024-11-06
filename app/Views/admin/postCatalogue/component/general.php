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
                value="{{ old('name') }}"
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
            >{{ old('description') }}</textarea>
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
            >{{ old('content') }}</textarea>
        </div>
    </div>
</div>