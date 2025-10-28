<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'category',
        'date',
        'time',
        'location',
        'address',
        'image_url',
        'ticket_price',
        'available_tickets',
        'seating_plan',
        'status',
    ];

    protected $casts = [
        'seating_plan' => 'array',
        'date' => 'date',
        'ticket_price' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
