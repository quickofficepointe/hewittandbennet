@extends('layouts.welcomelayout')

@section('content')
<div class="container">
    <form action="{{ route('submit-application') }}" method="post" enctype="multipart/form-data" class="form">
        @csrf
        <div class="form-group">
            <label for="name">Full Name</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="institution">Your Institution</label>
            <input type="text" name="institution" id="institution" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="department">Department You Want to Be Attached</label>
            <input type="text" name="department" id="department" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="course">Your Course</label>
            <input type="text" name="course" id="course" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="email">Your Email Address</label>
            <input type="text" name="email" id="email" class="form-control" required>
        </div>
        <!-- Add other form fields (name, institution, email, course) here -->
        <div class="form-group">
            <label for="document">Combined Document (PDF)</label>
            <input type="file" name="document" id="document" class="form-control-file" required accept=".pdf">
        </div>

        <button type="submit" class="btn btn-primary">Submit Application</button>
    </form>
</div>
@endsection
