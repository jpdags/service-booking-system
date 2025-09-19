<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'buyer_id',
        'service_id',
        'status'
    ];

    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_DECLINED = 'declined';

    public function buyer() {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function service() {
        return $this->belongsTo(Service::class);
    }
}
