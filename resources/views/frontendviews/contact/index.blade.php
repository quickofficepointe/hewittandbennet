@extends('layouts.welcomelayout')

@section('meta-title', 'Contact Us | Hewitt & Bennet International College')
@section('meta-description', 'Contact Hewitt & Bennet International College admissions by phone, WhatsApp or email, or visit our Ngong, Buruburu, Thika and Ongata Rongai campuses.')

@section('content')
<section class="bg-hbNavy text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-14">
        <nav class="text-sm text-white/60 mb-3" aria-label="Breadcrumb"><a href="{{ url('/') }}" class="hover:text-white">Home</a> <span class="mx-2">/</span> <span class="text-white">Contact</span></nav>
        <h1 class="font-serif text-3xl md:text-4xl font-black">Contact Us</h1>
        <p class="mt-3 text-white/80 max-w-2xl">Questions about courses, fees, admissions or studying and working abroad? Reach out – we respond within one working day.</p>
    </div>
</section>

<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 grid md:grid-cols-2 gap-10">
        @include('frontendviews.partials.contact-details')
        @include('frontendviews.partials.contact-form')
    </div>
</section>

<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <h2 class="text-2xl font-black text-hbNavy uppercase mb-8">Find Our Campuses</h2>
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach (config('college.campuses') as $campus)
                <div class="bg-white border rounded-xl p-5">
                    <h3 class="font-black text-hbNavy">{{ $campus['name'] }}</h3>
                    <p class="text-sm text-gray-600 mt-2"><i class="fa-solid fa-location-dot text-hbRed mr-1"></i>{{ $campus['address'] }}, {{ $campus['county'] }}</p>
                    <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode('Hewitt and Bennet International College '.$campus['name'].' '.$campus['address']) }}" target="_blank" rel="noopener"
                       class="mt-4 inline-flex items-center gap-2 text-sm font-bold text-hbNavy hover:text-hbRed"><i class="fa-solid fa-diamond-turn-right"></i> Get Directions</a>
                </div>
            @endforeach
        </div>
        <div class="mt-10 rounded-xl overflow-hidden shadow-lg border border-gray-200">
            <iframe src="{{ config('college.map_embed') }}" title="Map to Hewitt & Bennet International College" width="100%" height="380" style="border:0;" allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>
</section>
@endsection
