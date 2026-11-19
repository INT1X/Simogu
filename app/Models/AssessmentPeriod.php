<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AssessmentPeriod extends Model
{
    protected $fillable = [
        'academic_year',
        'semester',
        'start_date',
        'end_date',
        'status',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    /**
     * Semua penilaian yang terhubung dengan periode ini.
     */
    public function assessments(): HasMany
    {
        return $this->hasMany(
            Assessment::class,
            'assessment_period_id'
        );
    }

    /**
     * Semua dokumen guru yang terhubung dengan periode ini.
     */
    public function teacherDocuments(): HasMany
    {
        return $this->hasMany(
            TeacherDocument::class,
            'assessment_period_id'
        );
    }

    /**
     * Nama periode untuk ditampilkan di halaman.
     */
    public function getNameAttribute(): string
    {
        $semester = ucfirst($this->semester);

        return "{$semester} - {$this->academic_year}";
    }

    /**
     * Periksa apakah periode sedang dibuka.
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }
}
