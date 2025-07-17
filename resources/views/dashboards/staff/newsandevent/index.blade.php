@extends('dashboards.staff.layouts.stafflayout')

@section('content')
<div class="container">
    <h3 class="mb-4">Published News & Events</h3>

    <!-- Button to Open the Create Modal -->
    <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#createModal">
        Add News/Event
    </button>

    <!-- Table to Display Published News & Events -->
    <div class="table-responsive">
        <table class="table table-bordered" id="publishednewsandevent">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Slug</th>
                    <th>Cover Image</th>
                    <th>Content</th>
                    <th>Author</th>
                    <th>Published At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($newsEvents as $event)
                <tr>
                    <td>{{ $event->title }}</td>
                    <td>{{ $event->slug }}</td>
                    <td>
                        @if ($event->cover_image)
                        <img src="{{ asset('storage/' . $event->cover_image) }}" alt="Cover Image" style="width: 100px;">
@endif

                    </td>
                    <td>{!! Str::limit($event->content, 50) !!}</td>
                    <td>{{ $event->user->name }}</td>
                    <td>{{ $event->created_at->format('d/m/Y') }}</td>
                    <td>
                        <!-- Edit Button to Open Edit Modal -->
                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editModal{{ $event->id }}">
                            Edit
                        </button>
                    </td>
                </tr>

                <!-- Edit Modal for Each News/Event -->
                <div class="modal fade" id="editModal{{ $event->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel{{ $event->id }}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel{{ $event->id }}">Edit News/Event</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="{{ route('newsandevent.update', $event->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="title">Title</label>
                                        <input type="text" name="title" class="form-control" value="{{ $event->title }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="cover_image">Cover Image</label>
                                        <input type="file" name="cover_image" class="form-control-file">
                                        @if ($event->cover_image)
                                            <small>Current Image: {{ $event->cover_image }}</small>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="content">Content</label>
                                        <textarea name="content" id="content" class="form-control" rows="4" required>{{ $event->content }}</textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
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

<!-- Create Modal -->
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Add News/Event</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('newsandevent.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="cover_image">Cover Image</label>
                        <input type="file" name="cover_image" class="form-control-file">
                    </div>

                    <div class="form-group">
                        <label for="content">Content</label>
                        <textarea name="content" id="content1" class="form-control" rows="5" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Publish</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
