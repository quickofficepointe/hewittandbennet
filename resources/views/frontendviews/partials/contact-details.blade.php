{{-- College phone, email, WhatsApp and office hours from config/college.php. --}}
@php $college = config('college'); @endphp
<div>
    <h3 class="text-xl font-black text-hbNavy uppercase mb-6 flex items-center gap-3"><i class="fa-solid fa-address-card text-hbRed"></i> Get in Touch</h3>
    <div class="space-y-4">
        <div class="flex items-start gap-4 p-4 bg-hbLight rounded-lg border-l-4 border-hbRed">
            <span class="w-12 h-12 bg-hbNavy rounded-lg flex items-center justify-center text-white text-xl flex-shrink-0"><i class="fa-solid fa-phone"></i></span>
            <div>
                <h4 class="font-bold text-hbNavy text-sm">Call Us</h4>
                @foreach ($college['phones'] as $phone)
                    <a href="tel:{{ preg_replace('/\s+/', '', $phone) }}" class="block text-sm text-gray-600 hover:text-hbRed">{{ $phone }}</a>
                @endforeach
            </div>
        </div>
        <div class="flex items-start gap-4 p-4 bg-hbLight rounded-lg border-l-4 border-hbRed">
            <span class="w-12 h-12 bg-[#25D366] rounded-lg flex items-center justify-center text-white text-2xl flex-shrink-0"><i class="fa-brands fa-whatsapp"></i></span>
            <div>
                <h4 class="font-bold text-hbNavy text-sm">WhatsApp</h4>
                <a href="https://wa.me/{{ $college['whatsapp'] }}" target="_blank" rel="noopener" class="text-sm text-gray-600 hover:text-hbRed">Chat with admissions – ideal for international applicants</a>
            </div>
        </div>
        <div class="flex items-start gap-4 p-4 bg-hbLight rounded-lg border-l-4 border-hbRed">
            <span class="w-12 h-12 bg-hbNavy rounded-lg flex items-center justify-center text-white text-xl flex-shrink-0"><i class="fa-solid fa-envelope"></i></span>
            <div>
                <h4 class="font-bold text-hbNavy text-sm">Email Us</h4>
                <a href="mailto:{{ $college['email'] }}" class="text-sm text-gray-600 hover:text-hbRed">{{ $college['email'] }}</a>
            </div>
        </div>
        <div class="flex items-start gap-4 p-4 bg-hbLight rounded-lg border-l-4 border-hbRed">
            <span class="w-12 h-12 bg-hbNavy rounded-lg flex items-center justify-center text-white text-xl flex-shrink-0"><i class="fa-regular fa-clock"></i></span>
            <div>
                <h4 class="font-bold text-hbNavy text-sm">Office Hours (EAT, UTC+3)</h4>
                @foreach ($college['office_hours'] as $days => $hours)
                    <p class="text-sm text-gray-600">{{ $days }}: {{ $hours }}</p>
                @endforeach
            </div>
        </div>
    </div>
</div>
