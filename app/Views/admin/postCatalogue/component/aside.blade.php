<div class="form-group col-md-12">
    <label for="" class="col-form-label">Cấu hình nâng cao
        <span class="text-danger">*</span> <br>
    </label>
    <select name="publish" class="form-control mb-2">
        @foreach (config('apps.general.publish') as $key => $val)
            <option {{ old('publish') == $key ? 'selected' : '' }} value="{{ $key }}">{{ $val }}</option>
        @endforeach
    </select>
    
    <select name="follow" class="form-control">
        @foreach (config('apps.general.follow') as $key => $val)
        <option {{ old('follow') == $key ? 'selected' : '' }} value="{{ $key }}">{{ $val }}</option>
        @endforeach
    </select>
</div>