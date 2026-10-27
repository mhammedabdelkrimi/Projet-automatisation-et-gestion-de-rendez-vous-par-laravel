<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'firstname',
        'lastname',
        'age',
        'phone',
        'email',
        'gender',
        'date',
        'time',
        'services',
        'description',
    ];

    protected $casts = [
        'services' => 'array',
        'date' => 'date',
    ];
}
