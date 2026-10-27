<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bilan extends Model
{
    protected $fillable = [
        'patient_name',
        'date',
        'pathology',
        'notes',
        'image_path'
    ];
}
