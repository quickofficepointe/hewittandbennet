<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public const DIRECTOR = 0;
    public const ADMIN = 1;
    public const STUDENT = 2;
    public const TRAINER = 3;
    public const HR = 4;
    public const ACCOUNTANT = 5;

    public const ROLES = [
        self::DIRECTOR => 'director',
        self::ADMIN => 'admin',
        self::STUDENT => 'student',
        self::TRAINER => 'trainer',
        self::HR => 'hr',
        self::ACCOUNTANT => 'accountant',
    ];

    public const ROLE_LABELS = [
        self::DIRECTOR => 'Director',
        self::ADMIN => 'Administrator',
        self::STUDENT => 'Student',
        self::TRAINER => 'Trainer',
        self::HR => 'HR Officer',
        self::ACCOUNTANT => 'Accountant',
    ];

    protected $fillable = [
        'name', 'username', 'role', 'email', 'password', 'phone', 'avatar', 'is_active', 'last_login_at', 'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean',
        'role' => 'integer',
    ];

    public function getRoleNameAttribute(): string
    {
        return self::ROLES[$this->role] ?? 'student';
    }

    public function getRoleLabelAttribute(): string
    {
        return self::ROLE_LABELS[$this->role] ?? 'User';
    }

    public function hasRole(string ...$roles): bool
    {
        return in_array($this->role_name, $roles, true);
    }

    public function isStaff(): bool
    {
        return $this->role !== self::STUDENT;
    }

    public function student()
    {
        return $this->hasOne(Student::class);
    }

    public function employee()
    {
        return $this->hasOne(Employee::class);
    }

    public function units()
    {
        return $this->hasMany(Unit::class, 'trainer_id');
    }

    public function getInitialsAttribute(): string
    {
        return collect(explode(' ', $this->name))->filter()->take(2)
            ->map(fn ($part) => mb_strtoupper(mb_substr($part, 0, 1)))->implode('');
    }
}
