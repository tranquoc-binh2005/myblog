<div class="card-body row">
    <div class="col-md-4">
        <h4 class="header-title">{{ config('apps.title.postCatalogue.title.create') }}</h4>
        <p class="text-muted font-13">
        Các truờng <span class="text-danger">*</span> là bắt buộc
        </p>
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div class="text-danger">-{{ $error }}</div>
            @endforeach
        @endif      

    </div>

    <form class="col-md-8" action="{{ route('post.catalogue.handleUpdate',['id' => $postCatalogue->id]) }}" method="POST">
        @csrf
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="" class="col-form-label">Name
                    <span class="text-danger">*</span>
                </label>
                <input 
                    type="text" 
                    class="form-control" 
                    name="name" 
                    placeholder="Name"
                    value="{{ $postCatalogue->name }}"
                >
            </div>
            <div class="form-group col-md-6">
                <label for="" class="col-form-label">Canonical
                    <span class="text-danger">*</span>
                </label>
                <input type="text" class="form-control" name="canonical" value="{{ $postCatalogue->canonical }}" placeholder="Canonical">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="" class="col-form-label">Avata</label>
                <input type="text" class="form-control upload-image" data-type="Images" value="{{ $postCatalogue->image }}" name="image">
            </div>
        </div>

        <div class="form-group text-right mb-0">
            <button type="submit" class="btn btn-danger waves-effect waves-light">Cập nhật ngôn ngữ</button>
        </div>

    </form>

</div>