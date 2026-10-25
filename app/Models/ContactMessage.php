<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/** An enquiry sent through the public contact form (stored in the existing contacts table). */
class ContactMessage extends Model
{
    public const SUBJECTS = [
        'Admissions Enquiry',
        'Course Information',
        'Work Abroad Program',
        'International Students',
        'Fees & Payments',
        'Campus Information',
        'General Enquiry',
        'Complaint',
        'Other',
    ];

    protected $table = 'contacts';

    protected $fillable = ['name', 'email', 'phone', 'subject', 'body', 'is_read', 'read_at'];

    protected $casts = ['is_read' => 'boolean', 'read_at' => 'datetime'];

    public function markRead(bool $read = true): void
    {
        $this->update(['is_read' => $read, 'read_at' => $read ? now() : null]);
    }
}
