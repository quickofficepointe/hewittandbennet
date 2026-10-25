@extends('layouts.welcomelayout')

@php
    use Illuminate\Support\Str;
    $summary = Str::limit(strip_tags($course->course_description), 160);
    $total = (float) $course->registration_fees + (float) $course->school_fees + (float) $course->school_uniform_fee;
    $fees = array_filter([
        'Registration Fee' => (float) $course->registration_fees,
        'Tuition Fees' => (float) $course->school_fees,
        'Uniform Fee' => (float) $course->school_uniform_fee,
    ]);
@endphp

@section('meta-title', $course->name.' | Hewitt & Bennet International College')
@section('meta-description', $summary)
@section('meta-keywords', $course->name.', '.($course->department->name ?? 'Professional').', TVET, Kenya, Hewitt Bennet')
@section('og:type', 'article')
@if ($course->image)
    @section('og:image', asset('storage/'.$course->image))
@endif

@section('content')
<section class="bg-hbNavy text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-12">
        <nav class="text-sm text-white/60 mb-4" aria-label="Breadcrumb">
            <a href="{{ url('/') }}" class="hover:text-white">Home</a> <span class="mx-2">/</span>
            <a href="{{ route('courses.all') }}" class="hover:text-white">Courses</a> <span class="mx-2">/</span>
            <span class="text-white">{{ $course->name }}</span>
        </nav>
        <p class="text-xs font-bold uppercase tracking-[0.2em] text-hbGold">{{ $course->department->name ?? 'Professional Program' }}</p>
        <h1 class="font-serif text-3xl md:text-4xl font-black mt-2">{{ $course->name }}</h1>
        <div class="flex flex-wrap gap-3 mt-5 text-sm">
            @if ($course->duration)<span class="bg-white/10 rounded-full px-4 py-1.5"><i class="fa-regular fa-clock mr-2 text-hbGold"></i>{{ $course->duration }}</span>@endif
            @if ($course->level)<span class="bg-white/10 rounded-full px-4 py-1.5"><i class="fa-solid fa-layer-group mr-2 text-hbGold"></i>{{ $course->level }}</span>@endif
            @if ($course->examining_body)<span class="bg-white/10 rounded-full px-4 py-1.5"><i class="fa-solid fa-award mr-2 text-hbGold"></i>{{ $course->examining_body }}</span>@endif
        </div>
    </div>
</section>

<section class="py-14 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 grid lg:grid-cols-3 gap-10 items-start">
        <div class="lg:col-span-2 space-y-8">
            <img src="{{ $course->image ? asset('storage/'.$course->image) : asset('images/placeholder.webp') }}" alt="{{ $course->name }}"
                 class="w-full max-h-[420px] object-cover rounded-xl shadow-md bg-white">
            <div class="bg-white rounded-xl shadow-sm border p-6 sm:p-8">
                <h2 class="text-xl font-black text-hbNavy uppercase mb-4">About this Course</h2>
                <div class="text-gray-700 leading-relaxed space-y-4">{!! nl2br(e($course->course_description)) !!}</div>
            </div>
        </div>

        <aside class="lg:sticky lg:top-28 space-y-6">
            <div class="bg-white rounded-xl shadow-lg border-t-4 border-hbRed p-6">
                <h2 class="text-lg font-black text-hbNavy uppercase mb-4">Fees</h2>
                @if ($fees)
                    <dl class="space-y-3 text-sm">
                        @foreach ($fees as $label => $amount)
                            <div class="flex justify-between border-b pb-2"><dt class="text-gray-600">{{ $label }}</dt><dd class="font-semibold text-hbNavy">KES {{ number_format($amount) }}</dd></div>
                        @endforeach
                        <div class="flex justify-between pt-1"><dt class="font-bold">Total</dt><dd class="font-black text-hbNavy text-lg">KES {{ number_format($total) }}</dd></div>
                    </dl>
                @else
                    <p class="text-sm text-gray-600">Contact our admissions team for the current fees for this course.</p>
                @endif
                <button type="button" onclick="openEnrollModal({{ $course->id }})" class="mt-6 w-full bg-hbRed text-white py-3 rounded-md font-black uppercase text-sm hover:bg-red-700 transition">
                    <i class="fa-solid fa-user-graduate mr-2"></i>Apply for this Course
                </button>
                <a href="https://wa.me/{{ config('college.whatsapp') }}?text={{ rawurlencode('Hello, I would like to know more about '.$course->name.'.') }}" target="_blank" rel="noopener"
                   class="mt-3 w-full inline-flex justify-center items-center gap-2 border-2 border-[#25D366] text-[#128C7E] py-2.5 rounded-md font-bold text-sm hover:bg-[#25D366] hover:text-white transition">
                    <i class="fa-brands fa-whatsapp text-lg"></i> Ask on WhatsApp
                </a>
                <p class="text-xs text-gray-500 mt-4">Fees are subject to change. Monthly intakes – limited seats per class.</p>
            </div>
        </aside>
    </div>
</section>

@if ($relatedCourses->isNotEmpty())
    <section class="py-14 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <h2 class="text-2xl font-black text-hbNavy uppercase mb-8">Related Courses</h2>
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($relatedCourses as $related)
                    <a href="{{ route('course.single', $related->slug) }}" class="group bg-white border rounded-xl overflow-hidden hover:shadow-lg transition">
                        <img src="{{ $related->image ? asset('storage/'.$related->image) : asset('images/placeholder.webp') }}" alt="" class="w-full h-44 object-cover" loading="lazy">
                        <div class="p-5">
                            <h3 class="font-bold text-hbNavy group-hover:text-hbRed transition">{{ $related->name }}</h3>
                            <p class="text-xs text-gray-500 mt-1">{{ $related->duration }}</p>
                            <span class="text-sm font-bold text-hbRed mt-3 inline-block">View details →</span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
@endif

<section class="py-14 bg-hbNavy text-white text-center">
    <div class="max-w-3xl mx-auto px-4">
        <h2 class="text-2xl md:text-3xl font-black">Ready to Start Your Journey?</h2>
        <p class="text-white/80 mt-3">Join the graduates building careers in Kenya and abroad with Hewitt &amp; Bennet.</p>
        <div class="flex flex-wrap justify-center gap-3 mt-8">
            <a href="{{ route('application.form') }}" class="bg-hbRed text-white px-8 py-3 rounded-md font-black uppercase text-sm hover:bg-red-700 transition">Full Application Form</a>
            <a href="{{ route('courses.all') }}" class="bg-white text-hbNavy px-8 py-3 rounded-md font-black uppercase text-sm hover:bg-gray-100 transition">Browse All Courses</a>
        </div>
    </div>
</section>

@include('frontendviews.partials.enroll-modal')
@endsection
