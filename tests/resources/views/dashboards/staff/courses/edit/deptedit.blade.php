@extends('dashboards.staff.layouts.stafflayout')

@section('content')
@if($errors->any())
<div class="fixed top-6 left-1/2 -translate-x-1/2 z-50 bg-red-100 border border-red-400 text-red-700 px-6 py-4 rounded-lg shadow-lg min-w-[320px]">
    <ul class="list-disc pl-5 mb-0 text-sm">
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
    <button onclick="this.parentElement.remove()" class="absolute top-2 right-2 text-red-500 hover:text-red-700 text-xl">&times;</button>
</div>
<script>
    setTimeout(function() {
        let alert = document.querySelector('.bg-red-100');
        if (alert) alert.remove();
    }, 3000);

</script>
@endif

@if(session('success'))
<div class="fixed top-6 left-1/2 -translate-x-1/2 z-50 bg-green-100 border border-green-400 text-green-800 px-6 py-4 rounded-lg shadow-lg min-w-[320px] flex items-center gap-2">
    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
    </svg>
    <span>{{ session('success') }}</span>
    <button onclick="this.parentElement.remove()" class="ml-auto text-green-600 hover:text-green-800 text-xl">&times;</button>
</div>
<script>
    setTimeout(function() {
        let alert = document.querySelector('.bg-green-100');
        if (alert) alert.remove();
    }, 3000);

</script>
@endif

<div class="max-w-xl mx-auto my-12">
    <div class="bg-white shadow-xl rounded-3xl overflow-hidden">
        <div class="bg-gradient-to-r from-blue-700 to-blue-500 px-8 py-6">
            <h2 class="text-2xl md:text-3xl font-bold text-white flex items-center gap-2">
                <i class="fas fa-edit"></i>
                Edit Department: <span class="truncate">{{ $department->name }}</span>
            </h2>
        </div>
        <div class="p-8">
            <form action="{{ route('departments.update', $department) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')
                <div>
                    <label for="name" class="block font-semibold mb-2">Department Name</label>
                    <input type="text" name="name" id="name" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400" value="{{ $department->name }}" required>
                </div>
                <div>
                    <label for="description" class="block font-semibold mb-2">Description</label>
                    <textarea name="description" id="description" rows="4" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400">{{ $department->description }}</textarea>
                </div>
                <div>
                    <label class="block font-semibold mb-2">Current Image</label>
                    @if($department->image)
                    <img src="{{ asset('storage/' . $department->image) }}" alt="Current Image" class="rounded-xl shadow mb-2 max-h-40 object-contain bg-gray-50 border">
                    @else
                    <p class="text-gray-400 italic">No image available.</p>
                    @endif
                </div>
                <div>
                    <label for="image" class="block font-semibold mb-2">Change Image</label>
                    <input type="file" name="image" id="image" class="block w-full text-sm text-gray-700 border border-gray-300 rounded-lg cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <span class="text-xs text-gray-400">Leave blank to keep current image.</span>
                </div>
                <div class="pt-4 flex justify-end">
                    <a href="{{ route('index.departments') }}" class="inline-flex items-center gap-2 bg-yellow-400 hover:bg-yellow-500 text-yellow-900 font-semibold px-8 py-3 rounded-xl shadow transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-yellow-300">
                        <i class="fas fa-list"></i>
                        Manage Departments
                    </a>
                    <button type="submit" class="inline-flex items-center gap-2 bg-blue-700 hover:bg-blue-800 text-white font-semibold px-8 py-3 rounded-xl shadow transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-400">
                        <i class="fas fa-save"></i>
                        Update Department
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>



@endsection
