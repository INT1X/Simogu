<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssessmentWeight extends Model
{
    protected $fillable = [
        'competency',
        'weight',
        'is_active',
    ];

    protected $casts = [
        'weight' => 'decimal:2',
        'is_active' => 'boolean',
    ];
}