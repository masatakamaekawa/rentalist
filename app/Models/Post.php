<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'body',
        'price',
        'days',
        'brand',
        'area',
        'category',
        'delivery',
        
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function getImagePathAttribute()
    {
        return 'images/posts/' . $this->image;
    }

    public function getImageUrlAttribute()
    {
        return Storage::url($this->image_path);
    }

    public function scopeSearch(Builder $query, $params)
    {
        if (!empty($params['title'])) {
            $query->where('title', 'like', '%' . $params['title'] . '%');
        }
        return $query;
    }
}
