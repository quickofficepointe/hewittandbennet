<?php

/*
|--------------------------------------------------------------------------
| Public website details
|--------------------------------------------------------------------------
| One place for the contact details, campuses and social links shown in the
| header, footer, homepage and contact page, so they never drift apart.
*/

return [

    'name' => 'Hewitt & Bennet International College',
    'tagline' => 'Empowering Students for Global Careers',
    'accreditations' => ['TVETA', 'NITA', 'CDACC'],

    'email' => env('COLLEGE_EMAIL', 'info@hewittbennet.co.ke'),
    'phones' => ['+254 740 197 796', '+254 792 168 754', '+254 700 207 013', '+254 707 744 224'],

    // WhatsApp number in international format without "+" (used for the chat button).
    'whatsapp' => env('COLLEGE_WHATSAPP', '254740197796'),

    'office_hours' => [
        'Monday – Friday' => '8:00 AM – 5:00 PM',
        'Saturday' => '9:00 AM – 1:00 PM',
    ],

    'campuses' => [
        [
            'name' => 'Ngong Campus',
            'address' => 'Ngong Town, next to Co-operative Bank',
            'county' => 'Kajiado',
            'image' => 'images/campus-ngong.webp',
            'blurb' => 'Our flagship campus offering all programs with modern training facilities.',
        ],
        [
            'name' => 'Buruburu Campus',
            'address' => 'Buruburu Phase 2, opposite Buruburu Police Station',
            'county' => 'Nairobi',
            'image' => 'images/campus-buruburu.webp',
            'blurb' => 'Serving the Eastlands community with healthcare and hospitality programs.',
        ],
        [
            'name' => 'Thika Campus',
            'address' => 'Section 9, next to Mugumoini Primary School',
            'county' => 'Kiambu',
            'image' => null,
            'blurb' => 'Serving Thika and surrounding areas with the same programs and experienced faculty.',
        ],
        [
            'name' => 'Ongata Rongai Campus',
            'address' => 'Maasai Mall, Second Floor, Ongata Rongai',
            'county' => 'Kajiado',
            'image' => 'images/campus-rongai.webp',
            'blurb' => 'Convenient for residents of Rongai, Kiserian and the southern suburbs.',
        ],
    ],

    'map_embed' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.1628405791676!2d37.067009075722!3d-1.0385960354071377!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x182f4fba05870db9%3A0x9f1a0a8708f50e10!2sHewitt%20and%20Bennet%20International%20College%20Limited%20-%20Thika%20Campus!5e0!3m2!1sen!2ske!4v1783498427251!5m2!1sen!2ske',

    // Leave a link empty to hide its icon (no more dead "#" links).
    'social' => [
        'facebook' => env('SOCIAL_FACEBOOK'),
        'instagram' => env('SOCIAL_INSTAGRAM'),
        'tiktok' => env('SOCIAL_TIKTOK'),
        'youtube' => env('SOCIAL_YOUTUBE'),
        'linkedin' => env('SOCIAL_LINKEDIN'),
    ],

    'stats' => [
        ['2,000+', 'Graduates Placed'],
        ['50+', 'Programs Offered'],
        ['4', 'Campus Locations'],
        ['100+', 'Students in Germany'],
    ],
];
