
@extends('dashboards.staff.layouts.stafflayout')

@section('content')
@if($errors->any())
<div class="alert alert-danger alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3" role="alert" style="z-index: 9999; font-size: small;">
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    <ul>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
<script>
    setTimeout(function() {
        document.querySelector('.alert').remove();
    }, 3000);
</script>
@endif



@if(session('success'))
<div class="position-fixed top-0 start-50 translate-middle-x mt-3" style="z-index: 9999;">
<div class="alert alert-success d-flex align-items-center justify-content-center" role="alert">
    <i class="fas fa-check-circle me-2"></i>
    {{ session('success') }}
</div>
</div>
<script>
setTimeout(function() {
    document.querySelector('.alert').remove();
}, 3000);
</script>
@endif
<div class="container">

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">

                    <h4>All Banners</h4>

                </div>
                <div class="card-body">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#batchModal">
                        Add Banner
                    </button>
                    <table id="myDataTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Status</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($banners as $banner)
                            <tr>
                                <td>{{ $banner->id }}</td>
                                <td>
                                    <img src="{{ $banner->image_path }}" alt="Banner Image" style="max-width: 100px; max-height: 100px;">
                                </td>
                                <td>
                                    @if ($banner->status == 1)
                                        <span class="badge badge-success">On</span>
                                        <form action="{{ route('hewitt_banners.update', $banner->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="0">
                                            <button type="submit" class="btn btn-sm btn-danger">Turn Off</button>
                                        </form>
                                    @else
                                        <span class="badge badge-danger">Off</span>
                                        <form action="{{ route('hewitt_banners.update', $banner->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="1">
                                            <button type="submit" class="btn btn-sm btn-success">Turn On</button>
                                        </form>
                                    @endif
                                </td>


                                <td>
                                    <a href="{{ route('hewitt_banners.edit', $banner->id) }}" class="btn btn-outline-primary">Edit</a>
                                </td>
                                <td>
                                    <form action="{{ route('hewitt_banners.destroy', $banner->id) }}" method="post">
                                        <button class="btn btn-outline-danger" onclick="return confirm('Are you sure?');" type="submit">Delete</button>
                                        @csrf
                                        @method('delete')
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table>



                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="batchModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Hewitt and Bennet International College Banners</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('hewitt_banners.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="image">Banner Image</label>
                        <input type="file" class="form-control-file" id="image" name="image">
                    </div>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </form>

            </div>
        </div>
    </div>
</div>


@endsection
