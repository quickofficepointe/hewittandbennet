@extends('dashboards.student.layouts.studentlayouts')

@section('content')
    <div class="container">
        <h1>Unit Management</h1>
        <a href="{{ route('units.create') }}">Create New Unit</a>
        <ul>
            @foreach ($units as $unit)
                <li>
                    {{ $unit->name }}
                    <a href="{{ route('units.edit', $unit->id) }}">Edit</a>
                    <form action="{{ route('units.destroy', $unit->id) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Delete</button>
                    </form>
                </li>
            @endforeach
        </ul>
    </div>
@endsection
