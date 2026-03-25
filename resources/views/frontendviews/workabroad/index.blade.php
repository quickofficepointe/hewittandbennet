@extends('layouts.welcomelayout')

@section('meta-title', 'Work Abroad as a Certified Caregiver - Hewitt Bennet International College')
@section('meta-description', 'Train to become a professional caregiver and work abroad in countries like the UK, USA, Canada, and more. Apply now at Hewitt Bennet International College.')
@section('meta-keywords', 'Caregiving, Work Abroad, Hewitt Bennet, Certified Caregiver, Nursing Care, Senior Care')
@section('meta-author', 'Hewitt Bennet International College')
@section('meta-url', url()->current())
@section('meta-image', asset('assets/img/workabroad.jpg'))
@section('meta-date', now()->toIso8601String())

@section('og:type', 'website')
@section('og:title', 'Work Abroad as a Certified Caregiver - Hewitt Bennet International College')
@section('og:description', 'Train to become a professional caregiver and work abroad in countries like the UK, USA, Canada, and more. Apply now at Hewitt Bennet International College.')
@section('og:image', asset('assets/img/workabroad.jpg'))
@section('og:url', url()->current())
@section('og:site_name', 'Hewitt Bennet International College')
@section('og:published_time', now()->toIso8601String())

@section('twitter:card', 'summary_large_image')
@section('twitter:title', 'Work Abroad as a Certified Caregiver - Hewitt Bennet International College')
@section('twitter:description', 'Train to become a professional caregiver and work abroad in countries like the UK, USA, Canada, and more. Apply now at Hewitt Bennet International College.')
@section('twitter:image', asset('assets/img/workabroad.jpg'))
@section('twitter:site', '@HewittBennetIntl')

@section('content')
<section class="py-16 bg-gradient-to-br from-blue-50 to-indigo-100">
    <div class="container mx-auto px-4">
        <!-- Page Header -->
        <div class="text-center mb-12">
            <h5 class="text-lg font-semibold text-primary uppercase tracking-wider">Global Opportunities</h5>
            <h1 class="text-4xl md:text-5xl font-bold text-primary mt-2 mb-4">Work Abroad as a Certified Caregiver</h1>
            <p class="text-gray-600 max-w-3xl mx-auto">Caregiving is one of the most in-demand careers globally. Get certified and work abroad as a professional caregiver with our internationally recognized training program.</p>
        </div>

        <!-- Hero Section -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-16">
            <div class="grid md:grid-cols-2">
                <div class="p-8 md:p-12 flex flex-col justify-center">
                    <h2 class="text-2xl md:text-3xl font-bold text-primary mb-4">Global Caregiving Careers</h2>
                    <p class="text-gray-600 mb-6">At Hewitt Bennet International College, we train caregivers who are ready to compete in the global healthcare market. Our program is NITA certified and recognized by International Caregiver Associations for its quality training.</p>
                    <div class="flex flex-wrap gap-4">
                        <a href="{{ route('registration.create') }}" class="px-6 py-3 bg-primary text-white rounded-lg font-semibold hover:bg-secondary transition-colors shadow-md">
                            Apply Now
                        </a>
                        <a href="#program-details" class="px-6 py-3 border border-primary text-primary rounded-lg font-semibold hover:bg-primary hover:text-white transition-colors">
                            Program Details
                        </a>
                    </div>
                </div>
                <div class="h-64 md:h-auto bg-gradient-to-r from-primary to-secondary flex items-center justify-center p-8">
                    <div class="text-center text-white">
                        <i class="fas fa-globe-americas text-5xl mb-4"></i>
                        <h3 class="text-xl font-bold">International Opportunities</h3>
                        <p class="mt-2">Work in 15+ countries worldwide</p>
                    </div>
                </div>
            </div>
        </div>
<!-- Countries Section -->
<div class="mb-16">
    <h2 class="text-3xl font-bold text-primary text-center mb-12">Our Graduates Work In</h2>
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
        <!-- UK -->
        <div class="bg-white rounded-xl shadow-lg p-6 text-center hover-lift">
            <div class="w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                <span class="fi fi-gb text-3xl"></span>
            </div>
            <h3 class="font-semibold text-primary">United Kingdom</h3>
        </div>

        <!-- USA -->
        <div class="bg-white rounded-xl shadow-lg p-6 text-center hover-lift">
            <div class="w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                <span class="fi fi-us text-3xl"></span>
            </div>
            <h3 class="font-semibold text-primary">United States</h3>
        </div>

        <!-- Canada -->
        <div class="bg-white rounded-xl shadow-lg p-6 text-center hover-lift">
            <div class="w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                <span class="fi fi-ca text-3xl"></span>
            </div>
            <h3 class="font-semibold text-primary">Canada</h3>
        </div>

        <!-- Germany -->
        <div class="bg-white rounded-xl shadow-lg p-6 text-center hover-lift">
            <div class="w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                <span class="fi fi-de text-3xl"></span>
            </div>
            <h3 class="font-semibold text-primary">Germany</h3>
        </div>

        <!-- Australia -->
        <div class="bg-white rounded-xl shadow-lg p-6 text-center hover-lift">
            <div class="w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                <span class="fi fi-au text-3xl"></span>
            </div>
            <h3 class="font-semibold text-primary">Australia</h3>
        </div>

        <!-- Qatar -->
        <div class="bg-white rounded-xl shadow-lg p-6 text-center hover-lift">
            <div class="w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                <span class="fi fi-qa text-3xl"></span>
            </div>
            <h3 class="font-semibold text-primary">Qatar</h3>
        </div>

        <!-- UAE -->
        <div class="bg-white rounded-xl shadow-lg p-6 text-center hover-lift">
            <div class="w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                <span class="fi fi-ae text-3xl"></span>
            </div>
            <h3 class="font-semibold text-primary">UAE</h3>
        </div>

        <!-- Norway -->
        <div class="bg-white rounded-xl shadow-lg p-6 text-center hover-lift">
            <div class="w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                <span class="fi fi-no text-3xl"></span>
            </div>
            <h3 class="font-semibold text-primary">Norway</h3>
        </div>

        <!-- Sweden -->
        <div class="bg-white rounded-xl shadow-lg p-6 text-center hover-lift">
            <div class="w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                <span class="fi fi-se text-3xl"></span>
            </div>
            <h3 class="font-semibold text-primary">Sweden</h3>
        </div>

        <!-- Finland -->
        <div class="bg-white rounded-xl shadow-lg p-6 text-center hover-lift">
            <div class="w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                <span class="fi fi-fi text-3xl"></span>
            </div>
            <h3 class="font-semibold text-primary">Finland</h3>
        </div>
    </div>
</div>

        <!-- Specializations Section -->
        <div class="mb-16" id="program-details">
            <h2 class="text-3xl font-bold text-primary text-center mb-12">Our Caregivers Specialize In</h2>
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white rounded-xl shadow-lg p-6 text-center transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-user-md text-primary text-2xl"></i>
                    </div>
                    <h3 class="font-semibold text-primary mb-2">Patient Care / Nursing Care</h3>
                    <p class="text-gray-600 text-sm">Comprehensive training in medical care and patient support</p>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6 text-center transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-baby text-primary text-2xl"></i>
                    </div>
                    <h3 class="font-semibold text-primary mb-2">Child Care & Protection</h3>
                    <p class="text-gray-600 text-sm">Specialized skills for caring for children of all ages</p>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6 text-center transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-wheelchair text-primary text-2xl"></i>
                    </div>
                    <h3 class="font-semibold text-primary mb-2">Senior Care / Aged Care</h3>
                    <p class="text-gray-600 text-sm">Expertise in elderly care and support for aging adults</p>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6 text-center transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-heart text-primary text-2xl"></i>
                    </div>
                    <h3 class="font-semibold text-primary mb-2">Disability Care & Support</h3>
                    <p class="text-gray-600 text-sm">Training to assist individuals with various disabilities</p>
                </div>
            </div>
        </div>

        <!-- Certification Section -->
        <div class="bg-gradient-to-r from-primary to-secondary rounded-2xl shadow-xl p-8 md:p-12 text-white mb-16">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="text-3xl font-bold mb-6">Internationally Recognized Certification</h2>
                <p class="text-blue-100 mb-6">Our training program is NITA certified and recognized by International Caregiver Associations for its quality training standards and comprehensive curriculum.</p>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-10">
                    <div class="bg-white bg-opacity-20 rounded-lg p-4">
                        <i class="fas fa-award text-3xl mb-2"></i>
                        <p>NITA Certified</p>
                    </div>
                    <div class="bg-white bg-opacity-20 rounded-lg p-4">
                        <i class="fas fa-globe text-3xl mb-2"></i>
                        <p>Global Recognition</p>
                    </div>
                    <div class="bg-white bg-opacity-20 rounded-lg p-4">
                        <i class="fas fa-graduation-cap text-3xl mb-2"></i>
                        <p>Quality Training</p>
                    </div>
                    <div class="bg-white bg-opacity-20 rounded-lg p-4">
                        <i class="fas fa-hand-holding-heart text-3xl mb-2"></i>
                        <p>Compassionate Care</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="text-center">
            <h2 class="text-3xl font-bold text-primary mb-6">Start Your International Caregiving Career Today</h2>
            <p class="text-gray-600 max-w-2xl mx-auto mb-8">Join hundreds of our graduates who are now working abroad as professional caregivers in prestigious healthcare facilities around the world.</p>
            <a href="{{ route('registration.create') }}" class="inline-block px-8 py-4 bg-primary text-white rounded-lg font-semibold hover:bg-secondary transition-colors shadow-md text-lg">
                Apply for the Program
            </a>
            <p class="text-gray-500 text-sm mt-4">Limited seats available for the next intake</p>
        </div>
    </div>
</section>

<style>
    .hover-lift {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .hover-lift:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
    }
</style>
@endsection
