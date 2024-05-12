<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;
 
    protected $table = 'appointments';
    
    protected $fillable = [
        'user_id',
        'salon_id',
        'google_event_id',
        'start_time',
        'end_time',
    ];

    protected $hidden = [
        'google_event_id',
        'created_at',
        'updated_at',
    ];
}
