<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Guarded: the live server may already have some of these columns.
        Schema::table('courses', function (Blueprint $table) {
            if (! Schema::hasColumn('courses', 'code')) {
                $table->string('code')->nullable()->after('name');
            }
            if (! Schema::hasColumn('courses', 'level')) {
                $table->string('level')->nullable()->after('name'); // Certificate, Diploma, Short course...
            }
            if (! Schema::hasColumn('courses', 'examining_body')) {
                $table->string('examining_body')->nullable()->after('name'); // TVETA, NITA, CDACC, KNEC
            }
            if (! Schema::hasColumn('courses', 'total_terms')) {
                $table->unsignedTinyInteger('total_terms')->default(1)->after('duration');
            }
            if (! Schema::hasColumn('courses', 'is_active')) {
                $table->boolean('is_active')->default(true);
            }
        });

        Schema::create('academic_terms', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g. "Jan - Apr 2026"
            $table->date('start_date');
            $table->date('end_date');
            $table->boolean('is_current')->default(false);
            $table->timestamps();
        });

        Schema::create('intakes', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g. "January 2026"
            $table->date('start_date');
            $table->boolean('is_open')->default(true);
            $table->timestamps();
        });

        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('courses')->cascadeOnDelete();
            $table->string('code')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->text('learning_outcomes')->nullable(); // one outcome per line
            $table->unsignedTinyInteger('term_no')->default(1); // term/module of the course it is taught in
            $table->unsignedSmallInteger('hours')->default(0);
            $table->foreignId('trainer_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->unique()->constrained()->nullOnDelete();
            $table->string('admission_no')->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('id_number')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->string('address')->nullable();
            $table->string('guardian_name')->nullable();
            $table->string('guardian_phone')->nullable();
            $table->string('guardian_relationship')->nullable();
            $table->string('photo')->nullable();
            $table->foreignId('course_id')->constrained('courses');
            $table->foreignId('intake_id')->nullable()->constrained('intakes')->nullOnDelete();
            $table->foreignId('campus_id')->nullable()->constrained('campuses')->nullOnDelete();
            $table->string('mode_of_study')->default('Full time');
            $table->unsignedTinyInteger('current_term')->default(1);
            $table->date('admission_date');
            $table->enum('status', ['active', 'deferred', 'suspended', 'graduated', 'discontinued'])->default('active');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('timetable_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unit_id')->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('day_of_week'); // 1 = Monday ... 7 = Sunday
            $table->time('start_time');
            $table->time('end_time');
            $table->string('venue')->nullable();
            $table->timestamps();
        });

        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unit_id')->constrained()->cascadeOnDelete();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->date('date');
            $table->enum('status', ['present', 'absent', 'late', 'excused']);
            $table->foreignId('marked_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->unique(['unit_id', 'student_id', 'date']);
        });

        Schema::create('assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unit_id')->constrained()->cascadeOnDelete();
            $table->foreignId('academic_term_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->enum('type', ['cat', 'assignment', 'practical', 'project', 'exam']);
            $table->decimal('max_score', 6, 2)->default(100);
            $table->unsignedTinyInteger('weight')->default(100); // % contribution to the unit's final mark
            $table->date('date')->nullable();
            $table->boolean('published')->default(false);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('assessment_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assessment_id')->constrained()->cascadeOnDelete();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->decimal('score', 6, 2)->nullable();
            $table->string('remarks')->nullable();
            $table->timestamps();
            $table->unique(['assessment_id', 'student_id']);
        });

        Schema::create('learning_materials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unit_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('file_path')->nullable();
            $table->string('link')->nullable();
            $table->foreignId('uploaded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('online_exams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unit_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('instructions')->nullable();
            $table->unsignedSmallInteger('duration_minutes')->default(30);
            $table->dateTime('opens_at')->nullable();
            $table->dateTime('closes_at')->nullable();
            $table->boolean('published')->default(false);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('exam_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('online_exam_id')->constrained()->cascadeOnDelete();
            $table->text('question');
            $table->json('options'); // ["A text", "B text", ...]
            $table->unsignedTinyInteger('correct_option'); // index into options
            $table->unsignedTinyInteger('marks')->default(1);
            $table->timestamps();
        });

        Schema::create('exam_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('online_exam_id')->constrained()->cascadeOnDelete();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->json('answers')->nullable();
            $table->decimal('score', 6, 2)->nullable();
            $table->decimal('total', 6, 2)->nullable();
            $table->dateTime('started_at');
            $table->dateTime('submitted_at')->nullable();
            $table->timestamps();
            $table->unique(['online_exam_id', 'student_id']);
        });

        if (! Schema::hasColumn('courseapplications', 'student_id')) {
            Schema::table('courseapplications', function (Blueprint $table) {
                $table->foreignId('student_id')->nullable()->constrained()->nullOnDelete();
            });
        }
    }

    public function down(): void
    {
        Schema::table('courseapplications', function (Blueprint $table) {
            $table->dropConstrainedForeignId('student_id');
        });
        foreach (['exam_attempts', 'exam_questions', 'online_exams', 'learning_materials', 'assessment_results', 'assessments', 'attendances', 'timetable_entries', 'students', 'units', 'intakes', 'academic_terms'] as $table) {
            Schema::dropIfExists($table);
        }
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn(['code', 'level', 'examining_body', 'total_terms', 'is_active']);
        });
    }
};
