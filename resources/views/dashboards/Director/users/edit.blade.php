
@extends('dashboards.Director.layouts.directorlayout')

@section('content')
@if($errors->any())
<div class="alert alert-danger alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3 classy-alert" role="alert" style="z-index: 9999; font-size: small;">
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    <ul>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
<script>
    setTimeout(function() {
        document.querySelector('.classy-alert').remove();
    }, 3000);
</script>
@endif
@if(session('success'))
<div class="position-fixed top-0 start-50 translate-middle-x mt-3 classy-alert" style="z-index: 9999;">
    <div class="alert alert-success d-flex align-items-center justify-content-center" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        {{ session('success') }}
    </div>
</div>
<script>
    setTimeout(function() {
        document.querySelector('.classy-alert').remove();
    }, 3000);
</script>
@endif

<div class="content-body">
    <div class="container">

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Edit User</h4>
                    </div>
                    <div class="card-body">

                        <form action="{{ route('users.update', $users->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" class="form-control" value="{{ $users->name }}" required>
                            </div>

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" class="form-control" value="{{ $users->email }}" required>
                            </div>
                            <div class="form-group">
                                <label for="Username">Username</label>
                                <input type="text" name="username" id="username" class="form-control" value="{{ $users->username }}" required>
                            </div>
                            <div class="form-group">
                                <label for="role">Role</label>
                                <select name="role" id="role" class="form-control" required>
                                    <option value="0" @if($users->role === 0) selected @endif>Director</option>
                                    <option value="1" @if($users->role === 1) selected @endif>Staff</option>
                                    <option value="2" @if($users->role === 2) selected @endif>Student</option>
                                    <option value="3" @if($users->role === 3) selected @endif>Tutor</option>
                                </select>
                            </div>




                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
