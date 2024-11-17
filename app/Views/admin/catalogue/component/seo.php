<div class="ibox-content">
    <div class="seo-container">
        <div class="meta_title">
            <?= !empty($data['catalogue']['meta_title']) ? $data['catalogue']['meta_title'] : 'Bạn chưa có tiêu đề SEO' ?>
        </div>
        <div class="meta_keyword">
            <?=(!empty($data['catalogue']['meta_keyword'])) ? $data['catalogue']['meta_keyword'] : 'Bạn chưa có từ khoá SEO'?>
        </div>
        <div class="meta_description">
            <?=(!empty($data['catalogue']['meta_description'])) ? $data['catalogue']['meta_description'] : 'Bạn chưa có mô tả SEO'?>
        </div>
    </div>
    <div class="seo-wrapper">
        <div class="col-md-12">
            <label for="" class="col-form-label">Mô tả SEO
                <span class="count_meta-title">0 kí tự</span>
            </label>
            <input 
                type="text" 
                class="form-control" 
                name="meta_title" 
                placeholder="Nhập mô tả..."
                value="<?=(isset($data['catalogue']['meta_title'])) ? $data['catalogue']['meta_title'] : $data['meta_title']?>"
            >
        </div>

        <div class="col-md-12">
            <label for="" class="col-form-label">Từ khoá SEO</label>
            <input 
                type="text" 
                class="form-control" 
                name="meta_keyword" 
                placeholder="Nhập từ khoá..."
                value="<?=(isset($data['catalogue']['meta_keyword'])) ? $data['catalogue']['meta_keyword'] : $data['meta_keyword']?>"
            >
        </div>

        <div class="col-md-12">
            <label for="" class="col-form-label">Ghi chú SEO
                <span class="count_meta-title">0 kí tự</span>
            </label>
            <textarea 
                type="text" 
                class="form-control" 
                name="meta_description" 
                placeholder="Nhập ghi chú..."
            ><?=(isset($data['catalogue']['meta_description'])) ? $data['catalogue']['meta_description'] : $data['meta_description']?></textarea>
        </div>
    </div>
</div>