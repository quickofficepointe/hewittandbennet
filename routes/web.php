<?php

use App\Http\Controllers\aboutcontroller;
use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\CampusController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CourseapplicationController;
use App\Http\Controllers\CoursesController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\HewittBannersController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobsController;
use App\Http\Controllers\NewsandeventController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\RegistrationformController;
use App\Http\Controllers\ReviewsController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\TiktokvidController;
use App\Http\Controllers\WorkabroadController;
use App\Models\Campus;
use App\Models\courses;
use App\Models\Gallery;
use App\Models\newsandevent;
use App\Models\Partner;
use App\Models\Team;
use App\Models\Testimonial;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public website
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome', [
        'teams' => Team::all(),
        'partners' => Partner::all(),
        'galleryItems' => Gallery::where('file_type', 'image')->latest()->take(8)->get(),
        'coursese' => courses::with('department')->get(),
        'campuses' => Campus::orderBy('name')->get(),
        'news' => newsandevent::latest()->take(3)->get(),
        'testimonials' => Testimonial::where('is_active', true)->orderBy('sort_order')->take(6)->get(),
    ]);
})->name('welcome');

Route::get('/contact', [ContactController::class, 'show'])->name('contact.show');
Route::post('/contact', [ContactController::class, 'store'])->middleware('throttle:5,1')->name('contact.store');

// Accounts are created by the college (admission / employment), so public sign-up is disabled.
Auth::routes(['register' => false, 'verify' => false]);
Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/director/message', [aboutcontroller::class, 'aboutdirector'])->name('hewitt_director.about');
Route::get('/principal/message', [aboutcontroller::class, 'aboutprincipal'])->name('hewitt_principal.about');
Route::get('/dean/message', [aboutcontroller::class, 'aboutdean'])->name('hewitt_dean.about');
Route::get('/Captain/message', [aboutcontroller::class, 'aboutCaptain'])->name('hewitt_Captain.about');

Route::get('/courses', [CoursesController::class, 'allcourses'])->name('courses.all');
Route::get('/course/{slug}', [CoursesController::class, 'showSingleCourse'])->name('course.single');
Route::get('/courses/othercourses', [CoursesController::class, 'medicalsciences'])->name('hewitt_Captain.othercourses');
Route::get('/courses/caregivercourses', [CoursesController::class, 'shortcourses'])->name('hewitt_Captain.caregivercourses');
Route::get('/courses/cnacourses', [CoursesController::class, 'nursing'])->name('hewitt_Captain.cnacourses');
Route::get('/courses/hosipitality', [CoursesController::class, 'hosipitality'])->name('hewitt_Captain.hosipitality');
Route::get('/accreditations', [CoursesController::class, 'accreditations'])->name('hewitt_Captain.accreditations');
Route::get('/feesstructure', [CoursesController::class, 'fees'])->name('courses.fees');

Route::post('/registercourse', [CourseapplicationController::class, 'store'])->name('courseregistration.store');
Route::get('/registration', [RegistrationformController::class, 'index'])->name('registration.create');
Route::get('/apply', [RegistrationformController::class, 'index'])->name('application.form');
Route::post('/registration/submit', [RegistrationformController::class, 'store'])->name('registration.submit');

Route::get('/gallery', [GalleryController::class, 'index'])->name('student.gallery');
Route::post('/review', [ReviewsController::class, 'store'])->name('reviews.store');
Route::get('/hewittandbennet/news', [NewsandeventController::class, 'newsfront'])->name('news.event');
Route::get('news-and-events/{slug}', [NewsandeventController::class, 'show'])->name('newsandevent.show');
Route::get('/workabroad', [WorkabroadController::class, 'index'])->name('workabroad.index');

Route::get('/attachment', [AttachmentController::class, 'index'])->name('index.attachment');
Route::post('/submit-application', [AttachmentController::class, 'store'])->name('submit-application');
Route::get('/jobs', [JobsController::class, 'index'])->name('index.jobs');
Route::post('/submit-japplication', [JobsController::class, 'store'])->name('submit-japplication');

/*
|--------------------------------------------------------------------------
| Website content management (administrators)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin', 'PreventBackHistory'])->group(function () {
    Route::get('/admin/banners', [HewittBannersController::class, 'index'])->name('hewitt_banners.index');
    Route::post('/hewitt_bannerspost', [HewittBannersController::class, 'store'])->name('hewitt_banners.store');
    Route::patch('/hewitt_bannersupdate{id}', [HewittBannersController::class, 'update'])->name('hewitt_banners.update');
    Route::delete('/hewitt_bannersdestroy{id}', [HewittBannersController::class, 'destroy'])->name('hewitt_banners.destroy');
    Route::get('/hewitt_bannersedit{id}', [HewittBannersController::class, 'edit'])->name('hewitt_banners.edit');

    Route::get('/departments', [DepartmentController::class, 'index'])->name('index.departments');
    Route::post('/departmentstore', [DepartmentController::class, 'store'])->name('departments.store');
    Route::get('/departments/{department}/edit', [DepartmentController::class, 'edit'])->name('departments.edit');
    Route::put('/departments/{department}', [DepartmentController::class, 'update'])->name('departments.update');
    Route::delete('/departmentsdelete/{department}', [DepartmentController::class, 'destroy'])->name('departments.destroy');

    Route::get('/admin/courses', [CoursesController::class, 'index'])->name('index.cdpert');
    Route::post('/coursesstore', [CoursesController::class, 'store'])->name('courses.store');
    Route::get('/courses/{course}/edit', [CoursesController::class, 'edit'])->name('courses.edit');
    Route::put('/courses/{course}', [CoursesController::class, 'update'])->name('courses.update');
    Route::delete('/courses/{course}', [CoursesController::class, 'destroy'])->name('courses.destroy');

    Route::get('/registrationforms', [RegistrationformController::class, 'registrationforms'])->name('registrationforms.index');

    Route::get('/staff/news', [NewsandeventController::class, 'index'])->name('newsandevent.index');
    Route::post('/news', [NewsandeventController::class, 'store'])->name('newsandevent.store');
    Route::put('/news/{id}', [NewsandeventController::class, 'update'])->name('newsandevent.update');
    Route::delete('/news/{newsandevent}', [NewsandeventController::class, 'destroy'])->name('newsandevent.destroy');

    Route::get('/create/gallery', [GalleryController::class, 'create'])->name('gallery.index');
    Route::post('/store/gallery', [GalleryController::class, 'store'])->name('gallery.store');
    Route::put('/update/{gallery}', [GalleryController::class, 'update'])->name('gallery.update');
    Route::delete('/delete/{gallery}', [GalleryController::class, 'destroy'])->name('gallery.destroy');

    Route::get('/campuses', [CampusController::class, 'index'])->name('campuses.index');
    Route::post('/campuses', [CampusController::class, 'store'])->name('campuses.store');
    Route::put('/campuses/{campus}', [CampusController::class, 'update'])->name('campuses.update');
    Route::delete('/campuses/{campus}', [CampusController::class, 'destroy'])->name('campuses.destroy');

    Route::get('/tiktok-videos', [TiktokvidController::class, 'index'])->name('tiktok-videos.index');
    Route::post('/tiktok-videos', [TiktokvidController::class, 'store'])->name('tiktok-videos.store');
    Route::put('/tiktok-videos/{tiktokvid}', [TiktokvidController::class, 'update'])->name('tiktok-videos.update');
    Route::delete('/tiktok-videos/{tiktokvid}', [TiktokvidController::class, 'destroy'])->name('tiktok-videos.destroy');

    Route::get('/testimonials', [TestimonialController::class, 'index'])->name('testimonials.index');
    Route::post('/testimonials', [TestimonialController::class, 'store'])->name('testimonials.store');
    Route::put('/testimonials/{testimonial}', [TestimonialController::class, 'update'])->name('testimonials.update');
    Route::delete('/testimonials/{testimonial}', [TestimonialController::class, 'destroy'])->name('testimonials.destroy');

    Route::get('/index/review', [ReviewsController::class, 'index'])->name('index.review');
    Route::patch('/reviews/{review}/approve', [ReviewsController::class, 'approve'])->name('reviews.approve');
    Route::delete('/reviews/{review}', [ReviewsController::class, 'destroy'])->name('reviews.destroy');

    Route::get('/teams', [TeamController::class, 'index'])->name('teams.index');
    Route::post('/teams', [TeamController::class, 'store'])->name('teams.store');
    Route::put('/teams/{team}', [TeamController::class, 'update'])->name('teams.update');
    Route::delete('/teams/{team}', [TeamController::class, 'destroy'])->name('teams.destroy');

    Route::get('/partners', [PartnerController::class, 'index'])->name('partners.show');
    Route::post('/partners/store', [PartnerController::class, 'store'])->name('partners.store');
    Route::put('/partners/update/{id}', [PartnerController::class, 'update'])->name('partners.update');
    Route::delete('/partners/destroy/{id}', [PartnerController::class, 'destroy'])->name('partners.destroy');
});

require __DIR__.'/portal.php';
