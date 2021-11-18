<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rental extends Model
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
}
