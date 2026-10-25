{{-- Course application modal. Open it with openEnrollModal(courseId, courseName). Needs $coursese and $campuses. --}}
<div id="enroll-modal" class="fixed inset-0 z-[60] hidden bg-black/60 items-center justify-center px-4" role="dialog" aria-modal="true" aria-labelledby="enroll-modal-title"
     onclick="if (event.target === this) closeEnrollModal()">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto relative">
        <button type="button" onclick="closeEnrollModal()" class="absolute top-4 right-4 w-10 h-10 rounded-full text-xl text-gray-500 hover:bg-gray-100 hover:text-hbRed transition" aria-label="Close">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <form action="{{ route('courseregistration.store') }}" method="POST" class="p-6 sm:p-8 space-y-5">
            @csrf
            <div>
                <h2 id="enroll-modal-title" class="text-2xl font-black text-hbNavy">Course Application</h2>
                <p class="text-sm text-gray-500 mt-1">Send us your details and our admissions team will contact you within one working day.</p>
            </div>

            <div class="grid md:grid-cols-2 gap-4">
                <label class="block">
                    <span class="block text-sm font-semibold text-gray-700 mb-1">Full Name <span class="text-hbRed">*</span></span>
                    <input type="text" name="name" autocomplete="name" class="w-full border border-gray-300 px-4 py-3 rounded-md focus:ring-2 focus:ring-hbRed focus:border-transparent" required>
                </label>
                <label class="block">
                    <span class="block text-sm font-semibold text-gray-700 mb-1">Email Address <span class="text-hbRed">*</span></span>
                    <input type="email" name="email" autocomplete="email" class="w-full border border-gray-300 px-4 py-3 rounded-md focus:ring-2 focus:ring-hbRed focus:border-transparent" required>
                </label>
                <label class="block">
                    <span class="block text-sm font-semibold text-gray-700 mb-1">Phone / WhatsApp <span class="text-hbRed">*</span></span>
                    <input type="tel" name="phoneNumber" autocomplete="tel" placeholder="+254 7XX XXX XXX" class="w-full border border-gray-300 px-4 py-3 rounded-md focus:ring-2 focus:ring-hbRed focus:border-transparent" required>
                </label>
                <label class="block">
                    <span class="block text-sm font-semibold text-gray-700 mb-1">Location / Country <span class="text-hbRed">*</span></span>
                    <input type="text" name="location" placeholder="e.g. Ngong, Kenya" class="w-full border border-gray-300 px-4 py-3 rounded-md focus:ring-2 focus:ring-hbRed focus:border-transparent" required>
                </label>
                <label class="block md:col-span-2">
                    <span class="block text-sm font-semibold text-gray-700 mb-1">Course <span class="text-hbRed">*</span></span>
                    <select name="course_id" id="enroll-course" class="w-full border border-gray-300 px-4 py-3 rounded-md focus:ring-2 focus:ring-hbRed focus:border-transparent" required>
                        <option value="">-- Select Course --</option>
                        @foreach ($coursese as $course)
                            <option value="{{ $course->id }}">{{ $course->name }}</option>
                        @endforeach
                    </select>
                </label>
                <label class="block">
                    <span class="block text-sm font-semibold text-gray-700 mb-1">Campus <span class="text-hbRed">*</span></span>
                    <select name="campus_id" class="w-full border border-gray-300 px-4 py-3 rounded-md focus:ring-2 focus:ring-hbRed focus:border-transparent" required>
                        <option value="">-- Select Campus --</option>
                        @foreach ($campuses ?? [] as $campus)
                            <option value="{{ $campus->id }}">{{ \Illuminate\Support\Str::title($campus->name) }}</option>
                        @endforeach
                    </select>
                </label>
                <label class="block">
                    <span class="block text-sm font-semibold text-gray-700 mb-1">Mode of Learning <span class="text-hbRed">*</span></span>
                    <select name="modeOfLearning" class="w-full border border-gray-300 px-4 py-3 rounded-md focus:ring-2 focus:ring-hbRed focus:border-transparent" required>
                        <option value="">-- Select Mode --</option>
                        <option value="On-Campus">On-Campus</option>
                        <option value="Online">Online</option>
                        <option value="Hybrid">Hybrid</option>
                    </select>
                </label>
                <label class="block">
                    <span class="block text-sm font-semibold text-gray-700 mb-1">Start Month <span class="text-hbRed">*</span></span>
                    <select name="startMonth" class="w-full border border-gray-300 px-4 py-3 rounded-md focus:ring-2 focus:ring-hbRed focus:border-transparent" required>
                        <option value="">-- Select Month --</option>
                        @foreach (['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'] as $month)
                            <option value="{{ $month }}">{{ $month }}</option>
                        @endforeach
                    </select>
                </label>
                <label class="block">
                    <span class="block text-sm font-semibold text-gray-700 mb-1">Start Year <span class="text-hbRed">*</span></span>
                    <select name="startYear" class="w-full border border-gray-300 px-4 py-3 rounded-md focus:ring-2 focus:ring-hbRed focus:border-transparent" required>
                        @for ($year = date('Y'); $year <= date('Y') + 2; $year++)
                            <option value="{{ $year }}">{{ $year }}</option>
                        @endfor
                    </select>
                </label>
            </div>

            <div class="flex flex-col-reverse sm:flex-row sm:justify-end gap-3 pt-4 border-t">
                <button type="button" onclick="closeEnrollModal()" class="px-6 py-3 bg-gray-100 text-gray-700 rounded-md font-bold hover:bg-gray-200 transition">Cancel</button>
                <button type="submit" class="px-6 py-3 bg-hbRed text-white rounded-md font-bold hover:bg-red-700 transition inline-flex items-center justify-center gap-2">
                    <i class="fa-solid fa-paper-plane"></i> Submit Application
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function openEnrollModal(courseId, courseName) {
        const modal = document.getElementById('enroll-modal');
        if (courseId) document.getElementById('enroll-course').value = courseId;
        modal.classList.replace('hidden', 'flex');
        document.body.style.overflow = 'hidden';
        modal.querySelector('input[name=name]').focus();
    }
    function closeEnrollModal() {
        document.getElementById('enroll-modal').classList.replace('flex', 'hidden');
        document.body.style.overflow = '';
    }
    document.addEventListener('keydown', e => { if (e.key === 'Escape') closeEnrollModal(); });
</script>
@endpush
