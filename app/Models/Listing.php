<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Listing extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = ['title', 'description', 'price', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function savedUsers()
    {
        return $this->belongsToMany(User::class);
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(200)
            ->height(200);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function sizes()
    {
        return $this->belongsToMany(Size::class);
    }

    public function colors()
    {
        return $this->belongsToMany(Color::class);
    }
}
