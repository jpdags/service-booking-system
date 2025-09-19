<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'message',
        'parent_id', // for threaded messages
    ];

    // Sender relationship
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    // Receiver relationship
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    // Threaded replies
    public function replies()
    {
        return $this->hasMany(Message::class, 'parent_id')->with('replies');
    }

    // Parent message
    public function parent()
    {
        return $this->belongsTo(Message::class, 'parent_id');
    }
}
