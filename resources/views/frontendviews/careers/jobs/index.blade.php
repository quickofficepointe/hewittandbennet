@extends('layouts.welcomelayout')

@section('meta-title', 'Careers - Hewitt and Bennet International College')
@section('meta-description', 'Join the team at Hewitt and Bennet International College. View open positions and apply online.')

@section('inline-flash', '1')

@section('content')
<section class="bg-primary text-white py-14">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl md:text-4xl font-bold">Careers at HBIC</h1>
        <p class="mt-3 text-brand-100 max-w-2xl">We are always looking for passionate trainers and professionals to help us shape the next generation of health, hospitality and aviation experts.</p>
    </div>
</section>

<section class="py-12 bg-gray-50" x-data="{ vacancy: '{{ old('job_vacancy_id') }}' }">
    <div class="container mx-auto px-4 grid gap-8 lg:grid-cols-3">
        <div class="lg:col-span-2 space-y-4">
            @if (session('success'))
                <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-green-800">{{ session('success') }}</div>
            @endif
            <h2 class="text-2xl font-semibold text-primary">Open positions</h2>
            @forelse ($vacancies as $vacancy)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6" x-data="{ open: false }">
                    <div class="flex flex-wrap justify-between gap-3">
                        <div>
                            <h3 class="text-lg font-semibold">{{ $vacancy->title }}</h3>
                            <div class="text-sm text-gray-500 mt-1">
                                {{ $vacancy->department?->name ?? 'General' }} &middot; {{ \App\Models\Employee::TYPES[$vacancy->employment_type] }}
                                @if ($vacancy->location) &middot; {{ $vacancy->location }} @endif
                                &middot; Closes {{ $vacancy->closing_date?->format('d M Y') ?? 'when filled' }}
                            </div>
                        </div>
                        <div class="flex gap-2 items-start">
                            <button @click="open = !open" class="text-primary text-sm hover:underline" x-text="open ? 'Hide details' : 'View details'"></button>
                            <a href="#apply" @click="vacancy = '{{ $vacancy->id }}'" class="bg-secondary text-white text-sm px-4 py-2 rounded-lg hover:bg-red-700">Apply</a>
                        </div>
                    </div>
                    <div x-show="open" x-cloak class="mt-4 text-sm text-gray-700 space-y-3">
                        <div class="whitespace-pre-line">{{ $vacancy->description }}</div>
                        @if ($vacancy->requirements)
                            <div><div class="font-semibold mb-1">Requirements</div><div class="whitespace-pre-line">{{ $vacancy->requirements }}</div></div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-xl border border-gray-200 p-8 text-center text-gray-500">
                    There are no open positions right now. You can still send us a general application.
                </div>
            @endforelse

            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <h3 class="font-semibold">Looking for industrial attachment?</h3>
                <p class="text-sm text-gray-600 mt-1">Students from other institutions can apply for attachment placement.</p>
                <a href="{{ route('index.attachment') }}" class="inline-block mt-3 text-primary font-medium hover:underline">Apply for attachment &rarr;</a>
            </div>
        </div>

        <div id="apply" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 h-fit">
            <h2 class="text-xl font-semibold text-primary mb-4">Apply</h2>
            @if ($errors->any())
                <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-3 py-2 text-sm text-red-700">
                    @foreach ($errors->all() as $error)<div>{{ $error }}</div>@endforeach
                </div>
            @endif
            <form action="{{ route('submit-japplication') }}" method="post" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium mb-1" for="job_vacancy_id">Position</label>
                    <select name="job_vacancy_id" id="job_vacancy_id" x-model="vacancy" class="w-full rounded-lg border border-gray-300 px-3 py-2 bg-white">
                        <option value="">General application</option>
                        @foreach ($vacancies as $vacancy)<option value="{{ $vacancy->id }}">{{ $vacancy->title }}</option>@endforeach
                    </select>
                </div>
                <div x-show="vacancy === ''">
                    <label class="block text-sm font-medium mb-1" for="position">Role you are interested in</label>
                    <input type="text" name="position" id="position" value="{{ old('position') }}" class="w-full rounded-lg border border-gray-300 px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1" for="name">Full name *</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required class="w-full rounded-lg border border-gray-300 px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1" for="email">Email *</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required class="w-full rounded-lg border border-gray-300 px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1" for="phone">Phone *</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone') }}" required class="w-full rounded-lg border border-gray-300 px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1" for="cover_letter">Cover letter</label>
                    <textarea name="cover_letter" id="cover_letter" rows="4" class="w-full rounded-lg border border-gray-300 px-3 py-2">{{ old('cover_letter') }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1" for="cv">CV (PDF or Word, max 5MB) *</label>
                    <input type="file" name="cv" id="cv" required accept=".pdf,.doc,.docx" class="w-full text-sm">
                </div>
                <button type="submit" class="w-full bg-primary text-white py-2.5 rounded-lg hover:bg-brand-900 font-medium">Submit application</button>
            </form>
        </div>
    </div>
</section>
@endsection
