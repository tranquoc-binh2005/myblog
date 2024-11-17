<div class="col-md-12">
    <div class="form-row">
        <div class="form-group col-md-12">
            <label for="" class="col-form-label">Tiêu đề sản phẩm
                <span class="text-danger">*</span>
            </label>
            <input 
                type="text" 
                class="form-control" 
                name="name" 
                placeholder="Nhập tiêu đề"
                value="<?=(isset($data['product']['name'])) ? $data['product']['name'] : $data['name']?>"
            >
        </div>
    </div>
</div>

<div class="col-md-12">
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="" class="col-form-label">Giá sản phẩm</label>
            <input 
                type="number" 
                class="form-control" 
                name="price" 
                placeholder="Nhập giá"
                value="<?=(isset($data['product']['price'])) ? $data['product']['price'] : $data['price']?>"
            >
        </div>

        <div class="form-group col-md-6">
            <label for="" class="col-form-label">Phần trăm giảm giá</label>
            <input 
                type="number" 
                min = "0"
                max = "100"
                class="form-control" 
                name="sale" 
                placeholder="Nhập %"
                value="<?=(isset($data['product']['sale'])) ? $data['product']['sale'] : $data['sale']?>"
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
            ><?=(isset($data['product']['description'])) ? $data['product']['description'] : $data['description']?></textarea>
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
            ><?=(isset($data['product']['content'])) ? $data['product']['content'] : $data['content']?></textarea>
        </div>
    </div>
</div>