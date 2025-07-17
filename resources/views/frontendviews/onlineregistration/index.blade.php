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
<div class="container mx-auto px-4 py-12">
    <div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-3xl font-bold text-center mb-8">Student Registration Form</h2>

        <form method="post" action="{{ route('registration.submit') }}" id="registrationForm" enctype="multipart/form-data">
            @csrf

            <!-- Student Information Section -->
            <div class="form-section mb-8">
                <div class="bg-gray-100 p-4 rounded-lg">
                    <h3 class="text-xl font-semibold mb-4">Student Information</h3>
                    <div class="space-y-4">
                        <div class="flex flex-col">
                            <label for="student_name" class="text-sm font-medium">Student Name</label>
                            <input type="text" class="mt-2 p-3 border border-gray-300 rounded-md" id="student_name" name="student_name" required>
                        </div>
                        <div class="flex flex-col">
                            <label for="dob" class="text-sm font-medium">Date of Birth</label>
                            <input type="date" class="mt-2 p-3 border border-gray-300 rounded-md" id="dob" name="dob" required>
                        </div>
                        <div class="flex flex-col">
                            <label for="citizenship" class="text-sm font-medium">Citizenship</label>
                            <input type="text" class="mt-2 p-3 border border-gray-300 rounded-md" id="citizenship" name="citizenship" required>
                        </div>
                        <div class="flex flex-col">
                            <label for="religion" class="text-sm font-medium">Religion</label>
                            <select class="mt-2 p-3 border border-gray-300 rounded-md" id="religion" name="religion" required>
                                <option value="">Select Religion</option>
                                <option value="Christianity">Christianity</option>
                                <option value="Islam">Islam</option>
                                <option value="Hinduism">Hinduism</option>
                                <option value="Buddhism">Buddhism</option>
                                <option value="Sikhism">Sikhism</option>
                                <option value="Pagan">Pagan</option>
                            </select>
                        </div>
                        <div class="flex flex-col">
                            <label for="cityofresidence" class="text-sm font-medium">City of Residence</label>
                            <input type="text" class="mt-2 p-3 border border-gray-300 rounded-md" id="cityofresidence" name="cityofresidence" required>
                        </div>
                        <div class="flex flex-col">
                            <label for="mobile" class="text-sm font-medium">Mobile Number</label>
                            <input type="tel" class="mt-2 p-3 border border-gray-300 rounded-md" id="mobile" name="mobile" required>
                        </div>
                        <div class="flex flex-col">
                            <label for="emailadress" class="text-sm font-medium">Email Address</label>
                            <input type="email" class="mt-2 p-3 border border-gray-300 rounded-md" id="emailadress" name="emailadress" required>
                        </div>
                        <div class="flex flex-col">
                            <label for="homephone" class="text-sm font-medium">Home Telephone</label>
                            <input type="tel" class="mt-2 p-3 border border-gray-300 rounded-md" id="homephone" name="homephone" required>
                        </div>
                        <div class="flex flex-col">
                            <label for="education" class="text-sm font-medium">Highest Level of Education</label>
                            <input type="text" class="mt-2 p-3 border border-gray-300 rounded-md" id="education" name="education" required>
                        </div>
                        <div class="flex flex-col">
                            <label for="otherskills" class="text-sm font-medium">Other Skills Acquired</label>
                            <input type="text" class="mt-2 p-3 border border-gray-300 rounded-md" id="otherskills" name="otherskills" required>
                        </div>
                        <div class="flex flex-col">
                            <label for="profession" class="text-sm font-medium">Profession</label>
                            <input type="text" class="mt-2 p-3 border border-gray-300 rounded-md" id="profession" name="profession" required>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Guardian Information Section -->
            <div class="form-section mb-8">
                <div class="bg-gray-100 p-4 rounded-lg">
                    <h3 class="text-xl font-semibold mb-4">Guardian Information</h3>
                    <div class="space-y-4">
                        <div class="flex flex-col">
                            <label for="gurdianname" class="text-sm font-medium">Parent / Guardian Name</label>
                            <input type="text" class="mt-2 p-3 border border-gray-300 rounded-md" id="gurdianname" name="gurdianname" required>
                        </div>
                        <div class="flex flex-col">
                            <label for="phonenumber" class="text-sm font-medium">Phone Number</label>
                            <input type="tel" class="mt-2 p-3 border border-gray-300 rounded-md" id="phonenumber" name="phonenumber" required>
                        </div>
                        <div class="flex flex-col">
                            <label for="idnumber" class="text-sm font-medium">Guardian ID Number</label>
                            <input type="text" class="mt-2 p-3 border border-gray-300 rounded-md" id="idnumber" name="idnumber" required>
                        </div>
                        <div class="flex flex-col">
                            <label for="gresidence" class="text-sm font-medium">Residence</label>
                            <input type="text" class="mt-2 p-3 border border-gray-300 rounded-md" id="gresidence" name="gresidence" required>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Medical Information Section -->
            <div class="form-section mb-8">
                <div class="bg-gray-100 p-4 rounded-lg">
                    <h3 class="text-xl font-semibold mb-4">Medical Information</h3>
                    <p class="text-sm mb-4">Is there any critical medical information regarding the student's health status you as a parent/guardian would wish to share with the institution?</p>
                    <div class="flex flex-col">
                        <label class="text-sm font-medium">Medical Information:</label>
                        <div class="flex items-center space-x-4">
                            <div class="flex items-center">
                                <input type="radio" class="form-radio text-blue-600" id="medical_info_yes" name="medical_info_yes" value="yes">
                                <label class="ml-2 text-sm">Yes</label>
                            </div>
                            <div class="flex items-center">
                                <input type="radio" class="form-radio text-blue-600" id="medical_info_no" name="medical_info_yes" value="no">
                                <label class="ml-2 text-sm">No</label>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col mt-4">
                        <label for="medical_info_explanation" class="text-sm font-medium">Briefly explain (if yes):</label>
                        <textarea class="mt-2 p-3 border border-gray-300 rounded-md" id="medical_info_explanation" name="medical_info_explanation" rows="4"></textarea>
                    </div>
                </div>
            </div>
            <!-- Training Details Section -->
            <div class="form-section mb-8">
                <div class="bg-gray-100 p-4 rounded-lg">
                    <h3 class="text-xl font-semibold mb-4">Training Details</h3>
                    <div class="space-y-4">
                        <div class="flex flex-col">
                            <label for="reasonfortraining" class="text-sm font-medium">Reason for Joining the Training</label>
                            <textarea class="mt-2 p-3 border border-gray-300 rounded-md" id="reasonfortraining" name="reasonfortraining" rows="3" required></textarea>
                        </div>
                        <div class="flex flex-col">
                            <label for="gainfortraining" class="text-sm font-medium">What Do You Hope to Gain?</label>
                            <input type="text" class="mt-2 p-3 border border-gray-300 rounded-md" id="gainfortraining" name="gainfortraining" required>
                        </div>
                    </div>
                </div>
            </div>
            <!-- File Upload Section -->
            <div class="form-section mb-8">
                <div class="bg-gray-100 p-4 rounded-lg">
                    <h3 class="text-xl font-semibold mb-4">File Upload</h3>
                    <p class="text-sm mb-4">Please upload the following required documents:</p>
                    <div class="space-y-4">
                        <div class="flex flex-col">
                            <label for="passport" class="text-sm font-medium">Passport Photo</label>
                            <input type="file" class="mt-2 p-3 border border-gray-300 rounded-md" id="passport" name="passport" required>
                        </div>
                        <div class="flex flex-col">
                            <label for="idphoto" class="text-sm font-medium">ID/Passport Copy</label>
                            <input type="file" class="mt-2 p-3 border border-gray-300 rounded-md" id="idphoto" name="idphoto" required>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-center">
                <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg text-lg hover:bg-blue-700 transition duration-300">Submit Registration</button>
            </div>
        </form>
    </div>
</div>
@endsection
