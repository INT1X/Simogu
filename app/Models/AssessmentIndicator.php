<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AssessmentIndicator extends Model
{
    protected $fillable = [
        'code',
        'competency',
        'name',
        'description',
        'weight',
        'is_active',
    ];

    protected $casts = [
        'weight' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function assessmentDetails(): HasMany
    {
        return $this->hasMany(
            AssessmentComponentDetail::class,
            'indicator_id'
        );
    }
}