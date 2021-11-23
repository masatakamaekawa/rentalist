<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

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

    public function rentalcomments()
    {
        return $this->hasMany(RentalComment::class);
    }

    public function scopeSearch(Builder $query, $params)
    {
        if (!empty($params['title'])) {
            $query->where('title', 'like', '%' . $params['title'] . '%');
        }
        if (!empty($params['category'])) {
            $query->where('category', 'like', '%' . $params['category'] . '%');
        }
        return $query;
    }

    public function entries()
    {
        return $this->hasMany(Entry::class);
    }
}
