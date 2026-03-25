@extends('dashboards.staff.layouts.stafflayout')

@section('pageTitle', 'Message Details')

@section('content')
<div class="space-y-6 animate-fade-in">
    <!-- Page Header -->
    <div class="bg-gradient-to-r from-primary-600 to-primary-800 rounded-2xl p-6 text-white shadow-lg">
        <div class="flex items-center justify-between flex-wrap gap-4">
            <div>
                <h2 class="text-2xl font-bold mb-2">Message Details</h2>
                <p class="text-primary-100">View and respond to contact message</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('contact.messages.index') }}" class="bg-white/20 backdrop-blur-sm px-4 py-2 rounded-xl hover:bg-white/30 transition">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Messages
                </a>
            </div>
        </div>
    </div>

    <!-- Message Content -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between flex-wrap gap-4">
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Message from {{ $message->name }}</h3>
                    <p class="text-sm text-gray-500 mt-1">Received {{ $message->created_at->format('F d, Y H:i A') }} ({{ $message->created_at->diffForHumans() }})</p>
                </div>
                <div>
                    @if(!$message->is_read)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                            <i class="fas fa-circle mr-2 text-xs"></i>Unread
                        </span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-600">
                            <i class="fas fa-check-circle mr-2"></i>Read
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <div class="p-6">
            <!-- Sender Information -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="bg-gray-50 rounded-xl p-4">
                    <div class="flex items-center mb-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-primary-100 to-primary-200 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-user text-primary-600"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Sender Name</p>
                            <p class="font-semibold text-gray-800">{{ $message->name }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 rounded-xl p-4">
                    <div class="flex items-center mb-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-green-100 to-green-200 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-envelope text-green-600"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Email Address</p>
                            <a href="mailto:{{ $message->email }}" class="font-semibold text-primary-600 hover:text-primary-700">
                                {{ $message->email }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Subject -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Subject</label>
                <div class="bg-gray-50 rounded-xl p-4">
                    <div class="flex items-center">
                        <i class="fas fa-tag text-gray-400 mr-2"></i>
                        <span class="font-medium text-gray-800">{{ $message->subject }}</span>
                    </div>
                </div>
            </div>

            <!-- Message Body -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Message</label>
                <div class="bg-gray-50 rounded-xl p-6">
                    <div class="prose max-w-none">
                        <p class="text-gray-700 whitespace-pre-wrap leading-relaxed">{{ $message->body }}</p>
                    </div>
                </div>
            </div>

            <!-- Metadata -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6 pt-6 border-t border-gray-200">
                <div class="flex items-center text-sm text-gray-500">
                    <i class="fas fa-calendar-alt mr-2 text-gray-400"></i>
                    <span>Received: {{ $message->created_at->format('l, F d, Y H:i A') }}</span>
                </div>
                <div class="flex items-center text-sm text-gray-500">
                    <i class="fas fa-clock mr-2 text-gray-400"></i>
                    <span>{{ $message->created_at->diffForHumans() }}</span>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end space-x-3 mt-8 pt-6 border-t border-gray-200">
                <a href="mailto:{{ $message->email }}?subject=Re: {{ $message->subject }}"
                   class="px-4 py-2 bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white rounded-xl transition shadow-sm hover:shadow-md">
                    <i class="fas fa-reply mr-2"></i>Reply via Email
                </a>
                <form action="{{ route('contact.messages.destroy', $message->id) }}" method="POST" class="inline delete-form">
                    @csrf
                    @method('DELETE')
                    <button type="button" onclick="confirmDelete(this)"
                            class="px-4 py-2 border border-red-300 text-red-600 hover:bg-red-50 rounded-xl transition">
                        <i class="fas fa-trash-alt mr-2"></i>Delete Message
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Animate cards
        const cards = document.querySelectorAll('.bg-white.rounded-2xl');
        cards.forEach((card, index) => {
            card.style.animation = `slideUp 0.4s ease-out ${index * 0.1}s forwards`;
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
        });

        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideUp {
                to { opacity: 1; transform: translateY(0); }
            }
            @keyframes slideDown {
                from { opacity: 0; transform: translate(-50%, -100%); }
                to { opacity: 1; transform: translate(-50%, 0); }
            }
            .animate-slide-down { animation: slideDown 0.3s ease-out; }
        `;
        document.head.appendChild(style);
    });

    // Delete confirmation
    function confirmDelete(button) {
        Swal.fire({
            title: 'Delete Message?',
            text: "This action cannot be undone!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                button.closest('.delete-form').submit();
            }
        });
    }
</script>
@endpush

@push('styles')
<style>
    .prose {
        line-height: 1.6;
    }

    .prose p {
        margin-bottom: 1rem;
    }

    .prose p:last-child {
        margin-bottom: 0;
    }
</style>
@endpush
@endsection
