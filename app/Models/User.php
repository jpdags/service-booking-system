<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // buyer or seller
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Relationships
    public function services()
    {
        return $this->hasMany(Service::class, 'seller_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'buyer_id');
    }

    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'buyer_id');
    }
}
