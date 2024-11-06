<div class="ibox-content">
    <div class="seo-container">
        <div class="meta_title">
            {{ (old('meta-title')) ?? 'Bạn chưa có tiêu đề SEO' }}
        </div>
        <div class="canonical">
            {{ (old('canonical')) ? config('app.url').(old('canonical')).config('apps.general.suffix') : 'https://duong-dan-cua-ban.html' }}
        </div>
        <div class="meta_description">
            {{ (old('meta_description')) ?? 'Bạn chưa có mô tả SEO' }}
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
                value="{{ old('meta_title') }}"
            >
        </div>

        <div class="col-md-12">
            <label for="" class="col-form-label">Từ khoá SEO</label>
            <input 
                type="text" 
                class="form-control" 
                name="meta_keyword" 
                placeholder="Nhập từ khoá..."
                value="{{ old('meta_keyword') }}"
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
                value="{{ old('meta_description') }}"
            >{{ old('meta_description') }}</textarea>
        </div>

        <div class="col-md-12">
            <label for="" class="col-form-label">Đường dẫn
                <span class="text-danger">*</span>
            </label>
            <input 
                type="text" 
                class="form-control input-wapper" 
                name="canonical" 
                value="{{ old('canonical') }}"
            >
            <span class="baseUrl">{{ config('app.url') }}</span>
        </div>
    </div>
</div>