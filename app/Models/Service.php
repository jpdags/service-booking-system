<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
        'name',
        'description',
        'location',
        'price',
        'category',
        'image',
    ];

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

   public function reviews()
{
    return $this->hasMany(Review::class, 'service_id');
}

public function averageRating()
{
    return $this->reviews()->avg('rating');
}


    
}
