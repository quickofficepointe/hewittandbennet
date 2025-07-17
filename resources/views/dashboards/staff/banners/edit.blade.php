
@extends('dashboards.staff.layouts.stafflayout')

@section('content')

<!-- Update Banner Form -->
<form action="{{ route('hewitt_banners.update', $banner->id) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('patch')

    <div class="form-group">
        <label for="current_image">Current Image:</label>
        <p>{{ $banner->image_name }}</p>
    </div>

    <div class="form-group">
        <label for="image">New Image:</label>
        <input type="file" name="image" id="image" class="form-control">
    </div>

    <div class="form-group">
        <label for="status">Status:</label>
        <select name="status" id="status" class="form-control">
            <option value="1" {{ $banner->status ? 'selected' : '' }}>On</option>
            <option value="0" {{ !$banner->status ? 'selected' : '' }}>Off</option>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Update Banner</button>
</form>


@endsection
