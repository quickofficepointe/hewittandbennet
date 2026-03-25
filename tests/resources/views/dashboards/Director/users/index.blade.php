
@extends('dashboards.Director.layouts.directorlayout')

@section('content')
<div class="content-body">
<div class="container">

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">

                    <h4>All users</h4>

                </div>
                <div class="card-body">

                    <table id="myDataTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>

                                <th>Name</th>
                                <th>Email</th>
                                <th>Username</th>
                                <th>Role</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($users as $users)
                            <tr>

                                <td>
                                    {{ $users->name }}
                                </td>
                                <td>
                                    {{ $users->email }}
                                </td>
                                <td>
                                    {{ $users->username }}
                                </td>
                                <td>
                                    @if($users->role == 0)
                                        Director
                                    @elseif($users->role == 1)
                                        Staff
                                        @elseif($users->role == 2)
                                        Student
                                        @elseif($users->role == 3)
                                        Tutor
                                    @endif
                                </td>



                                <td>
                                    <a href="{{ route('users.edit', $users->id) }}" class="btn btn-outline-primary">Edit</a>
                                </td>
                                <td>
                                    <form action="{{ route('users.destroy', $users->id) }}" method="post">
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
</div>
@endsection
