<div class="card-box">
    <h4 class="header-title">{{ $title }}</h4>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
        <li class="breadcrumb-item"><a href="javascript: void(0);">Library</a></li>
    </ol>

    <div class="tools-box col bg-danger mb-4">
        <div class="ul right-0 position">
            <li>
                <p class="dropdown-toggle btn btn-outline-secondary"><i class="fe-settings noti-icon"></i> Tùy chọn</p>
                <ul class="dropdown-menu">
                    <li>
                        <a
                            class="publishAll"
                            data-field="languages"
                            data-column="publish"
                            data-value="2"
                            href="#"
                        >Xuất bản</a>
                    </li>
                    <li>
                        <a
                            class="publishAll"
                            data-field="languages"
                            data-column="publish"
                            data-value="1"
                            href="#"
                        >Huỷ xuất bản</a>
                    </li>
                </ul>
            </li>
        </div>
    </div>

    <form action="{{ route('post.catalogue.index') }}" method="GET">
        <div class="filter-box">
            <a class="btn btn-info" href="{{ route('post.catalogue.store') }}">Thêm ngôn ngữ</a>
            <div class="app-search-box bg-light mr-2">
                <div class="input-group">
                    <input type="text" name="keyword" class="form-control" placeholder="Search..."
                           value="{{ request('keyword') }}">
                    <div class="input-group-append">
                        <button class="btn" type="submit">
                            <i class="fe-search"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="mr-2">
                <select name="status" class="form-control">
                    <option value="-1">Chọn trạng thái bản ghi</option>
                    <option value="1" {{ request('status') == 1 ? 'selected' : '' }}>Publish</option>
                    <option value="2" {{ request('status') == 2 ? 'selected' : '' }}>UnPublish</option>
                </select>
            </div>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
            <tr>
                <th>
                    <input type="checkbox" id="inputCheckAll">
                </th>
                <th>Tên ngôn ngữ</th>
                <th>Flag</th>
                <th>Canonical</th>
                <th>Trạng thái</th>
                <th>#</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($postCatalogues as $postCatalogue)
                <tr class="">
                    <th scope="row">
                        <input
                            type="checkbox"
                            data-id="{{ $postCatalogue->id }}"
                            class="inputCheck"
                            name="checked"
                            id="checked">
                    </th>
                    <td>{{ $postCatalogue->name }}</td>
                    <td>
                        <img width="100px" class="text-center" src="{{ $postCatalogue->image }}" alt="">
                    </td>
                    <td>{{ $postCatalogue->canonical }}</td>
                    <th>
                        <input
                            type="checkbox"
                            {{ ($postCatalogue->publish == 1) ? 'checked' : '' }}
                            data-plugin="switchery"
                            data-color="#64b0f2"
                            data-size="small"
                            data-switchery="true"
                            style="display: none;"
                            class="changeStatusPublish location-{{$postCatalogue->id}}"
                            data-filed="languages"
                            data-column="publish"
                            data-id="{{ $postCatalogue->id }}"
                        >
                    </th>
                    <th>
                        <a style="font-size: 20px;" href="{{ route('post.catalogue.update', ['id' => $postCatalogue->id]) }}"><i
                                class="fe-edit"></i> </a>
                        <a style="font-size: 20px; color:rgb(241, 55, 55);"
                           href="{{ route('post.catalogue.destroy', ['id' => $postCatalogue->id]) }}"><i class="fe-trash"></i></a>
                    </th>
                </tr>
            @endforeach
            @if($postCatalogues->isEmpty())
                <tr>
                    <td colspan="6" class="text-center">Không tìm thấy ngôn ngữ nào.</td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>
</div>
@if (count($postCatalogues) > 10)
    {{ $postCatalogues->links('vendor.pagination.ui-paginate') }}
@endif