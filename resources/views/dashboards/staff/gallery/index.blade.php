@extends('dashboards.staff.layouts.stafflayout')

@section('content')
<div class="container">
    <h3 class="mb-4">Gallery</h3>

    <!-- Button to Open Add New Modal -->
    <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#addGalleryModal">
        Add New Gallery Item
    </button>

    <!-- Gallery Table -->
    <div class="table-responsive">
        <table class="table table-bordered" id="galleryTable">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>File</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($galleries as $gallery)
                <tr>
                    <td>{{ $gallery->title }}</td>
                    <td>{{ $gallery->description }}</td>
                    <td>
                        @if ($gallery->file_type == 'image')
                            <img src="{{ asset('storage/' . $gallery->file_path) }}" width="100" height="auto" alt="{{ $gallery->title }}">
                        @else
                            <video width="100" controls>
                                <source src="{{ asset('storage/' . $gallery->file_path) }}" type="video/{{ pathinfo($gallery->file_path, PATHINFO_EXTENSION) }}">
                            </video>
                        @endif
                    </td>
                    <td>
                        <!-- Edit Button -->
                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editGalleryModal{{ $gallery->id }}"
                                data-title="{{ $gallery->title }}"
                                data-description="{{ $gallery->description }}"
                                data-file="{{ asset('storage/' . $gallery->file_path) }}"
                                data-id="{{ $gallery->id }}">Edit</button>
                    </td>
                </tr>

                <!-- Edit Gallery Modal -->
                <div class="modal fade" id="editGalleryModal{{ $gallery->id }}" tabindex="-1" aria-labelledby="editGalleryModalLabel{{ $gallery->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('gallery.update', $gallery->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editGalleryModalLabel{{ $gallery->id }}">Edit Gallery Item</h5>
                                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="editTitle">Title</label>
                                        <input type="text" name="title" id="editTitle" class="form-control" value="{{ $gallery->title }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="editDescription">Description</label>
                                        <textarea name="description" id="editDescription" class="form-control" required>{{ $gallery->description }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="editFile">Upload New Image/Video (Optional)</label>
                                        <input type="file" name="file" id="editFile" class="form-control">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Add Gallery Modal -->
<div class="modal fade" id="addGalleryModal" tabindex="-1" aria-labelledby="addGalleryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('gallery.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addGalleryModalLabel">Add New Gallery Item</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" name="title" id="title" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" class="form-control" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="file">Upload Image/Video</label>
                        <input type="file" name="file" id="file" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
