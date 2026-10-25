<?php

if (! function_exists('money')) {
    /** Formats an amount in Kenya shillings, e.g. "KES 12,500.00". */
    function money($amount, bool $withCurrency = true): string
    {
        $formatted = number_format((float) $amount, 2);

        return $withCurrency ? "KES {$formatted}" : $formatted;
    }
}

if (! function_exists('status_color')) {
    /** Tailwind colour name used by <x-portal.badge> for common status values. */
    function status_color(?string $status): string
    {
        return match ($status) {
            'active', 'approved', 'paid', 'present', 'hired', 'open', 'published', 'Competent' => 'green',
            'pending', 'draft', 'late', 'new', 'shortlisted', 'deferred', 'on_leave' => 'amber',
            'rejected', 'absent', 'suspended', 'discontinued', 'exited', 'cancelled', 'closed', 'Not Yet Competent' => 'red',
            'graduated', 'interviewed', 'excused' => 'blue',
            default => 'gray',
        };
    }
}
