@php
    $college = config('college');
    $pageTitle = trim($__env->yieldContent('meta-title')) ?: (trim($__env->yieldContent('title')) ?: 'Hewitt & Bennet International College | Accredited TVET Programs in Kenya');
    $pageDescription = trim($__env->yieldContent('meta-description')) ?: 'Hewitt & Bennet International College – accredited TVET institution offering healthcare, caregiving, hospitality, medical imaging and international work-abroad programs. TVETA, NITA, CDACC approved.';
    $pageImage = trim($__env->yieldContent('og:image')) ?: trim($__env->yieldContent('meta-image'));
    // Several pages name share images that were never uploaded; fall back to the default card.
    $localImage = $pageImage ? public_path(ltrim((string) parse_url($pageImage, PHP_URL_PATH), '/')) : null;
    if (! $pageImage || (str_starts_with($pageImage, url('/')) && ! is_file($localImage))) {
        $pageImage = asset('images/og-image.jpg');
    }
    $navLinks = [
        ['Home', url('/'), request()->is('/')],
        ['About', url('/#about'), false],
        ['Courses', route('courses.all'), request()->is('courses*', 'course/*')],
        ['Admissions', route('registration.create'), request()->is('registration', 'apply')],
        ['Campuses', url('/#campuses'), false],
        ['Work Abroad', route('workabroad.index'), request()->is('workabroad')],
        ['News', route('news.event'), request()->is('hewittandbennet/news', 'news-and-events/*')],
        ['Gallery', route('student.gallery'), request()->is('gallery')],
        ['Contact', route('contact.show'), request()->is('contact')],
    ];
    $socialIcons = ['facebook' => 'fa-facebook-f', 'instagram' => 'fa-instagram', 'tiktok' => 'fa-tiktok', 'youtube' => 'fa-youtube', 'linkedin' => 'fa-linkedin-in'];
    $socials = array_filter($college['social']);
@endphp
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $pageTitle }}</title>
    <meta name="description" content="{{ $pageDescription }}">
    <meta name="keywords" content="@yield('meta-keywords', 'TVET College Kenya, Caregiving Course, EMT, Medical Imaging, German Language, Cabin Crew, Work Abroad Germany, Nairobi, Ngong, Buruburu, Thika, Rongai')">
    <meta name="author" content="@yield('meta-author', $college['name'])">
    <meta name="theme-color" content="#071B4D">
    <link rel="canonical" href="{{ url()->current() }}">

    {{-- Social sharing previews (pages override these with @section('og:*')) --}}
    <meta property="og:type" content="@yield('og:type', 'website')">
    <meta property="og:site_name" content="{{ $college['name'] }}">
    <meta property="og:title" content="{{ trim($__env->yieldContent('og:title')) ?: $pageTitle }}">
    <meta property="og:description" content="{{ trim($__env->yieldContent('og:description')) ?: $pageDescription }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ $pageImage }}">
    <meta property="og:locale" content="en_KE">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ trim($__env->yieldContent('twitter:title')) ?: $pageTitle }}">
    <meta name="twitter:description" content="{{ trim($__env->yieldContent('twitter:description')) ?: $pageDescription }}">
    <meta name="twitter:image" content="{{ $pageImage }}">

    <link rel="icon" href="{{ asset('assets/img/logo_nobg.png') }}" type="image/png">
    <link rel="apple-touch-icon" href="{{ asset('assets/img/logo_nobg.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Merriweather:wght@700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        // One palette for the whole public site: HBIC navy + red.
        // primary/secondary/hb* are kept as aliases so older pages keep working.
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#EEF2FA', 100: '#DCE4F4', 200: '#B9C8E8', 300: '#8CA3D6', 400: '#5677BD',
                            500: '#2F55A4', 600: '#1D3F8A', 700: '#143073', 800: '#0D245E', 900: '#071B4D', 950: '#04112F',
                        },
                        primary: '#071B4D',
                        secondary: '#E31E24',
                        light: '#F4F7FC',
                        hbBlue: '#071B4D',
                        hbBlueDark: '#04112F',
                        hbNavy: '#071B4D',
                        hbRed: '#E31E24',
                        hbGold: '#FFC72C',
                        hbLight: '#F4F7FC',
                        hbGray: '#6C757D',
                        hbDark: '#0B1530',
                        hbBorder: '#DEE2E6',
                    },
                    fontFamily: {
                        sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                        inter: ['Inter', 'sans-serif'],
                        serif: ['Merriweather', 'Georgia', 'serif'],
                        merriweather: ['Merriweather', 'serif'],
                    },
                }
            }
        }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js"></script>
    <style>
        [x-cloak] { display: none !important; }
        /* Keep anchored sections clear of the sticky header. */
        section[id] { scroll-margin-top: 6rem; }
        :focus-visible { outline: 3px solid #FFC72C; outline-offset: 2px; }
        @keyframes hb-scroll { from { transform: translateX(0); } to { transform: translateX(-50%); } }
        .animate-scroll { animation: hb-scroll 40s linear infinite; }
        .animate-scroll:hover { animation-play-state: paused; }
        @media (prefers-reduced-motion: reduce) {
            html { scroll-behavior: auto; }
            .animate-scroll { animation: none; }
            *, *::before, *::after { transition-duration: 0.01ms !important; }
        }
    </style>
    @yield('styles')
    @stack('styles')
</head>
<body class="bg-white text-gray-800 font-sans antialiased" x-data="{ mobileOpen: false }" :class="mobileOpen && 'overflow-hidden'">
    <a href="#main" class="sr-only focus:not-sr-only focus:fixed focus:top-2 focus:left-2 focus:z-[60] bg-hbRed text-white px-4 py-2 rounded">Skip to content</a>

    {{-- ===== TOP BAR ===== --}}
    <div class="hidden md:block bg-hbNavy text-white/80 text-xs">
        <div class="max-w-7xl mx-auto px-4 h-9 flex items-center justify-between gap-4">
            <div class="flex items-center gap-5">
                <span class="flex items-center gap-1.5"><i class="fa-solid fa-award text-hbGold"></i> {{ implode(' · ', $college['accreditations']) }} Accredited</span>
                <a href="tel:{{ preg_replace('/\s+/', '', $college['phones'][0]) }}" class="hover:text-white transition"><i class="fa-solid fa-phone mr-1.5"></i>{{ $college['phones'][0] }}</a>
                <a href="mailto:{{ $college['email'] }}" class="hover:text-white transition"><i class="fa-solid fa-envelope mr-1.5"></i>{{ $college['email'] }}</a>
            </div>
            <div class="flex items-center gap-5">
                <a href="{{ route('workabroad.index') }}" class="hover:text-white transition"><i class="fa-solid fa-earth-europe mr-1.5"></i>International Pathways</a>
                <a href="{{ route('index.jobs') }}" class="hover:text-white transition">Careers</a>
                @auth
                    <a href="{{ route('portal.dashboard') }}" class="font-semibold text-white hover:text-hbGold transition"><i class="fa-solid fa-gauge mr-1.5"></i>My Portal</a>
                @else
                    <a href="{{ route('login') }}" class="font-semibold text-white hover:text-hbGold transition"><i class="fa-solid fa-right-to-bracket mr-1.5"></i>Student &amp; Staff Portal</a>
                @endauth
            </div>
        </div>
    </div>

    {{-- ===== HEADER / NAVBAR ===== --}}
    <header class="sticky top-0 z-50 bg-white/95 backdrop-blur shadow-sm">
        <div class="max-w-7xl mx-auto px-4">
            <nav class="flex items-center justify-between h-20" aria-label="Main">
                <a href="{{ url('/') }}" class="flex items-center gap-3">
                    <img src="{{ asset('assets/img/logo_nobg.png') }}" alt="Hewitt & Bennet International College" class="h-12 w-auto" width="48" height="48">
                    <span class="leading-tight">
                        <span class="block font-black text-hbNavy text-sm">HEWITT AND BENNET</span>
                        <span class="block text-[10px] text-hbRed font-bold tracking-[0.2em]">INTERNATIONAL COLLEGE</span>
                    </span>
                </a>

                <div class="hidden xl:flex items-center gap-6 text-[13px] font-bold uppercase tracking-wide">
                    @foreach ($navLinks as [$label, $href, $active])
                        <a href="{{ $href }}" @class(['transition relative py-2', 'text-hbRed after:absolute after:inset-x-0 after:-bottom-0.5 after:h-0.5 after:bg-hbRed' => $active, 'text-gray-800 hover:text-hbRed' => ! $active]) @if ($active) aria-current="page" @endif>{{ $label }}</a>
                    @endforeach
                </div>

                <div class="flex items-center gap-3">
                    <a href="{{ route('registration.create') }}" class="hidden sm:inline-flex items-center gap-2 bg-hbRed text-white px-5 py-3 rounded-md text-xs font-black uppercase tracking-wide hover:bg-red-700 shadow-sm transition">
                        Apply Now <i class="fa-solid fa-arrow-right"></i>
                    </a>
                    <button type="button" @click="mobileOpen = true" class="xl:hidden w-11 h-11 rounded-md text-hbNavy text-2xl hover:bg-brand-50" aria-label="Open menu" :aria-expanded="mobileOpen">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                </div>
            </nav>
        </div>
    </header>

    {{-- ===== MOBILE MENU ===== --}}
    <div x-show="mobileOpen" x-cloak x-transition.opacity class="fixed inset-0 z-[55] xl:hidden" role="dialog" aria-modal="true" aria-label="Menu" @keydown.escape.window="mobileOpen = false">
        <div class="absolute inset-0 bg-black/50" @click="mobileOpen = false"></div>
        <div x-show="mobileOpen" x-transition:enter="transition duration-300" x-transition:enter-start="translate-x-full" x-transition:leave="transition duration-200" x-transition:leave-end="translate-x-full"
             class="absolute right-0 top-0 h-full w-full max-w-sm bg-white shadow-2xl overflow-y-auto">
            <div class="flex items-center justify-between px-5 py-4 border-b">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('assets/img/logo_nobg.png') }}" class="h-11" alt="">
                    <span class="leading-tight">
                        <span class="block font-black text-hbNavy text-xs">HEWITT AND BENNET</span>
                        <span class="block text-[9px] text-hbRed font-bold tracking-[0.2em]">INTERNATIONAL COLLEGE</span>
                    </span>
                </div>
                <button type="button" @click="mobileOpen = false" class="w-11 h-11 text-2xl text-hbNavy rounded-md hover:bg-brand-50" aria-label="Close menu"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="px-6 py-6 flex flex-col gap-1 text-sm font-bold uppercase">
                @foreach ($navLinks as [$label, $href, $active])
                    <a href="{{ $href }}" @click="mobileOpen = false" @class(['py-3 border-b border-gray-100 transition', 'text-hbRed' => $active, 'text-gray-800 hover:text-hbRed' => ! $active])>{{ $label }}</a>
                @endforeach
                <a href="{{ route('registration.create') }}" class="mt-5 bg-hbRed text-white text-center py-3 rounded-md hover:bg-red-700 transition">Apply Now</a>
                @auth
                    <a href="{{ route('portal.dashboard') }}" class="mt-2 border-2 border-hbNavy text-hbNavy text-center py-3 rounded-md hover:bg-hbNavy hover:text-white transition">My Portal</a>
                @else
                    <a href="{{ route('login') }}" class="mt-2 border-2 border-hbNavy text-hbNavy text-center py-3 rounded-md hover:bg-hbNavy hover:text-white transition">Student &amp; Staff Portal</a>
                @endauth
                <div class="mt-6 text-xs normal-case font-medium text-gray-500 space-y-2">
                    <a href="tel:{{ preg_replace('/\s+/', '', $college['phones'][0]) }}" class="block"><i class="fa-solid fa-phone text-hbRed mr-2"></i>{{ $college['phones'][0] }}</a>
                    <a href="mailto:{{ $college['email'] }}" class="block"><i class="fa-solid fa-envelope text-hbRed mr-2"></i>{{ $college['email'] }}</a>
                </div>
            </div>
        </div>
    </div>

    {{-- Pages that show their own flash message set @section('inline-flash', '1'). --}}
    @if ((session('success') || session('error') || session('status')) && ! trim($__env->yieldContent('inline-flash')))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 8000)" x-transition
             class="fixed top-24 right-4 left-4 sm:left-auto sm:w-96 z-[60] rounded-lg shadow-xl p-4 text-sm text-white flex items-start gap-3 {{ session('error') ? 'bg-hbRed' : 'bg-emerald-600' }}" role="status">
            <i class="fa-solid {{ session('error') ? 'fa-circle-exclamation' : 'fa-circle-check' }} mt-0.5"></i>
            <p class="flex-1">{{ session('success') ?? session('error') ?? session('status') }}</p>
            <button type="button" @click="show = false" class="text-white/80 hover:text-white" aria-label="Dismiss"><i class="fa-solid fa-xmark"></i></button>
        </div>
    @endif

    <main id="main">
        @yield('content')
    </main>

    {{-- ===== FOOTER ===== --}}
    <footer class="bg-hbDark text-white">
        <div class="bg-hbRed">
            <div class="max-w-7xl mx-auto px-4 py-5 grid md:grid-cols-3 gap-4 text-sm">
                <a href="tel:{{ preg_replace('/\s+/', '', $college['phones'][0]) }}" class="flex items-center gap-3 group">
                    <i class="fa-solid fa-phone text-2xl"></i>
                    <span><span class="block font-bold">Call Us</span><span class="text-white/90 group-hover:underline">{{ implode(' | ', array_slice($college['phones'], 0, 3)) }}</span></span>
                </a>
                <a href="mailto:{{ $college['email'] }}" class="flex items-center gap-3 group">
                    <i class="fa-solid fa-envelope text-2xl"></i>
                    <span><span class="block font-bold">Email Us</span><span class="text-white/90 group-hover:underline">{{ $college['email'] }}</span></span>
                </a>
                <a href="{{ url('/#campuses') }}" class="flex items-center gap-3 group">
                    <i class="fa-solid fa-location-dot text-2xl"></i>
                    <span><span class="block font-bold">Visit Us</span><span class="text-white/90 group-hover:underline">{{ collect($college['campuses'])->map(fn ($c) => str_replace(' Campus', '', $c['name']))->implode(' | ') }}</span></span>
                </a>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 py-12 grid sm:grid-cols-2 lg:grid-cols-4 gap-10">
            <div>
                <div class="flex items-center gap-3 mb-4">
                    <img src="{{ asset('assets/img/logo_nobg.png') }}" class="h-11" alt="">
                    <span class="leading-tight">
                        <span class="block font-black text-sm">HEWITT AND BENNET</span>
                        <span class="block text-[10px] text-hbRed font-bold tracking-[0.2em]">INTERNATIONAL COLLEGE</span>
                    </span>
                </div>
                <p class="text-sm text-white/70 leading-relaxed">Empowering students for global careers through accredited TVET education and internationally recognised qualifications.</p>
                <div class="flex flex-wrap gap-2 mt-5">
                    @foreach ($college['accreditations'] as $body)
                        <span class="text-[11px] font-bold tracking-wider border border-white/20 rounded px-2 py-1 text-white/80">{{ $body }}</span>
                    @endforeach
                </div>
            </div>

            <div>
                <h2 class="font-bold text-sm mb-4 uppercase tracking-wider">Quick Links</h2>
                <ul class="space-y-2 text-sm text-white/70">
                    <li><a href="{{ url('/#about') }}" class="hover:text-hbGold transition">About Us</a></li>
                    <li><a href="{{ route('hewitt_Captain.accreditations') }}" class="hover:text-hbGold transition">Accreditations</a></li>
                    <li><a href="{{ route('registration.create') }}" class="hover:text-hbGold transition">Admissions</a></li>
                    <li><a href="{{ route('news.event') }}" class="hover:text-hbGold transition">News &amp; Events</a></li>
                    <li><a href="{{ route('index.jobs') }}" class="hover:text-hbGold transition">Careers</a></li>
                    <li><a href="{{ route('index.attachment') }}" class="hover:text-hbGold transition">Industrial Attachment</a></li>
                </ul>
            </div>

            <div>
                <h2 class="font-bold text-sm mb-4 uppercase tracking-wider">Our Programs</h2>
                <ul class="space-y-2 text-sm text-white/70">
                    <li><a href="{{ route('courses.all') }}" class="hover:text-hbGold transition">All Courses</a></li>
                    <li><a href="{{ route('hewitt_Captain.caregivercourses') }}" class="hover:text-hbGold transition">Caregiving</a></li>
                    <li><a href="{{ route('hewitt_Captain.cnacourses') }}" class="hover:text-hbGold transition">Nursing &amp; Health</a></li>
                    <li><a href="{{ route('hewitt_Captain.hosipitality') }}" class="hover:text-hbGold transition">Hospitality</a></li>
                    <li><a href="{{ route('hewitt_Captain.othercourses') }}" class="hover:text-hbGold transition">Other Programs</a></li>
                    <li><a href="{{ route('workabroad.index') }}" class="hover:text-hbGold transition">Study &amp; Work Abroad</a></li>
                    <li><a href="{{ route('courses.fees') }}" class="hover:text-hbGold transition">Fees Structure</a></li>
                </ul>
            </div>

            <div>
                <h2 class="font-bold text-sm mb-4 uppercase tracking-wider">Contact Information</h2>
                <ul class="space-y-2 text-sm text-white/70">
                    @foreach (array_slice($college['phones'], 0, 3) as $phone)
                        <li><a href="tel:{{ preg_replace('/\s+/', '', $phone) }}" class="hover:text-hbGold transition"><i class="fa-solid fa-phone text-hbRed mr-2"></i>{{ $phone }}</a></li>
                    @endforeach
                    <li><a href="mailto:{{ $college['email'] }}" class="hover:text-hbGold transition"><i class="fa-solid fa-envelope text-hbRed mr-2"></i>{{ $college['email'] }}</a></li>
                    @foreach ($college['office_hours'] as $days => $hours)
                        <li><i class="fa-regular fa-clock text-hbRed mr-2"></i>{{ $days }}: {{ $hours }}</li>
                    @endforeach
                </ul>
                <div class="flex flex-wrap gap-3 mt-5">
                    @foreach ($socials as $network => $link)
                        <a href="{{ $link }}" target="_blank" rel="noopener" class="w-9 h-9 bg-white/10 rounded-full flex items-center justify-center hover:bg-hbRed transition" aria-label="{{ ucfirst($network) }}">
                            <i class="fa-brands {{ $socialIcons[$network] ?? 'fa-link' }} text-sm"></i>
                        </a>
                    @endforeach
                    <a href="https://wa.me/{{ $college['whatsapp'] }}" target="_blank" rel="noopener" class="w-9 h-9 bg-white/10 rounded-full flex items-center justify-center hover:bg-emerald-600 transition" aria-label="WhatsApp">
                        <i class="fa-brands fa-whatsapp text-sm"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="border-t border-white/10">
            <div class="max-w-7xl mx-auto px-4 py-4 flex flex-col md:flex-row items-center justify-between gap-3 text-sm text-white/50">
                <p>&copy; {{ date('Y') }} {{ $college['name'] }}. All rights reserved.</p>
                <p class="flex gap-4">
                    <a href="{{ route('contact.show') }}" class="hover:text-white transition">Contact</a>
                    <a href="{{ route('login') }}" class="hover:text-white transition">Portal Login</a>
                </p>
            </div>
        </div>
    </footer>

    {{-- WhatsApp + back-to-top --}}
    <div x-data="{ top: false }" @scroll.window="top = window.scrollY > 600" class="fixed bottom-5 right-5 z-40 flex flex-col items-end gap-3">
        <button type="button" x-show="top" x-cloak x-transition @click="window.scrollTo({ top: 0 })" class="w-11 h-11 rounded-full bg-hbNavy text-white shadow-lg hover:bg-brand-700 transition" aria-label="Back to top">
            <i class="fa-solid fa-arrow-up"></i>
        </button>
        <a href="https://wa.me/{{ $college['whatsapp'] }}?text={{ rawurlencode('Hello Hewitt & Bennet, I would like to enquire about your courses.') }}" target="_blank" rel="noopener"
           class="w-14 h-14 rounded-full bg-[#25D366] text-white text-3xl shadow-xl flex items-center justify-center hover:scale-105 transition" aria-label="Chat with us on WhatsApp">
            <i class="fa-brands fa-whatsapp"></i>
        </a>
    </div>

    <script>
        // Uploaded images that are missing on the server fall back to the college logo instead of a broken icon.
        document.addEventListener('error', function (e) {
            const img = e.target;
            if (img.tagName !== 'IMG' || img.dataset.fallback) return;
            img.dataset.fallback = '1';
            img.src = @json(asset('images/placeholder.webp'));
            img.classList.add('object-contain', 'bg-brand-50');
        }, true);
    </script>
    @yield('scripts')
    @stack('scripts')
</body>
</html>
