<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Assessment extends Model
{
    protected $fillable = [
        'teacher_id',
        'supervisor_id',
        'assessment_period_id',
        'assessment_date',
        'pedagogik_score',
        'kepribadian_score',
        'sosial_score',
        'profesional_score',
        'document_score',
        'final_score',
        'classification',
        'status',
    ];

    protected $casts = [
        'assessment_date' => 'date',
        'pedagogik_score' => 'decimal:2',
        'kepribadian_score' => 'decimal:2',
        'sosial_score' => 'decimal:2',
        'profesional_score' => 'decimal:2',
        'document_score' => 'decimal:2',
        'final_score' => 'decimal:2',
    ];

    /**
     * Relasi ke guru yang dinilai.
     */
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(
            Teacher::class,
            'teacher_id'
        );
    }

    /**
     * Relasi ke pengawas yang melakukan penilaian.
     */
    public function supervisor(): BelongsTo
    {
        return $this->belongsTo(
            Supervisor::class,
            'supervisor_id'
        );
    }

    /**
     * Relasi ke periode penilaian semester.
     */
    public function assessmentPeriod(): BelongsTo
    {
        return $this->belongsTo(
            AssessmentPeriod::class,
            'assessment_period_id'
        );
    }

    /**
     * Relasi ke detail indikator penilaian.
     */
    public function details(): HasMany
    {
        return $this->hasMany(
            AssessmentComponentDetail::class,
            'assessment_id'
        );
    }
}
