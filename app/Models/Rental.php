<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Consts\UserConst;
use Illuminate\Support\Facades\Auth;

class Rental extends Model
{
    use HasFactory;

        protected $fillable = [
        'title',
        'body',
        'price',
        'date',
        'days',
        'brand',
        'area',
        'category',
        'delivery',
        ];

    public function scopeMyRental(Builder $query)
    {
        $query->where(
            'user_id',
            Auth::user()->id
        );

        return $query;
    }

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
