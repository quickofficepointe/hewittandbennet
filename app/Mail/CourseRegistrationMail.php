<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CourseRegistrationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $phoneNumber;
    public $course;
    public $startMonth;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $phoneNumber, $course, $startMonth)
    {
        $this->name = $name;
        $this->phoneNumber = $phoneNumber;
        $this->course = $course;
        $this->startMonth = $startMonth;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.course_registration')
                    ->subject('New Course Applicant');
    }
}