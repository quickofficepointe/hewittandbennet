<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class newsandevent extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'slug', 'cover_image', 'content', 'user_id'];

    /**
     * Define the relationship with the user (who posted the event).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function handleCoverImageUpload($file)
    {
        // Store the file in the 'public' disk inside the 'cover_images' folder
        $path = $file->store('cover_images', 'public');
        return $path;
    }
}