{{-- Public contact form (homepage + contact page). --}}
<div>
    <h3 class="text-xl font-black text-hbNavy uppercase mb-6 flex items-center gap-3"><i class="fa-solid fa-paper-plane text-hbRed"></i> Send a Message</h3>
    <form action="{{ route('contact.store') }}" method="POST" class="space-y-4">
        @csrf
        <div class="hidden" aria-hidden="true"><label>Website <input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>
        <div class="grid sm:grid-cols-2 gap-4">
            <label class="block">
                <span class="block text-sm font-semibold text-gray-700 mb-1">Full Name <span class="text-hbRed">*</span></span>
                <input type="text" name="name" value="{{ old('name') }}" autocomplete="name" class="w-full border border-gray-300 px-4 py-3 rounded-md focus:ring-2 focus:ring-hbRed focus:border-transparent" required>
                @error('name')<span class="text-xs text-hbRed">{{ $message }}</span>@enderror
            </label>
            <label class="block">
                <span class="block text-sm font-semibold text-gray-700 mb-1">Email Address <span class="text-hbRed">*</span></span>
                <input type="email" name="email" value="{{ old('email') }}" autocomplete="email" class="w-full border border-gray-300 px-4 py-3 rounded-md focus:ring-2 focus:ring-hbRed focus:border-transparent" required>
                @error('email')<span class="text-xs text-hbRed">{{ $message }}</span>@enderror
            </label>
            <label class="block">
                <span class="block text-sm font-semibold text-gray-700 mb-1">Phone / WhatsApp</span>
                <input type="tel" name="phone" value="{{ old('phone') }}" autocomplete="tel" class="w-full border border-gray-300 px-4 py-3 rounded-md focus:ring-2 focus:ring-hbRed focus:border-transparent">
            </label>
            <label class="block">
                <span class="block text-sm font-semibold text-gray-700 mb-1">Subject <span class="text-hbRed">*</span></span>
                <select name="subject" class="w-full border border-gray-300 px-4 py-3 rounded-md focus:ring-2 focus:ring-hbRed focus:border-transparent" required>
                    <option value="">-- Select Subject --</option>
                    @foreach (\App\Models\ContactMessage::SUBJECTS as $subject)
                        <option value="{{ $subject }}" @selected(old('subject', request('subject')) === $subject)>{{ $subject }}</option>
                    @endforeach
                </select>
                @error('subject')<span class="text-xs text-hbRed">{{ $message }}</span>@enderror
            </label>
        </div>
        <label class="block">
            <span class="block text-sm font-semibold text-gray-700 mb-1">Message <span class="text-hbRed">*</span></span>
            <textarea name="message" rows="5" class="w-full border border-gray-300 px-4 py-3 rounded-md focus:ring-2 focus:ring-hbRed focus:border-transparent" required>{{ old('message') }}</textarea>
            @error('message')<span class="text-xs text-hbRed">{{ $message }}</span>@enderror
        </label>
        <button type="submit" class="w-full bg-hbRed text-white py-3 rounded-md font-bold hover:bg-red-700 transition"><i class="fa-solid fa-paper-plane mr-2"></i> Send Message</button>
    </form>
</div>
