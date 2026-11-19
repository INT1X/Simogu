<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssessmentComponentDetail extends Model
{
    protected $table = 'assessment_component_details';

    protected $fillable = [
        'assessment_id',
        'indicator_id',
        'score',
        'notes',
    ];

    protected $casts = [
        'score' => 'decimal:2',
    ];

    public function assessment(): BelongsTo
    {
        return $this->belongsTo(
            Assessment::class,
            'assessment_id'
        );
    }

    public function indicator(): BelongsTo
    {
        return $this->belongsTo(
            AssessmentIndicator::class,
            'indicator_id'
        );
    }
}
