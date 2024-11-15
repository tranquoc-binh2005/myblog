<div class="ibox-content">
    <div class="seo-container">
        <div class="meta_title">
            <?= !empty($data['post']['meta_title']) ? $data['post']['meta_title'] : 'Bạn chưa có tiêu đề SEO' ?>
        </div>
        <div class="canonical">
            <?=(!empty($data['post']['canonical'])) ? 'http://localhost/myblog/public/'.$data['post']['canonical'].'.html' : 'https://duong-dan-cua-ban.html'?>
        </div>
        <div class="meta_description">
            <?=(!empty($data['post']['meta_description'])) ? $data['post']['meta_description'] : 'Bạn chưa có mô tả SEO'?>
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
                value="<?=(isset($data['post']['meta_title'])) ? $data['post']['meta_title'] : $data['meta_title']?>"
            >
        </div>

        <div class="col-md-12">
            <label for="" class="col-form-label">Từ khoá SEO</label>
            <input 
                type="text" 
                class="form-control" 
                name="meta_keyword" 
                placeholder="Nhập từ khoá..."
                value="<?=(isset($data['post']['meta_keyword'])) ? $data['post']['meta_keyword'] : $data['meta_keyword']?>"
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
            ><?=(isset($data['post']['meta_description'])) ? $data['post']['meta_description'] : $data['meta_description']?></textarea>
        </div>

        <div class="col-md-12">
            <label for="" class="col-form-label">Đường dẫn
                <span class="text-danger">*</span>
            </label>
            <input 
                type="text" 
                class="form-control input-wapper" 
                name="canonical" 
                value="<?=(isset($data['post']['canonical'])) ? $data['post']['canonical'] : $data['canonical']?>"
            >
            <span class="baseUrl"><?=$GLOBALS['config']['rootPath']?></span>
        </div>
    </div>
</div>