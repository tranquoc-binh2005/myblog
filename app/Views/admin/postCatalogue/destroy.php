<div class="card-body row">
    <div class="col-md-6">
        <h4 class="header-title">{{ config('apps.title.postCatalogue.title.delete') }}</h4>
        <p class="text-muted font-13">
        Bạn có muốn xoá vai trò <span class="text-danger">{{ $postCatalogue->name }}</span> này không?
        </p>  
        <p>
            Lưu ý: Hành động này không thể hoàn tác!
        </p>
    </div>

    <form action="{{ route('post.catalogue.handleDestroy', ['id' => $postCatalogue->id]) }}" method="POST" class="col-md-6">
        @csrf
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="" class="col-form-label">Tên ngôn ngữ</label>
                <input 
                    type="text" 
                    name="name" 
                    class="form-control" 
                    readonly
                    value="{{ $postCatalogue->name }}"
                >
            </div>
            <div class="form-group col-md-6">
                <label for="" class="col-form-label">Canonical</label>
                <input 
                    type="text" 
                    name="canonical" 
                    class="form-control" 
                    readonly
                    value="{{ $postCatalogue->canonical }}"
                >
            </div>
        </div>

        <div class="form-group text-right mb-0">
            <button type="submit" class="btn btn-danger waves-effect waves-light">Xoá ngôn ngữ</button>
        </div>

    </form>

</div>