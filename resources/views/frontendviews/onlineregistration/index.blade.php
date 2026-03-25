@extends('layouts.welcomelayout')

@section('meta-title', 'Student Registration - Hewitt Bennet International College')
@section('meta-description', 'Register for courses at Hewitt Bennet International College. Fill in your details to join our learning community.')
@section('meta-keywords', 'Student Registration, Hewitt Bennet, College Registration')
@section('meta-author', 'Hewitt Bennet International College')
@section('meta-url', route('registration.create'))
@section('meta-image', asset('assets/img/registration.jpg'))
@section('meta-date', now()->toIso8601String())

@section('og:type', 'website')
@section('og:title', 'Student Registration - Hewitt Bennet International College')
@section('og:description', 'Register for courses at Hewitt Bennet International College. Fill in your details to join our learning community.')
@section('og:image', asset('assets/img/registration.jpg'))
@section('og:url', route('registration.create'))
@section('og:site_name', 'Hewitt Bennet International College')
@section('og:published_time', now()->toIso8601String())

@section('twitter:card', 'summary_large_image')
@section('twitter:title', 'Student Registration - Hewitt Bennet International College')
@section('twitter:description', 'Register for courses at Hewitt Bennet International College. Fill in your details to join our learning community.')
@section('twitter:image', asset('assets/img/registration.jpg'))
@section('twitter:site', '@HewittBennetIntl')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-10">
            <h1 class="text-3xl font-bold text-primary mb-2">Student Registration</h1>
            <p class="text-gray-600">Join our learning community at Hewitt Bennet International College</p>
        </div>

        <!-- Progress Indicator -->
        <div class="mb-10">
            <div class="flex items-center justify-between relative">
                <div class="absolute top-1/2 left-0 right-0 h-1 bg-gray-200 transform -translate-y-1/2 -z-10"></div>
                <div class="w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center font-semibold">
                    1
                </div>
                <div class="w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center font-semibold">
                    2
                </div>
                <div class="w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center font-semibold">
                    3
                </div>
                <div class="w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center font-semibold">
                    4
                </div>
                <div class="w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center font-semibold">
                    5
                </div>
            </div>
            <div class="flex justify-between mt-2 text-xs text-gray-600">
                <span>Student Info</span>
                <span>Guardian</span>
                <span>Medical</span>
                <span>Training</span>
                <span>Documents</span>
            </div>
        </div>

        <form method="post" action="{{ route('registration.submit') }}" id="registrationForm" enctype="multipart/form-data" class="bg-white rounded-xl shadow-lg overflow-hidden">
            @csrf

            <!-- Form Steps -->
            <div class="p-6 md:p-8">
                <!-- Step 1: Student Information -->
                <div class="step active" data-step="1">
                    <h2 class="text-2xl font-bold text-primary mb-6 pb-2 border-b border-gray-200">Student Information</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="student_name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                            <input type="text" id="student_name" name="student_name" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-colors">
                        </div>

                        <div>
                            <label for="dob" class="block text-sm font-medium text-gray-700 mb-1">Date of Birth</label>
                            <input type="date" id="dob" name="dob" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-colors">
                        </div>

                        <div>
                            <label for="citizenship" class="block text-sm font-medium text-gray-700 mb-1">Citizenship</label>
                            <input type="text" id="citizenship" name="citizenship" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-colors">
                        </div>

                        <div>
                            <label for="religion" class="block text-sm font-medium text-gray-700 mb-1">Religion</label>
                            <select id="religion" name="religion" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-colors">
                                <option value="">Select Religion</option>
                                <option value="Christianity">Christianity</option>
                                <option value="Islam">Islam</option>
                                <option value="Hinduism">Hinduism</option>
                                <option value="Buddhism">Buddhism</option>
                                <option value="Sikhism">Sikhism</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>

                        <div>
                            <label for="cityofresidence" class="block text-sm font-medium text-gray-700 mb-1">City of Residence</label>
                            <input type="text" id="cityofresidence" name="cityofresidence" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-colors">
                        </div>

                        <div>
                            <label for="mobile" class="block text-sm font-medium text-gray-700 mb-1">Mobile Number</label>
                            <input type="tel" id="mobile" name="mobile" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-colors">
                        </div>

                        <div>
                            <label for="emailadress" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                            <input type="email" id="emailadress" name="emailadress" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-colors">
                        </div>

                        <div>
                            <label for="homephone" class="block text-sm font-medium text-gray-700 mb-1">Home Telephone</label>
                            <input type="tel" id="homephone" name="homephone"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-colors">
                        </div>

                        <div>
                            <label for="education" class="block text-sm font-medium text-gray-700 mb-1">Highest Education Level</label>
                            <input type="text" id="education" name="education" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-colors">
                        </div>

                        <div>
                            <label for="otherskills" class="block text-sm font-medium text-gray-700 mb-1">Other Skills</label>
                            <input type="text" id="otherskills" name="otherskills"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-colors">
                        </div>

                        <div class="md:col-span-2">
                            <label for="profession" class="block text-sm font-medium text-gray-700 mb-1">Profession</label>
                            <input type="text" id="profession" name="profession" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-colors">
                        </div>
                    </div>

                    <div class="flex justify-between mt-8">
                        <div></div> <!-- Empty div for spacing -->
                        <button type="button" class="next-step bg-primary text-white px-6 py-2 rounded-lg hover:bg-primary-dark transition-colors">
                            Next: Guardian Information
                        </button>
                    </div>
                </div>

                <!-- Step 2: Guardian Information -->
                <div class="step hidden" data-step="2">
                    <h2 class="text-2xl font-bold text-primary mb-6 pb-2 border-b border-gray-200">Guardian Information</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="gurdianname" class="block text-sm font-medium text-gray-700 mb-1">Parent/Guardian Name</label>
                            <input type="text" id="gurdianname" name="gurdianname" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-colors">
                        </div>

                        <div>
                            <label for="phonenumber" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                            <input type="tel" id="phonenumber" name="phonenumber" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-colors">
                        </div>

                        <div>
                            <label for="idnumber" class="block text-sm font-medium text-gray-700 mb-1">ID Number</label>
                            <input type="text" id="idnumber" name="idnumber" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-colors">
                        </div>

                        <div>
                            <label for="gresidence" class="block text-sm font-medium text-gray-700 mb-1">Residence</label>
                            <input type="text" id="gresidence" name="gresidence" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-colors">
                        </div>
                    </div>

                    <div class="flex justify-between mt-8">
                        <button type="button" class="prev-step bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300 transition-colors">
                            Back
                        </button>
                        <button type="button" class="next-step bg-primary text-white px-6 py-2 rounded-lg hover:bg-primary-dark transition-colors">
                            Next: Medical Information
                        </button>
                    </div>
                </div>

                <!-- Step 3: Medical Information -->
                <div class="step hidden" data-step="3">
                    <h2 class="text-2xl font-bold text-primary mb-6 pb-2 border-b border-gray-200">Medical Information</h2>

                    <p class="text-gray-600 mb-6">Is there any critical medical information regarding the student's health status you as a parent/guardian would wish to share with the institution?</p>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-3">Medical Information</label>
                        <div class="flex space-x-6">
                            <label class="inline-flex items-center">
                                <input type="radio" name="medical_info_yes" value="yes"
                                    class="text-primary focus:ring-primary h-4 w-4">
                                <span class="ml-2">Yes</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="medical_info_yes" value="no" checked
                                    class="text-primary focus:ring-primary h-4 w-4">
                                <span class="ml-2">No</span>
                            </label>
                        </div>
                    </div>

                    <div id="medical-details" class="hidden">
                        <label for="medical_info_explanation" class="block text-sm font-medium text-gray-700 mb-1">Briefly explain</label>
                        <textarea id="medical_info_explanation" name="medical_info_explanation" rows="4"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-colors"></textarea>
                    </div>

                    <div class="flex justify-between mt-8">
                        <button type="button" class="prev-step bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300 transition-colors">
                            Back
                        </button>
                        <button type="button" class="next-step bg-primary text-white px-6 py-2 rounded-lg hover:bg-primary-dark transition-colors">
                            Next: Training Details
                        </button>
                    </div>
                </div>

                <!-- Step 4: Training Details -->
                <div class="step hidden" data-step="4">
                    <h2 class="text-2xl font-bold text-primary mb-6 pb-2 border-b border-gray-200">Training Details</h2>

                    <div class="space-y-6">
                        <div>
                            <label for="reasonfortraining" class="block text-sm font-medium text-gray-700 mb-1">Reason for Joining the Training</label>
                            <textarea id="reasonfortraining" name="reasonfortraining" rows="3" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-colors"></textarea>
                        </div>

                        <div>
                            <label for="gainfortraining" class="block text-sm font-medium text-gray-700 mb-1">What Do You Hope to Gain?</label>
                            <input type="text" id="gainfortraining" name="gainfortraining" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-colors">
                        </div>
                    </div>

                    <div class="flex justify-between mt-8">
                        <button type="button" class="prev-step bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300 transition-colors">
                            Back
                        </button>
                        <button type="button" class="next-step bg-primary text-white px-6 py-2 rounded-lg hover:bg-primary-dark transition-colors">
                            Next: Document Upload
                        </button>
                    </div>
                </div>

                <!-- Step 5: Document Upload -->
                <div class="step hidden" data-step="5">
                    <h2 class="text-2xl font-bold text-primary mb-6 pb-2 border-b border-gray-200">Document Upload</h2>

                    <p class="text-gray-600 mb-6">Please upload the following required documents:</p>

                    <div class="space-y-6">
                        <div>
                            <label for="passport" class="block text-sm font-medium text-gray-700 mb-1">Passport Photo</label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg">
                                <div class="space-y-1 text-center">
                                    <div class="flex text-sm text-gray-600">
                                        <label for="passport" class="relative cursor-pointer bg-white rounded-md font-medium text-primary hover:text-primary-dark focus-within:outline-none">
                                            <span>Upload a file</span>
                                            <input id="passport" name="passport" type="file" class="sr-only" required>
                                        </label>
                                        <p class="pl-1">or drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label for="idphoto" class="block text-sm font-medium text-gray-700 mb-1">ID/Passport Copy</label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg">
                                <div class="space-y-1 text-center">
                                    <div class="flex text-sm text-gray-600">
                                        <label for="idphoto" class="relative cursor-pointer bg-white rounded-md font-medium text-primary hover:text-primary-dark focus-within:outline-none">
                                            <span>Upload a file</span>
                                            <input id="idphoto" name="idphoto" type="file" class="sr-only" required>
                                        </label>
                                        <p class="pl-1">or drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">PNG, JPG, GIF, PDF up to 10MB</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-between mt-8">
                        <button type="button" class="prev-step bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300 transition-colors">
                            Back
                        </button>
                        <button type="submit" class="bg-primary text-white px-6 py-2 rounded-lg hover:bg-primary-dark transition-colors">
                            Submit Registration
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Multi-step form functionality
        const steps = document.querySelectorAll('.step');
        const nextButtons = document.querySelectorAll('.next-step');
        const prevButtons = document.querySelectorAll('.prev-step');
        let currentStep = 1;

        // Show current step
        function showStep(stepNumber) {
            steps.forEach(step => {
                step.classList.add('hidden');
                step.classList.remove('active');
            });

            const currentStepElement = document.querySelector(`.step[data-step="${stepNumber}"]`);
            if (currentStepElement) {
                currentStepElement.classList.remove('hidden');
                currentStepElement.classList.add('active');
            }

            currentStep = stepNumber;
        }

        // Next button event listeners
        nextButtons.forEach(button => {
            button.addEventListener('click', function() {
                if (validateStep(currentStep)) {
                    showStep(currentStep + 1);
                }
            });
        });

        // Previous button event listeners
        prevButtons.forEach(button => {
            button.addEventListener('click', function() {
                showStep(currentStep - 1);
            });
        });

        // Medical info toggle
        const medicalRadios = document.querySelectorAll('input[name="medical_info_yes"]');
        const medicalDetails = document.getElementById('medical-details');

        medicalRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.value === 'yes') {
                    medicalDetails.classList.remove('hidden');
                } else {
                    medicalDetails.classList.add('hidden');
                }
            });
        });

        // Basic step validation
        function validateStep(step) {
            // Add validation logic for each step if needed
            return true;
        }

        // Form submission
        document.getElementById('registrationForm').addEventListener('submit', function(e) {
            // Add final validation before submission if needed
        });
    });
</script>

<style>
    .step {
        transition: opacity 0.3s ease;
    }

    .step.active {
        display: block;
    }

    .step.hidden {
        display: none;
    }

    input:focus, select:focus, textarea:focus {
        outline: none;
        box-shadow: 0 0 0 3px rgba(30, 58, 138, 0.1);
    }
</style>
@endsection
