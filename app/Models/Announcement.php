<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    public const AUDIENCES = ['everyone' => 'Everyone', 'students' => 'Students only', 'staff' => 'Staff only'];

    protected $guarded = ['id'];

    protected $casts = ['is_pinned' => 'boolean'];

    public function author()
    {
        return $this->belongsTo(User::class, 'posted_by');
    }

    public function scopeVisibleTo($query, User $user)
    {
        $audience = $user->role === User::STUDENT ? 'students' : 'staff';

        return $query->whereIn('audience', ['everyone', $audience])
            ->orderByDesc('is_pinned')->latest();
    }
}
