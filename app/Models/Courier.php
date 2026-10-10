<?php

namespace App\Models;

use Database\Factories\CourierFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Courier extends Model
{
    /** @use HasFactory<CourierFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'vehicle_type',
        'plate_number',
        'level',
        'is_active',
    ];

    protected $casts = [
        'level' => 'integer',
        'is_active' => 'boolean',
    ];
}
