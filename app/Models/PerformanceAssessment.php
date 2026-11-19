<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PerformanceAssessment extends Model
{
    protected $fillable = [
        'teacher_id',
        'supervisor_id',
        'assessment_period_id',
        'assessment_date',
        'avg_pedagogik',
        'avg_kepribadian',
        'avg_sosial',
        'avg_profesional',
        'final_score',
        'final_classification',
    ];

    protected $casts = [
        'assessment_date' => 'date',
        'avg_pedagogik' => 'decimal:2',
        'avg_kepribadian' => 'decimal:2',
        'avg_sosial' => 'decimal:2',
        'avg_profesional' => 'decimal:2',
        'final_score' => 'decimal:2',
    ];

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    public function supervisor(): BelongsTo
    {
        return $this->belongsTo(Supervisor::class);
    }

    public function assessmentPeriod(): BelongsTo
    {
        return $this->belongsTo(AssessmentPeriod::class);
    }

    public function detail(): HasOne
    {
        return $this->hasOne(
            AssessmentDetail::class,
            'performance_assessment_id'
        );
    }
}
