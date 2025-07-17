<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class registrationform extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_name',
        'dob',
        'citizenship',
        'religion',
        'cityofresidence',
        'mobile',
        'emailadress',
        'homephone',
        'education',
        'otherskills',
        'profession',
        'gurdianname',   // Add guardian fields
        'phonenumber',
        'idnumber',
        'file_name',
        'gresidence',
        'reasonfortraining', // Add reason for training field
        'gainfortraining',
        'medical_info_yes',  // Add medical information fields
        'pdf_path',
        'medical_info_explanation',
        // Add other fields from your form here
    ];
}
