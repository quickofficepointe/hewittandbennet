@props(['title'])
<div class="flex items-center justify-between border-b-2 border-primary pb-4 mb-6">
    <div class="flex items-center gap-4">
        <img src="{{ asset('assets/img/logo_nobg.png') }}" alt="HBIC" class="h-16">
        <div>
            <div class="text-lg font-bold text-primary">HEWITT AND BENNET INTERNATIONAL COLLEGE</div>
            <div class="text-xs text-slate-500">Nairobi &middot; Buruburu &middot; Thika &middot; info@hewittbennet.co.ke &middot; +254 740 197 796</div>
        </div>
    </div>
    <div class="text-right">
        <div class="text-xl font-semibold uppercase tracking-wide text-slate-700">{{ $title }}</div>
        {{ $slot }}
    </div>
</div>
