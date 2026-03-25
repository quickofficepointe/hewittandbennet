<!DOCTYPE html>
<html>
<head></head>
<body>
    <div style="font-family: Arial, sans-serif; background-color: #f5f5f5; padding: 20px;">
        <div style="background-color: #ffffff; border-radius: 5px; padding: 20px;">
            <h2 style="color: #333;">Welcome to Hewitt and Bennett Internallional College!</h2>
            <p style="color: #333;">Dear {{ $student->name }},</p>
            <p style="color: #333;">We are delighted to have you as a student at our College. Your journey begins now!</p>
            <p style="color: #333;">You are enrolled in the <strong>{{$student->course }}</strong> program.</p>
            <p style="color: #333;">The Program Fees is <strong>{{$student->course_fee }}</strong> and an addition attachment fee of 3,000 and  1000 School ID CARD FEE .</p>
            <p style="color: #333;">Your username (admission number) for registration is: <strong>{{ $student->student_no }}</strong></p>
            <p style="color: #333;">To complete your registration, click the button below: <strong>(use your admission number as username)</strong></p>
            <a href="{{ route('register', ['username' => $student->student_no]) }}" style="display: inline-block; background-color: #007bff; color: #fff; padding: 10px 20px; text-decoration: none; border-radius: 5px;">Register Now</a>
            <p style="color: #333;">If you have any general queries, please feel free to contact us at <a href="mailto:info@hewittbennet.co.ke">info@hewittbennet.co.ke</a>.</p>
            <p style="color: #333;">For technical support, you can reach our ICT support team at <a href="mailto:info@hewittbennet.co.ke">ictsupport@hewittbennet.co.ke</a>.</p>
            <ul>
                <li>Phone: <a href="tel:+254740197796">+254 740 197 796</a></li>
                <li>Phone: <a href="tel:+25713490768">+257 134 90768</a></li>
            </ul>
            <p style="color: #333;">We wish you a successful academic journey with us!</p>
        </div>
    </div>
</body>
</html>
