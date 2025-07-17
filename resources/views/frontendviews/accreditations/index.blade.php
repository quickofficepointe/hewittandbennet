@extends('layouts.welcomelayout')

@section('title', 'Accreditations - Hewitt and Bennet International College')
@section('meta-description', 'Hewitt and Bennet International College is accredited by leading educational authorities such as KNEC, NITA, TVETA, CDACC, ICM, and others. Explore our prestigious accreditations and certifications that ensure high-quality education and career readiness.')
@section('meta-keywords', 'Accreditations, KNEC, NITA, TVETA, CDACC, ICM, Educational Certifications, Hewitt and Bennet, Quality Education, Career Readiness')
@section('meta-author', 'Hewitt and Bennet International College')
@section('meta-url', url()->current())
@section('meta-image', asset('assets/img/college_accreditations.jpeg')) <!-- Replace with a relevant image -->
@section('meta-date', now()->toIso8601String())

<!-- Open Graph Tags for Social Sharing -->
@section('og:type', 'website')
@section('og:title', 'Accreditations - Hewitt and Bennet International College')
@section('og:description', 'Explore the list of prestigious accreditations at Hewitt and Bennet International College. Accredited by KNEC, NITA, TVETA, CDACC, and ICM, we offer quality education to empower students for success.')
@section('og:image', asset('assets/img/college_accreditations.jpeg')) <!-- Replace with a relevant image -->
@section('og:url', url()->current())
@section('og:site_name', 'Hewitt and Bennet International College')
@section('og:published_time', now()->toIso8601String())

<!-- Twitter Card Tags -->
@section('twitter:card', 'summary_large_image')
@section('twitter:title', 'Accreditations - Hewitt and Bennet International College')
@section('twitter:description', 'Learn about the prestigious accreditations of Hewitt and Bennet International College, including KNEC, NITA, TVETA, CDACC, ICM, and others, ensuring quality education for our students.')
@section('twitter:image', asset('assets/img/college_accreditations.jpeg')) <!-- Replace with a relevant image -->
@section('twitter:site', '@HewittBennetIntl')

@section('content')
<div class="container mx-auto mt-12 px-4">
    <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-8">Our Accreditations</h2>
        <p class="text-lg text-gray-600 mb-6 text-center">
            At Hewitt and Bennet International College, we pride ourselves on being accredited by top educational bodies. These accreditations ensure that we provide quality education, professional training, and certification that empowers our students to achieve success in their careers.
        </p>
        <ul class="list-disc pl-6 space-y-3 text-lg text-gray-700">
            <li class="list-item">Kenya National Examinations Council (KNEC)</li>
            <li class="list-item">National Industrial Training Authority (NITA)</li>
            <li class="list-item">Technical and Vocational Education and Training Authority (TVETA)</li>
            <li class="list-item">Curriculum Development Assessment and Certification Council (CDACC)</li>
            <li class="list-item">International Certification in Management (ICM)</li>
            <li class="list-item">And other esteemed bodies</li>
        </ul>
        <p class="text-lg text-gray-600 mt-6">
            These accreditations not only validate the high standards of education at our college but also provide our students with opportunities for national and international recognition in their professional fields.
        </p>
    </div>
</div>
@endsection
