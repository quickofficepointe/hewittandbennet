@extends('layouts.welcomelayout')

@php
    use Illuminate\Support\Str;

    $college = config('college');
    // Tuition is blank for some courses; then only the registration fee is known.
    $feeLabel = fn ($course) => (float) $course->school_fees > 0
        ? 'KES '.number_format((float) $course->registration_fees + (float) $course->school_fees + (float) $course->school_uniform_fee)
        : ((float) $course->registration_fees > 0 ? 'Registration KES '.number_format((float) $course->registration_fees) : 'Contact us');
    $featured = [
        ['Caregiving', '4–6 Months', 'fa-hand-holding-medical', 'caregiv'],
        ['Emergency Medical Technician', '12–24 Months', 'fa-truck-medical', 'emergency'],
        ['Medical Imaging', '12 Months', 'fa-x-ray', 'imaging'],
        ['Mortuary Science', '12 Months', 'fa-microscope', 'mortuary'],
        ['German Language', '3 Months', 'fa-language', 'german'],
        ['Cabin Crew', '6–9 Months', 'fa-plane-departure', 'cabin'],
    ];
    $whyUs = [
        ['fa-certificate', 'Accredited Programs', 'TVETA, NITA & CDACC approved'],
        ['fa-user-tie', 'Expert Trainers', 'Industry professionals'],
        ['fa-location-dot', count($college['campuses']).' Campuses', 'Across Nairobi & environs'],
        ['fa-earth-europe', 'Global Placement', 'Study & work abroad'],
        ['fa-hand-holding-heart', 'Practical Training', 'Hands-on skills labs'],
        ['fa-briefcase', 'Career Support', 'Placement & guidance'],
    ];
    $steps = [
        ['Choose Your Course', 'Browse our programs and pick the one that fits your goals.'],
        ['Apply Online', 'Complete the application form online or at any campus.'],
        ['Submit Documents', 'Provide your academic and identification documents.'],
        ['Pay Fees', 'Pay registration and course fees via M-Pesa or bank.'],
        ['Get Admitted', 'Receive your admission letter and portal login, then report.'],
    ];
    $fallbackGallery = ['gallery-6', 'gallery-5', 'gallery-hero', 'gallery-caregiving', 'gallery-3', 'gallery-1', 'gallery-4', 'gallery-2'];
@endphp

@section('content')

{{-- ===== HERO ===== --}}
<section class="relative bg-hbNavy overflow-hidden">
    <div class="absolute inset-0 opacity-20 bg-[radial-gradient(circle_at_20%_20%,#2F55A4_0,transparent_45%),radial-gradient(circle_at_90%_80%,#E31E24_0,transparent_35%)]" aria-hidden="true"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center min-h-[460px] py-12 md:py-0">
            <div class="text-white">
                <p class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-[0.2em] text-hbGold mb-4">
                    <i class="fa-solid fa-award"></i> {{ implode(' · ', $college['accreditations']) }} Accredited
                </p>
                <h1 class="font-serif text-4xl md:text-5xl font-black leading-tight">
                    Empowering Students<br> for <span class="text-hbGold">Global Careers</span>
                </h1>
                <p class="mt-5 text-lg text-white/85 max-w-xl">
                    Kenya's leading TVET college in Healthcare, Hospitality and Languages, with structured pathways to work and study abroad. Start your journey today.
                </p>
                <div class="mt-8 flex flex-wrap gap-4">
                    <a href="{{ route('registration.create') }}" class="bg-hbRed text-white px-8 py-3.5 text-sm font-black uppercase rounded-md hover:bg-red-700 shadow-lg shadow-black/20 transition">Apply Now</a>
                    <a href="{{ route('courses.all') }}" class="bg-white text-hbNavy px-8 py-3.5 text-sm font-black uppercase rounded-md hover:bg-gray-100 transition">View All Courses</a>
                </div>
                <div class="mt-8 flex flex-wrap items-center gap-x-6 gap-y-2 text-sm text-white/70">
                    <span><i class="fa-solid fa-calendar-check text-hbGold mr-2"></i>Monthly intakes</span>
                    <span><i class="fa-solid fa-laptop text-hbGold mr-2"></i>On-campus, online &amp; hybrid</span>
                </div>
            </div>
            <div class="flex justify-center md:justify-end">
                <img src="{{ asset('images/hero-students.webp') }}" alt="Hewitt & Bennet health sciences students in a practical class"
                     class="w-full max-w-md h-auto rounded-2xl bg-white shadow-2xl" width="900" height="600" fetchpriority="high">
            </div>
        </div>
    </div>
</section>

{{-- ===== STATS ===== --}}
<section class="bg-hbRed text-white py-8" aria-label="College in numbers">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
        @foreach ($college['stats'] as [$value, $label])
            <div>
                <div class="text-3xl md:text-4xl font-black">{{ $value }}</div>
                <div class="text-sm text-white/85 mt-1">{{ $label }}</div>
            </div>
        @endforeach
    </div>
</section>

{{-- ===== FEATURED COURSES ===== --}}
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <p class="text-center text-xs font-bold uppercase tracking-[0.2em] text-hbRed">Programs</p>
        <h2 class="text-center text-2xl md:text-3xl font-black text-hbNavy uppercase mt-2">Featured Courses</h2>
        <p class="text-center text-gray-500 text-sm mt-2 mb-10">Accredited programs designed for in-demand careers locally and globally</p>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            @foreach ($featured as [$title, $duration, $icon, $keyword])
                @php $match = $coursese->first(fn ($c) => Str::contains(Str::lower($c->name), $keyword)); @endphp
                <a href="{{ $match ? route('course.single', $match->slug) : route('courses.all') }}"
                   class="group border border-gray-200 rounded-xl p-5 text-center hover:shadow-xl hover:-translate-y-1 hover:border-hbNavy/30 transition">
                    <span class="w-16 h-16 mx-auto mb-4 rounded-full bg-brand-50 text-hbNavy flex items-center justify-center text-2xl group-hover:bg-hbNavy group-hover:text-white transition">
                        <i class="fa-solid {{ $icon }}"></i>
                    </span>
                    <h3 class="text-hbNavy text-xs font-black uppercase leading-tight">{{ $title }}</h3>
                    <p class="text-xs mt-2 text-gray-500">{{ $duration }}</p>
                </a>
            @endforeach
        </div>
        <div class="text-center mt-10">
            <a href="{{ route('courses.all') }}" class="bg-hbRed text-white px-8 py-3 text-sm font-black uppercase rounded-md hover:bg-red-700 transition inline-block">See All Courses &amp; Fees</a>
        </div>
    </div>
</section>

{{-- ===== WHY CHOOSE US ===== --}}
<section class="bg-hbNavy text-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <h2 class="text-center text-2xl md:text-3xl font-black uppercase mb-10">Why Choose Hewitt &amp; Bennet</h2>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 text-center">
            @foreach ($whyUs as [$icon, $title, $text])
                <div class="bg-white/5 ring-1 ring-white/10 rounded-xl p-5 hover:bg-white/10 transition">
                    <i class="fa-solid {{ $icon }} text-3xl text-hbGold mb-3"></i>
                    <h3 class="text-xs font-black uppercase">{{ $title }}</h3>
                    <p class="text-xs text-white/70 mt-2">{{ $text }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ===== STUDY & WORK ABROAD + TESTIMONIALS ===== --}}
<section id="work-abroad" class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 grid lg:grid-cols-2 gap-12 items-start">
        <div>
            <p class="text-xs font-bold uppercase tracking-[0.2em] text-hbRed">International Pathways</p>
            <h2 class="text-2xl font-black text-hbNavy uppercase mt-2 mb-5">Study &amp; Work Abroad</h2>
            <p class="text-gray-600 mb-6">We partner with employers and institutions in Germany and across Europe to place qualified graduates in healthcare careers, with support at every step.</p>
            <ul class="space-y-3">
                @foreach ([
                    'Germany Caregiving Program – high demand, competitive salaries',
                    'Full visa processing and documentation support',
                    'German language training (A1–B2 levels)',
                    'Pre-departure orientation and cultural training',
                    'Ongoing support for graduates already in Germany',
                ] as $point)
                    <li class="flex items-start gap-3 text-gray-700"><i class="fa-solid fa-circle-check text-hbRed mt-1"></i><span>{{ $point }}</span></li>
                @endforeach
            </ul>
            <div class="mt-8 flex flex-wrap gap-3">
                <a href="{{ route('workabroad.index') }}" class="bg-hbRed text-white px-6 py-3 text-sm font-black uppercase rounded-md hover:bg-red-700 transition">Explore Work Abroad</a>
                <a href="{{ route('contact.show', ['subject' => 'Work Abroad Program']) }}" class="border-2 border-hbNavy text-hbNavy px-6 py-3 text-sm font-black uppercase rounded-md hover:bg-hbNavy hover:text-white transition">Enquire Now</a>
            </div>
        </div>

        <div x-data="{ i: 0, n: {{ max($testimonials->count(), 1) }} }" x-init="n > 1 && setInterval(() => i = (i + 1) % n, 7000)">
            <h2 class="text-2xl font-black text-hbNavy uppercase mb-5">What Our Students Say</h2>
            <div class="relative border border-gray-200 rounded-xl p-6 sm:p-8 bg-hbLight min-h-[220px]">
                <i class="fa-solid fa-quote-left text-5xl text-hbNavy/10 absolute top-5 right-6" aria-hidden="true"></i>
                @forelse ($testimonials as $index => $t)
                    <figure x-show="i === {{ $index }}" @if ($index) x-cloak @endif x-transition.opacity class="flex flex-col sm:flex-row gap-5">
                        <div class="w-20 h-20 rounded-full overflow-hidden bg-brand-100 flex-shrink-0 flex items-center justify-center text-2xl font-black text-hbNavy">
                            @if ($t->avatar)
                                <img src="{{ asset('storage/'.$t->avatar) }}" alt="" class="w-full h-full object-cover" loading="lazy">
                            @else
                                {{ Str::upper(Str::substr($t->name, 0, 1)) }}
                            @endif
                        </div>
                        <div>
                            @if ($t->rating)
                                <div class="text-hbGold text-sm mb-2" aria-label="{{ $t->rating }} out of 5 stars">@for ($s = 1; $s <= 5; $s++)<i class="fa-{{ $s <= $t->rating ? 'solid' : 'regular' }} fa-star"></i>@endfor</div>
                            @endif
                            <blockquote class="text-gray-700 italic leading-relaxed">“{{ $t->testimony }}”</blockquote>
                            <figcaption class="mt-4">
                                <span class="block text-sm font-black text-hbNavy">{{ $t->name }}</span>
                                <span class="text-xs text-gray-500">{{ collect([$t->position, $t->company])->filter()->implode(' – ') }}</span>
                            </figcaption>
                        </div>
                    </figure>
                @empty
                    <figure class="flex flex-col sm:flex-row gap-5">
                        <div class="w-20 h-20 rounded-full bg-brand-100 flex-shrink-0 flex items-center justify-center text-2xl font-black text-hbNavy">M</div>
                        <div>
                            <blockquote class="text-gray-700 italic leading-relaxed">“Hewitt &amp; Bennet gave me the skills and confidence to work in Germany. The training was excellent and truly life-changing.”</blockquote>
                            <figcaption class="mt-4"><span class="block text-sm font-black text-hbNavy">Mary W.</span><span class="text-xs text-gray-500">Caregiver – Germany</span></figcaption>
                        </div>
                    </figure>
                @endforelse
                @if ($testimonials->count() > 1)
                    <div class="flex justify-center gap-2 mt-6">
                        @foreach ($testimonials as $index => $t)
                            <button type="button" @click="i = {{ $index }}" class="w-2.5 h-2.5 rounded-full transition" :class="i === {{ $index }} ? 'bg-hbNavy w-6' : 'bg-gray-300'" aria-label="Show testimonial {{ $index + 1 }}"></button>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

{{-- ===== ACCREDITATIONS & PARTNERS ===== --}}
<section class="py-8 bg-gray-50 border-y border-gray-100" aria-label="Accreditations and partners">
    <h2 class="text-center text-xs font-bold uppercase tracking-[0.2em] text-gray-500 mb-6">Accreditations &amp; Partners</h2>
    <div class="overflow-hidden">
        <div class="flex w-max animate-scroll items-center">
            @foreach ([1, 2] as $copy)
                <div class="flex items-center gap-12 px-6 flex-shrink-0" @if ($copy === 2) aria-hidden="true" @endif>
                    @foreach ($partners as $partner)
                        <img src="{{ asset('storage/'.$partner->logo) }}" alt="{{ $partner->name }}" class="h-14 w-auto object-contain" loading="lazy">
                    @endforeach
                    <img src="{{ asset('images/partner-h2.webp') }}" alt="{{ $copy === 1 ? 'Skill Development Council Canada, UKIQ, British Council, IELTS, EuroAmerican Education' : '' }}" class="h-12 w-auto object-contain" loading="lazy">
                    <img src="{{ asset('images/partner-c1.webp') }}" alt="{{ $copy === 1 ? 'Accreditation and partner logos' : '' }}" class="h-12 w-auto object-contain" loading="lazy">
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ===== ABOUT ===== --}}
<section id="about" class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <div class="bg-hbNavy text-white px-6 py-10 rounded-t-xl">
            <h2 class="text-2xl md:text-3xl font-black uppercase">About Hewitt &amp; Bennet International College</h2>
            <p class="mt-2 text-white/80">A leading TVET institution committed to quality education, practical skills and internationally competitive graduates.</p>
        </div>
        <div class="grid md:grid-cols-2 gap-10 mt-10">
            <div>
                <h3 class="text-xl font-black text-hbNavy uppercase mb-4">College Profile</h3>
                <p class="text-gray-600 leading-relaxed">Hewitt &amp; Bennet International College is a TVET institution dedicated to quality education and practical training that prepares students for successful careers in Kenya and abroad. We are accredited by TVETA, NITA and CDACC.</p>
                <div class="grid sm:grid-cols-2 gap-4 mt-6">
                    <div class="bg-hbLight rounded-lg p-4 border-l-4 border-hbNavy">
                        <h4 class="font-bold text-hbNavy">Vision</h4>
                        <p class="text-sm text-gray-600 mt-1">To be a leading institution inspiring innovation, transformation and excellence.</p>
                    </div>
                    <div class="bg-hbLight rounded-lg p-4 border-l-4 border-hbRed">
                        <h4 class="font-bold text-hbRed">Mission</h4>
                        <p class="text-sm text-gray-600 mt-1">To provide quality education that builds reliable citizens and professionals who transform lives.</p>
                    </div>
                </div>
                <h4 class="font-bold text-hbNavy mt-6">Core Values</h4>
                <div class="grid grid-cols-2 gap-2 mt-2">
                    @foreach (['Integrity', 'Excellence', 'Professionalism', 'Inclusivity'] as $value)
                        <div class="flex items-center gap-2 text-sm text-gray-700 py-2 border-b"><i class="fa-solid fa-diamond text-[8px] text-hbRed"></i> {{ $value }}</div>
                    @endforeach
                </div>
            </div>
            <div>
                <h3 class="text-xl font-black text-hbNavy uppercase mb-4">Leadership</h3>
                <div class="grid sm:grid-cols-2 gap-4">
                    @forelse ($teams->take(4) as $member)
                        <div class="border rounded-xl overflow-hidden">
                            <img src="{{ asset('storage/'.$member->image) }}" alt="{{ $member->name }}" class="w-full h-56 object-cover object-top" loading="lazy">
                            <div class="p-4">
                                <h4 class="font-black text-hbNavy text-sm uppercase">{{ $member->name }}</h4>
                                <p class="text-xs text-gray-500 mt-1">{{ Str::limit(strip_tags($member->description), 110) }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="border rounded-xl overflow-hidden">
                            <img src="{{ asset('images/director.webp') }}" alt="Patrick Hawala, Director" class="w-full h-56 object-cover object-top" loading="lazy">
                            <div class="p-4">
                                <h4 class="font-black text-hbNavy text-sm">PATRICK HAWALA</h4>
                                <p class="text-hbRed font-bold text-xs">Director</p>
                                <p class="text-xs text-gray-500 mt-1">Provides strategic leadership with extensive experience in TVET education and management.</p>
                            </div>
                        </div>
                    @endforelse
                    <div class="border rounded-xl p-5 flex flex-col justify-between bg-hbLight">
                        <div>
                            <h4 class="font-black text-hbNavy text-sm uppercase">Accredited &amp; Recognised</h4>
                            <ul class="mt-3 space-y-2 text-sm text-gray-700">
                                <li><i class="fa-solid fa-circle-check text-hbRed mr-2"></i>TVETA registered institution</li>
                                <li><i class="fa-solid fa-circle-check text-hbRed mr-2"></i>NITA accredited trade tests</li>
                                <li><i class="fa-solid fa-circle-check text-hbRed mr-2"></i>TVET CDACC competency-based programs</li>
                            </ul>
                        </div>
                        <a href="{{ route('hewitt_Captain.accreditations') }}" class="mt-5 text-xs font-bold uppercase text-hbNavy hover:text-hbRed">Our accreditations →</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===== COURSES ===== --}}
<section id="courses" class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <div class="bg-hbNavy text-white px-6 py-10 rounded-t-xl">
            <h2 class="text-2xl md:text-3xl font-black uppercase">Our Courses</h2>
            <p class="mt-2 text-white/80">Accredited, practical programs for in-demand careers – locally and internationally</p>
        </div>
        <div class="bg-white shadow-lg rounded-b-xl overflow-hidden">
            {{-- Cards on phones, table on larger screens --}}
            <div class="md:hidden divide-y">
                @foreach ($coursese as $course)
                    <div class="p-5">
                        <a href="{{ route('course.single', $course->slug) }}" class="font-bold text-hbNavy hover:text-hbRed">{{ $course->name }}</a>
                        <p class="text-xs text-gray-500 mt-1">{{ $course->duration ?: '—' }} · {{ $course->department->name ?? 'General' }}</p>
                        <p class="text-sm font-semibold mt-2">{{ $feeLabel($course) }}</p>
                        <div class="flex gap-2 mt-3">
                            <a href="{{ route('course.single', $course->slug) }}" class="flex-1 text-center border border-hbNavy text-hbNavy px-3 py-2 rounded-md text-xs font-bold">Learn More</a>
                            <button type="button" onclick="openEnrollModal({{ $course->id }})" class="flex-1 bg-hbRed text-white px-3 py-2 rounded-md text-xs font-bold">Apply</button>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full border-collapse text-sm">
                    <thead>
                        <tr class="bg-brand-50 text-hbNavy text-xs uppercase text-left">
                            <th class="px-4 py-3 font-bold">Course</th>
                            <th class="px-4 py-3 font-bold">Department</th>
                            <th class="px-4 py-3 font-bold">Duration</th>
                            <th class="px-4 py-3 font-bold">Fees</th>
                            <th class="px-4 py-3 font-bold sr-only">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse ($coursese as $course)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-4 py-4">
                                    <a href="{{ route('course.single', $course->slug) }}" class="font-bold text-hbNavy hover:text-hbRed">{{ $course->name }}</a>
                                    <p class="text-xs text-gray-500 mt-1 max-w-md">{{ Str::limit(strip_tags($course->course_description), 90) }}</p>
                                </td>
                                <td class="px-4 py-4 text-gray-600">{{ $course->department->name ?? '—' }}</td>
                                <td class="px-4 py-4 whitespace-nowrap">{{ $course->duration ?: '—' }}</td>
                                <td class="px-4 py-4 whitespace-nowrap font-semibold">{{ $feeLabel($course) }}</td>
                                <td class="px-4 py-4">
                                    <div class="flex gap-2 justify-end">
                                        <a href="{{ route('course.single', $course->slug) }}" class="border border-hbNavy text-hbNavy px-3 py-2 rounded-md text-xs font-bold hover:bg-hbNavy hover:text-white transition whitespace-nowrap">Learn More</a>
                                        <button type="button" onclick="openEnrollModal({{ $course->id }})" class="bg-hbRed text-white px-4 py-2 rounded-md text-xs font-bold hover:bg-red-700 transition">Apply</button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center py-10 text-gray-500">Courses will be published soon.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <p class="px-6 py-4 bg-gray-50 border-t text-sm text-gray-600"><i class="fa-solid fa-circle-info text-hbRed mr-2"></i>Fees are subject to change. See the <a href="{{ route('courses.fees') }}" class="font-semibold text-hbNavy underline">fees structure</a> or contact us for the latest figures.</p>
        </div>
    </div>
</section>

{{-- ===== ADMISSIONS ===== --}}
<section id="admissions" class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <div class="bg-hbNavy text-white px-6 py-10 rounded-t-xl">
            <h2 class="text-2xl md:text-3xl font-black uppercase">Admissions</h2>
            <p class="mt-2 text-white/80">Five simple steps to join one of our programs</p>
        </div>
        <div class="bg-white shadow-lg rounded-b-xl p-6 sm:p-8">
            <ol class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-4">
                @foreach ($steps as $n => [$title, $text])
                    <li class="text-center p-5 border rounded-xl hover:border-hbNavy transition">
                        <span class="w-12 h-12 bg-hbNavy text-white rounded-full flex items-center justify-center text-xl font-black mx-auto mb-3">{{ $n + 1 }}</span>
                        <h3 class="font-bold text-hbNavy text-sm">{{ $title }}</h3>
                        <p class="text-xs text-gray-500 mt-1">{{ $text }}</p>
                    </li>
                @endforeach
            </ol>
            <div class="grid md:grid-cols-3 gap-8 mt-10">
                <div>
                    <h3 class="font-bold text-hbNavy text-lg">Entry Requirements</h3>
                    <ul class="mt-3 space-y-2 text-sm text-gray-600">
                        @foreach (['KCSE Certificate (or international equivalent)', 'Minimum Grade C (Plain)', 'Age 17 years and above', 'Valid Birth Certificate'] as $req)
                            <li class="flex gap-2 border-b pb-2"><i class="fa-solid fa-circle-check text-emerald-600 mt-0.5"></i>{{ $req }}</li>
                        @endforeach
                    </ul>
                </div>
                <div>
                    <h3 class="font-bold text-hbNavy text-lg">Required Documents</h3>
                    <ul class="mt-3 space-y-2 text-sm text-gray-600">
                        @foreach (['Academic certificates & result slips', 'National ID, birth certificate or passport', 'Two passport-size photos', 'Completed application form'] as $doc)
                            <li class="flex gap-2 border-b pb-2"><i class="fa-solid fa-file-lines text-hbNavy mt-0.5"></i>{{ $doc }}</li>
                        @endforeach
                    </ul>
                </div>
                <div>
                    <h3 class="font-bold text-hbNavy text-lg">Intakes</h3>
                    <div class="grid grid-cols-2 gap-3 mt-3">
                        <div class="bg-hbNavy text-white p-4 rounded-lg text-center"><span class="block text-lg font-black">Monthly</span><span class="text-xs text-white/70">Regular intake</span></div>
                        <div class="bg-hbRed text-white p-4 rounded-lg text-center"><span class="block text-lg font-black">Open</span><span class="text-xs text-white/80">Rolling enrolment</span></div>
                    </div>
                    <a href="{{ route('courses.fees') }}" class="mt-4 inline-block text-sm font-bold text-hbNavy hover:text-hbRed">View fees structure →</a>
                </div>
            </div>
            <div class="flex flex-wrap justify-center gap-3 mt-10">
                <a href="{{ route('registration.create') }}" class="bg-hbRed text-white px-8 py-3 text-sm font-black uppercase rounded-md hover:bg-red-700 transition">Apply Online</a>
                <a href="{{ route('contact.show', ['subject' => 'Admissions Enquiry']) }}" class="border-2 border-hbNavy text-hbNavy px-8 py-3 text-sm font-black uppercase rounded-md hover:bg-hbNavy hover:text-white transition">Contact Admissions</a>
            </div>
        </div>
    </div>
</section>

{{-- ===== CAMPUSES ===== --}}
<section id="campuses" class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <div class="bg-hbNavy text-white px-6 py-10 rounded-t-xl">
            <h2 class="text-2xl md:text-3xl font-black uppercase">Our Campuses</h2>
            <p class="mt-2 text-white/80">Quality education close to you – {{ count($college['campuses']) }} campuses in and around Nairobi</p>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 mt-6">
            @foreach ($college['campuses'] as $campus)
                <div class="bg-white border rounded-xl overflow-hidden hover:shadow-lg transition flex flex-col">
                    @if ($campus['image'])
                        <img src="{{ asset($campus['image']) }}" alt="{{ $campus['name'] }}" class="w-full h-44 object-cover" loading="lazy">
                    @else
                        <div class="w-full h-44 bg-gradient-to-br from-hbNavy to-brand-600 flex items-center justify-center text-5xl text-white/30"><i class="fa-solid fa-building-columns"></i></div>
                    @endif
                    <div class="p-5 flex flex-col flex-1">
                        <h3 class="font-black text-hbNavy text-lg">{{ $campus['name'] }}</h3>
                        <p class="text-sm text-gray-500 mt-1"><i class="fa-solid fa-location-dot text-hbRed mr-1"></i>{{ $campus['address'] }}</p>
                        <p class="text-sm text-gray-600 mt-2 flex-1">{{ $campus['blurb'] }}</p>
                        <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode('Hewitt and Bennet International College '.$campus['name'].' '.$campus['address']) }}" target="_blank" rel="noopener"
                           class="mt-4 inline-flex items-center justify-center gap-2 border-2 border-hbNavy text-hbNavy px-4 py-2 text-xs font-bold rounded-md hover:bg-hbNavy hover:text-white transition">
                            <i class="fa-solid fa-diamond-turn-right"></i> Get Directions
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ===== NEWS ===== --}}
<section id="news" class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <div class="bg-hbNavy text-white px-6 py-10 rounded-t-xl">
            <h2 class="text-2xl md:text-3xl font-black uppercase">News &amp; Events</h2>
            <p class="mt-2 text-white/80">The latest from Hewitt &amp; Bennet International College</p>
        </div>
        <div class="grid md:grid-cols-3 gap-6 mt-6">
            @forelse ($news as $item)
                <article class="bg-white border rounded-xl overflow-hidden hover:shadow-lg transition flex flex-col">
                    <img src="{{ asset('storage/'.$item->cover_image) }}" alt="" class="w-full h-48 object-cover" loading="lazy">
                    <div class="p-5 flex flex-col flex-1">
                        <time class="text-[11px] font-bold uppercase tracking-wider text-gray-500" datetime="{{ $item->created_at?->toDateString() }}">{{ $item->created_at?->format('d M Y') }}</time>
                        <h3 class="font-black text-hbNavy mt-2 mb-2">{{ $item->title }}</h3>
                        <p class="text-gray-600 text-sm flex-1">{{ Str::limit(strip_tags($item->content), 120) }}</p>
                        <a href="{{ route('newsandevent.show', $item->slug) }}" class="text-hbRed text-sm font-bold mt-3 hover:underline">Read more →</a>
                    </div>
                </article>
            @empty
                @foreach ([
                    ['news-germany', 'Germany', 'Germany Opportunities Still Open', 'High demand for Kenyan caregivers in Germany. We provide full pre-departure support and placement.', route('workabroad.index'), 'Learn more'],
                    ['news-caregiving', 'Caregiving', 'New Caregiving Pathways Program', 'Training, German language, documentation and placement support – all in one structured program.', route('hewitt_Captain.caregivercourses'), 'View program'],
                    ['news-visa', 'Visa Support', 'End-to-End Visa Assistance', 'Our experienced team handles your complete visa documentation and submission process.', route('contact.show', ['subject' => 'Work Abroad Program']), 'Enquire now'],
                ] as [$img, $tag, $title, $text, $link, $cta])
                    <article class="bg-white border rounded-xl overflow-hidden hover:shadow-lg transition flex flex-col">
                        <img src="{{ asset("images/$img.webp") }}" alt="" class="w-full h-48 object-cover" loading="lazy">
                        <div class="p-5 flex flex-col flex-1">
                            <span class="self-start bg-brand-50 text-hbNavy text-[10px] font-bold uppercase tracking-wider px-3 py-1 rounded">{{ $tag }}</span>
                            <h3 class="font-black text-hbNavy mt-3 mb-2">{{ $title }}</h3>
                            <p class="text-gray-600 text-sm flex-1">{{ $text }}</p>
                            <a href="{{ $link }}" class="text-hbRed text-sm font-bold mt-3 hover:underline">{{ $cta }} →</a>
                        </div>
                    </article>
                @endforeach
            @endforelse
        </div>
        <div class="text-center mt-8">
            <a href="{{ route('news.event') }}" class="bg-hbNavy text-white px-8 py-3 text-sm font-black uppercase rounded-md hover:bg-brand-700 transition inline-block">View All News</a>
        </div>
    </div>
</section>

{{-- ===== GALLERY ===== --}}
<section id="gallery" class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <div class="bg-hbNavy text-white px-6 py-10 rounded-t-xl">
            <h2 class="text-2xl md:text-3xl font-black uppercase">Gallery</h2>
            <p class="mt-2 text-white/80">Moments from our campuses, graduations and activities</p>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-6">
            @php
                $photos = $galleryItems->map(fn ($g) => [asset('storage/'.$g->file_path), $g->title])
                    ->concat(collect($fallbackGallery)->map(fn ($f) => [asset("images/$f.webp"), 'Hewitt & Bennet students']))
                    ->take(8);
            @endphp
            @foreach ($photos as [$src, $alt])
                <a href="{{ route('student.gallery') }}" class="block rounded-xl overflow-hidden shadow-md hover:shadow-xl transition">
                    <img src="{{ $src }}" alt="{{ $alt }}" class="w-full h-48 object-cover hover:scale-105 transition duration-300" loading="lazy">
                </a>
            @endforeach
        </div>
        <div class="text-center mt-8">
            <a href="{{ route('student.gallery') }}" class="bg-hbRed text-white px-8 py-3 text-sm font-black uppercase rounded-md hover:bg-red-700 transition inline-block">View Full Gallery</a>
        </div>
    </div>
</section>

{{-- ===== CONTACT ===== --}}
<section id="contact" class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <div class="bg-hbNavy text-white px-6 py-10 rounded-t-xl">
            <h2 class="text-2xl md:text-3xl font-black uppercase">Contact Us</h2>
            <p class="mt-2 text-white/80">We'd love to hear from you. Our team responds within one working day.</p>
        </div>
        <div class="grid md:grid-cols-2 gap-10 mt-10">
            @include('frontendviews.partials.contact-details')
            @include('frontendviews.partials.contact-form')
        </div>
    </div>
</section>

@include('frontendviews.partials.enroll-modal')
@endsection
