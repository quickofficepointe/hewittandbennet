@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                    <a href="{{ route('hewitt_banners.index') }}">Creat Banners </a>
                    <div class="card">
                        <div class="card-header">
                          <h3 class="card-title">DataTable with default features</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                          <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>

                              <th>Student Name </th>
                              <th>Student Email</th>
                              <th>location</th>
                              <th>phone Number </th>
                              <th>course</th>
                              <th>Start Month</th>
                              <th>start Year</th>
                              <th>Mode Of Learning</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($courseapplications as $courseapplications)
                            <tr>
                                <td>{{ $courseapplications->name }}</td>
                                <td>{{ $courseapplications->email }}</td>
                             <td>{{$courseapplications->location }}</td>
                              <td>{{ $courseapplications->phoneNumber }}</td>
                              <td> {{ $courseapplications->course }}</td>
                              <td> {{ $courseapplications->startMonth }}</td>
                              <td> {{ $courseapplications->startYear }}</td>
                              <td> {{ $courseapplications->modeOfLearning }}</td>



                            </tr>
                            @endforeach
                            </tfoot>
                          </table>
                          <div class="container">
                            <h1>Create a Testimonial</h1>

                            <form method="POST" action="{{ route('testimonials.store') }}">
                                @csrf <!-- CSRF protection token -->

                                <div class="form-group">
                                    <label for="name">Name:</label>
                                    <input type="text" name="name" id="name" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label for="message">Message:</label>
                                    <textarea name="message" id="message" class="form-control" rows="4" required></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="rating">Rating:</label>
                                    <div id="star-rating">
                                        <span class="star" data-rating="1">&#9733;</span>
                                        <span class="star" data-rating="2">&#9733;</span>
                                        <span class="star" data-rating="3">&#9733;</span>
                                        <span class="star" data-rating="4">&#9733;</span>
                                        <span class="star" data-rating="5">&#9733;</span>
                                    </div>
                                    <input type="hidden" name="rate" id="rate" required>
                                </div>



                                <!-- Additional fields: email, company, location, date -->

                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                        </section>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="mt-5">
    <!-- Grid row-->
    <div class="row text-center d-flex justify-content-center pt-5">
      <!-- Grid column -->
      <div class="col-md-2">
        <h6 class="text-uppercase font-weight-bold">
          <a href="#!" class="text-white">About us</a>
        </h6>
      </div>
      <!-- Grid column -->

      <!-- Grid column -->
      <div class="col-md-2">
        <h6 class="text-uppercase font-weight-bold">
          <a href="#!" class="text-white">Course</a>
        </h6>
      </div>
      <!-- Grid column -->

      <!-- Grid column -->
      <div class="col-md-2">
        <h6 class="text-uppercase font-weight-bold">
          <a href="#!" class="text-white">Certificate</a>
        </h6>
      </div>
      <!-- Grid column -->

      <!-- Grid column -->
      <div class="col-md-2">
        <h6 class="text-uppercase font-weight-bold">
          <a href="#!" class="text-white">Help</a>
        </h6>
      </div>
      <!-- Grid column -->

      <!-- Grid column -->
      <div class="col-md-2">
        <h6 class="text-uppercase font-weight-bold">
          <a href="#!" class="text-white">Contact</a>
        </h6>
      </div>
      <!-- Grid column -->
    </div>
    <!-- Grid row-->
  </section>
@endsection
