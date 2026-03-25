<?php

use App\Http\Controllers\CampusController;
use App\Http\Controllers\CoursesController;
use App\Http\Controllers\FeesstructureController;
use App\Http\Controllers\OnlineExamsController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\QuestionsController;
use App\Http\Controllers\ReviewsController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentDataController;
use App\Http\Controllers\StudentExamsController;
use App\Http\Controllers\StudentResponsesController;
use App\Http\Controllers\StudentScoresController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\TiktokvidController;
use App\Http\Controllers\TutorController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

use App\Models\Course; // Assuming your Course model is in the App\Models namespace
use App\Models\courses;
use App\Models\department;
use App\Models\Gallery;
use App\Models\hewitt_banners;
use App\Models\student_scores;
use App\Models\Team;
use App\Models\Campus;
use App\Models\Partner;

Route::get('/', function () {
    // Fetch data for banners
    $banners = hewitt_banners::where('status', true)->get();
    // Fetch all courses
    $coursese = Courses::all();
    // fetch campus
    $campuses = Campus::all();
    $partners = Partner::all(); // Fetch all partners
    // Fetch data for each department's first three courses
    $shortDepartments = Department::where('name', 'like', '%caregiver%')->pluck('id');
    $hospitalityDepartments = Department::where('name', 'like', '%Hospitality%')->pluck('id');
    $othercourses = Department::where('name', 'like', '%other%')->pluck('id');
    $nursingDepartments = Department::where('name', 'like', '%nursing%')->pluck('id');
    $shortCourses = Courses::whereIn('department_id', $shortDepartments)->take(3)->get();
    $hospitalityCourses = Courses::whereIn('department_id', $hospitalityDepartments)->take(3)->get();
    $othercourses = Courses::whereIn('department_id', $othercourses)->take(3)->get();
    $nursingCourses = Courses::whereIn('department_id', $nursingDepartments)->take(3)->get();
    $galleryItems = Gallery::where('file_type', 'image')->latest()->take(15)->get(); // or ->inRandomOrder()

    // ✅ Fetch team members
    $teams = Team::all();
    return view('welcome', [
        'banners' => $banners,
        'teams' => $teams,'partners' => $partners,
        'galleryItems' => $galleryItems,
        'shortCourses' => $shortCourses,
        'coursese' => $coursese,
        'campuses' => $campuses,
        'hospitalityCourses' => $hospitalityCourses,
        'othercourses' => $othercourses,
        'nursingCourses' => $nursingCourses,
    ]);
});
Route::get('email/verify', function () {
    return view('auth.verify');
})->middleware(['auth'])->name('verification.notice');

Auth::routes(['verify' => true]);

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->middleware('verified');
Route::group(['middleware' => ['auth', 'isDirector', 'PreventBackHistory']], function () {
    Route::get('/director/dashboard', [App\Http\Controllers\DirectorController::class, 'dashboard'])->name('director.dashboard');
    Route::get('users', [App\Http\Controllers\UserController::class, 'index'])->name('index.users');
    Route::get('users/edit/{id}', [App\Http\Controllers\UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [App\Http\Controllers\UserController::class, 'update'])->name('users.update');
    Route::delete('users/{id}', [App\Http\Controllers\UserController::class, 'destroy'])->name('users.destroy');
});

Route::group(['middleware' => ['auth', 'isStaff', 'PreventBackHistory']], function () {
    // Staff routes
    Route::get('/staff/dashboard', [App\Http\Controllers\StaffController::class, 'dashboard'])->name('staff.dashboard');
    Route::get('/staff/students', [App\Http\Controllers\StaffController::class, 'index'])->name('staff.onlineregister');
    Route::get('/staff/news', [App\Http\Controllers\NewsandeventController::class, 'index'])->name('newsandevent.index');
    Route::post('/news', [App\Http\Controllers\NewsandeventController::class, 'store'])->name('newsandevent.store');

    //routes for campuses
    Route::get('/campuses', [CampusController::class, 'index'])->name('campuses.index');
    Route::post('/campuses', [CampusController::class, 'store'])->name('campuses.store');
    Route::put('/campuses/{campus}', [CampusController::class, 'update'])->name('campuses.update');
    Route::delete('/campuses/{campus}', [CampusController::class, 'destroy'])->name('campuses.destroy');

    // routes for tiktok videos
    Route::get('/tiktok-videos', [TiktokvidController::class, 'index'])->name('tiktok-videos.index');
    Route::post('/tiktok-videos', [TiktokvidController::class, 'store'])->name('tiktok-videos.store');
    Route::put('/tiktok-videos/{tiktokvid}', [TiktokvidController::class, 'update'])->name('tiktok-videos.update');
    Route::delete('/tiktok-videos/{tiktokvid}', [TiktokvidController::class, 'destroy'])->name('tiktok-videos.destroy');

    // Testimonials routes
    Route::get('/testimonials', [TestimonialController::class, 'index'])->name('testimonials.index');
    Route::post('/testimonials', [TestimonialController::class, 'store'])->name('testimonial.store');
    Route::put('/testimonials/{testimonial}', [TestimonialController::class, 'update'])->name('testimonials.update');
    Route::delete('/testimonials/{testimonial}', [TestimonialController::class, 'destroy'])->name('testimonials.destroy');

    //routes for teams
    Route::get('/teams', [TeamController::class, 'index'])->name('teams.index');
    Route::post('/teams', [TeamController::class, 'store'])->name('teams.store');
    Route::put('/teams/{team}', [TeamController::class, 'update'])->name('teams.update');
    Route::delete('/teams/{team}', [TeamController::class, 'destroy'])->name('teams.destroy');

    // Route to update an existing news/event
    Route::put('/news/{id}', [App\Http\Controllers\NewsandeventController::class, 'update'])->name('newsandevent.update');

    // Optional: Route to delete a news/event
    Route::delete('/news/{id}', [App\Http\Controllers\NewsandeventController::class, 'destroy'])->name('newsandevent.destroy');
    // Route to store new gallery item
    Route::post('/store/gallery', [App\Http\Controllers\GalleryController::class, 'store'])->name('gallery.store');
    Route::get('/create/gallery', [App\Http\Controllers\GalleryController::class, 'create'])->name('gallery.index');
    // Route to update an existing gallery item
    Route::put('/update/{gallery}', [App\Http\Controllers\GalleryController::class, 'update'])->name('gallery.update');

    // Route to delete a gallery item (optional)
    Route::delete('/delete/{gallery}', [App\Http\Controllers\GalleryController::class, 'destroy'])->name('gallery.destroy');
});

Route::group(['middleware' => ['auth', 'isStudent', 'PreventBackHistory']], function () {
    // Student routes
    Route::get('/student/dashboard', [App\Http\Controllers\StudentController::class, 'dashboard'])->name('student.dashboard');
});

Route::group(['middleware' => ['auth', 'isTutor', 'PreventBackHistory']], function () {
    // Tutor routes
    Route::get('/tutor/dashboard', [App\Http\Controllers\TutorController::class, 'dashboard'])->name('tutor.dashboard');
});

Route::get('/paymentsreceipt', [App\Http\Controllers\PaymentreceiptController::class, 'index'])->name('Paymentreceipt.index');
Route::get('/payment-receipts/{id}/print', [App\Http\Controllers\PaymentreceiptController::class, 'print'])->name('payment-receipts.print');
Route::post('/payment-receipts', [App\Http\Controllers\PaymentreceiptController::class, 'store'])->name('payment-receipts.store');

Route::get('/index', [App\Http\Controllers\HewittBannersController::class, 'index'])->name('hewitt_banners.index');
Route::post('/hewitt_bannerspost', [App\Http\Controllers\HewittBannersController::class, 'store'])->name('hewitt_banners.store');
Route::patch('/hewitt_bannersupdate{id}', [App\Http\Controllers\HewittBannersController::class, 'update'])->name('hewitt_banners.update');
Route::delete('/hewitt_bannersdestroy{id}', [App\Http\Controllers\HewittBannersController::class, 'destroy'])->name('hewitt_banners.destroy');
Route::get('/hewitt_bannersedit{id}', [App\Http\Controllers\HewittBannersController::class, 'edit'])->name('hewitt_banners.edit');
Route::get('/student/index', [App\Http\Controllers\StudentController::class, 'index'])->name('hewitt_student.index');
Route::get('/student/mycourses', [App\Http\Controllers\StudentController::class, 'courses'])->name('hewitt_student.courses');
Route::get('/director/index', [App\Http\Controllers\DirectorController::class, 'index'])->name('hewitt_director.index');
Route::get('/staff/index', [App\Http\Controllers\StaffController::class, 'index'])->name('hewitt_staff.index');
Route::get('/director/message', [App\Http\Controllers\aboutcontroller::class, 'aboutdirector'])->name('hewitt_director.about');
Route::get('/principal/message', [App\Http\Controllers\aboutcontroller::class, 'aboutprincipal'])->name('hewitt_principal.about');
Route::get('/dean/message', [App\Http\Controllers\aboutcontroller::class, 'aboutdean'])->name('hewitt_dean.about');
Route::get('/Captain/message', [App\Http\Controllers\aboutcontroller::class, 'aboutCaptain'])->name('hewitt_Captain.about');
Route::get('/courses/othercourses', [App\Http\Controllers\CoursesController::class, 'medicalsciences'])->name('hewitt_Captain.othercourses');
Route::get('/courses/caregivercourses', [App\Http\Controllers\CoursesController::class, 'shortcourses'])->name('hewitt_Captain.caregivercourses');
Route::get('/courses/cnacourses', [App\Http\Controllers\CoursesController::class, 'nursing'])->name('hewitt_Captain.cnacourses');
Route::get('/courses/hosipitality', [App\Http\Controllers\CoursesController::class, 'hosipitality'])->name('hewitt_Captain.hosipitality');
Route::post('/registercourse', [App\Http\Controllers\CourseapplicationController::class,  'store'])->name('courseregistration.store');
Route::get('/course/department', [App\Http\Controllers\CoursesController::class,  'index'])->name('index.cdpert');
Route::post('/coursesstore', [App\Http\Controllers\CoursesController::class,  'store'])->name('courses.store');
Route::get('/accreditations', [App\Http\Controllers\CoursesController::class, 'accreditations'])->name('hewitt_Captain.accreditations');
// Routes for Department
Route::get('/departments', [App\Http\Controllers\DepartmentController::class,  'index'])->name('index.departments');
Route::post('/departmentstore', [App\Http\Controllers\DepartmentController::class,  'store'])->name('departments.store');
Route::get('/departments/{department}/edit', [App\Http\Controllers\DepartmentController::class,  'edit'])->name('departments.edit');
Route::put('/departments/{department}', [App\Http\Controllers\DepartmentController::class,  'update'])->name('departments.update');
Route::delete('/departmentsdelete/{department}', [App\Http\Controllers\DepartmentController::class,  'destroy'])->name('departments.destroy');
Route::get('/courses/{course}/edit', [App\Http\Controllers\CoursesController::class,  'edit'])->name('courses.edit');
Route::put('/courses/{course}', [App\Http\Controllers\CoursesController::class, 'update'])->name('courses.update');
Route::delete('/courses/{course}', [App\Http\Controllers\CoursesController::class,  'destroy'])->name('courses.destroy');
Route::get('/feesstructure', [App\Http\Controllers\CoursesController::class,  'fees'])->name('courses.fees');
//Routes for Units
Route::get('/units', [App\Http\Controllers\UnitController::class,  'index'])->name('index.units');
Route::post('/unitstore', [App\Http\Controllers\UnitController::class,  'store'])->name('unit.store');
Route::put('units/{unit}', [App\Http\Controllers\UnitController::class, 'update'])->name('units.update');
Route::get('units/{unit}/edit', [App\Http\Controllers\UnitController::class, 'edit'])->name('units.edit');
Route::delete('/units/{department}', [App\Http\Controllers\UnitController::class,  'destroy'])->name('units.destroy');
Route::get('/student/courses', [App\Http\Controllers\StudentController::class, 'courses'])->name('student.courses');
Route::get('/student/units/{course}', [App\Http\Controllers\StudentController::class, 'units'])->name('student.units');
Route::post('/student/enroll/{unit}', [App\Http\Controllers\StudentController::class, 'enroll'])->name('student.enroll');
Route::get('/gallery', [App\Http\Controllers\GalleryController::class, 'index'])->name('student.gallery');
Route::post('/review', [App\Http\Controllers\ReviewsController::class, 'store'])->name('testimonials.store');
Route::get('/index/review', [App\Http\Controllers\ReviewsController::class, 'index'])->name('index.review');
Route::get('/attachment', [App\Http\Controllers\AttachmentController::class, 'index'])->name('index.attachment');
Route::post('/submit-application', [App\Http\Controllers\AttachmentController::class, 'store'])->name('submit-application');
Route::get('/jobs', [App\Http\Controllers\JobsController::class, 'index'])->name('index.jobs');
Route::post('/submit-japplication', [App\Http\Controllers\JobsController::class, 'store'])->name('submit-japplication');
// Display the registration form
Route::get('/registration', [App\Http\Controllers\RegistrationformController::class, 'index'])->name('registration.create');
// Handle form submissions
Route::post('/registration/submit', [App\Http\Controllers\RegistrationformController::class, 'store'])->name('registration.submit');
Route::get('/registrationforms', [App\Http\Controllers\RegistrationformController::class, 'registrationforms'])->name('registrationforms.index');

//workabroad
Route::get('/workabroad', [App\Http\Controllers\WorkabroadController::class, 'index'])->name('workabroad.index');
Route::get('/students/create', [StudentDataController::class, 'create'])->name('students.create');
Route::post('/students', [StudentDataController::class, 'store'])->name('students.store');
Route::get('/get-student-info/{studentNumber}', [App\Http\Controllers\PaymentreceiptController::class, 'getStudentInfo']);
Route::put('/students/{student}',  [StudentDataController::class, 'update'])->name('students.update');
Route::get('/students/{student}/edit', [StudentDataController::class, 'edit'])->name('students.edit');
Route::get('/student/fee-statement', [FeesstructureController::class, 'index'])->name('fee-statement.index');
Route::get('tutor_exams', [OnlineExamsController::class, 'index'])->name('tutor_exams.index');

// Store a new online exam
Route::post('/online_exams', [OnlineExamsController::class, 'store'])->name('online_exams.store');
Route::post('/questions', [QuestionsController::class, 'store'])->name('questions.store');

Route::get('all_exams', [QuestionsController::class, 'index'])->name('exams_all.index');
Route::get('/exams/start/{exam}', [QuestionsController::class, 'start'])->name('exams.start');

Route::post('/responses', [StudentResponsesController::class, 'store'])->name('exams.submit');
Route::post('/exams', [StudentExamsController::class, 'store'])->name('exams.store');
Route::get('/tutor/exam-results', [TutorController::class, 'viewExamResults'])->name('tutor.exam-results');

Route::get('/tutor/Student_scores', [TutorController::class, 'StudentScores'])->name('tutor.Student_scores');
Route::post('/scores', [StudentScoresController::class, 'store'])->name('exams.scores');
Route::get('/student/my-scores', [StudentController::class, 'myscores'])->name('student.my-scores');
Route::get('/hewittandbennet/news', [App\Http\Controllers\NewsandeventController::class, 'newsfront'])->name('news.event');

Route::get('news-and-events/{slug}', [App\Http\Controllers\NewsandeventController::class, 'show'])->name('newsandevent.show');


Route::get('/course/{slug}', [CoursesController::class, 'showSingleCourse'])->name('course.single');
Route::get('/courses', [CoursesController::class, 'allcourses'])->name('courses.all');// Partners Routes
Route::get('/partners', [PartnerController::class, 'index'])->name('partners.show');
Route::post('/partners/store', [PartnerController::class, 'store'])->name('partners.store');

Route::put('/partners/update/{id}', [PartnerController::class, 'update'])->name('partners.update');
Route::delete('/partners/destroy/{id}', [PartnerController::class, 'destroy'])->name('partners.destroy');
