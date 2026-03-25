@extends('dashboards.staff.layouts.stafflayout')

@section('pageTitle', 'Registered Users')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-bold text-primary">Registered Users</h2>
    </div>

    <div class="overflow-x-auto">
        <table id="registeredUsersTable" class="min-w-full display nowrap" style="width:100%">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student Name</th>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student Email</th>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Location</th>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone Number</th>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Course</th>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Application Date</th>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Start Month</th>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Start Year</th>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mode Of Learning</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($courseapplications as $application)
                    <tr>
                        <td class="px-4 py-3 whitespace-nowrap">{{ $application->name }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">{{ $application->email }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">{{ $application->location }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">{{ $application->phoneNumber }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">{{ $application->course }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">{{ \Carbon\Carbon::parse($application->timestamp)->format('d/m/Y H:i:s') }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">{{ $application->startMonth }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">{{ $application->startYear }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">{{ $application->modeOfLearning }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
