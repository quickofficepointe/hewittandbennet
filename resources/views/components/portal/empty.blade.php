@props(['icon' => 'fa-folder-open', 'message' => 'Nothing to show yet.'])
<div class="text-center py-10 text-slate-400">
    <i class="fa-solid {{ $icon }} text-3xl mb-3"></i>
    <p class="text-sm">{{ $message }}</p>
    {{ $slot }}
</div>
