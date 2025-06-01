<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventRegistration extends Model
{
    protected $table = 'event_registration';
    protected $primaryKey = 'registration_id';
    public $timestamps = false;

    protected $fillable = [
        'student_id',
        'event_id',
        'status'
    ];

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id', 'event_id');
    }
} 