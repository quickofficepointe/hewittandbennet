<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/** An enquiry sent through the public contact form. */
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
    ];

    protected $fillable = ['name', 'email', 'phone', 'subject', 'message', 'read_at'];

    protected $casts = ['read_at' => 'datetime'];
}
